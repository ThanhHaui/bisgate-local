<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mschoolreports extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "schoolreports";
        $this->_primary_key = "SchoolReportId";
    }
}