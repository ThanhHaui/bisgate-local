<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configtable extends MY_Controller {

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array('scriptFooter' => array('js' => 'js/config_table.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'configtable')) {
            $this->load->model('Mconfigtables');
            $data['listConfigTables'] = $this->Mconfigtables->getBy(array());
            $this->load->view('setting/config_table', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit(){
        $this->checkUserLogin();
        $configTableId = $this->input->post('ConfigTableId');
        if($configTableId > 0){
            $this->load->model('Mconfigtables');
            $data = $this->Mconfigtables->get($configTableId);
            echo json_encode(array('code' => 1, 'message' => '', 'data' => $data));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function update(){
        $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('TableName', 'ConfigTableJson'));
        if(!empty($postData['TableName'])) {
            $configTableId = $this->input->post('ConfigTableId');
            $this->load->model('Mconfigtables');
            $flag = $this->Mconfigtables->save($postData, $configTableId);
            if ($flag > 0) {
                echo json_encode(array('code' => 1, 'message' => "Cập nhật thành công", 'data' => $flag));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function updateDrapDrop(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('ConfigTableId', 'TableUserJson'));
        $configTableUserId = $this->input->post('ConfigTableUserId');
        if($configTableUserId == 0) $postData['UserId'] = $user['UserId'];
        $this->load->model('Mconfigtableusers');
        $flag = $this->Mconfigtableusers->save($postData, $configTableUserId);
        if ($flag > 0) {
            echo json_encode(array('code' => 1, 'message' => "Dịch chuyển thành công", 'data' => $flag));
        }
        else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function updateActiveAndLock(){
        $user = $this->checkUserLogin();
        $userId = isset($user['UserId'])?$user['UserId']:$user['StaffId'];
        $postData = $this->arrayFromPost(array('ConfigTableId', 'TableUserJson'));
        if($postData['ConfigTableId'] > 0){
            $this->loadModel(array('Mconfigtableusers', 'Mconfigtables'));
            $configTableUserId = $this->Mconfigtableusers->getFieldValue(array('ConfigTableId' => $postData['ConfigTableId'], 'UserId' => $userId), 'ConfigTableUserId', 0);
            $postData['UserId'] = $userId;
            $flag = $this->Mconfigtableusers->save($postData, $configTableUserId);
            if ($flag) {
                echo json_encode(array('code' => 1, 'message' => "Cập nhật thành công", 'data' => $flag));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        
    }

    // public function delete(){
    //     $this->checkUserLogin(true);
    //     $bankTypeId = $this->input->post('BankTypeId');
    //     if($bankTypeId > 0){
    //         $this->load->model('Mbanktypes');
    //         $flag = $this->Mbanktypes->changeStatus(0, $bankTypeId);
    //         if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa loại ngân hàng thành công"));
    //         else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    //     }
    //     else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    // }
}
