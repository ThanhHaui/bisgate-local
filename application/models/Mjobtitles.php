<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mjobtitles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "jobtitles";
        $this->_primary_key = "JobTitleId";
    }
}