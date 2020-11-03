<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mstaffgroups extends MY_Model {

	function __construct() {
		parent::__construct();
		$this->_table_name = "staffgroups";
		$this->_primary_key = "StaffGroupId";
	}
}