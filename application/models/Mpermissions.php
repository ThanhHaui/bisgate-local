<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpermissions extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "permissions";
        $this->_primary_key = "PermissionId";
    }
}