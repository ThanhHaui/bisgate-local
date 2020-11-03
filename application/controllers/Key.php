<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Key extends MY_Controller {

	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Key Active',
            array('scriptFooter' => array('js' => 'js/key.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'key')) {
            $this->load->model('Mkeys');
            $data['listKeys'] = $this->Mkeys->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/key', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $this->load->model('Mkeys');
        $flag = $this->Mkeys->save(array(
            'KeyCode' => uniqid($user['StaffId'].strtotime(getCurentDateTime())),
            'StatusId' => STATUS_ACTIVED
        ));
        if ($flag > 0) {
            echo json_encode(array('code' => 1, 'message' => "Thêm Key thành công", 'data' => $flag));
        }
        else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $keyId = $this->input->post('KeyId');
        if($keyId > 0){
            $this->load->model('Mkeys');
            $flag = $this->Mkeys->changeStatus(0, $keyId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Key thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}