<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpackages extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "packages";
        $this->_primary_key = "PackageId";
    }

    public function getPackages($packageIds, $searchText = '', $userId = 0, $isCheck = 0, $packageTypeId = 0){
        $where = '';
        $packageIds = join(",",$packageIds);
        
        if(!empty($packageIds)) $where .= ' AND packages.PackageId NOT IN ('.$packageIds.')';
        if(!empty($searchText)) $where .= ' AND packages.PackageName LIKE "%'.$searchText.'%"';
        $query = " SELECT packages.PackageId, packages.PackageCode, packages.PackageName  FROM packages  WHERE packages.PackageTypeId = ? ".$where." GROUP BY packages.PackageId";
        return $this->getByQuery($query, array($packageTypeId));
    }

    public function update($postData = array(), $packageId = 0, $packageRoles = array()){
        $isUpdate = $packageId > 0 ? true : false;
        $this->db->trans_begin();
        $packageId = $this->save($postData, $packageId);
        if($packageId > 0){
            if($isUpdate){
                $this->db->delete('packageroles', array('PackageId' => $packageId));
            } else {
                $this->db->update('packages', array('PackageCode' => $this->genPackageCode($packageId)), array('PackageId' => $packageId));
            }
            if(!empty($packageRoles)) {
                for($i = 0; $i < count($packageRoles); $i++) {
                    $packageRoles[$i]['PackageId'] = $packageId;
                }
                if(!empty($packageRoles)) $this->db->insert_batch('packageroles', $packageRoles);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        }
        else {
            $this->db->trans_commit();
            return $packageId;
        }
    }

  
    public function genPackageCode($packageId, $prefix = 'PM'){
        return $prefix . '-' . ($packageId + 10000);
    }
}