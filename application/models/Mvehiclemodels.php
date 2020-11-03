<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehiclemodels extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehiclemodels";
        $this->_primary_key = "VehicleModelId";
    }
}