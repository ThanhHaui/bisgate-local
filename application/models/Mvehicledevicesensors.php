<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehicledevicesensors extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehicledevicesensors";
        $this->_primary_key = "VehicleDeviceSensorId";
    }

}