<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenttype extends MY_Controller {
// Loại đại lý
	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Loại đại lý',
            array('scriptFooter' => array('js' => 'js/agent_type.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'agenttype')) {
            $this->load->model('Magenttypes');
            $data['listAgentTypes'] = $this->Magenttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/agent_type', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('AgentTypeName', 'Comment'));
        if(!empty($postData['AgentTypeName'])) {
            $agentTypeId = $this->input->post('AgentTypeId');
            if($agentTypeId == 0){
            	$postData['StatusId'] = STATUS_ACTIVED;
            }
            
            $this->load->model('Magenttypes');
            $flag = $this->Magenttypes->save($postData, $agentTypeId);
            if ($flag > 0) {
                $postData['AgentTypeId'] = $flag;
                $postData['IsAdd'] = ($agentTypeId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật Loại đại lý thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin();
        $agentTypeId = $this->input->post('AgentTypeId');
        if($agentTypeId > 0){
            $this->load->model('Magenttypes');
            $flag = $this->Magenttypes->changeStatus(0, $agentTypeId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Loại đại lý thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}