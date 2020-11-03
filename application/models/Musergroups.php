<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musergroups extends MY_Model{
	function __construct(){
        parent::__construct();
        $this->_table_name = "usergroups";
        $this->_primary_key = "UserGroupId";
    }
}