<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "users";
        $this->_primary_key = "UserId";
    }
    public function userCodeName($userId,$prefix = 'UID'){
        return $prefix . '-' . ($userId + 100000);
    }

    public function apiLogin($userName, $userPass){
        if(!empty($userName) && !empty($userPass)){
            $query = "SELECT * FROM users WHERE UserPass=? AND StatusId=? AND RoleId = ? AND (UserName=? OR PhoneNumber=?) LIMIT 1";
            $param = array(md5($userPass), STATUS_ACTIVED, 1, $userName, $userName);
            $users = $this->getByQuery($query, $param);
            if(!empty($users)){
                $user = $users[0];
                if($user['UserLevelId'] == 1) return $user;
                else if(in_array($user['UserLevelId'], [2,3])) {
                    $owner = $this->Musers->get($user['UserId']);
                    if(intval($owner['StatusId']) == STATUS_ACTIVED){
                        return $user;
                    } 
                }
            }
        }
        return false;
    }

    public function login($userName, $userPass, $roleId = 0){
        if(!empty($userName) && !empty($userPass)){
            if($roleId > 0){
                $query = "SELECT * FROM users WHERE UserPass=? AND StatusId=? AND RoleId = ? AND (UserName=? OR PhoneNumber=?) LIMIT 1";
                $param = array(md5($userPass), STATUS_ACTIVED, $roleId, $userName, $userName);
            }
            else{
                $query = "SELECT * FROM users WHERE UserPass=? AND StatusId=? AND (UserName=? OR PhoneNumber=?) LIMIT 1";
                $param = array(md5($userPass), STATUS_ACTIVED, $userName, $userName);
            }
            $users = $this->getByQuery($query, $param);
            if(!empty($users)){
                $user = $users[0];
                return $user;
            }
        }
        return false;
    }

    public function checkExist($userId, $email, $phoneNumber){
        $query = "SELECT UserId FROM users WHERE UserId!=? AND StatusId=?";

        if(!empty($email) && !empty($phoneNumber)){
            $query .= " AND (Email=? OR PhoneNumber=?) LIMIT 1";
            $users = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $email, $phoneNumber));
        }
        elseif(!empty($email)){
            $query .= " AND Email=? LIMIT 1";
            $users = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $email));
        }
        elseif(!empty($phoneNumber)){
            $query .= " AND PhoneNumber=? LIMIT 1";
            $users = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $phoneNumber));
        }
        if (!empty($users)) return true;
        return false;
      
    }
    public function getCount($postData){
        $query = "StatusId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM users WHERE StatusId > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['CodeUser']) && !empty($postData['CodeUser'])) $query.=" AND CodeUser LIKE '%{$postData['UserName']}%'";
        if(isset($postData['UserName']) && !empty($postData['UserName'])) $query.=" AND UserName LIKE '%{$postData['UserName']}%'";
        if(isset($postData['FullName']) && !empty($postData['FullName'])) $query.=" AND FullName LIKE '%{$postData['FullName']}%'";
        if(isset($postData['Email']) && !empty($postData['Email'])) $query.=" AND Email LIKE '%{$postData['Email']}%'";
        if(isset($postData['PhoneNumber']) && !empty($postData['PhoneNumber'])) $query.=" AND PhoneNumber LIKE '%{$postData['PhoneNumber']}%'";
        if(isset($postData['GenderId']) && $postData['GenderId'] > 0) $query.=" AND GenderId=".$postData['GenderId'];
        if(isset($postData['StatusId']) && $postData['StatusId'] > 0) $query.=" AND StatusId=".$postData['StatusId'];
        if(isset($postData['RoleId']) && $postData['RoleId'] > 0) $query.=" AND RoleId=".$postData['RoleId'];
        if(isset($postData['GroupId']) && $postData['GroupId'] > 0) $query.=" AND UserId IN(SELECT UserId FROM usergroups WHERE GroupId={$postData['GroupId']})";
        if(isset($postData['AgentId']) && $postData['AgentId'] > 0) $query.=" AND AgentId=".$postData['AgentId'];
        if(isset($postData['ManagementUnitId']) && $postData['ManagementUnitId'] > 0) $query.=" AND ManagementUnitId=".$postData['ManagementUnitId'];
        return $query;
    }

    public function maxUserId(){
        $query = "SELECT MAX(UserId) AS UserId FROM users WHERE StatusId > 0 ";
        $data = $this->getByQuery($query);
        if(count($data) > 0) return $data[0]['UserId'];
        else return 0;
    }

    public function getBySessionId($sessionId, $select = 'UserId'){
        $user = $this->getBy(array('SessionId' => $sessionId, 'RoleId' => 1, 'StatusId' => STATUS_ACTIVED), true, '', $select);
        if($user){
            if($select == 'UserId') return $user['UserId'];
            return $user;
        }
        return false;
    }

    public function getListForSelect($userIdFirst = 0, $fullNameFist = '') {
        $retVal = array();
        if($userIdFirst > 0){
            $users = $this->getByQuery('SELECT UserId,UserName,FullName,PhoneNumber,Email FROM users WHERE StatusId = ? ORDER BY (CASE UserId WHEN ? THEN 1 ELSE 2 END) ASC, UserId DESC', array(STATUS_ACTIVED, $userIdFirst));
            $i = 0;
            foreach($users as $u){
                $i++;
                if($i == 1 && !empty($fullNameFist)) $u['FullName'] = $fullNameFist;
                $retVal[] = $u;
            }
        }
        else $retVal = $this->getBy(array('StatusId' => STATUS_ACTIVED), false, '', 'UserId,UserName,FullName,PhoneNumber,Email');
        return $retVal;
    }

    public function update($postData, $userId = 0, $isAdminUpdate = false, $groupIds = array(), $contactUsers = array(), $user, $dataDetail = array(), $userCards = array(), $provinceIds = array()){
        $isUpdate = $userId > 0;
        $this->db->trans_begin();
        $userId = $this->save($postData, $userId);
        if($userId > 0){
            if($isUpdate){
                if($isAdminUpdate) $this->db->delete('usergroups', array('UserId' => $userId));
                $this->db->delete('itemcontacts', array('ItemId' => $userId));
                $this->db->delete('usercards', array('UserId' => $userId));
                if($postData['RoleId'] == 2){
                    $this->db->delete('agentprovinces', array('AgentId' => $userId));
                }
            }
            if(!empty($groupIds)){
                $userGroups = array();
                foreach ($groupIds as $groupId) $userGroups[] = array('UserId' => $userId, 'GroupId' => $groupId);
                if(!empty($userGroups)) $this->db->insert_batch('usergroups', $userGroups);

            }            
            if(!empty($contactUsers)){
                $itemContacts = array();
                foreach ($contactUsers as $contactUser){
                    $contactUser['ItemId'] = $userId;
                    $contactUser['ItemTypeId'] = $postData['RoleId'];
                    $contactUser['StatusId'] = STATUS_ACTIVED;
                    $contactUser['UpdateStaffId'] =  $user['StaffId'];
                    $contactUser['UpdateDateTime'] = getCurentDateTime();
                    $itemContacts[] = $contactUser;
                } 
                if(!empty($itemContacts)) $this->db->insert_batch('itemcontacts', $itemContacts);
            }
            if(empty($postData['CodeUser'])) $this->db->update('users', array('CodeUser' => $this->genCustomerCode($userId, $postData['RoleId'])), array('UserId' => $userId));
            if(!empty($dataDetail)){
                $this->load->model('Muserdetails');
                $dataDetail['UserId'] = $userId;
                $userDetailId = $dataDetail['UserDetailId'];
                unset($dataDetail['UserDetailId']);
                $this->Muserdetails->save($dataDetail, $userDetailId);
            }
            if(!empty($userCards)){
                $arrUserCards = array();
                foreach ($userCards as $userCard) $arrUserCards[] = array('UserId' => $userId, 'RFID' => $userCard, 'StatusId' => STATUS_ACTIVED);
                if(!empty($arrUserCards)) $this->db->insert_batch('usercards', $arrUserCards);
            }
            if(!empty($provinceIds)){
                $arrProvinceIds = array();
                foreach ($provinceIds as $provinceId) $arrProvinceIds[] = array('AgentId' => $userId, 'ProvinceId' => $provinceId);
                if(!empty($arrProvinceIds)) $this->db->insert_batch('agentprovinces', $arrProvinceIds);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        }
        else {
            $this->db->trans_commit();
            return $userId;
        }
    }

    private function genCustomerCode($userId, $roleId){
        switch ($roleId){
            case 1:
            $prefix = 'KH';
            break;
            case 2:
            $prefix = 'DL';
            break;
            case 4:
            $prefix = 'LX';
            break;
            default:
            $prefix = 'NV';
        }
        return $prefix . '-' . ($userId + 10000);
    }


    public function searchByFilterUser($searchText, $itemFilters, $limit, $page, $userId, $roleId = 0){
        $agentLevelIds = $this->Mconstants->agentLevelId;
        $queryCount = "select users.UserId AS totalRow from users {joins} where {wheres}";
        $query = "select {selects} from users {joins} where {wheres} ORDER BY users.CrDateTime DESC LIMIT {limits}";
        if($roleId == 4){
            $selects = [
                'users.*',
                'userdetails.*',
            ];
            $joins = [
                'userdetails' => 'LEFT JOIN userdetails on userdetails.UserId = users.UserId',
            ];
        }else{
            $selects = [
                'users.*',
            ];
            $joins = [
            ];
        }
        
        $wheres = array('users.UserId > 0 AND users.StatusId > 0 AND UserLevelId = 1');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'users.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'users.CodeUser like ? or users.FullName like ? or users.ShortName like ? or users.Email like ? or users.PhoneNumber like ? ';
                for( $i = 0; $i < 5; $i++) $dataBind[] = "%$searchText%";
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
                        // $cond[0] là điều kiện ví dụ : < > = like .....   $cons[1] và $cond[2]  là gía trị điều kiện như 2017-01-02 và 2017-01-01
                switch ($filed_name) {
                    case 'status_id':
                    $wheres[] = "users.StatusId $conds[0] ?";
                    $dataBind[] = $conds[1];
                    break;
                    case 'licence_type_id':
                    $wheres[] = "userdetails.LicenceTypeId $conds[0] ?";
                    $dataBind[] = $conds[1];
                    break;
                    default :
                    break;
                }
            }
        }
        $this->load->model('Mssls');
        $userStatusList = $this->Mconstants->userStatusList;
        $userStatusLableCss = $this->Mconstants->userStatusLableCss;
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
        $controller = 'drivemycar';
        if($roleId == 1) $controller = 'customer';
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable(''.$controller.'', $userId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';
        $labelCss = $this->Mconstants->labelCss;
        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_'.$datas[$i]['UserId'].'" class="dnd-moved trItem ">';
            $checkSsls = $this->Mssls->checkSsl($datas[$i]['UserId']);
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['UserId'].'"></td>';
                } else if(!empty($tables[$z]['Status']) && $tables[$z]['Status'] != NULL){
                    $arrStatus = $this->Mconstants->$columnName;
                    $nameStatus = $datas[$i][$tables[$z]['Status']] > 0 ? $arrStatus[$datas[$i][$tables[$z]['Status']]] : '';
                    if($nameStatus){
                        $statusId = $datas[$i][$tables[$z]['Status']];
                        $html .= '<td style="'.$displayNone.'" class="text-center" id="show_and_hide_3"><span class="'.$labelCss[$statusId].'">' . $nameStatus . '</span></td>';
                    }else {
                        $html .= '<td style="'.$displayNone.'" class="text-center"></td>';
                    }

                }else if($columnName == 'BirthDay' || $columnName == 'CrDateTime' || $columnName == 'LoginTimes' || $columnName == 'CrStaffDateTime') {
                    if ($columnName == 'BirthDay') {
                        $html .= '<td style="' . $displayNone . '" >' . ddMMyyyy($datas[$i][$columnName]) . '</td>';
                    } else {
                        $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                        $crDateTime = strpos(ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'),'00:00')?ddMMyyyy($datas[$i][$columnName],'d/m/Y'):ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                        $html .= '<td style="' . $displayNone . '" >' . getDayDiffText($dayDiff) . $crDateTime . '</td>';
                    }
                }elseif ($columnName == 'StatusId'){
                    $checkLabelSsls='';
                    if($checkSsls != null && $datas[$i][$columnName] == 2 ){
                        $checkLabelSsls = 2;
                    }else if( $datas[$i][$columnName] == 1 ){
                        $checkLabelSsls = 1;
                    }else if( $datas[$i][$columnName] == 3 ){
                        $checkLabelSsls = 3;
                    }else{
                        $checkLabelSsls = 4;
                    }
                    $html .= '<td style="'.$displayNone.'" ><span class="'.$userStatusLableCss[$checkLabelSsls].'">'.$userStatusList[$checkLabelSsls].'</span></td>';
                    
                }else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['UserId'].'">'.$datas[$i][$columnName].'</a></td>';
                }else if(!empty($tables[$z]['ModelsDb']) || !empty($tables[$z]['NameRelationship'])){
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                    if($columnName == 'VehicleId'){

                                // check count data, cac truong hop rieng cua trang
                        $data = $this->$models->getCount(array('UserId' => $datas[$i]['UserId']));
                        $vehicleNumber = $this->$models->getCount(array());
                        $html .= '<td style="'.$displayNone.'" >'.$data.'/'.$vehicleNumber.'</td>';
                    }else if($columnName == 'AgentId'){

                        $data = $this->$models->getBy(array('AgentId' => $datas[$i]['UserId'] , 'AgentId >' => 0));
                        $html .= '<td style="'.$displayNone.'" >'.count($data).'</td>';
                    }else if ($columnName == 'AgentLevelId') {
                        $nameStatusCus = $datas[$i]['AgentLevelId'] > 0 ? $agentLevelIds[$datas[$i]['AgentLevelId']] : '';
                        $classStatus = isset($labelCss[$datas[$i]['AgentLevelId']]) ? $labelCss[$datas[$i]['AgentLevelId']]:'';
                        $html .= '<td style="'.$displayNone.'" class="text-center" id="show_and_hide_3"><span class="'.$classStatus.'">' . $nameStatusCus . '</span></td>';
                    }else if($columnName == 'ManagementUnitId'){
                        $columnId = 'StaffId';
                        $data = $this->$models->getFieldValue(array($columnId => $datas[$i][$columnName]), $nameRelationship, '');
                        $managementUnit = $datas[$i]['AgentLevelId'] == 1?$agentLevelIds[$datas[$i]['AgentLevelId']]:$data;
                        $html .= '<td style="'.$displayNone.'" >'.$managementUnit.'</td>';
                    }else{
                        $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                        $html .= '<td style="'.$displayNone.'" >'.$data.'</td>';
                    }
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
        $data['callBackTable'] = 'renderContentDatas';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }

    public function checkPermissionMenu($userId = 0, $userLevelId = 0, $ownerId = 0){
        $inforLogin = [];
        if(in_array($userLevelId, [1,2])) {
            if($userLevelId == 2)  $userId = $ownerId;
            $query = "SELECT 
            ssls.SSLId, 
            vehicles.VehicleId, 
            packages.PackageId, 
            rolemenus.*
            FROM ssls 
            LEFT JOIN vehicles on vehicles.VehicleId = ssls.VehicleId
            LEFT JOIN packages ON packages.PackageId = ssls.PackageId
            LEFT JOIN packageroles ON packages.PackageId = packageroles.PackageId
            LEFT JOIN rolemenus ON rolemenus.RoleMenuId = packageroles.RoleMenuId
            WHERE ssls.UserId = ? AND ssls.SSLStatusId IN (2) AND packages.StatusId = 2
            GROUP BY rolemenus.RoleMenuId ORDER BY rolemenus.RoleMenuId ASC"; // AND ssls.VehicleId > 0 //,3,4
            $datas = $this->getByQuery($query, array($userId));
            // if(count($datas) > 0){
                $roleMenuIds = array();
                foreach($datas as $d){
                    $roleMenuIds[] = $d['RoleMenuId'];
                }
                $this->load->model('Mssldetails');
                $sslId = count($datas) > 0 ? $datas[0]['SSLId']: 0;
                $querySslDetails = "SELECT 
                ssldetails.SSLId,
                packages.PackageId, 
                rolemenus.*
                FROM ssldetails
                LEFT JOIN packages ON packages.PackageId = ssldetails.PackageId
                LEFT JOIN packageroles ON packages.PackageId = packageroles.PackageId
                LEFT JOIN rolemenus ON rolemenus.RoleMenuId = packageroles.RoleMenuId
                WHERE ssldetails.SSLId =? AND ssldetails.SSLDetailStatusId IN (2) AND packages.StatusId = 2
                GROUP BY rolemenus.RoleMenuId ORDER BY rolemenus.RoleMenuId ASC";
                $sslDetails = $this->getByQuery($querySslDetails, array($sslId)); //,3,4
                if(count($sslDetails) > 0) {
                    $arrSslDetail = array();
                    foreach($sslDetails as $a){
                        if(!in_array($a['RoleMenuId'], $roleMenuIds)) {
                            $a['VehicleId'] = $datas[0]['VehicleId'];
                            $arrSslDetail[] = $a;
                        }
                    }
                    $inforLogin = array_merge($datas, $arrSslDetail);
                } else {
                    $inforLogin = $datas;
                }
                
            // }
            $this->load->model('Mrolemenus');
            $roleMenus = $this->Mrolemenus->getBy(array('RoleStatusId' => 3));
            foreach($roleMenus as $m) {
                $inforLogin[] = array(
                    'SSLId' => 0,
                    'PackageId' => 0,
                    'RoleMenuId' => $m['RoleMenuId'],
                    'RoleMenuName' => $m['RoleMenuName'],
                    'RoleMenuChildId' => $m['RoleMenuChildId'],
                    'RoleMenuUrl' => $m['RoleMenuUrl'],
                    'RoleLevel' => $m['RoleLevel'],
                    'RoleStatusId' => $m['RoleStatusId']
                );
            }
        } else if($userLevelId == 3) {
           
            // $query = "SELECT ssls.SSLId, 
            //         vehicles.VehicleId, 
            //         packages.PackageId, 
            //         rolemenus.*
            //     FROM ssls 
            //     LEFT JOIN vehicles on vehicles.VehicleId = ssls.VehicleId
            //     LEFT JOIN packages ON packages.PackageId = ssls.PackageId
            //     LEFT JOIN userrolemembers ON userrolemembers.UserId = ?
            //     LEFT JOIN userroles ON userroles.UserRoleId = userrolemembers.UserRoleId
            //     LEFT JOIN userroledetails ON userroledetails.UserRoleId = userroles.UserRoleId
            //     LEFT JOIN rolemenus ON rolemenus.RoleMenuId = userroledetails.RoleMenuId
            //     WHERE ssls.UserId = ?  AND ssls.SSLStatusId IN (2,3,4) AND rolemenus.RoleStatusId = 2
            //     GROUP BY rolemenus.RoleMenuId"; //AND ssls.VehicleId > 0
            // $datas = $this->getByQuery($query, array($userId, $ownerId));
            $datas = [];
            $roleMenus = $this->getByQuery("
                SELECT rolemenus.* FROM userrolemembers 
                LEFT JOIN userroles ON userroles.UserRoleId = userrolemembers.UserRoleId
                LEFT JOIN userroledetails ON userroledetails.UserRoleId = userroles.UserRoleId
                LEFT JOIN rolemenus ON rolemenus.RoleMenuId = userroledetails.RoleMenuId
                WHERE rolemenus.RoleStatusId IN (2,3) AND userrolemembers.UserId = ? GROUP BY rolemenus.RoleMenuId ORDER BY rolemenus.RoleMenuId ASC
            ", array($userId));
            $data2 = array();
            foreach($roleMenus as $m) {
                $data2[] = array(
                    'SSLId' => 0,
                    'PackageId' => 0,
                    'RoleMenuId' => $m['RoleMenuId'],
                    'RoleMenuName' => $m['RoleMenuName'],
                    'RoleMenuChildId' => $m['RoleMenuChildId'],
                    'RoleMenuUrl' => $m['RoleMenuUrl'],
                    'RoleLevel' => $m['RoleLevel'],
                    'RoleStatusId' => $m['RoleStatusId']
                );
            }
            $inforLogin = array_merge($datas, $data2);
        }
        $arrDataAll = array();
        foreach($inforLogin as $i){
            if($i['RoleMenuId'] != NULL){
                $arrDataAll[] = $i;
            }
            
        }
        
        return $arrDataAll;
    }

    public function changeStatus($statusId, $id, $fieldName = 'StatusId', $updateUserId = 0){
        $retVal = false;
        if($statusId >= 0 && $id > 0){
            if(empty($fieldName)) $fieldName = 'StatusId';
            if($updateUserId > 0) $id =  $this->save(array($fieldName => $statusId, 'UpdateUserId' => $updateUserId, 'UpdateDateTime' => getCurentDateTime()), $id);
            else $id = $this->save(array($fieldName => $statusId), $id);
            $retVal = $id > 0;
        }
        return $retVal;
    }


    public function checkRoleUser($userId){
        $list = $this->getByQuery('SELECT UserLevelId FROM users WHERE UserLevelId = 2 AND OwnerId ='. $userId);
        $i = 0;
        foreach ($list as $value) {
            if($value['UserLevelId'] == 2){
                $i = 1;
            }
        }
        return $i; 
    }

    public function getListUser($searchText = '', $pagination  = 0, $limit,$usd = 0){
        $page = $limit * $pagination;
        $dataBind = [];
        $where = '';
        if($searchText !='' && !empty($searchText)){
            $where = 'And (users.UserName like ?  or users.FullName like ? or users.ShortName like ? or users.Email like ? or users.PhoneNumber like ? or users.AddRess like ? or users.CodeUser like ? )';
            for( $i = 0; $i < 7; $i++) $dataBind[] = "%$searchText%";
        }
        if($usd == 1){
            $query = "SELECT * FROM users where StatusId = 2 AND UserLevelId = 1  ".$where." limit  ?, ?" ;
        }
        else if($usd == 2){
            $query = "SELECT * FROM users where StatusId = 2 AND RoleId = 4  ".$where." limit  ?, ?" ;
        }
        $dataBind[] = $page;
        $dataBind[] = $limit;
        return $this->getByQuery($query,$dataBind);
    }

    public function checkPermissionMenuCustomer($userId = 0, $userLevelId = 0, $ownerId = 0){
        $inforLogin = [];
        if(in_array($userLevelId, [1,2])) {
            if($userLevelId == 2)  $userId = $ownerId;
            $query = "SELECT 
            ssls.SSLId, 
            vehicles.VehicleId, 
            packages.PackageId, 
            rolemenus.*
            FROM ssls 
            LEFT JOIN vehicles on vehicles.VehicleId = ssls.VehicleId
            LEFT JOIN packages ON packages.PackageId = ssls.PackageId
            LEFT JOIN packageroles ON packages.PackageId = packageroles.PackageId
            LEFT JOIN rolemenus ON rolemenus.RoleMenuId = packageroles.RoleMenuId
            WHERE ssls.UserId = ? AND ssls.SSLStatusId IN (2,3,4) AND packages.StatusId = 2
            GROUP BY rolemenus.RoleMenuId ORDER BY rolemenus.RoleMenuId ASC"; // AND ssls.VehicleId > 0 //,3,4
            $datas = $this->getByQuery($query, array($userId));
            // if(count($datas) > 0){
                $roleMenuIds = array();
                foreach($datas as $d){
                    $roleMenuIds[] = $d['RoleMenuId'];
                }
                $this->load->model('Mssldetails');
                $sslId = count($datas) > 0 ? $datas[0]['SSLId']: 0;
                $querySslDetails = "SELECT 
                ssldetails.SSLId,
                packages.PackageId, 
                rolemenus.*
                FROM ssldetails
                LEFT JOIN packages ON packages.PackageId = ssldetails.PackageId
                LEFT JOIN packageroles ON packages.PackageId = packageroles.PackageId
                LEFT JOIN rolemenus ON rolemenus.RoleMenuId = packageroles.RoleMenuId
                WHERE ssldetails.SSLId =? AND ssldetails.SSLDetailStatusId IN (2,3,4) AND packages.StatusId = 2
                GROUP BY rolemenus.RoleMenuId ORDER BY rolemenus.RoleMenuId ASC";
                $sslDetails = $this->getByQuery($querySslDetails, array($sslId)); //,3,4
                if(count($sslDetails) > 0) {
                    $arrSslDetail = array();
                    foreach($sslDetails as $a){
                        if(!in_array($a['RoleMenuId'], $roleMenuIds)) {
                            $a['VehicleId'] = $datas[0]['VehicleId'];
                            $arrSslDetail[] = $a;
                        }
                    }
                    $inforLogin = array_merge($datas, $arrSslDetail);
                } else {
                    $inforLogin = $datas;
                }
                
            // }
            $this->load->model('Mrolemenus');
            $roleMenus = $this->Mrolemenus->getBy(array('RoleStatusId' => 3));
            foreach($roleMenus as $m) {
                $inforLogin[] = array(
                    'SSLId' => 0,
                    'PackageId' => 0,
                    'RoleMenuId' => $m['RoleMenuId'],
                    'RoleMenuName' => $m['RoleMenuName'],
                    'RoleMenuChildId' => $m['RoleMenuChildId'],
                    'RoleMenuUrl' => $m['RoleMenuUrl'],
                    'RoleLevel' => $m['RoleLevel'],
                    'RoleStatusId' => $m['RoleStatusId']
                );
            }
        } else if($userLevelId == 3) {
            $datas = [];
            $roleMenus = $this->getByQuery("
                SELECT rolemenus.* FROM userrolemembers 
                LEFT JOIN userroles ON userroles.UserRoleId = userrolemembers.UserRoleId
                LEFT JOIN userroledetails ON userroledetails.UserRoleId = userroles.UserRoleId
                LEFT JOIN rolemenus ON rolemenus.RoleMenuId = userroledetails.RoleMenuId
                WHERE rolemenus.RoleStatusId IN (2,3) AND userrolemembers.UserId = ? GROUP BY rolemenus.RoleMenuId ORDER BY rolemenus.RoleMenuId ASC
            ", array($userId));
            $data2 = array();
            foreach($roleMenus as $m) {
                $data2[] = array(
                    'SSLId' => 0,
                    'PackageId' => 0,
                    'RoleMenuId' => $m['RoleMenuId'],
                    'RoleMenuName' => $m['RoleMenuName'],
                    'RoleMenuChildId' => $m['RoleMenuChildId'],
                    'RoleMenuUrl' => $m['RoleMenuUrl'],
                    'RoleLevel' => $m['RoleLevel'],
                    'RoleStatusId' => $m['RoleStatusId']
                );
            }
            $inforLogin = array_merge($datas, $data2);
        }
        $arrDataAll = array();
        foreach($inforLogin as $i){
            if($i['RoleMenuId'] != NULL){
                $arrDataAll[] = $i;
            }
            
        }
        
        return $arrDataAll;
    }


}