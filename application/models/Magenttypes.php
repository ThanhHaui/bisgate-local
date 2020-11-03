<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Magenttypes extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "agenttypes";
        $this->_primary_key = "AgentTypeId";
    }
}