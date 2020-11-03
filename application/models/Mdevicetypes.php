<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdevicetypes extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "devicetypes";
        $this->_primary_key = "DeviceTypeId";
    }
}