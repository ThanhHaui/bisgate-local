<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msslvehiclelogs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "sslvehiclelogs";
        $this->_primary_key = "SslvehiclelogId";
    }
    function getShowEditNew($vehicleId){
        $query ='SELECT sslvehiclelogs.CrDateTime FROM sslvehiclelogs WHERE VehicleId = '.$vehicleId.' AND ItemStatus = 1 ORDER BY CrDateTime DESC';
        $q = $this->getByQuery($query);
        return $q;
    }
    function getpushNew($vehicleId){
        $query ='SELECT sslvehiclelogs.SslvehiclelogId FROM sslvehiclelogs WHERE VehicleId = '.$vehicleId.' ORDER BY CrDateTime DESC';
        $q = $this->getByQuery($query);
        return $q[0];
    }
}
