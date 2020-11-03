<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdevicemanufacturers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "devicemanufacturers";
        $this->_primary_key = "DeviceManufacturerId";
    }
}