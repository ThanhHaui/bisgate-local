<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mstaffs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "staffs";
        $this->_primary_key = "StaffId";
    }


    public function checkExistLogin($userId, $email, $phoneNumber){
        $query = "SELECT StaffId FROM staffs WHERE StaffId!=? AND StatusId=?";
        if(!empty($email) && !empty($phoneNumber)){
            $query .= " AND (Email=? OR PhoneNumber=?) LIMIT 1";
            $staffs = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $email, $phoneNumber));
        }
        elseif(!empty($email)){
            $query .= " AND Email=? LIMIT 1";
            $staffs = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $email));
        }
        elseif(!empty($phoneNumber)){
            $query .= " AND PhoneNumber=? LIMIT 1";
            $staffs = $this->getByQuery($query, array($userId, STATUS_ACTIVED, $phoneNumber));
        }
        if (!empty($staffs)) return true;
        return false;
    }
    
    public function login($userName, $userPass, $roleId = 0){
        if(!empty($userName) && !empty($userPass)){
            if($roleId > 0){
                $query = "SELECT * FROM staffs WHERE StaffPass=? AND StatusId=? AND StaffRoleId = ? AND (StaffName=? OR PhoneNumber=?) LIMIT 1";
                $param = array(md5($userPass), STATUS_ACTIVED, $roleId, $userName, $userName);
            }
            else{
                $query = "SELECT * FROM staffs WHERE StaffPass=? AND StatusId=? AND (StaffName=? OR PhoneNumber=?) LIMIT 1";
                $param = array(md5($userPass), STATUS_ACTIVED, $userName, $userName);
            }
            $staffs = $this->getByQuery($query, $param);
            $user = [];
            if(!empty($staffs)){
                $user = $staffs[0];
                return $user;
            }
        }
        return false;
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM staffs WHERE StatusId > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    public function getCount($postData = array()){
        $query = "StatusId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['CheckStaffRole']) && $postData['CheckStaffRole'] > 0) $query.=" AND StaffTypeId = 0";
        return $query;
    }

    public function checkRoleStaff(){
        $list = $this->getByQuery('SELECT StaffRoleId FROM staffs');
        $i = 0;
        foreach ($list as $value) {
            if($value['StaffRoleId'] == 2){
                $i = 1;
            }
        }
        return $i; 
    }
    public function changeStatus($statusId, $id, $fieldName = 'StatusId', $updateUserId = 0){
        $retVal = false;
        if($statusId >= 0 && $id > 0){
            if(empty($fieldName)) $fieldName = 'StatusId';
            if($updateUserId > 0) $id =  $this->save(array($fieldName => $statusId, 'UpdateStaffId' => $updateUserId, 'UpdateDateTime' => getCurentDateTime()), $id);
            else $id = $this->save(array($fieldName => $statusId), $id);
            $retVal = $id > 0;
        }
        return $retVal;
    }

    public function checkExist($staffid, $email, $phoneNumber, $staffName){
       
        $query = "SELECT StaffId FROM staffs WHERE StaffId!=? AND StatusId=?";
        if(!empty($email) && !empty($phoneNumber) && !empty($staffName)){
            $query .= " AND (Email=? OR PhoneNumber=? OR  StaffName LIKE '%".$staffName."%') LIMIT 1";
            $staffs = $this->getByQuery($query, array($staffid, STATUS_ACTIVED, $email, $phoneNumber));
        }
        elseif(!empty($email) && !empty($phoneNumber)){
            $query .= " AND (Email=? OR PhoneNumber=?) LIMIT 1";
            $staffs = $this->getByQuery($query, array($staffid, STATUS_ACTIVED, $email, $phoneNumber));
        }
        elseif(!empty($phoneNumber) && !empty($staffName)){
            $query .= " AND (PhoneNumber=? OR StaffName LIKE '%".$staffName."%') LIMIT 1";
            $staffs = $this->getByQuery($query, array($staffid, STATUS_ACTIVED, $phoneNumber));
        }
        elseif(!empty($staffName) && !empty($email)){
            $query .= "  AND (Email=? OR StaffName LIKE '%".$staffName."%') LIMIT 1";
            $staffs = $this->getByQuery($query, array($staffid, STATUS_ACTIVED, $email));
        } else if(!empty($email)){
            $query .= " AND Email=? LIMIT 1";
            $staffs = $this->getByQuery($query, array($staffid, STATUS_ACTIVED, $email));
        } else if(!empty($phoneNumber)){
            $query .= " AND PhoneNumber=? LIMIT 1";
            $staffs = $this->getByQuery($query, array($staffid, STATUS_ACTIVED, $phoneNumber));
        } else if(!empty($staffName)){
            $query .= "  AND StaffName LIKE '%".$staffName."%' LIMIT 1";
            $staffs = $this->getByQuery($query, array($staffid, STATUS_ACTIVED));
        }
        if (!empty($staffs)) return true;
        return false;
    }

    public function update($postData = array(), $staffId = 0, $groupStaff = array(), $schoolReports = array(), $jobTitles = array(), $experiences = array(), $tagNames = array(), $itemTypeId = 10, $contactUsers = array(), $provinceIds = array(), $staff = array() ,$checkPass = 0)
    {
        $isUpdate = $staffId > 0;
        $this->db->trans_begin();
        $staffId = $this->save($postData, $staffId);
        if($checkPass==1){
            $this->session->unset_userdata('user');
        }
        if ($staffId > 0) {
            if ($isUpdate) {
                $this->db->delete('staffgroups', array('StaffId' => $staffId));
                $this->db->delete('schoolreports', array('StaffId' => $staffId));
                $this->db->delete('jobtitles', array('StaffId' => $staffId));
                $this->db->delete('experiences', array('StaffId' => $staffId));
                $this->db->delete('itemtags', array('ItemId' => $staffId, 'ItemTypeId' => $itemTypeId));
                $this->db->delete('itemcontacts', array('ItemId' => $staffId));
                $this->db->delete('agentprovinces', array('AgentId' => $staffId));
            } else {
                $this->db->update('staffs', array('StaffCode' => $this->genStaffCode($staffId,$itemTypeId)), array('StaffId' => $staffId));
            }
            /**
             * Kiểm tra quyền
             */
            if (isset($postData['StaffRoleId']) && ($postData['StaffRoleId'] > 2)) {
                if (!empty($groupStaff)) {
                    $arrGroupStaff = array();
                    foreach ($groupStaff as $group) {
                        $arrGroupStaff[] = array(
                            'StaffId' => $staffId,
                            'GroupId' => $group['GroupId'],
                            'CrDateTime' => getCurentDateTime()
                        );
                    }
                    if (!empty($arrGroupStaff)) $this->db->insert_batch('staffgroups', $arrGroupStaff);
                }
            } 

            if (!empty($schoolReports)) {
                $arrSchoolReport = array();
                foreach ($schoolReports as $schoolReport) {
                    $schoolReport['StartDate'] = !empty($schoolReport['StartDate']) ? ddMMyyyyToDate($schoolReport['EndDate']) : NULL;
                    $schoolReport['EndDate'] = !empty($schoolReport['EndDate']) ? ddMMyyyyToDate($schoolReport['EndDate']) : NULL;
                    $schoolReport['StaffId'] = $staffId;
                    $arrSchoolReport[] = $schoolReport;
                }
                if (!empty($arrSchoolReport)) $this->db->insert_batch('schoolreports', $arrSchoolReport);
            }

            if (!empty($jobTitles)) {
                $arrJobTitle = array();
                foreach ($jobTitles as $jobTitle) {
                    $jobTitle['StaffId'] = $staffId;
                    $arrJobTitle[] = $jobTitle;
                }
                if (!empty($arrJobTitle)) $this->db->insert_batch('jobtitles', $arrJobTitle);
            }

            if (!empty($experiences)) {
                $arrExperience = array();
                foreach ($experiences as $experience) {
                    $experience['StartDate'] = !empty($experience['StartDate']) ? ddMMyyyyToDate($experience['EndDate']) : NULL;
                    $experience['EndDate'] = !empty($experience['EndDate']) ? ddMMyyyyToDate($experience['EndDate']) : NULL;
                    $experience['StaffId'] = $staffId;
                    $arrExperience[] = $arrExperience;
                }
                if (!empty($arrExperience)) $this->db->insert_batch('experiences', $arrExperience);
            }

            if (!empty($tagNames)) {
                $this->load->model('Mtags');
                $itemTags = array();
                foreach ($tagNames as $tagName) {
                    $tagId = $this->Mtags->getTagId($tagName, $itemTypeId);
                    if ($tagId > 0) {
                        $itemTags[] = array(
                            'ItemId' => $staffId,
                            'ItemTypeId' => $itemTypeId,
                            'TagId' => $tagId
                        );
                    }
                }
                if (!empty($itemTags)) $this->db->insert_batch('itemtags', $itemTags);
            }

            if (!empty($contactUsers)) {
                $itemContacts = array();
                foreach ($contactUsers as $contactUser) {
                    $contactUser['ContactName'] = !empty($contactUser['ContactName']) ? $contactUser['ContactName'] : NULL;
                    $contactUser['PositionName'] = !empty($contactUser['PositionName']) ? $contactUser['PositionName'] : NULL;
                    $contactUser['PhoneNumber'] = !empty($contactUser['PhoneNumber']) ? $contactUser['PhoneNumber'] : NULL;
                    $contactUser['Email'] = !empty($contactUser['Email']) ? $contactUser['Email'] : NULL;
                    $contactUser['ItemId'] = $staffId;
                    $contactUser['ItemTypeId'] = ID_LOG_AGENT;
                    $contactUser['StatusId'] = STATUS_ACTIVED;
                    $contactUser['UpdateStaffId'] = $staff['StaffId'];
                    $contactUser['UpdateDateTime'] = getCurentDateTime();
                    $itemContacts[] = $contactUser;
                }
                if (!empty($itemContacts)) $this->db->insert_batch('itemcontacts', $itemContacts);
            }

            if (!empty($provinceIds)) {
                $arrProvinceIds = array();
                foreach ($provinceIds as $provinceId) $arrProvinceIds[] = array('AgentId' => $staffId, 'ProvinceId' => $provinceId);
                if (!empty($arrProvinceIds)) $this->db->insert_batch('agentprovinces', $arrProvinceIds);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return $staffId;
        }
    }

    public function genStaffCode($staffId = 0,$itemTypeId = 10){
        if($itemTypeId == 2){
            $prefix = 'DL';
        }
        else{
            $prefix = 'UID';
        }
        return $prefix . '-' . ($staffId + 10000);
    }

    public function getListManagerUnit($searchText = '',$typeId = 0,$staffId = 0){
        $where = '';
        if(!empty($searchText)) $where = ' AND (FullName LIKE "%'.$searchText.'%" OR NickName LIKE "%'.$searchText.'%" OR StaffName LIKE "%'.$searchText.'%")';
        $query = "SELECT * FROM staffs WHERE StatusId > 0 AND StaffId !=?  AND AgentLevelId =? ".$where;
        return $this->getByQuery($query,array($staffId,$typeId));
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $staffId, $staffLogin){
        $queryCount = "select staffs.StaffId AS totalRow from staffs {joins} where {wheres}";
        $query = "select {selects} from staffs {joins} where {wheres} ORDER BY staffs.CrDateTime DESC LIMIT {limits}";

        $selects = [
            'staffs.*',
        ];
        $joins = [
        ];
        $jobLevelId = $this->Mconstants->jobLevelId;
        $status = $this->Mconstants->itemStaffStatus;
        $labelStaffCss = $this->Mconstants->labelStaffCss;
        $labelStaffTypeCss = $this->Mconstants->labelStaffTypeCss;
        $staffRoleId = $this->Mconstants->staffRoleId;
        $staffLoginRole = $this->Mstaffs->getFieldValue(array('StaffId'=>$staffLogin['StaffId']),'StaffRoleId','');
        $wheres = array('staffs.StaffId > 0 AND staffs.StatusId > 0 ');
        $wheres = array('staffs.StaffTypeId = 0');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'staffs.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'staffs.StaffName like ? or staffs.FullName like ? or staffs.ShortName like ? or staffs.Email like ? or staffs.PhoneNumber like ? ';
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
                    $wheres[] = "staffs.StatusId $conds[0] ?";
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
        $controller = 'staff';
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable(''.$controller.'', $staffId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';
        for ($i = 0; $i < count($datas); $i++) {
            if($datas[$i]['StatusId'] > 0) {
                $html .= '<tr id="trItem_'.$datas[$i]['StaffId'].'" class="dnd-moved trItem ">';
                for ($z = 0; $z < count($tables); $z++) {
                    $displayNone = '';
                    if($tables[$z]['IsActive'] == 'OFF'){
                        $displayNone = 'display:none';
                    }
                    $columnName = $tables[$z]['ColumnName'];

                    if($columnName == 'Check'){
                        $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['StaffId'].'"></td>';
                    } else if($columnName == 'BirthDay' || $columnName == 'CrDateTime' || $columnName == 'LoginTimes') {
                        if ($columnName == 'BirthDay') {
                            $html .= '<td style="' . $displayNone . '" >' . ddMMyyyy($datas[$i][$columnName]) . '</td>';
                        } else {
                            $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                            $crDateTime = ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                            $html .= '<td style="' . $displayNone . '" >' . getDayDiffText($dayDiff) . $crDateTime . '</td>';
                        }
                    }else if ($columnName == 'StaffCode'){
                            if($datas[$i]['StaffId'] == $staffLogin['StaffId']) {
                                $html .= '<td style="'.$displayNone.'" ><a href="'.base_url('staff/view').'/'.$datas[$i]['StaffId'].'">'.$datas[$i]['StaffCode'].'</a></td>';
                            }else{
                                if ((($staffLoginRole == 1) && ($datas[$i]['StaffRoleId'] != 1)) || (($staffLoginRole == 2) && ($datas[$i]['StaffRoleId'] == 3))){
                                    $html .= '<td style="'.$displayNone.'" ><a href="'.base_url('staff/edit').'/'.$datas[$i]['StaffId'].'">'.$datas[$i]['StaffCode'].'</a></td>';
                                }else{
                                    $html .= '<td style="'.$displayNone.'" ><a class="show_info_user list-staff-name" data-modal ="#btnShowModalInfoUser_'.$datas[$i]['StaffId'].'" user-id="'.$datas[$i]['StaffId'].'">'.$datas[$i]['StaffCode'].'</a></td>';
                                }
                            }
                        }elseif ($columnName == 'FullName'){
                            $html .= '<td style="'.$displayNone.'" >
                                        <a class="show_info_user list-staff-name" data-modal ="#btnShowModalInfoUser_'.$datas[$i]['StaffId'].'" user-id="'.$datas[$i]['StaffId'].'"><img class="img-table width30" src="'.USER_PATH.$datas[$i]['Avatar'].'" alt="" onError="this.onerror=null;this.src=\'assets/vendor/dist/img/no_img.jpg\';">
                                            <p class="d-inline-block m-0 staff_level '.(!empty($datas[$i]['JobLevelId'] && $datas[$i]['JobLevelId'] > 0)?'':'none_level').'">
                                            <span class="full_name   '.$labelStaffCss[$datas[$i]['StatusId']].'">' .$datas[$i]['FullName'].'</span>
                                            <span class="staff-level ">'.(!empty($datas[$i]['JobLevelId'] && $datas[$i]['JobLevelId'] > 0)?$jobLevelId[$datas[$i]['JobLevelId']]:'').'</span>
                                            </p>
                                        </a>
                                    </td>';
                        }elseif ($columnName == 'JobLevelId'){
                            $html .= '<td style="'.$displayNone.'" >'.(!empty($datas[$i]['JobLevelId'] && $datas[$i]['JobLevelId'] > 0)?$jobLevelId[$datas[$i]['JobLevelId']]:'').'</td>';
                        }elseif ($columnName == 'StatusId'){
                            $html .= '<td style="'.$displayNone.'" ><span class="'.$labelStaffCss[$datas[$i]['StatusId']].'staff label">'.$status[$datas[$i]['StatusId']].'</span></td>';
                        }elseif ($columnName == 'StaffRoleId'){
                            if(isset($datas[$i]['StaffRoleId']) && !empty($datas[$i]['StaffRoleId']) && $datas[$i]['StaffRoleId'] > 0){
                                $html .= '<td style="'.$displayNone.'" ><span class="'.$labelStaffTypeCss[$datas[$i]['StaffRoleId']].'">'.$staffRoleId[$datas[$i]['StaffRoleId']].'</span></td>';
                            } else {
                                $html .= '<td style="'.$displayNone.'" ></td>';
                            }
                        } else if ($columnName == 'AgentLevelId'){
                            $html .= '<td class="agent_level agent_level_'.((int)$datas[$i][$columnName] -1).'" style="'.$displayNone.'" > <span>Đại lí cấp '.((int)$datas[$i][$columnName] -1) .'</span></td>';
                        } else if ($columnName){
                            $html .= '<td style="'.$displayNone.'" >'.$datas[$i][$columnName].'</td>';
                        } else {
                            $html .= '<td style="'.$displayNone.'" ></td>';
                        }
                }
                $html .= '</tr>';
            }
            
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
    public function getCountStaff($groupId){
		$num = " StaffId IN (SELECT StaffId from staffgroups WHERE GroupId = {$groupId})";
		return $this->countRows($num);
    }
    public function getCountActive(){
        $query = "StatusId = 2" ;
        return $this->countRows($query);
    }
}
