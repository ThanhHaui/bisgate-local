<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mwards extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "wards";
        $this->_primary_key = "WardId";
    }

    public function getList($districtId = 0){
        if($districtId > 0) return $this->getBy(array('DistrictId' => $districtId), false, "DisplayOrder", 'WardId, WardName', 0, 0, 'asc');
        return $this->get(0, false, "DisplayOrder", '', 0, 0, 'asc');
    }

    public function selectHtml($wardId = 0, $selectName = 'WardId'){
        $retVal = '<select class="form-control wardId" name="'.$selectName.'" id="'.lcfirst($selectName).'" data-id="'.$wardId.'"><option value="0" data-id="0">--Chọn--</option>';
        $retVal .= '</select>';
        return $retVal;
    }

    public function getWardName($wardId){
        $retVal = '';
        if($wardId > 0) $retVal = $this->getFieldValue(array('WardId' => $wardId), 'WardName');
        return $retVal;
    }
    public function getListSelect2Ajax($districtId = 0, $searchText = ''){
        $where = '';
        if(!empty($searchText)) $where = " AND WardName LIKE '%".$searchText."%' ";
        $query = "SELECT * FROM wards WHERE WardId > 0 AND DistrictId = ".$districtId.$where." ORDER BY DisplayOrder ASC LIMIT 20";
        return $this->getByQuery($query);
    }
}