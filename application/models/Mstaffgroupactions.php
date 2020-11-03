<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mstaffgroupactions extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "staffgroupactions";
        $this->_primary_key = "StaffGroupActionId";
    }
}