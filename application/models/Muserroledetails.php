<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muserroledetails extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "userroledetails";
        $this->_primary_key = "UserRoleDetailId";
    }
}