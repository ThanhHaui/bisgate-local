<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muserdetails extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "userdetails";
        $this->_primary_key = "UserDetailId";
    }
}