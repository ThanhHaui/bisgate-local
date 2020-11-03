<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdeadlinedetails extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "deadlinedetails";
        $this->_primary_key = "DeadlineDetailId";
    }
}