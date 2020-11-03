<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcountries extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "countries";
        $this->_primary_key = "CountryId";
    }

    public function getList(){
        return $this->get(0, false, "DisplayOrder", '', 0, 0, 'asc');
    }

    public function changeDisplayOrder($countryId, $displayOrder){
        $this->db->trans_begin();
        $this->db->set('DisplayOrder', 'DisplayOrder+1', false);
        $this->db->where('DisplayOrder>=', $displayOrder);
        $this->db->update('countries');
        $this->save(array('DisplayOrder' => $displayOrder), $countryId);
        if ($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    
}