<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehiclekinds extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehiclekinds";
        $this->_primary_key = "VehicleKindId";
    }
}