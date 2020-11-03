<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mroleactions extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "roleactions";
        $this->_primary_key = "RoleActionId";
    }

    public function updateBatch($roleId, $partId, $valueData){
        if(!empty($valueData)){
            $this->db->trans_begin();
            $this->db->delete('roleactions', array('RoleId' => $roleId, 'PartId' => $partId));
            $this->db->insert_batch('roleactions', $valueData);
            if ($this->db->trans_status() === false){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }
        }
        else{
            $this->db->delete('roleactions', array('RoleId' => $roleId, 'PartId' => $partId));
            return true;
        }
    }

}