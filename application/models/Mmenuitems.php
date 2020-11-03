<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmenuitems extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "menuitems";
        $this->_primary_key = "MenuItemId";
    }

    public function update($postData, $menuItemId){
        $this->db->trans_begin();
        if($postData['DisplayOrder'] > 0) {
            $this->db->set('DisplayOrder', 'DisplayOrder+1', false);
            $this->db->where(array('MenuId' => $postData['MenuId'], 'ParentItemId' => $postData['ParentItemId'], 'DisplayOrder>=' => $postData['DisplayOrder']));
            $this->db->update('menuitems');
        }
        $this->save($postData, $menuItemId);
        if ($this->db->trans_status() === false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    public function getList($menuId){
        $retVal = array();
        $menuItems = $this->getBy(array('MenuId' => $menuId), false, 'DisplayOrder', '', 0, 0, 'asc');
        foreach($menuItems as $mi1){
            if($mi1['MenuLevel'] == 1){
                $retVal[] = $mi1;
                foreach($menuItems as $mi2){
                    if($mi2['MenuLevel'] == 2 && $mi2['ParentItemId'] == $mi1['MenuItemId']) $retVal[] = $mi2;
                }
            }
        }
        return $retVal;
    }

    public function getListByPosition($menuPositionIds, $isMerge = false){
        $retVal = array();
        if(is_array($menuPositionIds)){
            $query = 'SELECT menuitems.*, menus.MenuPositionId FROM menuitems INNER JOIN menus ON menuitems.MenuId = menus.MenuId WHERE menus.MenuPositionId IN ? AND menus.StatusId = ? ORDER BY DisplayOrder ASC';
            foreach($menuPositionIds as $menuPositionId) $retVal[$menuPositionId] = array();
        }
        else{
            $query = 'SELECT menuitems.*, menus.MenuPositionId FROM menuitems INNER JOIN menus ON menuitems.MenuId = menus.MenuId WHERE menus.MenuPositionId = ? AND menus.StatusId = ? ORDER BY DisplayOrder ASC';
            $retVal[$menuPositionIds] = array();
        }
        $listMenuItems = $this->getByQuery($query, array($menuPositionIds, STATUS_ACTIVED));
        if($isMerge){
            foreach ($listMenuItems as $mi) {
                if ($mi['ParentItemId'] == 0) {
                    $mi['Childs'] = array();
                    foreach ($listMenuItems as $mi1) {
                        $mi1['Childs'] = array();
                        foreach ($listMenuItems as $mi2) {
                            $mi2['Childs'] = array();
                            if ($mi2['ParentItemId'] == $mi1['MenuItemId']) $mi1['Childs'][] = $mi2;
                        }
                        if ($mi1['ParentItemId'] == $mi['MenuItemId']) $mi['Childs'][] = $mi1;
                    }
                    $retVal[$mi['MenuPositionId']][] = $mi;
                }
            }
        }
        else{
            foreach ($listMenuItems as $mi) $retVal[$mi['MenuPositionId']][] = $mi;
        }
        return $retVal;
    }
    
    public function getParentMenuHtml($listMenuItems){
        $retVal = '<option value="0">Không có</option>';
        foreach($listMenuItems as $mi){
            if($mi['MenuLevel'] == 1) $retVal .= '<option value="' . $mi['MenuItemId'] . '">' . $mi['ItemName'] . '</option>';
            elseif($mi['MenuLevel'] == 2) $retVal .= '<option value="' . $mi['MenuItemId'] . '">+> ' . $mi['ItemName'] . '</option>';
        }
        return $retVal;
    }
}