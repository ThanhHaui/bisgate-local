<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mgroupactions extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "groupactions";
        $this->_primary_key = "GroupActionId";
    }
    public function getListGroupAction($groupId = 0){
        $query = " SELECT staffgroups.StaffId, groups.CrStaffId, staffgroups.CrDateTime, staffs.FullName, staffs.Avatar FROM `groups` 
        JOIN staffgroups ON staffgroups.GroupId =  groups.GroupId
        JOIN staffs ON staffs.StaffId =  staffgroups.StaffId
        WHERE groups.StatusId = ? AND groups.GroupId = ? ORDER BY groups.CrDateTime ASC";
    return $this->getByQuery($query, array(STATUS_ACTIVED, $groupId));
    }
}