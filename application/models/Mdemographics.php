<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdemographics extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "demographics";
        $this->_primary_key = "DemographicId";
    }
}