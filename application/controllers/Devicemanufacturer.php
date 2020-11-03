<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devicemanufacturer extends MY_Controller {
// Nhà sản xuất
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Nhà sản xuất',
            array('scriptFooter' => array('js' => 'js/device_manu_facturer.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'devicemanufacturer')) {
            $this->load->model('Mdevicemanufacturers');
            $data['listDeviceManuFfacturers'] = $this->Mdevicemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/device_manu_facturer', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('DeviceManufacturerName', 'Comment'));
        if(!empty($postData['DeviceManufacturerName'])) {
            $deviceManufacturerId = $this->input->post('DeviceManufacturerId');
            if($deviceManufacturerId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            }
            
            $this->load->model('Mdevicemanufacturers');
            $flag = $this->Mdevicemanufacturers->save($postData, $deviceManufacturerId);
            if ($flag > 0) {
                $postData['DeviceManufacturerId'] = $flag;
                $postData['IsAdd'] = ($deviceManufacturerId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Nhà sản xuất thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $deviceManufacturerId = $this->input->post('DeviceManufacturerId');
        if($deviceManufacturerId > 0){
            $this->load->model('Mdevicemanufacturers');
            $flag = $this->Mdevicemanufacturers->changeStatus(0, $deviceManufacturerId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Nhà sản xuất thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}