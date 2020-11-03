<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconfigs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "configs";
        $this->_primary_key = "ConfigId";
    }

    public function getListMap($autoLoad = 1){
        $configs = $this->getBy(array('AutoLoad' => $autoLoad), false, "", "ConfigCode,ConfigValue");
        $retVal = array();
        foreach($configs as $cf) $retVal[$cf['ConfigCode']] = $cf['ConfigValue'];
        return $retVal;
    }

    public function getConfigValue($configCode, $defaultValue){
        return $this->getFieldValue(array('ConfigCode' => $configCode), 'ConfigValue', $defaultValue);
    }

    public function updateBatch($valueData){
        if(!empty($valueData)) $this->db->update_batch('configs', $valueData, 'ConfigId');
        return true;
    }

    public function updateItem($configCode, $configValue, $userId){
        $this->db->update('configs', array('ConfigValue' => $configValue, 'UpdateUserId' => $userId, 'UpdateDateTime' => getCurentDateTime()), array('ConfigCode' => $configCode));
        return true;
    }
}
