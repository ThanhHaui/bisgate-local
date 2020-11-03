<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muserjobtitles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "userjobtitles";
        $this->_primary_key = "UserJobTitleId";
    }
}