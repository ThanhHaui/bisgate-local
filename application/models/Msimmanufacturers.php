<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msimmanufacturers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "simmanufacturers";
        $this->_primary_key = "SimManufacturerId";
    }

    public function getCount($postData){
        $query = "SimManufacturerStatusId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    private function buildQuery($postData){
        $query = '';
        return $query;
    }

    public function update($postData, $simManufacturerId = 0, $telcoId = array(), $user){
        $isUpdate = $simManufacturerId > 0;
        $this->db->trans_begin();
        $simManufacturerId = $this->save($postData, $simManufacturerId);
        if($simManufacturerId > 0){
            if ($isUpdate) {
                $this->db->delete('telcoidetails', array('SimManufacturerId' => $simManufacturerId));
            } 
            else{
                $this->db->update('simmanufacturers',  array('SimManufacturerCode' => $this->genSimManufacturerCode($simManufacturerId)), array('SimManufacturerId' => $simManufacturerId));
            }
            if(!empty($telcoId)){
                $itemNetwork = array();
                foreach ($telcoId as $telcois){
                    $telcoi['SimManufacturerId'] = $simManufacturerId;
                    $telcoi['TelcoId'] = $telcois;
                    $itemNetwork[] = $telcoi;
                } 
                if(!empty($itemNetwork)) $this->db->insert_batch('telcoidetails', $itemNetwork);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        }
        else {
            $this->db->trans_commit();
            return $simManufacturerId;
        }
    }

    private function genSimManufacturerCode($simManufacturerId, $prefix = 'NM'){
        return $prefix . '-' . ($simManufacturerId + 10000);
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId){
        $queryCount = "select simmanufacturers.SimManufacturerId AS totalRow from simmanufacturers {joins} where {wheres}";
        $query = "select {selects} from simmanufacturers {joins} where {wheres} ORDER BY simmanufacturers.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'simmanufacturers.*',
        ];
        $joins = [
        ];
        $wheres = array('SimManufacturerStatusId > 0');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'simmanufacturers.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'simmanufacturers.SimManufacturerCode like ? or simmanufacturers.SimManufacturerName like ? or simmanufacturers.PhoneNumber like ? or simmanufacturers.Email like ?';
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
                    $wheres[] = "simmanufacturers.SimManufacturerStatusId $conds[0] ?";
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
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('simmanufacturer', $userId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';

        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_'.$datas[$i]['SimManufacturerId'].'" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['SimManufacturerId'].'"></td>';
                } else if(!empty($tables[$z]['Status']) && $tables[$z]['Status'] != NULL){
                    $arrStatus = $this->Mconstants->$columnName;
                    $nameStatus = $datas[$i][$tables[$z]['Status']] > 0 ? $arrStatus[$datas[$i][$tables[$z]['Status']]] : '';
                    if($nameStatus){
                        $labelCss = $this->Mconstants->labelCss;
                        $html .= '<td style="'.$displayNone.'" class="text-center"><span class="'.$labelCss[$datas[$i][$tables[$z]['Status']]].'">' . $nameStatus . '</span></td>';
                    }else{
                        $html .= '<td style="'.$displayNone.'" class="text-center"></td>';
                    }

                }else if(!empty($tables[$z]['DateTime'])){
                    $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                    $crDateTime = ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="'.$displayNone.'" >'.getDayDiffText($dayDiff).$crDateTime.'</td>';
                }else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                    $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['SimManufacturerId'].'">'.$datas[$i][$columnName].'</a></td>';
                }else if(!empty($tables[$z]['ModelsDb']) && !empty($tables[$z]['NameRelationship'])){
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                    if($columnName == 'SimManufacturerId'){
                        $data = count($this->$models->getBy(array('SimManufacturerId' =>  $datas[$i][$columnName], 'SimStatusId' => STATUS_ACTIVED))). '';
                    }else{
                        $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                    }

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
        $data['callBackTable'] = 'renderContentSimManufacturers';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }

    public function selectConstantMultiple($key, $selectName, $itemId = array(), $isAll = false, $txtAll = 'Tất cả', $selectClass = '', $attrSelect = '')
    {
        $obj = $this->Mconstants->$key;
        if ($obj) {
            echo '<select class="form-control' . $selectClass . '" name="' . $selectName . '" id="' . lcfirst($selectName) . '"' . $attrSelect . '>';
            if ($isAll) echo '<option value="0">' . $txtAll . '</option>';
            foreach ($obj as $i => $v) {
                if (in_array($i, $itemId)) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="' . $i . '"' . $selected . '>' . $v . '</option>';
        }
            echo "</select>";
        }
    }

    public function checkExist($simManufacturerId, $phoneNumber){
        
        if(!empty($phoneNumber)){
            $query = "SELECT SimManufacturerId FROM simmanufacturers WHERE SimManufacturerId!=? AND SimManufacturerStatusId=?";
            $query .= " AND PhoneNumber=? LIMIT 1";
            $simManufacturer = $this->getByQuery($query, array($simManufacturerId, STATUS_ACTIVED, $phoneNumber));
            if(!empty($simManufacturer)) return json_encode(array('code' => -1, "message" => 'Số điện thoại đã tồn tại, vui lòng nhập lại !!!'));
        }
        return false;
    }
}
