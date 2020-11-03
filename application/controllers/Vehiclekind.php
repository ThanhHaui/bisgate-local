<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclekind extends MY_Controller {
// Dòng xe
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Dòng xe',
            array('scriptFooter' => array('js' => 'js/vehicle_kind.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'vehiclekind')) {
            $this->load->model('Mvehiclekinds');
            $data['listVehicleKinds'] = $this->Mvehiclekinds->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/vehicle_kind', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('VehicleKindName', 'Comment'));
        if(!empty($postData['VehicleKindName'])) {
            $vehicleKindId = $this->input->post('VehicleKindId');
            if($vehicleKindId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            	$postData['CrUserId'] = $user['UserId'];
            	$postData['CrDateTime'] = getCurentDateTime();
            }
            
            $this->load->model('Mvehiclekinds');
            $flag = $this->Mvehiclekinds->save($postData, $vehicleKindId);
            if ($flag > 0) {
                $postData['VehicleKindId'] = $flag;
                $postData['IsAdd'] = ($vehicleKindId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Dòng xe thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $vehicleKindId = $this->input->post('VehicleKindId');
        if($vehicleKindId > 0){
            $this->load->model('Mvehiclekinds');
            $flag = $this->Mvehiclekinds->changeStatus(0, $vehicleKindId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Dòng xe thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}