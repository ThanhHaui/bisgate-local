<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Group extends MY_Controller {

	public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Danh sách Nhóm quyền',
			array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css','css/staff.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/device_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/group_list.js', 'js/search_filter.js'))
            )
		);
		if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->loadModel(array('Mfilters'));
            $itemTypeId = ID_LOG_GROUP;
            $data['itemTypeId'] = $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
			$this->load->view('group/list', $data);
		}
		else $this->load->view('user/permission', $data);
	}

	public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Phân quyền cho nhóm quyền đang chọn',
			array(
				'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
				'scriptFooter' => array('js' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.js','js/group_update.js'))
			)
		);
		if($this->Mactions->checkAccess($data['listActions'], 'group/add')) {
			$this->loadModel(array('Mgroups'));
			$itemTypeId = ID_LOG_GROUP;
			$data['itemTypeId'] =  $itemTypeId;
			$data['listActiveActions'] = $this->Mactions->getHierachy();
			$this->load->view('group/add', $data);
		}
		else $this->load->view('user/permission', $data);
	}

	public function view($groupId = 0){
		if($groupId > 0) {
			$user = $this->checkUserLogin();
			$data = $this->commonData($user,
				'Xem nhóm quyền',
				array(
					'scriptHeader' => array('css' => array('vendor/plugins/rangeslider/rangeslider.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
					'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','js/group_update.js'))
				)
			);
			if($this->Mactions->checkAccess($data['listActions'], 'group/view')) {
				$this->loadModel(array('Mgroups','Mgroupactions','Mactionlogs'));
				$data['listGroupView'] = $listGroupView = $this->Mgroups->get($groupId);
                if ($listGroupView && $listGroupView['StatusId'] > 0) {
				$itemTypeId = ID_LOG_GROUP;
				$data['itemTypeId'] =  $itemTypeId;
				$data['listActionLogs'] = $this->Mactionlogs->getList($groupId, $itemTypeId);
				$data['groupId'] = $groupId;
				$data['listGroupId'] = $this->Mgroupactions->getListFieldValue(array('GroupId' => $groupId),'ActionId');
				$data['listGroupAction'] = $this->Mgroupactions->getListGroupAction($groupId);
				$data['listActiveActions'] = $this->Mactions->getHierachy();
				}
				else{
					$data['GroupId'] = 0;
					$data['txtError'] = "Không tìm thấý trang";
				}
				$this->load->view('group/view', $data);
			}
			else $this->load->view('user/permission', $data);
		}
		else redirect('group');
	}

	public function searchByFilter(){
        $user = $this->checkUserLogin();
        $data = array();
        $filterId = $this->input->post('filterId');
        $searchText = $this->input->post('searchText');
        $itemFilters = $this->input->post('itemFilters');
        if(!is_array($itemFilters)) $itemFilters = array();
        if ($filterId > 0 && empty($itemFilters)){
            $this->load->model('Mfilters');
            $data = $this->Mfilters->getInfo($filterId);
            $itemFilters = $data['itemFilters'];
		}
		$this->loadModel(array('Mgroups','Mstaffgroups'));
        $page = $this->input->post('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $limit = $this->input->post('limit');
        if (!is_numeric($limit) || $limit < 1) $limit = DEFAULT_LIMIT;
        $data1 = $this->Mgroups->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }

	public function update(){
		$user = $this->checkUserLogin(true);
		$data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'group/add');
        $permissionView = $this->Mactions->checkAccess($data['listActions'], 'group/view');
        if(!$permissionAdd) $this->load->view('user/permission', $data);
        else if(!$permissionView)  $this->load->view('user/permission', $data);
		$postData = $this->arrayFromPost(array('GroupName', 'Comment'));
		if(!empty($postData['GroupName'])) {
			$this->load->model('Mgroups');
			$groupId = $this->input->post('GroupId');
			if ($this->Mgroups->checkExist($groupId, $postData['GroupName'])) {
				echo json_encode(array('code' => -1, 'message' => "Tên vai trò đã tồn tại, vui lòng nhập tên khác !!!"));
				die;
			}
			else {
				$logDeadline = array(
					'ItemTypeId' => 100,
					'CrUserId' => $user['StaffId'],
					'ActionTypeId' => 1,
					'CrDateTime' => getCurentDateTime()
				);
				$actionId = json_decode($this->input->post('ActionId'), true);
				if ($groupId == 0){
					$postData['StatusId'] = STATUS_ACTIVED;
					$postData['CrStaffId'] = $user['StaffId'];
					$postData['CrDateTime'] = getCurentDateTime();
					$logDeadline['Comment'] = $user['FullName'] . ': Tạo nhóm quyền';
					$flag = $this->Mgroups->update($postData, $groupId,$actionId,$logDeadline);
				}
				else{
					$staffGroupId = json_decode($this->input->post('StaffGroupId'), true);
					$postData['UpdateStaffId'] = $user['StaffId'];
					$postData['UpdateDateTime'] = getCurentDateTime();
					$logDeadline['Comment'] = $user['FullName'] . ': Cập nhật nhóm quyền';
					$flag = $this->Mgroups->update($postData, $groupId,$actionId,$logDeadline,$staffGroupId);
				}
				if ($flag > 0) {
					$postData['GroupId'] = $flag;
					echo json_encode(array('code' => 1, 'message' => "Cập nhật Nhóm quyền thành công", 'data' => $postData));
					if ($groupId == 0){
						$commentLog[] = 'Nhóm quyền mới';
						$actionTypeId = ID_CREATE;
						$this->Mactionlogs->saveLog($flag, ID_LOG_GROUP, $actionTypeId, $user, $commentLog);
					}
				}
				else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
			}
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
	
	public function delete(){
		$this->checkUserLogin();
		$groupId = $this->input->post('GroupId');
		if($groupId > 0){
			$this->load->model('Mgroups');
			$flag = $this->Mgroups->changeStatus(0, $groupId);
			if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa Nhóm quyền thành công"));
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}