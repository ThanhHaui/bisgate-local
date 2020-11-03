<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mprovinces extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "provinces";
        $this->_primary_key = "ProvinceId";
    }

    public function getList(){
        return $this->get(0, false, "DisplayOrder", '', 0, 0, 'asc');
    }

    public function changeDisplayOrder($provinceId, $displayOrder){
        $this->db->trans_begin();
        $this->db->set('DisplayOrder', 'DisplayOrder+1', false);
        $this->db->where('DisplayOrder>=', $displayOrder);
        $this->db->update('provinces');
        $this->save(array('DisplayOrder' => $displayOrder), $provinceId);
        if ($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    public function getListSelect2Ajax($searchText = ''){
        $where = '';
        if(!empty($searchText)) $where = " AND ProvinceName LIKE '%".$searchText."%' ";
        $query = "SELECT * FROM provinces WHERE ProvinceId > 0 ".$where." ORDER BY DisplayOrder ASC";
        return $this->getByQuery($query);
    }
}