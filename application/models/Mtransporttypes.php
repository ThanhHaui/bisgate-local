<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtransporttypes extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "transporttypes";
        $this->_primary_key = "TransportTypeId";
    }
}