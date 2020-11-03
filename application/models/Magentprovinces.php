<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Magentprovinces extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "agentprovinces";
        $this->_primary_key = "AgentProvinceId";
    }
}