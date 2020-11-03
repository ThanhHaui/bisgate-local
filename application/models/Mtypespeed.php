<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtypespeed extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "typespeed";
        $this->_primary_key = "TypeSpeedId";
    }

}