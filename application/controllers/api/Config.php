<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller{

    public function update($autoLoad = 1){
        $user = $this->checkUserLogin(true);
        $this->load->model('Mconfigs');
        $listConfigs = $this->Mconfigs->getBy(array('AutoLoad' => $autoLoad), false, "", "ConfigId,ConfigCode,ConfigValue");
        $valueData = array();
        $updateDateTime = getCurentDateTime();
        foreach($listConfigs as $c){
            $configValue = trim($this->input->post($c['ConfigCode'], false));
            if($c['ConfigCode'] == 'LOGO_IMAGE' || $c['ConfigCode'] == 'FOOTER_IMAGE' || $c['ConfigCode'] == 'YOUTUBE_IMAGE_FOOTER') $configValue = replaceFileUrl($configValue);

            if($c['ConfigValue'] != $configValue){
                $valueData[] = array('ConfigId' => $c['ConfigId'], 'ConfigValue' => $configValue, 'UpdateUserId' => $user['UserId'], 'UpdateDateTime' => $updateDateTime);
            }
        }
        $flag = $this->Mconfigs->updateBatch($valueData);
        if($flag){
            if($autoLoad == 1) {
                $configs = $this->Mconfigs->getListMap();
                $this->session->set_userdata('configs', $configs);
            }
            echo json_encode(array('code' => 1, 'message' => "Update config success"));
        }
        else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function updateItem(){
        $user = $this->checkUserLogin(true);
        $configCode = trim($this->input->post('ConfigCode'));
        $configValue = trim($this->input->post('ConfigValue'));
        if(!empty($configCode) && !empty($configValue)){
            $this->load->model('Mconfigs');
            $flag = $this->Mconfigs->updateItem($configCode, $configValue, $user['UserId']);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Update config success"));
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }

    /*public function getListDistrict(){
        $provinceId = $this->input->post('ProvinceId');
        $listDistricts = array();
        if($provinceId > 0){
            $this->load->model('Mdistricts');
            $listDistricts = $this->Mdistricts->getList($provinceId);
        }
        echo json_encode($listDistricts);
    }*/

    public function getListWard(){
        $districtId = $this->input->post('DistrictId');
        $listWards = array();
        if($districtId > 0){
            $this->load->model('Mwards');
            $listWards = $this->Mwards->getList($districtId);
        }
        echo json_encode($listWards);
    }
}