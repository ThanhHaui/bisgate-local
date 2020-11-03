<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groupaction extends MY_Controller {

	public function index($groupId = 0){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Cấp quyền cho nhóm',
			array('scriptFooter' => array('js' => 'js/group_action.js'))
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'groupaction')) {
			$data['groupId'] = $groupId > 0 ? $groupId : 0;
			$this->load->model('Mgroups');
			$data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
			$data['listActiveActions'] = $this->Mactions->getHierachy();
			$this->load->view('setting/group_action', $data);
		}
		else $this->load->view('user/permission', $data);
	}

	public function getAction(){
		$this->checkUserLogin(true);
		$groupId = $this->input->post('GroupId');
		if($groupId > 0){
			$this->load->model('Mgroupactions');
			echo json_encode(array('code' => 1, 'data' => $this->Mgroupactions->getBy(array('GroupId' => $groupId), false, '', 'ActionId')));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

	public function update(){
		$user = $this->checkUserLogin(true);
		$groupId = $this->input->post('GroupId');
		if ($groupId > 0) {
			$valueData = array();
			$actionIds = $this->input->post('ActionIds');
			if(!empty($actionIds)){
				$crDateTime = getCurentDateTime();
				$actionIds = json_decode($actionIds, true);
				foreach($actionIds as $actionId) $valueData[] = array('GroupId' => $groupId, 'ActionId' => $actionId);
			}
			$this->load->model('Mgroupactions');
			$flag = $this->Mgroupactions->updateBatch($groupId, $valueData);
			if($flag) echo json_encode(array('code' => 1, 'message' => "Cấp quyên truy cập thành công"));
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}
