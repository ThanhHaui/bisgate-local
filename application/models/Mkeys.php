<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mkeys extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "keys";
        $this->_primary_key = "KeyId";
    }
}