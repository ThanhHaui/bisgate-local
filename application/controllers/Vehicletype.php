<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicletype extends MY_Controller {
// Chủng loại xe
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Chủng loại xe',
            array('scriptFooter' => array('js' => 'js/vehicle_type.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'vehicletype')) {
            $this->loadModel(array('Mvehicletypes','Mtonnages'));
            $data['listTonages'] = $this->Mtonnages->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listVehicletypes'] = $this->Mvehicletypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/vehicle_type', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $this->loadModel(array('Mvehicletypes','Mtonnages'));
        $postData = $this->arrayFromPost(array('VehicleTypeName', 'Comment'));
        $postData1 = $this->arrayFromPost(array('UnitVallues','UnitName','TonnageId'));
        if((!empty($postData['VehicleTypeName'])) && (!empty($postData1['UnitVallues'])) && (!empty($postData1['UnitName']))) {
            $vehicleTypeId = $this->input->post('VehicleTypeId');
            $postData1['StatusId'] = STATUS_ACTIVED;
            $postData1['CrUserId'] = $user['UserId'];
            $postData1['CrDateTime'] = getCurentDateTime();
            // $postData1['UnitVallues'] = '['.$postData1['UnitVallues'].']';
            $flag1 = $this->Mtonnages->save($postData1,$postData1['TonnageId']);
//            if($vehicleTypeId == 0){
//                if($this->Mvehicletypes->checkExist( $postData['VehicleTypeName'])) {
//                    echo json_encode(array('code' => -2, 'message' => "Tên chủng loại xe đã tồi tại"));
//                    return;
//                }
//            	$postData['StatusId'] = STATUS_ACTIVED;
//            	$postData['CrUserId'] = $user['UserId'];
//            	$postData['CrDateTime'] = getCurentDateTime();
//            }
            $postData['TonnageId'] = $flag1;
            $flag = $this->Mvehicletypes->save($postData, $vehicleTypeId);
            if ($flag > 0) {
                $postData['VehicleTypeId'] = $flag;
                $postData['IsAdd'] = ($vehicleTypeId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Chủng loại xe thành công", 'data' => $postData,'name' => $postData1));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

//    public function delete(){
//        $this->checkUserLogin();
//        $vehicleTypeId = $this->input->post('VehicleTypeId');
//        if($vehicleTypeId > 0){
//            $this->load->model('Mvehicletypes');
//            $flag = $this->Mvehicletypes->changeStatus(0, $vehicleTypeId);
//            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Chủng loại xe thành công"));
//            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
//        }
//        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
//    }
}