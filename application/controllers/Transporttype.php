<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transporttype extends MY_Controller {
// Lĩnh vực vẫn tải
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Lĩnh vực vẫn tải',
            array('scriptFooter' => array('js' => 'js/transport_type.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'transporttype')) {
            $this->load->model('Mtransporttypes');
            $data['listTransportTypes'] = $this->Mtransporttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/transport_type', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('TransportTypeName', 'Comment'));
        if(!empty($postData['TransportTypeName'])) {
            $transportTypeId = $this->input->post('TransportTypeId');
            if($transportTypeId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            }
            
            $this->load->model('Mtransporttypes');
            $flag = $this->Mtransporttypes->save($postData, $transportTypeId);
            if ($flag > 0) {
                $postData['TransportTypeId'] = $flag;
                $postData['IsAdd'] = ($transportTypeId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Lĩnh vực vẫn tải thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $transportTypeId = $this->input->post('TransportTypeId');
        if($transportTypeId > 0){
            $this->load->model('Mtransporttypes');
            $flag = $this->Mtransporttypes->changeStatus(0, $transportTypeId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Lĩnh vực vẫn tải thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}