<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehiclemanufacturers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehiclemanufacturers";
        $this->_primary_key = "VehicleManufacturerId";
    }
}