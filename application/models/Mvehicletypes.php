<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehicletypes extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehicletypes";
        $this->_primary_key = "VehicleTypeId";
    }
    public function checkExist($vehicleTypeName){
        $check = $this->getByQuery("SELECT VehicleTypeId FROM vehicletypes WHERE StatusId = ? AND VehicleTypeName = ?", array(STATUS_ACTIVED, $vehicleTypeName));
        if (!empty($check)) return true;
        return false;
    }
}