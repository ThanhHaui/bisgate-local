<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mgroups extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "groups";
        $this->_primary_key = "GroupId";
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM `groups` WHERE StatusId > 0" . $this->buildQuery($postData);
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
        return $query;
    }


    public function searchByFilter($searchText, $itemFilters, $limit, $page, $staffId){
        $labelCss = $this->Mconstants->itemStaffStatus;
        $status = $this->Mconstants->itemStaffStatus;
        $queryCount = "select GroupId AS totalRow from `groups` {joins} where {wheres}";
        $query = "select {selects} from `groups` {joins} where {wheres} ORDER BY CrDateTime DESC LIMIT {limits}";
        $selects = [
            '*',
        ];
        $joins = [
        ];
        $wheres = array(' StatusId > 0 ');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'GroupName like ? or GroupCode like ? ';
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
                    $wheres[] = "groups.StatusId $conds[0] ?";
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
        $controller = 'group';
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable(''.$controller.'', $staffId);
        $tables = $dataConfigTable['tableTh'];
        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';
        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_'.$datas[$i]['GroupId'].'" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['GroupId'].'"></td>';
                }
                else if(!empty($tables[$z]['DateTime'])){
                    $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                    $crDateTime = ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="'.$displayNone.'" >'.getDayDiffText($dayDiff).$crDateTime.'</td>';
                }
                else if ($columnName == 'GroupCode'){
                    $html .= '<td style="'.$displayNone.'" ><a href="'.base_url('group/view').'/'.$datas[$i]['GroupId'].'">'.$datas[$i]['GroupCode'].'</a></td>';
                }
                elseif ($columnName == 'StatusId'){
                    $html .= '<td style="'.$displayNone.'" ><span class="'.$labelCss[$datas[$i]['StatusId']].'">'.$status[$datas[$i]['StatusId']].'</span></td>';
                }
                elseif ($columnName == 'StaffName'){
                    $staffName = $this->Mstaffs->getFieldValue(array('StaffId' => $datas[$i]["CrStaffId"]), 'FullName', '');
                    $html .= '<td style="'.$displayNone.'" >'.$staffName.'</td>';
                }
                elseif ($columnName == 'StaffId'){
                    $countStaff = $this->Mstaffs->getCountStaff($datas[$i]["GroupId"]);
                    $countAllStaff = $this->Mstaffs->getCountActive();
                    $html .= '<td style="'.$displayNone.'" >'.$countStaff.'/'.$countAllStaff.'</td>';
                }
                else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                    $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['GroupId'].'">'.$datas[$i][$columnName].'</a></td>';
                }
                else if ($columnName){
                    $html .= '<td style="'.$displayNone.'" >'.$datas[$i][$columnName].'</td>';
                }
                else{
                    $html .= '<td style="'.$displayNone.'" ></td>';
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

    public function groupCode($groupId,$prefix = 'NQ'){
        return $prefix . '-' . ($groupId + 10000);
    }
    
    public function checkExist($groupId, $groupName){
        $query = "SELECT GroupId FROM `groups` WHERE GroupId!=? AND StatusId=?";
        if(!empty($groupName)){
            $query .= " AND GroupName=? LIMIT 1";
            $staffs = $this->getByQuery($query, array($groupId, STATUS_ACTIVED, $groupName));
        }
        if (!empty($staffs)) return true;
        return false;
    }
    public function update($postData = array(), $groupId = 0, $actionId = array(), $logDeadline = array(), $staffGroupId = array()){
        $isUpdate = $groupId > 0;
        $this->db->trans_begin();
        $groupId = $this->save($postData, $groupId);
        if ($groupId > 0) {
            
            if ($isUpdate) {
                $this->db->delete('staffgroups', array('GroupId' => $groupId));
                $this->db->delete('groupactions', array('GroupId' => $groupId));
            } else {
                $this->db->update('groups', array('GroupCode' => $this->groupCode($groupId)), array('GroupId' => $groupId));
            }
            if (!empty($actionId)) {
                $arrgroupaction = array();
                foreach ($actionId as $groupaction) {
                    $groupactions['ActionId'] = !empty($groupaction) ? $groupaction : 0;
                    $groupactions['GroupId'] = $groupId;
                    $arrgroupaction[] = $groupactions;
                }
                if (!empty($arrgroupaction)) $this->db->insert_batch('groupactions', $arrgroupaction);
            }

            if (!empty($staffGroupId)) {
                $arrstaffGroupId = array();
                foreach ($staffGroupId as $staffGI) {
                    $staffGroupIds['StaffId'] = $staffGI['StaffId'] ;
                    $staffGroupIds['GroupId'] = $groupId;
                    $staffGroupIds['CrDateTime'] = getCurentDateTime();
                    $arrstaffGroupId[] = $staffGroupIds;
                }
                if (!empty($arrstaffGroupId)) $this->db->insert_batch('staffgroups', $arrstaffGroupId);
            }
            $logDeadlines = array();
            if(!empty($logDeadline)) {
                $logDeadline['ItemId'] = $groupId;
                $logDeadlines[] = $logDeadline;
            }
            if(!empty($logDeadlines)) $this->db->insert_batch('actionlogs', $logDeadlines);
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return $groupId;
        }
    }
}