<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devicegroup extends MY_Controller {
// Loại thiết bị
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Loại thiết bị',
            array('scriptFooter' => array('js' => 'js/device_group.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'devicegroup')) {
            $this->load->model('Mdevicegroups');
            $data['listDeviceGroups'] = $this->Mdevicegroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/device_group', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('DeviceGroupName'));
        if(!empty($postData['DeviceGroupName'])) {
            $deviceGroupId = $this->input->post('DeviceGroupId');
            if($deviceGroupId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            }
            
            $this->load->model('Mdevicegroups');
            $flag = $this->Mdevicegroups->save($postData, $deviceGroupId);
            if ($flag > 0) {
                $postData['DeviceGroupId'] = $flag;
                $postData['IsAdd'] = ($deviceGroupId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Loại thiết bị thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $deviceGroupId = $this->input->post('DeviceGroupId');
        if($deviceGroupId > 0){
            $this->load->model('Mdevicegroups');
            $flag = $this->Mdevicegroups->changeStatus(0, $deviceGroupId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Loại thiết bị thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}