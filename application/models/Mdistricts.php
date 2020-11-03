<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdistricts extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "districts";
        $this->_primary_key = "DistrictId";
    }

    public function getList($provinceId = 0){
        if($provinceId > 0) return $this->getBy(array('ProvinceId' => $provinceId), false, "DisplayOrder", 'DistrictId, DistrictName', 0, 0, 'asc');
        return $this->get(0, false, "DisplayOrder", '', 0, 0, 'asc');
    }

    public function selectHtml($districtId = 0, $selectName = 'DistrictId', $listDistricts = array()){
        if(empty($listDistricts)) $listDistricts = $this->get();
        $retVal = '<select class="form-control districtId" name="'.$selectName.'" id="'.lcfirst($selectName).'"><option value="0" data-id="0">--Chọn--</option>';
        foreach($listDistricts as $d) $retVal .= '<option value="'.$d['DistrictId'].'" data-id="'.$d['ProvinceId'].'"'.($d['DistrictId'] == $districtId ? ' selected="selected"' : '').'>'.$d['DistrictName'].'</option>';
        $retVal .= '</select>';
        return $retVal;
    }
    public function getListSelect2Ajax($provinceId = 0, $searchText = ''){
        $where = '';
        if(!empty($searchText)) $where = " AND DistrictName LIKE '%".$searchText."%' ";
        $query = "SELECT * FROM districts WHERE DistrictId > 0 AND ProvinceId = ".$provinceId.$where." ORDER BY DisplayOrder ASC LIMIT 20";
        return $this->getByQuery($query);
    }
}