<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends MY_Controller {

	public function index(){
		$staff = $this->checkUserLogin();
		$data = $this->commonData($staff,
			'Danh sách Nhân viên',
			array(
				'scriptHeader' => array('css' => array('css/staff.css','vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css','css/custom.css')),
				'scriptFooter' => array('js' => array( 'vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js','js/search_item_modal.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js','vendor/plugins/dragndrop/dragndrop.table.columns.js','vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/header_table.js', 'js/search_filter.js','js/staff_list.js'))
			)
		);
		if($this->Mactions->checkAccess($data['listActions'], 'staff')) {
			$postData = $this->arrayFromPost(array());
			$postData['CheckStaffRole'] = 1; // kiểm tra là NV của bisgate không phải thuộc trong nhóm đại lý
			$rowCount = $this->Mstaffs->getCount($postData);
			$data['staffLogin'] = $staff['StaffId'];
			$data['staffLoginRole'] = $this->Mstaffs->getFieldValue(array('StaffId'=>$staff['StaffId']),'StaffRoleId','');
			$data['listStaff'] = array();
            $this->loadModel(array('Mfilters', 'Mprovinces', 'Mcountries', 'Mtransporttypes', 'Magents', 'Magenttypes','Mstaffs'));
            $itemTypeId = ID_LOG_STAFF;
            $data['itemTypeId'] = $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['listProvinces'] = $this->Mprovinces->getList();
            $data['listCountries'] = $this->Mcountries->getList();
            $data['listTransportTypes'] = $this->Mtransporttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listAgentTypes'] = $this->Magenttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listAgents1'] = $this->Mstaffs->getBy(array('StatusId' => STATUS_ACTIVED, 'AgentLevelId' => 1));
            $data['listAgents2'] = $this->Mstaffs->getBy(array('StatusId' => STATUS_ACTIVED, 'AgentLevelId' => 2));
			if($rowCount > 0){
				$perPage = DEFAULT_LIMIT;
				$pageCount = ceil($rowCount / $perPage);
				$page = $this->input->post('PageId');
				if(!is_numeric($page) || $page < 1) $page = 1;
				$data['listStaff'] = $this->Mstaffs->search($postData, $perPage, $page);
				$data['paggingHtml'] = getPaggingHtml($page, $pageCount);
			}
			$this->load->view('staff/list', $data);
		}
		else $this->load->view('user/permission', $data);
	}
	public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Thêm Nhân viên',
			array(
				'scriptHeader' => array('css' => array('vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css', 'css/staff.css')),
				'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','js/staff_update.js'))
			)
		);
		if($this->Mactions->checkAccess($data['listActions'], 'staff/add')) {
			$this->loadModel(array('Mtags','Mprovinces','Mdistricts','Mwards','Mgroups'));
			$itemTypeId = ID_LOG_STAFF;
			$data['itemTypeId'] =  $itemTypeId;
			$data['checkRole'] = $this->Mstaffs->checkRoleStaff();
			$data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
			$data['staffLogin'] = $user['StaffRoleId'];
			$data['listProvinces'] = $this->Mprovinces->getList();
			$data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));			
			$this->load->view('staff/add', $data);
		}
		else $this->load->view('user/permission', $data);
	}
	public function view($staffId = 0){
		if($staffId > 0) {
			$user = $this->checkUserLogin();
			$data = $this->commonData($user,
				'Xem profile',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/rangeslider/rangeslider.css','vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css','css/staff.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','js/staff_update.js'))
                )
			);
			if($user['StaffId'] == $staffId){
				$data['staffEdit'] = $staffEdit = $this->Mstaffs->get($staffId);
                if ($staffEdit && $staffEdit['StatusId'] > 0) {
					$this->loadModel(array('Mprovinces', 'Mdistricts', 'Mwards', 'Mgroups', 'Musergroups','Mtags','Mschoolreports','Mjobtitles','Mexperiences','Mstaffgroups','Mactionlogs'));
					$itemTypeId = ID_LOG_STAFF;
					$data['itemTypeId'] =  $itemTypeId;
					$data['listActionLogs'] = $this->Mactionlogs->getList($staffId, $itemTypeId);
					$data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
					$data['staffLogin'] = $user['StaffRoleId'];
					$data['staffid'] = $staffId;
					$data['listProvinces'] = $this->Mprovinces->getList();
					$data['schoolreports'] = $this->Mschoolreports->getBy(array('StaffId' => $staffId));
					$data['jobtitles'] = $this->Mjobtitles->getBy(array('StaffId' => $staffId));
					$data['experiences'] = $this->Mexperiences->getBy(array('StaffId' => $staffId));
					$data['listGroupIds'] = $this->Mstaffgroups->getBy(array('StaffId' => $staffId));
					$data['tagNames'] = $this->Mtags->getTagNames($staffId, $itemTypeId);
					$data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));			
					$this->load->view('staff/view', $data);
				}
				else {
					$data['staffid'] = 0;
					$data['txtError'] = "Không tìm thấy thông tin nhân viên này.";
					$this->load->view('staff/view', $data);
				}
			}
			else $this->load->view('user/permission', $data);
		}
		else redirect('staff');
	}
	public function edit($staffId = 0){
		if($staffId > 0) {
			$user = $this->checkUserLogin();
			$data = $this->commonData($user,
				'Sửa profile nhân viên',
				array(
					'scriptHeader' => array('css' => array('vendor/plugins/rangeslider/rangeslider.css','vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css','css/staff.css')),
					'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','js/staff_update.js'))
				)
			);
            $roleMember = $this->Mstaffs->getFieldValue(array('StaffId' => $staffId),'StaffRoleId',0);
			if ($this->Mactions->checkAccess($data['listActions'], 'staff/edit') && ($user['StaffRoleId'] < $roleMember) && ($roleMember > 0) && ($user['StaffRoleId'])) {
				$data['staffEdit'] = $staffEdit = $this->Mstaffs->get($staffId);
				if ($staffEdit && $staffEdit['StatusId'] > 0) {
					$this->loadModel(array('Mprovinces', 'Mdistricts', 'Mwards', 'Mgroups', 'Musergroups','Mtags','Mschoolreports','Mjobtitles','Mexperiences','Mstaffgroups','Mactionlogs'));
					$itemTypeId = ID_LOG_STAFF;
					$data['itemTypeId'] =  $itemTypeId;
					$data['listActionLogs'] = $this->Mactionlogs->getList($staffId, $itemTypeId);
					$data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
					$data['staffLogin'] = $user['StaffRoleId'];
					$data['staffid'] = $staffId;
					$data['listProvinces'] = $this->Mprovinces->getList();		
					$data['schoolreports'] = $this->Mschoolreports->getBy(array('StaffId' => $staffId));
					$data['jobtitles'] = $this->Mjobtitles->getBy(array('StaffId' => $staffId));
					$data['experiences'] = $this->Mexperiences->getBy(array('StaffId' => $staffId));
					$data['listGroupIds'] = $this->Mstaffgroups->getBy(array('StaffId' => $staffId));
					$data['tagNames'] = $this->Mtags->getTagNames($staffId, $itemTypeId);
					$data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
					$this->load->view('staff/edit', $data);
				}
				else {
					$data['staffid'] = 0;
					$data['txtError'] = "Không tìm thấy nhân viên";
					$this->load->view('staff/edit', $data);
				}
			}
		else $this->load->view('user/permission', $data);
		}
	}

	public function update(){
		$staff = $this->checkUserLogin();
		$data = $this->commonData($staff,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'staff/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'staff/edit');
        $permissionView = $this->Mactions->checkAccess($data['listActions'], 'staff/view');
        if(!$permissionAdd) $this->load->view('user/permission', $data);
        else if(!$permissionEdit)  $this->load->view('user/permission', $data);
        else if(!$permissionView)  $this->load->view('user/permission', $data);
		$checkPass = 0;
		$postData = $this->arrayFromPost(array('FullName', 'NickName', 'GenderId', 'Avatar', 'Description', 'PhoneNumber',
			'Email', 'BirthDay', 'CardId','CardDate','CardPossition','AvatarBegin','AvatarBehind','NationalityId','SexStatusId',
			'ResProvinceId','ResDistrictId','ResWardId','ResAddress','HTProvinceId','HTDistrictId',
			'HTWardId','HTAddress','JobDate','JobLevelId','JobDepartment','Note','StaffName','StaffRoleId','TaxCode'));
		if(!empty($postData['FullName'])  && $postData['PhoneNumber'] > 0 ) {
			$this->loadModel(array('Mexperiences','Mjobtitles', 'Mschoolreports','Mstaffgroups','Mgroups'));
			$dataOldPost = $staffId = $this->input->post('StaffId');
			    // lấy dữ liệu cũ để ghi log
			$dataOld = $this->Mstaffs->get($staffId);
			$checkExit = $this->Mstaffs->checkExist($staffId, $postData['Email'], $postData['PhoneNumber'], trim($postData['StaffName']));
			if ($checkExit) {
				echo json_encode(array('code' => -1, 'message' => "Email, số điện thoại hoặc user name đã tồn tại!!!"));
				die;
			}
			else {
				$itemTypeId = ID_LOG_STAFF;
				$schoolReports = json_decode($this->input->post('SchoolReports'), true);
				$jobTitles = json_decode($this->input->post('JobTitles'), true);
				$experiences = json_decode($this->input->post('Experiences'), true);
				$groupStaff = json_decode($this->input->post('GroupStaff'), true);
				$tagNames = json_decode($this->input->post('Tags'), true);
				$postData['BirthDay'] = !empty($postData['BirthDay']) ? ddMMyyyyToDate($postData['BirthDay']): null;
				$postData['CardDate'] = !empty($postData['CardDate']) ? ddMMyyyyToDate($postData['CardDate']): null;
				$postData['JobDate'] = !empty($postData['JobDate']) ? ddMMyyyyToDate($postData['JobDate']): null;
				$postData['ResProvinceId'] = !empty($postData['ResProvinceId']) ? (int)$postData['ResProvinceId']: null;
				$postData['ResDistrictId'] = !empty($postData['ResDistrictId']) ? (int)$postData['ResDistrictId']: null;
				$postData['ResWardId'] = !empty($postData['ResWardId']) ? (int)$postData['ResWardId']: null;
				$postData['CountryId'] = !empty($postData['CountryId']) ? (int)$postData['CountryId']: null;
				$postData['HTProvinceId'] = !empty($postData['HTProvinceId']) ? (int)$postData['HTProvinceId']: null;
				$postData['HTDistrictId'] = !empty($postData['HTDistrictId']) ? (int)$postData['HTDistrictId']: null;
				$postData['HTWardId'] = !empty($postData['HTWardId']) ? (int)$postData['HTWardId']: null;
				$postData['AgentLevelId'] = !empty($postData['AgentLevelId']) ? (int)$postData['AgentLevelId']: null;
				$postData['ManagementUnitId'] = !empty($postData['ManagementUnitId']) ? (int)$postData['ManagementUnitId']: null;
				$postData['AgentTypeId'] = !empty($postData['AgentTypeId']) ? (int)$postData['AgentTypeId']: null;
				$postData['JobLevelId'] = !empty($postData['JobLevelId']) ? (int)$postData['JobLevelId']: null;
			
				if (isset($postData['AgentLevelId'])) $postData['ManagementUnitId'] = $postData['AgentLevelId'] == 2 ? 1 : $postData['ManagementUnitId'];
				
				$postData['Avatar'] = empty($postData['Avatar'])?NO_IMAGE:replaceFileUrl($postData['Avatar'], USER_PATH);
				$postData['AvatarBegin'] = empty($postData['AvatarBegin'])?NO_IMAGE:replaceFileUrl($postData['AvatarBegin'], USER_PATH);
				$postData['AvatarBehind'] = empty($postData['AvatarBehind'])?NO_IMAGE:replaceFileUrl($postData['AvatarBehind'], USER_PATH);

				if ($staffId == 0){
					$postData['StatusId'] = STATUS_ACTIVED;
					$postData['StaffPass'] = md5('123456');
					$postData['CrStaffId'] = ($staff) ? $staff['StaffId'] : 0;
					$postData['CrDateTime'] = getCurentDateTime();
				}
				else{
					$oldPass = $this->input->post('OldPass');
					$statusId = $this->input->post('StatusId');
					$postData['StatusId'] = $statusId;
					if($oldPass){
						$checkExist = $this->Mstaffs->getBy(['StaffId' => $staffId, 'StaffPass !=' => md5($oldPass)], true);
						if(!empty($checkExist)) {
							echo json_encode(array('code' => -1, 'message' => "Mật khẩu cũ không đúng, vui lòng nhập lại!!!"));
							die;
						}
						else{
							$newPass = $this->input->post('NewPass');
							$rePass = $this->input->post('RePass');
							if(!empty($newPass) && !empty($rePass)) {
								if($newPass == $rePass){
									$postData['StaffPass'] = md5($newPass);
									$checkPass = 1;
								}
								else{
									echo json_encode(array('code' => -2, 'message' => "Mật khẩu lần 1 và lần 2 không khớp, vui lòng nhập lại!!!"));
									die;
	
								}
							}
							
						}
					}
					if($postData['StaffRoleId'] == 2){
						$checkAdmin = $this->Mstaffs->getFieldValue(array('StaffRoleId' => 2,'StaffId !=' => $staffId), 'StaffId', '');
						if($checkAdmin){
							echo json_encode(array('code' => -2, 'message' => "Đã có tài khoản Admin đang tồn tại, vui lòng chọn tài khoản member hoặc loại bỏ Admin cũ!!!"));
							die;
						}
					}
					$postData['UpdateStaffId'] = $staff['StaffId'];
					$postData['UpdateDateTime'] = getCurentDateTime();
				}
				$staffId = $this->Mstaffs->update($postData, $staffId, $groupStaff, $schoolReports, $jobTitles, $experiences, $tagNames, $itemTypeId, array(), array(), $staff,$checkPass);
				if ($staffId > 0) {
					$postData['StaffCode'] = $this->Mstaffs->genStaffCode($staffId);
					echo json_encode(array('code' => 1, 'message' => "Cập nhật người dùng thành công", 'data' => array('postData' => $postData, 'groups' => $groupStaff), 'checkPass' => $checkPass));
					$staffRoleId = $this->input->post('StaffRoleId');
					if ($dataOldPost > 0) {

						if($dataOld['StaffRoleId'] != $staffRoleId){
							$actionTypeId = ID_ROLE;
							$formDataNew = $this->arrayFromPost(array('StaffRoleId'));
							$commentLog = $this->Mactionlogs->conVertCommentUpdate($formDataNew, $dataOld,'','','');
							$this->Mactionlogs->saveLog($staffId, ID_LOG_STAFF, $actionTypeId, $staff, $commentLog);
						}
						if($dataOld['FullName'] || $dataOld['PhoneNumber'] || $dataOld['Email']){
							$actionTypeId = ID_UPDATE;
							$formDataNew = $this->arrayFromPost(array('FullName','PhoneNumber','Email'));
							$commentLog = $this->Mactionlogs->conVertCommentUpdate($formDataNew, $dataOld,'','','');
							$this->Mactionlogs->saveLog($staffId, ID_LOG_STAFF, $actionTypeId, $staff, $commentLog);
						}
					}
					else {
						$commentLog[] = 'Nhân viên mới';
						$actionTypeId = ID_CREATE;
						$this->Mactionlogs->saveLog($staffId, ID_LOG_STAFF, $actionTypeId, $staff, $commentLog);
					}
					
				}
				else {
					echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
				}
			}
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
	public function getListProvince(){
		$user = $this->checkUserLogin();
		$searchText = $this->input->post('SearchText');
		$this->load->model('Mprovinces');
		$list = $this->Mprovinces->getListSelect2Ajax($searchText);
		echo json_encode($list);
	}

	public function getListDistrict(){
		$user = $this->checkUserLogin();
		$provinceId = $this->input->post('ProvinceId');
		$searchText = $this->input->post('SearchText');
		$this->load->model('Mdistricts');
		if(empty($provinceId)) $provinceId = 0;
		$list = $this->Mdistricts->getListSelect2Ajax($provinceId, $searchText);
		echo json_encode($list);
	}

	public function getListWard(){
		$user = $this->checkUserLogin();
		$districtId = $this->input->post('DistrictId');
		$searchText = $this->input->post('SearchText');
		$this->load->model('Mwards');
		if(empty($districtId)) $districtId = 0;
		$list = $this->Mwards->getListSelect2Ajax($districtId, $searchText);
		echo json_encode($list);
	}

	public function refreshPass(){
		$user = $this->checkUserLogin();
		$staffId = $this->input->post('StaffId');
		$this->load->model('Mstaffs');
		if($staffId > 0){
			$data['StaffPass']= md5('123456');
			$flag = $this->Mstaffs->updateBy(array('StaffId'=>$staffId),$data);
			if($flag){
				echo json_encode(array('code' => 1, 'message' => "Reset mật khẩu người dùng thành công"));
				$commentLog[] = '<strong>Reset</strong>';
                $this->Mactionlogs->saveLog($staffId, ID_LOG_STAFF, ID_RESET, $user, $commentLog);
			} 
		}
		else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
	}

	public function changeStatus() {
		$user = $this->checkUserLogin();
		$StatusId = $this->input->post('StatusId');
		$StaffId = $this->input->post('StaffId');
		$itemTypeId = ID_LOG_STAFF;
		if ($StatusId > 0 && $StaffId > 0) {
			$staff = $this->Mstaffs->get($StaffId);
			$flag = $this->Mstaffs->changeStatus($StatusId, $StaffId, 'StatusId', $user['StaffId']);
			if ($flag) {
				$roleStaffId = $this->Mstaffs->getFieldValue(array('StaffId' => $StaffId),'StaffRoleId','');
				if(($StatusId == 3) && ($roleStaffId == 2)){
					$this->Mstaffs->save(array('StaffRoleId' => 3), $StaffId);
				}
				if($staff['StatusId'] != $StatusId) {
                    $statusNameOld = $this->Mconstants->itemStaffStatus[$staff['StatusId']];
                    $commentLog[] = 'trạng thái từ <strong>'.$statusNameOld.'</strong> thành <strong>'.$this->Mconstants->itemStaffStatus[$StatusId].'</strong>';
                    $idStatus = ID_STATUS;
                    $this->Mactionlogs->saveLog($StaffId, ID_LOG_STAFF, $idStatus, $user, $commentLog);
                }
				echo json_encode(array('code' => 1, 'message' => "Cập nhật trạng thái thành công", 'data' => $StaffId));
			} else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));

		} else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
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
        $page = $this->input->post('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $limit = $this->input->post('limit');
        if (!is_numeric($limit) || $limit < 1) $limit = DEFAULT_LIMIT;
        $data1 = $this->Mstaffs->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId'],$user);
        $data = array_merge($data, $data1);
        echo json_encode($data);
	}
	
	public function ajaxModalInfoUser(){
        $user = $this->checkUserLogin();
        $staffId = $this->input->post('StaffId');
        $data['staffLogin'] = $user['StaffId'];
        $data['staffLoginRole'] = $this->Mstaffs->getFieldValue(array('StaffId' => $user['StaffId']), 'StaffRoleId','');
        $data['staffInfo'] = $this->Mstaffs->getBy(array('StaffId' =>$staffId));
        $flag = $this->load->view('staff/_modal_info_user',$data);
        echo json_encode($flag);
    }
}