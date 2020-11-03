<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mactionlogstaffs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "actionlogstaffs";
        $this->_primary_key = "ActionLogStaffId";
    }
       public function getList($itemId){
        return $this->getBy(array('ItemId' => $itemId), false, 'CrDateTime');
    }
}
