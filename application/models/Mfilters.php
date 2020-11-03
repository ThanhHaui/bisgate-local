<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfilters extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "filters";
        $this->_primary_key = "FilterId";
    }
  public function getCount($postData)
    {
        $query = "StatusId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function getList($itemTypeId){
        return $this->getBy(array('StatusId' => STATUS_ACTIVED, 'ItemTypeId' => $itemTypeId), false, 'DisplayOrder', 'FilterId,FilterNote, FilterName, DisplayOrder', 0, 0, 'asc');
    }

    public function getInfo($filterId){
        $retVal = array(
            'itemFilters' => array(),
            'tagFilters' => array()
        );
        $filter = $this->get($filterId, true, '', 'FilterData, TagFilter');
        if($filter){
            $retVal['itemFilters'] = json_decode($filter['FilterData'], true);
            $retVal['tagFilters'] = json_decode($filter['TagFilter'], true);
        }
        return $retVal;
    }

    public function updateBatch($valueData){
        if(!empty($valueData)) $this->db->update_batch('filters', $valueData, 'FilterId');
        return true;
    }

    public function searchByFilter($searchText, $limit, $page, $itemTypeId){
        $queryCount = "select filters.FilterId AS totalRow from filters {joins} where {wheres}";
        $query = "select {selects} from filters {joins} where {wheres} ORDER BY filters.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'filters.*',
        ];
        $joins = [
        ];
        $wheres = array('StatusId > 0 AND ItemTypeId = '.$itemTypeId);
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'filters.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'filters.FilterName like ? or filters.CrDateTime like ? ';
                for( $i = 0; $i < 2; $i++) $dataBind[] = "%$searchText%";
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
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{joins}', $joins_string, $queryCount);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $now = new DateTime(date('Y-m-d'));
        $dataFilters = $this->getByQuery($query, $dataBind);
        for ($i = 0; $i < count($dataFilters); $i++) {
            $dayDiff = getDayDiff($dataFilters[$i]['CrDateTime'], $now);
            $dataFilters[$i]['CrDateTime'] = ddMMyyyy($dataFilters[$i]['CrDateTime'], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
            $dataFilters[$i]['DayDiff'] = $dayDiff;
            $dataFilters[$i]['UserCreate'] = $this->Musers->getFieldValue(array('UserId' => $dataFilters[$i]['CrUserId']), 'FullName');
            $dataFilters[$i]['FilterNote'] = $dataFilters[$i]['FilterNote'] != null ? $dataFilters[$i]['FilterNote'] : '';
             $dataFilters[$i]['Code'] = 'BC-'.($dataFilters[$i]['FilterId'] + 10000);
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = $dataFilters;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentFilters';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($dataFilters);
        return $data;
    }
}