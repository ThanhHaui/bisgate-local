<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msslitems extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "sslitems";
        $this->_primary_key = "SSLItemId";
    }

}