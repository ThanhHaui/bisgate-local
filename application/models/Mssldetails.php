<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mssldetails extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "ssldetails";
        $this->_primary_key = "SSLDetailId";
    }
}