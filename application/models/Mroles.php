<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mroles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "roles";
        $this->_primary_key = "RoleId";
    }
}
