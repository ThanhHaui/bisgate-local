<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclemanufacturer extends MY_Controller {
// Hãng xe
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Hãng xe',
            array('scriptFooter' => array('js' => 'js/vehicle_manu_facturer.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'vehiclemanufacturer')) {
            $this->load->model('Mvehiclemanufacturers');
            $data['listVehiclemanufacturers'] = $this->Mvehiclemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/vehicle_manu_facturer', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('VehicleManufacturerName', 'Comment'));
        if(!empty($postData['VehicleManufacturerName'])) {
            $vehicleManufacturerId = $this->input->post('VehicleManufacturerId');
            if($vehicleManufacturerId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            	$postData['CrUserId'] = $user['StaffId'];
            	$postData['CrDateTime'] = getCurentDateTime();
            }
            
            $this->load->model('Mvehiclemanufacturers');
            $flag = $this->Mvehiclemanufacturers->save($postData, $vehicleManufacturerId);
            if ($flag > 0) {
                $postData['VehicleManufacturerId'] = $flag;
                $postData['IsAdd'] = ($vehicleManufacturerId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Hãng xe thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $vehicleManufacturerId = $this->input->post('VehicleManufacturerId');
        if($vehicleManufacturerId > 0){
            $this->load->model('Mvehiclemanufacturers');
            $flag = $this->Mvehiclemanufacturers->changeStatus(0, $vehicleManufacturerId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Hãng xe thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}