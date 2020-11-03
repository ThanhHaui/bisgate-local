<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mactions extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "actions";
        $this->_primary_key = "ActionId";
    }

    public function getByUserId($user){
        if(isset($user['StaffId'])){
            if(in_array($user['StaffRoleId'], [1,2])) {
                return $this->getBy(array('StatusId' => STATUS_ACTIVED), false, 'DisplayOrder', '', 0, 0, 'asc');
            } else {
                return $this->getByQuery('SELECT DISTINCT actions.* FROM actions
                    INNER JOIN groupactions ON actions.ActionId = groupactions.ActionId
                    INNER JOIN staffgroups ON staffgroups.GroupId = groupactions.GroupId
                    WHERE actions.StatusId = ? AND staffgroups.StaffId = ? ORDER BY actions.DisplayOrder ASC',
                array(STATUS_ACTIVED, $user['StaffId']));
            }
            
            
        } else if(isset($user['UserId'])){
            // $this->load->model('Mrolemenus');
            // return $this->Mrolemenus->getBy(array('RoleStatusId' => STATUS_ACTIVED), false, 'RoleLevel', '', 0, 0, 'asc');
            return $this->getByQuery('
            SELECT rolemenus.* FROM rolemenus
             LEFT JOIN userroledetails ON rolemenus.RoleMenuId = userroledetails.RoleMenuId
             LEFT JOIN users ON users.UserId = userroledetails.UserRoleId
             WHERE users.StatusId = ? AND  userroledetails.UserRoleId = ?
            ORDER BY rolemenus.RoleLevel', array(STATUS_ACTIVED, $user['UserId']));
        }
        
    }

    public function checkAccess($listActions, $actionUrl){
        // return true;
        foreach($listActions as $action) {
            if ($action['ActionUrl'] == $actionUrl) return true;
        }
        return false;
    }

    public function checkAccessFromDb($actionUrl, $userId){
        return true;
        $acts = $this->getByQuery('SELECT 1 FROM actions
                INNER JOIN groupactions ON actions.ActionId = groupactions.ActionId
                INNER JOIN staffgroups ON staffgroups.GroupId = groupactions.GroupId
                WHERE actions.StatusId = ? AND actions.ActionUrl = ? AND staffgroups.StaffId = ?', array(STATUS_ACTIVED, $actionUrl, $userId));
        if(!empty($acts)) return true;
        return false;
    }

    public function getHierachy(){
        $retVal = array();
        $listActions = $this->getBy(array('StatusId' => STATUS_ACTIVED), false, 'DisplayOrder',  '', 0, 0, 'asc');
        $listActions1 = $listActions2 = $listActions3 = array();
        foreach($listActions as $a){
            if($a['ActionLevel'] == 1) $listActions1[]=$a;
            elseif($a['ActionLevel'] == 2) $listActions2[]=$a;
            elseif($a['ActionLevel'] == 3) $listActions3[]=$a;
        }
        foreach($listActions1 as $a1){
            $retVal[] = $a1;
            foreach ($listActions2 as $a2) {
                if($a2['ParentActionId'] == $a1['ActionId']){
                    $retVal[]=$a2;
                    foreach ($listActions3 as $a3) {
                        if($a3['ParentActionId'] == $a2['ActionId']) $retVal[]=$a3;
                    }
                }
            }
        }
        return $retVal;
    }

    public function getParentActionHtml($listAction){
        $retVal = '<option value="0">Không có</option>';
        foreach($listAction as $act){
            if($act['ActionLevel'] == 1) $retVal .= '<option value="' . $act['ActionId'] . '">' . $act['ActionName'] . '</option>';
            elseif($act['ActionLevel'] == 2) $retVal .= '<option value="' . $act['ActionId'] . '">+> ' . $act['ActionName'] . '</option>';
        }
        return $retVal;
    }

    public function update($postData, $actionId){
        $this->db->trans_begin();
        if($postData['DisplayOrder'] > 0) {
            $this->db->set('DisplayOrder', 'DisplayOrder+1', false);
            $this->db->where(array('StatusId' => STATUS_ACTIVED, 'ParentActionId' => $postData['ParentActionId'], 'DisplayOrder>=' => $postData['DisplayOrder']));
            $this->db->update('actions');
        }
        $this->save($postData, $actionId);
        if ($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    public function deleteBy($actionId){
        $actions = $this->getBy(array('ParentActionId' => $actionId, 'StatusId' => STATUS_ACTIVED), false, 'ActionId');
        if(empty($actions)) return $this->changeStatus(0, $actionId);
        return false;
    }
}
