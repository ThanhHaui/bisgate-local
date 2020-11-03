<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdevicecodes extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "devicecodes";
        $this->_primary_key = "DeviceCodeId";
    }
}