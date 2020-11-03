<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devicecode extends MY_Controller {
// Mã sản phẩm , Mẫ thiết bị
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Mã sản phẩm',
            array('scriptFooter' => array('js' => 'js/device_code.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'devicecode')) {
            $this->load->model('Mdevicecodes');
            $data['listDeviceCodes'] = $this->Mdevicecodes->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/device_code', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('DeviceCodeName', 'Comment'));
        if(!empty($postData['DeviceCodeName'])) {
            $deviceCodeId = $this->input->post('DeviceCodeId');
            if($deviceCodeId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            }
            
            $this->load->model('Mdevicecodes');
            $flag = $this->Mdevicecodes->save($postData, $deviceCodeId);
            if ($flag > 0) {
                $postData['DeviceCodeId'] = $flag;
                $postData['IsAdd'] = ($deviceCodeId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Mã sản phẩm thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $deviceCodeId = $this->input->post('DeviceCodeId');
        if($deviceCodeId > 0){
            $this->load->model('Mdevicecodes');
            $flag = $this->Mdevicecodes->changeStatus(0, $deviceCodeId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Mã sản phẩm thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}