<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mworks extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "works";
        $this->_primary_key = "WorkId";
    }
}