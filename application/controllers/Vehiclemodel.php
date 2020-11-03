<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclemodel extends MY_Controller {
// Đời xe
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Đời xe',
            array('scriptFooter' => array('js' => 'js/vehicle_model.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'vehiclemodel')) {
            $this->load->model('Mvehiclemodels');
            $data['listVehicleModels'] = $this->Mvehiclemodels->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/vehicle_model', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('VehicleModelName', 'Comment'));
        if(!empty($postData['VehicleModelName'])) {
            $vehicleModelId = $this->input->post('VehicleModelId');
            if($vehicleModelId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            	$postData['CrUserId'] = $user['UserId'];
            	$postData['CrDateTime'] = getCurentDateTime();
            }
            
            $this->load->model('Mvehiclemodels');
            $flag = $this->Mvehiclemodels->save($postData, $vehicleModelId);
            if ($flag > 0) {
                $postData['VehicleModelId'] = $flag;
                $postData['IsAdd'] = ($vehicleModelId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Đời xe thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $vehicleModelId = $this->input->post('VehicleModelId');
        if($vehicleModelId > 0){
            $this->load->model('Mvehiclemodels');
            $flag = $this->Mvehiclemodels->changeStatus(0, $vehicleModelId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Đời xe thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}