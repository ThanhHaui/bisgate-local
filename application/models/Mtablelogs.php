<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtablelogs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "tablelogs";
        $this->_primary_key = "TableLogId";
    }

    public function insert($tableLogs, $actionLogs, $tableInfo){
        $this->db->trans_begin();
        $this->db->query("UPDATE {$tableInfo['TableName']} SET {$tableInfo['StatusFieldName']} = 0, UpdateUserId = ?, UpdateDateTime = ? WHERE {$tableInfo['PrimaryKeyName']} IN ?", array($tableInfo['UserId'], $tableInfo['CrDateTime'], $tableInfo['ItemIds']));
        if(!empty($tableLogs)) $this->db->insert_batch('tablelogs', $tableLogs);
        if(!empty($actionLogs)) $this->db->insert_batch('actionlogs', $actionLogs);
        if($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function restore($tableLog, $tableLogId, $actionLog, $tableInfo){
        $modelName = $tableInfo['ModelName'];
        $this->db->trans_begin();
        $this->save($tableLog, $tableLogId);
        $this->Mactionlogs->save($actionLog);
        $this->$modelName->save(array($tableInfo['StatusFieldName'] => $tableInfo['StatusIdOld'], 'UpdateUserId' => $actionLog['CrUserId'], 'UpdateDateTime' => $actionLog['CrDateTime']), $tableInfo['ItemId']);
        if($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $postData = array()){
        $queryCount = "select tablelogs.TableLogId AS totalRow from tablelogs {joins} where {wheres}";
        $query = "select {selects} from tablelogs {joins} where {wheres} ORDER BY tablelogs.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'tablelogs.*',
            'users.FullName',
        ];
        $joins = [
            'users' => "left join users on users.UserId = tablelogs.CrUserId",
        ];
        $wheres = array('tablelogs.IsBack = 1');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'tablelogs.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'users.FullName like ?';
                $dataBind[] = "%$searchText%";
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
                    case 'userId':
                        $wheres[] = "tablelogs.CrUserId $conds[0] ?";
                        $dataBind[] = $conds[1];
                        break;
                    case 'create_date':
                        if ($conds[0] == 'between') {
                            $wheres[] = 'tablelogs.CrDateTime between ? and ?';
                            $dataBind[] = @ddMMyyyyToDate($conds[1]);
                            $dataBind[] = @ddMMyyyyToDate($conds[2], 'd/m/Y', 'Y-m-d 23:59:59');
                        }
                        elseif($conds[0] == '<'){
                            $wheres[] = "tablelogs.CrDateTime < ?";
                            $dataBind[] = @ddMMyyyyToDate($conds[1], 'd/m/Y', 'Y-m-d 23:59:59');
                        }
                        elseif($conds[0] == '>'){
                            $wheres[] = "tablelogs.CrDateTime > ?";
                            $dataBind[] = @ddMMyyyyToDate($conds[1]);
                        }
                        else{
                            $wheres[] = "DATE(tablelogs.CrDateTime) $conds[0] ?";
                            $dataBind[] = $conds[1];
                        }
                        break;
                    case 'table_log_tag':
                        $wheres[] = "tablelogs.TableLogId $conds[0](SELECT ItemId FROM itemtags WHERE ItemTypeId = 34 AND TagId = ?)";
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
        $tablelogs = $this->getByQuery($query, $dataBind);
        $dataAll = array();
        foreach ($tablelogs as $t) {
            $tableName = 'M'.$t['TableName'];
            $colName = ucfirst(substr($t['TableName'], 0, -1));
            $this->load->model($tableName);
            $data = $this->$tableName->get($t['ItemId'], true, '', ''.$colName.'Code'.', '.$colName.'Id'.'');
            $dataAll[] = array(
                'Code' => $data[$colName.'Code'],
                'CodeId' => $data[$colName.'Id'],
                'CrDateTime' => ddMMyyyy($t['CrDateTime'],'d/m/Y H:i'),
                'TableLogId' => $t['TableLogId'],
                'Comment' => $t['Comment'],
                'FullName' => $t['FullName'],
            );
        }
        $data = array();
        $totalRow = count($dataAll);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = $dataAll;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentTableLog';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        return $data;
    }
}
