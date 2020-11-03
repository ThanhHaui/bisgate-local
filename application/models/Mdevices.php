<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdevices extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "devices";
        $this->_primary_key = "DeviceId";
    }

    public function checkExist($deviceId, $IMEI){
        $query = "SELECT DeviceId FROM devices WHERE DeviceId!=? AND StatusId=? ";
        if(!empty($IMEI)){
            $query .= " AND (IMEI=?) LIMIT 1";
            $device = $this->getByQuery($query, array($deviceId, STATUS_ACTIVED, $IMEI));
        }
        if (!empty($device)) return true;
        return false;
    }

    public function getDetailBy($where) {
        $this->db->select('devices.*, devicetypes.DeviceTypeName');
        $this->db->from($this->_table_name);
        $this->db->join('devicetypes','devicetypes.DeviceTypeId=devices.DeviceTypeId');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId){
        $queryCount = "select devices.DeviceId AS totalRow from devices {joins} where {wheres}";
        $query = "select {selects} from devices {joins} where {wheres} ORDER BY devices.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'devices.*',
            'devicecodes.DeviceCodeName',
            'vehicles.LicensePlate',
            'devicetypes.DeviceTypeName',
            'sims.SeriSim',
            'devicemanufacturers.DeviceManufacturerName',
        ];
        $joins = [
            'users' => 'LEFT JOIN users on users.UserId = devices.UserId',
            'devicecodes' => 'LEFT JOIN devicecodes on devicecodes.DeviceCodeId = devices.DeviceCodeId',
            'vehicles' => 'LEFT JOIN vehicles on vehicles.VehicleId = devices.VehicleId',
            'devicetypes' => 'LEFT JOIN devicetypes on devicetypes.DeviceTypeId = devices.DeviceTypeId',
            'devicemanufacturers' => 'LEFT JOIN devicemanufacturers on devicemanufacturers.DeviceManufacturerId = devices.DeviceManufacturerId',
            'sims' => 'LEFT JOIN sims on devices.SimId = sims.SimId'
        ];
        $wheres = array('devices.StatusId > 0');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'devices.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'devices.IMEI like ? or vehicles.LicensePlate like ? or devicecodes.DeviceCodeName like ? or devices.CrDateTime like ? ';
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
                    case 'status_id':
                        $wheres[] = "devices.StatusId $conds[0] ?";
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
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('device', $userId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';

        for ($i = 0; $i < count($datas); $i++) {
            $datas[$i]['ServiceDateTime'] = 'Test';
            $datas[$i]['TimeMin'] = '';
            $datas[$i]['SSLStatusId'] = '';
            $datas[$i]['ConnectStatusId'] = '';
            if($datas[$i]['InstallationStatusId'] == 1) {
                $datas[$i]['InstallationStatusId'] = '<span class="label label-default">Đã gỡ</span>';
            } else if($datas[$i]['InstallationStatusId'] == 2) {
                $InfoDeviceLog = $this->Mconstants->getInfoDeviceLog($datas[$i]['IMEI']);
                $datas[$i]['TimeMin'] = $InfoDeviceLog['gtgn'];
                $datas[$i]['ConnectStatusId'] = $InfoDeviceLog['ConnectStatusId'];
                $datas[$i]['InstallationStatusId'] = '<span class="label label-primary">Đang gán xe</span>';
                $SSLItem = $this->Mssls->getBy(['VehicleId' => $datas[$i]['VehicleId']], true);
                if(!empty($SSLItem)) {
                    $arrStatus = $this->Mconstants->sslStatus;
                    $nameStatus = $SSLItem['SSLStatusId'] > 0 ? $arrStatus[$SSLItem['SSLStatusId']] : '';
                    $labelCss = $this->Mconstants->labelCss;
                    $datas[$i]['SSLStatusId'] = '<span class="'.$labelCss[$SSLItem['SSLStatusId']].'">' . $nameStatus . '</span>';
                } else {
                    $datas[$i]['SSLStatusId'] = '--';
                }
            } else {
                $datas[$i]['InstallationStatusId'] = '<span class="label label-success">Chưa lắp đặt</span>';
            }
            $datas[$i]['GuaranteeStatusId'] = '';
            $html .= '<tr id="trItem_'.$datas[$i]['DeviceId'].'" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['DeviceId'].'"></td>';
                } else if(!empty($tables[$z]['DateTime'])){
                    $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                    $crDateTime = strpos(ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'),'00:00')?ddMMyyyy($datas[$i][$columnName],'d/m/Y'):ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="'.$displayNone.'" >'.getDayDiffText($dayDiff).$crDateTime.'</td>';
                }else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                    $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['DeviceId'].'">'.$datas[$i][$columnName].'</a></td>';
                }else if(!empty($tables[$z]['ModelsDb']) && !empty($tables[$z]['NameRelationship'])){
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                    $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                    $html .= '<td style="'.$displayNone.'" >'.$data.'</td>';
                }else {
                    if ($columnName == 'DeviceTypeName'){
                        if($datas[$i][$columnName]){
                            $labelCss = $this->Mconstants->labelCss;
                            $html .= '<td style="'.$displayNone.'" class="text-center"><span class="'.$labelCss[$datas[$i]['DeviceTypeId']].'">' . $datas[$i][$columnName] . '</span></td>';
                        }
                    }
                    else{
                        $html .= '<td style="'.$displayNone.'" >'.$datas[$i][$columnName].'</td>';

                    }
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
        $data['callBackTable'] = 'renderContentDevices';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }

}