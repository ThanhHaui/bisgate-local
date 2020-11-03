<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclegroup extends MY_Controller {
// Nhóm xe tự tạo 
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Nhóm xe tự tạo',
            array('scriptFooter' => array('js' => 'js/vehicle_group.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'vehiclegroup')) {
            $this->load->model('Mvehiclegroups');
            $data['listVehicleGroups'] = $this->Mvehiclegroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/vehicle_group', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('VehicleGroupName', 'Comment'));
        if(!empty($postData['VehicleGroupName'])) {
            $vehicleGroupId = $this->input->post('VehicleGroupId');
            if($vehicleGroupId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            	$postData['CrUserId'] = $user['UserId'];
            	$postData['CrDateTime'] = getCurentDateTime();
            }
            
            $this->load->model('Mvehiclegroups');
            $flag = $this->Mvehiclegroups->save($postData, $vehicleGroupId);
            if ($flag > 0) {
                $postData['VehicleGroupId'] = $flag;
                $postData['IsAdd'] = ($vehicleGroupId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Nhóm xe tự tạo thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $vehicleGroupId = $this->input->post('VehicleGroupId');
        if($vehicleGroupId > 0){
            $this->load->model('Mvehiclegroups');
            $flag = $this->Mvehiclegroups->changeStatus(0, $vehicleGroupId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Nhóm xe tự tạo thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}