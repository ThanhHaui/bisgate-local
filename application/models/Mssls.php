<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mssls extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "ssls";
        $this->_primary_key = "SSLId";
    }
   public function checkSsl($userId){
        $query = "SELECT ssls.* FROM ssls WHERE ssls.SSLStatusId IN (2,3,4) AND UserId = ".$userId;
        return $this->getByQuery($query);
    }

    public function update($postData = array(), $sslId = 0, $sslDetails = array(), $user = array(), $commentLogSSL = array(), $deadline = array(), $commentLogDeadline = array(), $actionTypeId = 0){
        $actionLogs = array();
        $isUpdate = $sslId > 0 ? true : false;
        $this->db->trans_begin();
        $sslId = $this->save($postData, $sslId);
        if($sslId > 0){
            $this->load->model('Mdeadlines');
            $this->load->model('Mdeadlinessls');
            $this->load->model('Mactionlogs');
            $deadline['DeadlineStatusId'] = 1; // Chờ áp dụng
            $deadline['CrUserId'] = $user['StaffId'];
            $deadline['CrDateTime'] = getCurentDateTime();

            if($isUpdate){
                if(!empty($sslDetails)){
                    $flag = false;
                    foreach($sslDetails as $s){
                        if($s['CheckAdd'] == 0){
                            $flag = true;
                            break;
                        }
                    }
                    if($flag ){
                        $deadlineId = $this->Mdeadlines->save($deadline);
                        $logDeadlines = array();
                        if($deadlineId){
                            $this->db->update('deadlines', array('DeadlineCode' => $this->genSSLCode($deadlineId, 'KHPM')), array('DeadlineId' => $deadlineId));
                            $flagDeadLiness = $this->Mdeadlinessls->save(array(
                                'DeadlineId' => $deadlineId,
                                'SSLId' => $sslId,
            
                            ));
                            if($flagDeadLiness) $this->Mactionlogs->saveLog($deadlineId, ID_LOG_DEADLINE, $actionTypeId, $user, $commentLogDeadline, TYPE_UPDATE_2);
                            if(!empty($sslDetails)){
                                $arrDeadlineDetails = array();
                                foreach($sslDetails as $s){
                                    if($s['CheckAdd'] == 0){
                                        $s['DeadlineId'] = $deadlineId;
                                        $s['PackagePrice'] = replacePrice($s['PackagePrice']);
                                        $s['ExpiryDate'] = replacePrice($s['ExpiryDate']);
                                        unset($s['CheckAdd']);
                                        $arrDeadlineDetails[] = $s;
                                    }
                                    
                                }
                                if(!empty($arrDeadlineDetails)) $this->db->insert_batch('deadlinedetails', $arrDeadlineDetails);
                            }
                        }
                    }
                    
                }
            }else{
                $this->db->update('ssls', array('SSLCode' => $this->genSSLCode($sslId)), array('SSLId' => $sslId));

                $deadlineId = $this->Mdeadlines->save($deadline);
                $logDeadlines = array();
                if($deadlineId){
                    $this->db->update('deadlines', array('DeadlineCode' => $this->genSSLCode($deadlineId, 'KHPM')), array('DeadlineId' => $deadlineId));
                    $flagDeadLiness = $this->Mdeadlinessls->save(array(
                        'DeadlineId' => $deadlineId,
                        'SSLId' => $sslId,
    
                    ));
                    if($flagDeadLiness) $this->Mactionlogs->saveLog($deadlineId, ID_LOG_DEADLINE, $actionTypeId, $user, $commentLogDeadline);
                    if(!empty($sslDetails)){
                        $arrDeadlineDetails = array();
                        foreach($sslDetails as $s){
                            if($s['CheckAdd'] == 0){
                                $s['DeadlineId'] = $deadlineId;
                                $s['PackagePrice'] = replacePrice($s['PackagePrice']);
                                $s['ExpiryDate'] = replacePrice($s['ExpiryDate']);
                                unset($s['CheckAdd']);
                                $arrDeadlineDetails[] = $s;
                            }
                            
                        }
                        if(!empty($arrDeadlineDetails)) $this->db->insert_batch('deadlinedetails', $arrDeadlineDetails);
                    }
                }
            }
            
            if(!empty($sslDetails)){
                $arrSSLDetails = array();
                foreach($sslDetails as $s){
                    if($s['CheckAdd'] == 0){
                        unset($s['PackagePrice']);
                        unset($s['ExpiryDate']);
                        unset($s['CheckAdd']);
                        $s['SSLId'] = $sslId;
                        $s['SSLDetailStatusId'] = 1;
                        $s['ContractStatusId'] = 2;
                        $arrSSLDetails[] = $s;
                        $this->db->delete('ssldetails', array('SSLId' => $sslId, 'SSLDetailStatusId' => 1));
                    }
                }

                if(!empty($arrSSLDetails)) $this->db->insert_batch('ssldetails', $arrSSLDetails);
               
            }

            $this->Mactionlogs->saveLog($sslId, ID_LOG_SSL, $actionTypeId, $user, $commentLogSSL, TYPE_UPDATE_2);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        }
        else {
            $this->db->trans_commit();
            return $sslId;
        }
    }

    public function genSSLCode($sslId, $prefix = 'SSL'){
        return $prefix . '-' . ($sslId + 10000);
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId){
        $queryCount = "select ssls.SSLId AS totalRow from ssls {joins} where {wheres}";
        $query = "select {selects} from ssls {joins} where {wheres} ORDER BY ssls.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'ssls.*',
            'users.FullName',
            'vehicles.LicensePlate',
        ];
        $joins = [
            'users' => 'LEFT JOIN users on users.UserId = ssls.UserId',
            'vehicles' => 'LEFT JOIN vehicles on vehicles.VehicleId = ssls.VehicleId',
        ];
        $wheres = array('ssls.SSLStatusId > 0');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'ssls.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'ssls.SSLCode like ? or users.FullName like ? or vehicles.LicensePlate like ? ';
                for( $i = 0; $i < 3; $i++) $dataBind[] = "%$searchText%";
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
                        $wheres[] = "ssls.SSLStatusId $conds[0] ?";
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
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('ssl', $userId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';

        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_'.$datas[$i]['SSLId'].'" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['SSLId'].'"></td>';
                }else if(!empty($tables[$z]['Status']) && $tables[$z]['Status'] != NULL){
                    $arrStatus = $this->Mconstants->$columnName;
                    $nameStatus = $datas[$i][$tables[$z]['Status']] > 0 ? $arrStatus[$datas[$i][$tables[$z]['Status']]] : '';
                    if($nameStatus){
                        $labelCss = $this->Mconstants->labelCss;
                        $html .= '<td style="'.$displayNone.'" class="text-center"><span class="'.$labelCss[$datas[$i][$tables[$z]['Status']]].'">' . $nameStatus . '</span></td>';
                    }else{
                        $html .= '<td style="'.$displayNone.'" class="text-center"></td>';
                    }
                    
                } else if(!empty($tables[$z]['DateTime'])){
                    $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                    $crDateTime = strpos(ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'),'00:00')?ddMMyyyy($datas[$i][$columnName],'d/m/Y'):ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="'.$displayNone.'" >'.getDayDiffText($dayDiff).$crDateTime.'</td>';
                }else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                    $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['SSLId'].'">'.$datas[$i][$columnName].'</a></td>';
                }else if(!empty($tables[$z]['ModelsDb']) && !empty($tables[$z]['NameRelationship'])){
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                    // if($columnName == 'VehicleId'){
                    //     $data = count($this->$models->getBy(array('VehicleId' =>  $datas[$i][$columnName], 'VehicleStatusId' => STATUS_ACTIVED)));
                    // }else{
                        $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                    // }
                    
                    $html .= '<td style="'.$displayNone.'" >'.$data.'</td>';
                }else {
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
        $data['callBackTable'] = 'renderContentSSLs';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }

    public function convertActiveExpiryDateToDay($startDate = '', $endDate = ''){
        if(!empty($startDate) && !empty($endDate)){
            $startDate = strtotime(date('Y-m-d H:i',strtotime($startDate)));
            $endDate = strtotime(date('Y-m-d H:i',strtotime($endDate)));
            $todayDate = strtotime(date('Y-m-d H:i',strtotime(getCurentDateTime())));
            if($startDate > $todayDate){
//                $datediff = abs($endDate - $startDate);
                $datediff = $endDate - $startDate;
            }
            else{
                $datediff = $endDate - $todayDate;
            }
            return ceil($datediff / (60*60*24));
        } else return 0;
        
    }

    public function getSslInUser($sslsIds = array(), $searchText, $userId){
        $where = '';
        $sslsIds = join(",",$sslsIds);
        
        if(!empty($sslsIds)) $where .= ' AND ssls.SSLId NOT IN ('.$sslsIds.')';
        if(!empty($searchText)) $where .= ' AND ( ssls.SSLCode LIKE "%'.$searchText.'%" OR vehicles.LicensePlate LIKE "%'.$searchText.'%" )';

        $query = "SELECT ssls.SSLId, ssls.SSLCode, vehicles.VehicleId, vehicles.LicensePlate, ssls.PackageId, ssls.SSLStatusId, ssls.UpdateDateTime  FROM ssls LEFT JOIN vehicles ON vehicles.VehicleId = ssls.VehicleId WHERE ssls.UserId = $userId AND ssls.SSLStatusId IN (1,2,4) ".$where;
        return $this->getByQuery($query);
    }
    public function getModalSSL($userId){
    $query = "SELECT ssls.* FROM ssls WHERE ssls.SSLStatusId IN (1,2,4) AND VehicleId = 0 AND UserId = {$userId}";
        return $this->getByQuery($query);
    }

    public function checkActiveSSL($SSLIds = array()) {
        if(isset($SSLIds)){
            $SSLIds = join(",",$SSLIds);
            if(!empty($SSLIds)) {
                $query = "SELECT 1=1 FROM ssls WHERE ssls.SSLStatusId NOT IN (3,5,6) AND ssls.SSLId  IN (".$SSLIds.") ";
                return count($this->getByQuery($query));
            } else return false;
        } else return false;
       
    }
    public function checkPermissionSSL($sslId){
        $showRoleSSL = [];
        $query = "SELECT 
        packages.PackageId, 
        ssls.SSLStatusId,
        packages.StatusId,
        rolemenus.*
        FROM ssls 
        LEFT JOIN packages ON packages.PackageId = ssls.PackageId
        LEFT JOIN packageroles ON packages.PackageId = packageroles.PackageId
        LEFT JOIN rolemenus ON rolemenus.RoleMenuId = packageroles.RoleMenuId
        WHERE ssls.SSLId = ? AND ssls.SSLStatusId IN (2,3,4)"; 
        $data = $this->getByQuery($query, array($sslId));

        $roleSSLIds = array();
        foreach($data as $d){
            $roleSSLIds[] = $d['RoleMenuId'];
        }
        $querySslDetails = "SELECT 
        packages.PackageId, 
        ssldetails.SSLDetailStatusId,
        packages.StatusId,
        rolemenus.*
        FROM ssldetails
        LEFT JOIN packages ON packages.PackageId = ssldetails.PackageId
        LEFT JOIN packageroles ON packages.PackageId = packageroles.PackageId
        LEFT JOIN rolemenus ON rolemenus.RoleMenuId = packageroles.RoleMenuId
        WHERE ssldetails.SSLId =? AND ssldetails.SSLDetailStatusId IN (2,3,4)";
        $sslDetails = $this->getByQuery($querySslDetails, array($sslId)); 
        if(count($sslDetails) > 0) {
            $arrSslDetail = array();
            foreach($sslDetails as $arrDetail){
                if(!in_array($arrDetail['RoleMenuId'], $roleSSLIds)) {
                    $arrSslDetail[] = $arrDetail;
                }
            }
            $showRoleSSL = array_merge($data, $arrSslDetail,$sslDetails);
        } else {
            $showRoleSSL = $data;
        }
        return $showRoleSSL;
    }

}