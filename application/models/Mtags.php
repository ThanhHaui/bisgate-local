<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtags extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "tags";
        $this->_primary_key = "TagId";
    }

    public function getTagId($tagName, $itemTypeId){
        $tagId = $this->getFieldValue(array('TagName' => $tagName, 'ItemTypeId' => $itemTypeId), 'TagId', 0);
        if($tagId == 0) $tagId = $this->save(array('TagName' => $tagName, 'TagSlug' => makeSlug($tagName), 'ItemTypeId' => $itemTypeId), 0);
        return $tagId;
    }

    public function getTagNames($itemId, $itemTypeId){
        $retVal = array();
        $tags = $this->getByQuery('SELECT TagName FROM tags WHERE TagId IN(SELECT TagId FROM itemtags WHERE ItemId = ? AND ItemTypeId = ?)', array($itemId, $itemTypeId));
        foreach($tags as $tag) $retVal[] = $tag['TagName'];
        return $retVal;
    }

    public function updateItem($itemIds, $tagNames, $itemTypeId, $changeTagTypeId){
        $this->load->model('Mitemtags');
        $this->db->trans_begin();
        $tagIds = array();
        foreach($tagNames as $tagName) $tagIds[] = $this->getTagId($tagName, $itemTypeId);
        if(!empty($tagIds)){
            if ($changeTagTypeId == 1) { //add
                foreach($itemIds as $itemId) {
                    foreach ($tagIds as $tagId) $this->Mitemtags->update(array('ItemId' => $itemId, 'ItemTypeId' => $itemTypeId, 'TagId' => $tagId));
                }
            }
            elseif ($changeTagTypeId == 2) { //remove

                $this->db->query('DELETE FROM itemtags WHERE ItemTypeId = ? AND ItemId IN ? AND TagId IN ?', array($itemTypeId, $itemIds, $tagIds));
            }
            elseif ($changeTagTypeId == 3){ //update
                $this->db->query('DELETE FROM itemtags WHERE ItemTypeId = ? AND ItemId IN ?', array($itemTypeId, $itemIds));
                $itemTags = array();
                foreach($itemIds as $itemId) {
                    foreach ($tagIds as $tagId){
                        $itemTags[] = array(
                            'ItemId' => $itemId,
                            'ItemTypeId' => $itemTypeId,
                            'TagId' => $tagId
                        );
                    }
                }
                if (!empty($itemTags)) $this->db->insert_batch('itemtags', $itemTags);
            }
        }
        if ($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    public function getCount($postData){
        $query = "TagId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM tags WHERE TagId > 0" . $this->buildQuery($postData) . ' ORDER BY TagId ASC';
        if ($perPage > 0) {
            $from = ($page - 1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if (isset($postData['ItemTypeId']) && $postData['ItemTypeId'] > 0) $query .= " AND ItemTypeId=".$postData['ItemTypeId'];
        return $query;
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page){
        $queryCount = "SELECT tags.TagId AS totalRow FROM tags  WHERE {wheres}";
        $query = "SELECT {selects} FROM tags  WHERE {wheres}  LIMIT {limits}";
        $selects = [
            'tags.*',
        ];
        $wheres = array('TagId > 0');
        $whereSearch= '';
        $dataBind = [];
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'tags.TagName like ?';
                $dataBind[] = "$searchText%";
            }
            /*else if(preg_match('/\d+|\w+-/im',$searchText)){
                $whereSearch = 'transactioninternals.TransactionCode like ? or transactioninternals.CrDateTime like ?';
                $dataBind[] = "%$searchText%";
                $dataBind[] = "%$searchText%";
            }*/
            else{
                $whereSearch = 'tags.TagName like ? or tags.TagSlug like ?';
                for( $i = 0; $i < 2; $i++) $dataBind[] = "%$searchText%";
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
                    case 'tag_item_type':
                        $wheres[] = "tags.ItemTypeId $conds[0] ?";
                        $dataBind[] = $conds[1];
                        break;
                    case 'tag_tag':
                        $wheres[] = "tags.TagId $conds[0](SELECT ItemId FROM itemtags WHERE ItemTypeId = 36 AND TagId = ?)";
                        $dataBind[] = $conds[1];
                        break;
                    default :
                        break;
                }
            }
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $dataTags = $this->getByQuery($query, $dataBind);
        for ($i = 0; $i < count($dataTags); $i++) {
            $dataTags[$i]['ItemTypeName'] = $dataTags[$i]['ItemTypeId'] > 0 ?   $this->Mconstants->itemTypes[$dataTags[$i]['ItemTypeId']] : '';
        }
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data = array();
        $data['dataTables'] = $dataTags;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentTags';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        return $data;
    }
}
