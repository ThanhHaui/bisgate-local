<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mrolemenus extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "rolemenus";
        $this->_primary_key = "RoleMenuId";
    }
    public function getParentRoleHtml($listRole){
        $retVal = '<option value="0">Không có</option>';
        foreach($listRole as $act){
            if($act['RoleLevel'] == 1) $retVal .= '<option value="' . $act['RoleMenuId'] . '">' . $act['RoleMenuName'] . '</option>';
            elseif($act['RoleLevel'] == 2) $retVal .= '<option value="' . $act['RoleMenuId'] . '">+> ' . $act['RoleMenuName'] . '</option>';
        }
        return $retVal;
    }
    public function getHierachy(){
        $retVal = array();
        $listActions = $this->getBy(array('RoleStatusId' => STATUS_ACTIVED), false, '',  '', 0, 0, 'asc');
        $listActions1 = $listActions2 = $listActions3 = array();
        foreach($listActions as $a){
            if($a['RoleLevel'] == 1) $listActions1[]=$a;
            elseif($a['RoleLevel'] == 2) $listActions2[]=$a;
            elseif($a['RoleLevel'] == 3) $listActions3[]=$a;
        }
        foreach($listActions1 as $a1){
            $retVal[] = $a1;
            foreach ($listActions2 as $a2) {
                if($a2['RoleMenuChildId'] == $a1['RoleMenuId']){
                    $retVal[]=$a2;
                    foreach ($listActions3 as $a3) {
                        if($a3['RoleMenuChildId'] == $a2['RoleMenuId']) $retVal[]=$a3;
                    }
                }
            }
        }
        return $retVal;
    }
    public function deleteRole($roleId){
        $actions = $this->getBy(array('RoleMenuChildId' => $roleId, 'RoleStatusId' => STATUS_ACTIVED), false, 'RoleMenuId');
        if(empty($actions)) return $this->changeStatusRoleMenu(0, $roleId);
        return false;
    }
    private function changeStatusRoleMenu($statusId, $id, $fieldName = 'RoleStatusId'){
        $retVal = false;
        if($statusId >= 0 && $id > 0){
            if(empty($fieldName)) $fieldName = 'RoleStatusId';
            $id = $this->save(array($fieldName => $statusId), $id);
            $retVal = $id > 0;
        }
        return $retVal;
    }
}
