<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehiclegroups extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehiclegroups";
        $this->_primary_key = "VehicleGroupId";
    }
}