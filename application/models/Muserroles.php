<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muserroles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "userroles";
        $this->_primary_key = "UserRoleId";
    }
    public function checkExist($userRoleId, $roleName){
        $query = "SELECT UserRoleId FROM userroles WHERE UserRoleId!=? AND StatusId=?";
        if(!empty($roleName)){
            $query .= " AND RoleName=? LIMIT 1";
            $userRole = $this->getByQuery($query, array($userRoleId, STATUS_ACTIVED, $roleName));
        }
        if (!empty($userRole)) return true;
        return false;
    }
    public function update($postData, $userRoleId = 0, $roleMenuId = array())
    {
        $isUpdate = $userRoleId > 0;
        $this->db->trans_begin();
        $userRoleId = $this->save($postData, $userRoleId);
        if ($userRoleId > 0) {
            if ($isUpdate) {
                $this->db->delete('userroledetails', array('UserRoleId' => $userRoleId));
            }

            if (!empty($roleMenuId)) {
                $arrroleMenuId = array();
                foreach ($roleMenuId as $roleMenuIds) {
                    $roleMenuIds['UserRoleId'] = $userRoleId;
                    $roleMenuIds['RoleMenuId'] = $roleMenuIds['RoleMenuId'];
                    $roleMenuIds['RoleMenuChildId'] = isset($roleMenuIds['RoleMenuChildId'])?$roleMenuIds['RoleMenuChildId']:'';
                    $arrroleMenuId[] = $roleMenuIds;
                }
                if (!empty($arrroleMenuId)) $this->db->insert_batch('userroledetails', $arrroleMenuId);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return $userRoleId;
        }
    }
}