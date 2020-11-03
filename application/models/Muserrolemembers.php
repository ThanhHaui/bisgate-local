<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muserrolemembers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "userrolemembers";
        $this->_primary_key = "UserRoleMemberId";
    }
    public function getListUserRole($userId = 0){
        $query = " SELECT userrolemembers.UserRoleId,userroles.RoleName, userroles.CrUserId, userroles.CrDateTime, users.FullName, users.Avatar, users.JobLevelId FROM userrolemembers 
        JOIN userroles ON userrolemembers.UserRoleId =  userroles.UserRoleId
        JOIN users On userroles.CrUserId = users.UserId
        WHERE userrolemembers.UserId = ? ";
        return $this->getByQuery($query, $userId);
    }
}