<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mmenus extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "menus";
        $this->_primary_key = "MenuId";
    }

    public function checkExist($menuPositionId, $menuId = 0){
        $menus = $this->getByQuery('SELECT MenuId FROM menus WHERE MenuId != ? AND MenuPositionId = ? AND StatusId > 0', array($menuId, $menuPositionId));
        if(!empty($menus)) return true;
        return false;
    }
}