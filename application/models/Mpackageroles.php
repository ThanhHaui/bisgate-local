<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpackageroles extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = "packageroles";
        $this->_primary_key = "PackageRoleId";
    }
    public function getArrayRolePackageId($packageId){
        $listRolePackage = $this->getBy(array('packageId'=>$packageId));
        $arrayRolePackageId =[];
        foreach($listRolePackage as $rolePackage){
            array_push($arrayRolePackageId,$rolePackage['RoleMenuId']);
        }
        return $arrayRolePackageId;
    }

    public function getRoleMenuExit($packageId = 0){
        $where = '';
        if($packageId > 0) $where = ' AND packages.PackageId !='.$packageId;
        $query = "SELECT packageroles.RoleMenuId FROM packages
        LEFT JOIN packageroles ON packages.PackageId = packageroles.PackageId
        WHERE packages.StatusId = 2 AND packageroles.RoleMenuId IS NOT NULL ".$where."
        GROUP BY packageroles.RoleMenuId";
        $datas = $this->getByQuery($query); 
        $arrIds = array();
        foreach($datas as $d) {
            $arrIds[] = $d['RoleMenuId'];
        }
        return $arrIds;
    }
}