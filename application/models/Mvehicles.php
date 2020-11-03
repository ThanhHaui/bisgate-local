<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehicles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehicles";
        $this->_primary_key = "VehicleId";
    }

    public function getCount($postData){
        $query = "VehicleStatusId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['UserId']) && $postData['UserId'] > 0) $query.=" AND UserId=".$postData['UserId'];
        return $query;
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId){
        $queryCount = "select vehicles.VehicleId AS totalRow from vehicles {joins} where {wheres}";
        $query = "select {selects} from vehicles {joins} where {wheres} ORDER BY vehicles.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'vehicles.*, vehicletypes.VehicleTypeName','staffs.FullName','provinces.ProvinceName',
        ];
        $joins = [
            'vehicletypes' => 'LEFT JOIN vehicletypes on vehicletypes.VehicleTypeId = vehicles.VehicleTypeId',
            'staffs' => 'LEFT JOIN staffs on staffs.StaffId = vehicles.CrUserId',
            'vehiclemanufacturers' => 'LEFT JOIN vehiclemanufacturers on vehiclemanufacturers.VehicleManufacturerId = vehicles.VehicleManufacturerId',
            'provinces' => 'LEFT JOIN provinces on vehicles.ProvinceId = provinces.ProvinceId',
        ];
        $wheres = array('vehicles.VehicleId > 0 AND vehicles.VehicleStatusId > 0');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        if($searchText){
            $searchText = str_replace(array('-','.'),array('',''), $searchText);
        }
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'vehicles.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'vehicles.LicensePlate like ? or vehicles.VIN like ? or vehicles.RegistryCycle like ? or vehicles.LastRegistryDate like ? ';
                for( $i = 0; $i < 4; $i++) $dataBind[] = "%$searchText%";
            }
        }
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }
        //search theo bộ lọc ,
        if (!empty($itemFilters) && count($itemFilters)) {
            foreach ($itemFilters as $item) {
                $filed_name = $item['field_name'];
                $conds = $item['conds'];
                //$cond[0] là điều kiện ví dụ : < > = like .....   $cons[1] và $cond[2]  là gía trị điều kiện như 2017-01-02 và 2017-01-01
                switch ($filed_name) {
                    case 'vehicle_status_id':
                        $wheres[] = "vehicles.VehicleStatusId $conds[0] ?";
                        $dataBind[] = $conds[1];
                        break;
                    default :
                        break;
                }
            }
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{joins}', $joins_string, $queryCount);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('vehicle', $userId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';
        for ($i = 0; $i < count($datas); $i++) {
            $datas[$i]['SSLStatusId'] = '';
            $datas[$i]['SSLId'] = '';
            $SSLItem = $this->Mssls->getBy(['VehicleId' => $datas[$i]['VehicleId']], true);
            if(!empty($SSLItem)) {
                $arrStatus = $this->Mconstants->sslStatus;
                $nameStatus = $SSLItem['SSLStatusId'] > 0 ? $arrStatus[$SSLItem['SSLStatusId']] : '';
                $labelCss = $this->Mconstants->labelCss;
                $datas[$i]['SSLStatusId'] = '<span class="'.$labelCss[$SSLItem['SSLStatusId']].'">' . $nameStatus . '</span>';
                $SSLCode = 10000 + $SSLItem['SSLId'];
                $datas[$i]['SSLId'] = 'SSL-'.$SSLCode;
            } else {
                $datas[$i]['SSLId'] = '--';
                $datas[$i]['SSLStatusId'] = '--';
            }
            $html .= '<tr id="trItem_'.$datas[$i]['VehicleId'].'" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['VehicleId'].'"></td>';
                } else if(!empty($tables[$z]['Status']) && $tables[$z]['Status'] != NULL){
                    $arrStatus = $this->Mconstants->$columnName;
                    $nameStatus = $datas[$i][$tables[$z]['Status']] > 0 ? $arrStatus[$datas[$i][$tables[$z]['Status']]] : '';
                    if($nameStatus){
                        $labelCss = $this->Mconstants->labelCss;
                        $html .= '<td style="'.$displayNone.'" class="text-center"><span class="'.$labelCss[$datas[$i][$tables[$z]['Status']]].'">' . $nameStatus . '</span></td>';
                    }else{
                        $html .= '<td style="'.$displayNone.'" class="text-center"></td>';
                    }
                }else if($columnName == 'CrDateTime'){
                    $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                    $crDateTime = strpos(ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'),'00:00')?ddMMyyyy($datas[$i][$columnName],'d/m/Y'):ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="'.$displayNone.'" >'.getDayDiffText($dayDiff).$crDateTime.'</td>';
                }
                else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                    $bsx = $this->formatLicensePlate($datas[$i]['VehicleTypeId'],$datas[$i][$columnName]);
                    $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['VehicleId'].'">'.$bsx.'</a></td>';
                }else if(!empty($tables[$z]['ModelsDb']) && !empty($tables[$z]['NameRelationship'])){
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                    if($columnName == 'sslStatus'){
                        $status = $this->Mconstants->sslStatus;
                        $labelCss = $this->Mconstants->labelCss;
                        $data = $this->$models->getFieldValue(array($nameRelationship => $datas[$i]['VehicleId']), 'SSLStatusId', '');
                        if($data) $html .= '<td style="'.$displayNone.'" ><span class="'.$labelCss[$data].'">'.$status[$data].'</span></td>';
                        else $html .= '<td ></td>';
                    }
                    else if($columnName == 'FullName'){
                        $data = $this->$models->getFieldValue(array($nameRelationship => $datas[$i]['CrUserId']), $columnName, '');
                        $avatar = $this->$models->getFieldValue(array($nameRelationship => $datas[$i]['CrUserId']), 'Avatar', '');
                        $html .= '<td style="'.$displayNone.'" >
                                    <a href="javascript:void(0)" class="d-flex align-items-center"><img class="img-table width30" src="'.USER_PATH.$avatar.'" alt="">
                                        <p class="d-inline-block m-0 pl-2">
                                        <span class="full_name">' .$data.'</span>
                                        </p>
                                    </a>
                                </td>';
                    }
                    else{
                        if($columnName == 'UserId'){
                            $data = $this->$models->getFieldValue(array($columnName => $datas[$i]['UserId']), $nameRelationship, '');
                        }
                        else if($columnName == 'DeviceCodeId'){
                            $data = $this->$models->getFieldValue(array($nameRelationship => $datas[$i]['VehicleId']), $columnName, '');
                        }
                        else if($columnName == 'SSLCode'){
                            $data = $this->$models->getFieldValue(array($nameRelationship => $datas[$i]['VehicleId']), $columnName, '');
                        }
                        else{
                            $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                        }
                        $html .= '<td style="'.$displayNone.'" >'.$data.'</td>';
                    }
                }  else {
                    $html .= '<td style="'.$displayNone.'" >'.$datas[$i][$columnName].'</td>';
                }
            }
            $html .= '</tr>';
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = array('htmlTableTh' => $dataConfigTable['htmlTableTh'], 'dataTables' => $html, 'countIsLock' => $dataConfigTable['countIsLock']);
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentVehicles';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }

    public function getList($searchText, $userId) {
        $query = "select {selects} from vehicles {joins} where {wheres} ORDER BY vehicles.UpdateDateTime DESC";
        $selects = [
            'vehicles.*','vehiclegroups.VehicleGroupName','vehicletypes.VehicleTypeName', 'staffs.FullName', 'staffs.PhoneNumber', 'provinces.ProvinceName'
        ];
        $joins = [
            'staffs' => 'LEFT JOIN staffs on staffs.UserId = vehicles.DriverId',
            'provinces' => 'LEFT JOIN provinces on provinces.ProvinceId = vehicles.ProvinceId',
            'vehicletypes' => 'LEFT JOIN vehicletypes on vehicletypes.VehicleTypeId = vehicles.VehicleTypeId',
            'vehiclegroups' => 'LEFT JOIN vehiclegroups on vehiclegroups.VehicleGroupId = vehicles.VehicleGroupId',
        ];
        $wheres = array('vehicles.VehicleStatusId > 0 AND vehicles.UserId = '.$userId);
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'vehicles.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'staffs.FullName like ? or vehicles.LicensePlate like ? or vehiclegroups.VehicleGroupName like ? or vehicletypes.VehicleTypeName like ? ';
                for( $i = 0; $i < 4; $i++) $dataBind[] = "%$searchText%";
            }
        }
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }

        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $data = $this->getByQuery($query, $dataBind);
        return $data;
    }

    public function getVehicleNotInSsl($searchText, $userId,$ssl){
        $where = "";
        if(trim($searchText) != "") $where = " AND vehicles.LicensePlate LIKE '%".$searchText."%'";
        $query = "SELECT vehicles.* FROM vehicles WHERE vehicles.VehicleStatusId = 2 AND vehicles.VehicleId NOT IN " . $ssl . " AND vehicles.UserId = ?".$where;
        return $this->getByQuery($query, array($userId));
    }
    public function getValueMax($array){
        $max = null;

        for ($i = 0; $i < count($array); $i++)
        {
            if ($max == null){
                $max = $array[$i];
            }
            else {
                if ($array[$i] > $max){
                    $max = $array[$i];
                }
            }
        }
        return $max;
    }
    public function getListVehicle($userId = 0){
            $query = " SELECT vehicles.VehicleId,vehicles.LicensePlate, ssls.SSLStatusId FROM vehicles 
                 JOIN ssls ON ssls.VehicleId =  vehicles.VehicleId
                        WHERE vehicles.VehicleStatusId = ? AND vehicles.UserId = ? ORDER BY vehicles.UpdateDateTime ASC";
            return $this->getByQuery($query, array(STATUS_ACTIVED, $userId));
        }
        public function getCountAgentVehicle($staffId){
            $num = " UserId IN (SELECT UserId from users WHERE ManagementUnitId = {$staffId})";
            // var_dump($num);
        return $this->countRows($num);

    }
    function formatLicensePlate($vehicleType = 0,$licensePlate = ''){
        if(($vehicleType == 1) || ($vehicleType == 2) || ($vehicleType == 3) || ($vehicleType == 4) || ($vehicleType == 5)){
            $check = 0;
            if ($vehicleType == 1) {
                if (strlen($licensePlate) == 8 || strlen($licensePlate) == 9) {
                    if (is_numeric($licensePlate[0]) && is_numeric($licensePlate[1]) && !is_numeric($licensePlate[2])) {
                        if (is_numeric($licensePlate[3]) && is_numeric($licensePlate[4]) && is_numeric($licensePlate[5]) && is_numeric($licensePlate[6]) && is_numeric($licensePlate[7])) {
                            if (strlen($licensePlate) == 8) {
                                $text = $licensePlate[0] . $licensePlate[1] . $licensePlate[2] . $licensePlate[3] . '-' . $licensePlate[4] . $licensePlate[5] . $licensePlate[6] . $licensePlate[7];
                                return $text;
                                $check = 1;
                            } else if (is_numeric($licensePlate[8])) {
                                $text = $licensePlate[0] . $licensePlate[1] . $licensePlate[2] . $licensePlate[3] . '-' . $licensePlate[4] . $licensePlate[5] . $licensePlate[6] . '.' . $licensePlate[7] . $licensePlate[8];
                                return $text;
                                $check = 1;
                            }
                            else{
                                return $licensePlate;
                            }
                        }
                        else{
                            return $licensePlate;
                        }
                    }
                    else{
                        return $licensePlate;
                    }
                }
                else{
                    return $licensePlate;
                }
            } else{
                if (strlen($licensePlate) == 7 || strlen($licensePlate) == 8) {
                    if (is_numeric($licensePlate[0]) && is_numeric($licensePlate[1]) && !is_numeric($licensePlate[2])) {
                        if (is_numeric($licensePlate[3]) && is_numeric($licensePlate[4]) && is_numeric($licensePlate[5]) && is_numeric($licensePlate[6])) {
                            if (strlen($licensePlate) == 7) {
                                $text = $licensePlate[0] . $licensePlate[1] . $licensePlate[2] . '-' . $licensePlate[3] . $licensePlate[4] . $licensePlate[5] . $licensePlate[6];
                                return $text;
                                $check = 1;
                            } else if (is_numeric($licensePlate[7])) {
                                $text = $licensePlate[0] . $licensePlate[1] . $licensePlate[2] . '-' . $licensePlate[3] . $licensePlate[4] . $licensePlate[5] . '.' . $licensePlate[6] . $licensePlate[7];
                                return $text;
                                $check = 1;
                            }
                            else{
                                return $licensePlate;
                            }
                        }
                        else{
                            return $licensePlate;
                        }
                    }
                    else{
                        return $licensePlate;
                    }
                }
                else{
                    return $licensePlate;
                }
            }
            if($check = 0){
                return $licensePlate;
            }
        }
        else{
            return $licensePlate;
        }
    }

    public function getVehicleInUser($userId = 0, $searchText = ''){
        $where = '';
        if(!empty($searchText)) $where = ' AND (LicensePlate LIKE "%'.$searchText.'%" OR IMEI LIKE "%'.$searchText.'%")';
        $query = "SELECT * FROM vehicles WHERE VehicleStatusId > 0 AND UserId =? ".$where;
        return $this->getByQuery($query,array($userId));
    }
}