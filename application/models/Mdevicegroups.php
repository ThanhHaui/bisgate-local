<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdevicegroups extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "devicegroups";
        $this->_primary_key = "DeviceGroupId";
    }
}