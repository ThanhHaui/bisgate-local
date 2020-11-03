<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rolemenu extends MY_Controller {

	public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Menu bislog 1',
			array('scriptFooter' => array('js' => 'js/rolemenus.js'))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'Rolemenu')) {
			$this->load->model('Mrolemenus');
			$data['listActiveRolemenu'] = $this->Mrolemenus->getHierachy();
			$this->load->view('setting/rolemenu', $data);
		}
		else $this->load->view('user/permission', $data);
	}
	public function update(){
		$this->checkUserLogin(true);
		$postData = $this->arrayFromPost(array('RoleMenuName', 'RoleMenuChildId','RoleLevel','RoleMenuUrl'));
		$postData['RoleStatusId'] = STATUS_ACTIVED;
		$roleId = $this->input->post('RoleMenuId');
		$this->load->model('Mrolemenus');
		$flag = $this->Mrolemenus->save($postData, $roleId);
		if($flag) echo json_encode(array('code' => 1, 'message' => "Cập nhật menu thành công"));
		else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
	}
	public function delete(){
		$this->checkUserLogin(true);
		$roleId = $this->input->post('RoleMenuId');
		if($roleId > 0){
			$this->load->model('Mrolemenus');
			$flag = $this->Mrolemenus->deleteRole($roleId);
			if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa menu thành công"));
			else echo json_encode(array('code' => 0, 'message' => "Menu này chưa xóa được vì có menu con"));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}