<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msims extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "sims";
        $this->_primary_key = "SimId";
    }

    public function getListBy($where) {
        $this->db->select('sims.SimId, sims.PhoneNumber, sims.SeriSim, sims.SimTypeId');
        $this->db->from($this->_table_name);
        $this->db->join('simmanufacturers','simmanufacturers.SimManufacturerId=sims.SimManufacturerId');
        $this->db->order_by('sims.CrDateTime', 'DESC');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId){
        $queryCount = "select sims.SimId AS totalRow from sims {joins} where {wheres}";
        $query = "select {selects} from sims {joins} where {wheres} ORDER BY sims.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'sims.*',
            'simmanufacturers.SimManufacturerName',
        ];
        $joins = [
            'simmanufacturers' => 'LEFT JOIN simmanufacturers on simmanufacturers.SimManufacturerId = sims.SimManufacturerId',
        ];
        $wheres = array('sims.SimId > 0 AND sims.SimStatusId > 0 ');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'sims.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'sims.PhoneNumber like ? or sims.SeriSim like ? or sims.CrDateTime like ? ';
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
                        $wheres[] = "sims.SimStatusId $conds[0] ?";
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
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('sim', $userId);
        $tables = $dataConfigTable['tableTh'];
        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';
        
        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_'.$datas[$i]['SimId'].'" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['SimId'].'"></td>';
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
                    $crDateTime = strpos(ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'),'00:00')?ddMMyyyy($datas[$i][$columnName],'d/m/Y'):ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="'.$displayNone.'" >'.getDayDiffText($dayDiff).$crDateTime.'</td>';
                }else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                    $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['SimId'].'">'.$datas[$i][$columnName].'</a></td>';
                }else if(!empty($tables[$z]['ModelsDb']) && !empty($tables[$z]['NameRelationship'])){
                    $models = $tables[$z]['ModelsDb'];
                    $nameRelationship = $tables[$z]['NameRelationship'];
                    $this->load->model($models);
                    $data = $this->$models->getFieldValue(array($columnName => $datas[$i][$columnName]), $nameRelationship, '');
                    $html .= $columnName == 'SimManufacturerId'?'<td style="color:#027DB4;'.$displayNone.'" >'.$data.'</td>':'<td style="'.$displayNone.'" >'.$data.'</td>';
                    
                }else {
                    $html .= $columnName == 'PhoneNumber'?'<td style="color:#027DB4;'.$displayNone.'" >'.$datas[$i][$columnName].'</td>':'<td style="'.$displayNone.'" >'.$datas[$i][$columnName].'</td>';
                    
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
        $data['callBackTable'] = 'renderContentSims';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }
    public function checkExist($simId, $seriSim, $phoneNumber){
        
        if(!empty($phoneNumber)){
            $query = "SELECT SimId FROM sims WHERE SimId!=? AND SimStatusId=?";
            $query .= " AND PhoneNumber=? LIMIT 1";
            $sims = $this->getByQuery($query, array($simId, STATUS_ACTIVED, $phoneNumber));
            if(!empty($sims)) return json_encode(array('code' => -1, "message" => 'Số điện thoại đã tồn tại, vui lòng nhập lại !!!'));
        }
        if(!empty($seriSim)){
            $query = "SELECT SimId FROM sims WHERE SimId!=? AND SimStatusId=?";
            $query .= " AND SeriSim=? LIMIT 1";
            $sims = $this->getByQuery($query, array($simId, STATUS_ACTIVED, $seriSim));
            if(!empty($sims)) return json_encode(array('code' => -1, "message" => 'SeriSim đã tồn tại, vui lòng nhập lại !!!'));
        }
        return false;
    }

    public function getListSims($searchText = ''){
        $where = '';
        $arrSim = $this->Mdevices->getListFieldValue(array('StatusId' => STATUS_ACTIVED),'SimId');
        $arrSims  = str_replace(array('[',']'), array('(',')'), json_encode($arrSim,true));
        if(!empty($searchText)) $where = ' AND PhoneNumber LIKE "%'.$searchText.'%"';
        $query = "SELECT * FROM sims WHERE SimStatusId > 0 AND SimId NOT IN ".$arrSims .$where.' LIMIT 0,1000';
        return $this->getByQuery($query);
        var_dump($query);die;
    }
}
