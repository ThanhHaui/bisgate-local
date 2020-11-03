<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconfigtableusers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "configtableusers";
        $this->_primary_key = "ConfigTableUserId";
    }
}