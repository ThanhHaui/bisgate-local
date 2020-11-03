<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtelcoidetails extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "telcoidetails";
        $this->_primary_key = "TelCoIDetailId";
    }
}