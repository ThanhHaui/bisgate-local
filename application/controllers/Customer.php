<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller{

    public function index($roleId = 1){
        $title = 'Khách hàng';
        $code = "KH";
        $controller = 'customer';
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách '.$title,
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/customer_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/customer_update.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], ''.$controller.'')) {
            $this->loadModel(array('Mfilters', 'Mprovinces', 'Mcountries', 'Mtransporttypes', 'Magents', 'Magenttypes','Mstaffs'));
            $data['staffInfo'] = $user;
            $data['roleId'] = $roleId;
            $data['itemTypeId'] = $roleId;
            $data['staffIdBis'] = $this->Mstaffs->getFieldValue(array('AgentLevelId' => 1),'StaffId');
            $data['listFilters'] = $this->Mfilters->getList($roleId);
            $data['listProvinces'] = $this->Mprovinces->getList();
            $data['listCountries'] = $this->Mcountries->getList();
            $data['listTransportTypes'] = $this->Mtransporttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listAgentTypes'] = $this->Magenttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['genCustomerCode'] = $code.($this->Musers->maxUserId() + 10001);
            $data['permissionAdd'] = $this->Mactions->checkAccess($data['listActions'], 'customer/add');
            $this->load->view('user/customer/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit($userId = 0){
        if($userId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật ',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/rangeslider/rangeslider.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/rangeslider/ceoslider.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/customer_update.js'))
                )
            );
            if($this->Mactions->checkAccess($data['listActions'], 'customer/edit')) {
                $this->loadModel(array('Mvehicles','Mprovinces', 'Mcountries', 'Mtransporttypes', 'Mtypespeed', 'Mvehicletypes', 'Magents', 'Magenttypes', 'Mitemcontacts', 'Musercomments', 'Mtags', 'Magentprovinces','Mssls','Mactionlogs','Mrolemenus','Musers','Mstaffs'));
                $data['checkvehicle'] = $this->Mvehicles->getFieldValue(array('UserId' => $userId), 'VehicleId', '');
                $customer = $this->Musers->get($userId);
                $data['checkSsls'] = $this->Mssls->checkSsl($userId);
                $checkLabelSsls='';
                if($data['checkSsls'] != null && $customer['StatusId'] == 2 ){
                    $checkLabelSsls = 2;
                }else if($customer['StatusId'] == 1 ){
                    $checkLabelSsls = 1;
                }else if($customer['StatusId'] == 3 ){
                    $checkLabelSsls = 3;
                }else{
                    $checkLabelSsls = 4;
                }
                if($customer['StatusId'] > 0){
                    $itemTypeId = ID_LOG_CUSTOMER;
                    $data['roleId'] = $customer['RoleId'];
                    $data['itemTypeId'] = $itemTypeId;
                    $customer['CrName'] = $this->Mstaffs->getFieldValue(array('StaffId' => $customer['CrStaffId']), 'FullName', '');
                    $agentStaffId = $data['staffId'] = $this->Musers->getFieldValue(array('UserId' => $userId), 'ManagementUnitId', '');
                    $staffLeveId = $this->Mstaffs->getFieldValue(array('StaffId' => $agentStaffId), 'AgentLevelId', '');
                    $userComments = $this->Musercomments->getBy(array('UserId' => $userId, 'CommentTypeId' => $itemTypeId));
                    $now = new DateTime(date('Y-m-d'));
                    for($i = 0; $i < count($userComments); $i++){
                        $dayDiff = getDayDiff($userComments[$i]['CrDateTime'], $now);
                        $userComments[$i]['CrDateTime'] = ddMMyyyy($userComments[$i]['CrDateTime'], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                        $userComments[$i]['DayDiff'] = $dayDiff;
                    }
                    $data['listMenuCustomer'] = $this->Mrolemenus->getHierachy();
                    $data['listMenuactive'] = $this->Musers->checkPermissionMenuCustomer($customer['UserId'], $customer['UserLevelId'], $customer['OwnerId']);
                    $data['checkLabelSsls'] =$checkLabelSsls;
                    $data['userComments'] = $userComments;
                    $data['userId'] = $userId;
                    $data['customer'] = $customer;
                    $data['itemContacts'] = $this->Mitemcontacts->getBy(array('ItemId' => $userId));
                    $data['tagNames'] = $this->Mtags->getTagNames($userId, $itemTypeId);
                    $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
                    $data['provinceIds'] = $this->Magentprovinces->getListFieldValue(array('AgentId' => $userId), 'ProvinceId');
                    $data['listProvinces'] = $this->Mprovinces->getList();
                    $data['listCountries'] = $this->Mcountries->getList();
                    $data['listTransportTypes'] = $this->Mtransporttypes->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listAgentTypes'] = $this->Magenttypes->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listAgents'] = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'RoleId' => 2));
                    $data['staffInfo'] = $user;
                    $data['listStaff'] = $this->Mstaffs->getBy(array('StatusId' => STATUS_ACTIVED,'AgentLevelId' => $staffLeveId));
                    $data['staffIdBis'] = $this->Mstaffs->getFieldValue(array('AgentLevelId' => 1),'StaffId');
                    $listVehicletypes = $this->Mvehicletypes->getBy(array('StatusId' => STATUS_ACTIVED));
                    for ($i = 0; $i < count($listVehicletypes); $i++) {
                        $checkMaxSpeed = $this->Mtypespeed->getBy(['CustomerId' => $userId, 'VehicleTypeId' => $listVehicletypes[$i]['VehicleTypeId']], true);
                        if(!empty($checkMaxSpeed)) {
                            $listVehicletypes[$i]['MaxSpeed'] = $checkMaxSpeed['MaxSpeed'];
                        }
                    }
                    $data['listVehicletypes'] = $listVehicletypes;
                }else{
                    $data['userId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                $this->load->view('user/customer/edit', $data);
            }else $this->load->view('user/permission', $data);
        } else redirect('customer');
    }

    public function update(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'customer/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'customer/edit');
        if(!$permissionAdd)  $this->load->view('user/permission', $data);
        if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $postData = $this->arrayFromPost(array('FullName', 'TaxCode', 'Email', 'GenderId', 'CountryId', 'ProvinceId', 'Address', 'BirthDay', 'PhoneNumber', 'IDCardNumber', 'CustomerTypeId', 'TransportTypeId', 'RoleId','ManagementUnitId','AgentLevelId','ShortName'));
        $userId = $this->input->post('UserId');
        if ($this->Musers->checkExist($userId, '', $postData['PhoneNumber'], $postData['RoleId'], '')) {
            echo json_encode(array('code' => -1, 'message' => "Số điện thoại bị trùng."));
            die;
        }else if($this->Musers->checkExist($userId, '', '', $postData['RoleId'], $postData['TaxCode'])){
            echo json_encode(array('code' => -1, 'message' => "Mã số thuế bị trùng."));
            die;
        }else{
            $postData['BirthDay'] = !empty($postData['BirthDay']) ? ddMMyyyyToDate($postData['BirthDay']): null;
            if(empty($postData['ManagementUnitId'])) $postData['ManagementUnitId'] = 0;
            if(empty($postData['GenderId'])) $postData['GenderId'] = 0;
            if($postData['RoleId'] == 1){
                if($postData['CustomerTypeId'] == 2){
                    unset($postData['BirthDay'], $postData['GenderId']);
                }
            }else{
                unset($postData['BirthDay'], $postData['ConnectTypeId']);
            }
            if($userId > 0){
                $postData['UpdateStaffId'] = $user['StaffId'];
                $postData['UpdateStaffDateTime'] = getCurentDateTime();

                // lấy data cũ của khách hàng
                $dataOld = $this->Musers->get($userId);
            }else{
                $postData['UserName'] = $this->input->post('UserName');
                if($this->Musers->getFieldValue(array('UserName' => $postData['UserName'], 'UserId !=' => '' ), 'UserName', '') != '') {
                    echo json_encode(array('code' => -1, 'message' => "Username ( Tên đăng nhập ) bị trùng."));
                    die;
                }
                $postData['UserLevelId'] = 1;
                $postData['UserPass'] = md5('123456');
                $postData['CrStaffId'] = $user['StaffId'];
                $postData['CrStaffDateTime'] = getCurentDateTime();
                $postData['StatusId'] = STATUS_ACTIVED;
            }
            $provinceIds = $this->input->post('ProvinceIds1');
            if (!is_array($provinceIds)) $provinceIds = array();
            $contactUsers = json_decode(trim($this->input->post('ContactUsers')), true);
            $flag = $this->Musers->update($postData, $userId, false, array(), $contactUsers, $user,array(),array(), $provinceIds);
            if ($flag) {
                echo json_encode(array('code' => 1, "message" => 'Cập nhật thành công', 'data' => $flag));
                if ($userId > 0) {
                    $actionTypeId = ID_UPDATE;
                    $formDataNew = $this->arrayFromPost(array('FullName', 'PhoneNumber', 'Email', 'AgentLevelId', 'ManagementUnitId'));
                    $commentLog = $this->Mactionlogs->conVertCommentUpdate($formDataNew, $dataOld);
                } else {
                    $actionTypeId = ID_CREATE;
                    $commentLog[] = 'Khách hàng mới <strong>'.$postData['FullName'].'</strong>';
                }
                $this->Mactionlogs->saveLog($flag, ID_LOG_CUSTOMER, $actionTypeId, $user, $commentLog);
            }
            else echo json_encode(array('code' => 0, "message" => "Có lỗi ảy ra, vui lòng thử lại."));
        }
    }

    public function insertComment(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('UserId', 'Comment', 'CommentTypeId'));
        if($postData['UserId'] > 0 && !empty($postData['Comment']) && $postData['CommentTypeId'] > 0){
            $postData['CrDateTime'] = getCurentDateTime();
            $postData['CrUserId'] = $user['StaffId'];
            $this->load->model('Musercomments');
            $flag = $this->Musercomments->save($postData);
            if($flag > 0) echo json_encode(array('code' => 1, 'message' => "Cập nhật ghi chú thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function searchByFilter($roleId){
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
        $userId = isset($user['UserId'])?$user['UserId']:$user['StaffId'];
        if($roleId == 1){
            $data1 = $this->Musers->searchByFilterUser($searchText, $itemFilters, $limit, $page, $userId, $roleId);
        }
        else if($roleId == 2){
            $data1 = $this->Musers->searchByFilterMember($searchText, $itemFilters, $limit, $page, $userId, $roleId);
        }
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }

    public function refreshPass(){
        $user = $this->checkUserLogin();
        $userId = $this->input->post('UserId');
        if($userId > 0){
            $data['UserPass']= md5('123456');
            $flag = $this->Musers->updateBy(array('UserId'=>$userId),$data);
            if($flag){
                echo json_encode(array('code' => 1, 'message' => "Reset mật khẩu người dùng thành công"));
                $commentLog[] = '<strong>Reset</strong>';
                $this->Mactionlogs->saveLog($userId, ID_LOG_CUSTOMER, ID_RESET, $user, $commentLog);
            } 
        }
        else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function changeStatus() {
        $user = $this->checkUserLogin();
        $statusId = $this->input->post('StatusId');
        $userId = $this->input->post('UserId');
        $checkMember = $this->input->post('CheckMember');
        if ($statusId > 0 && $userId > 0) {
            $customer  = $this->Musers->get($userId);
            $text = '';
            if ($statusId == 2) $text = ' Đã kích hoạt lại hợp đồng ';
            else if ($statusId == 1) $text = ' Tạm cắt hợp đồng - LOCK';
            else $text = ' Dừng hẳn hợp đồng luôn - STOP';

            $commentNew = '';
            if($checkMember == 1){
                $commentNew = $text;
                $flag = $this->Musers->changeStatus($statusId, $userId, 'StatusId', $user['UserId']);
            }else{
                $commentNew = $text;
                $flag = $this->Musers->changeStatus($statusId, $userId, 'StatusId', $user['StaffId']);
            }
            if ($flag) {
                echo json_encode(array('code' => 1, 'message' => "" . $commentNew . " thành công", 'data' => $userId));
                if($customer['StatusId'] != $statusId) {
                    $commentOld = $this->Mconstants->userStatus[$customer['StatusId']];

                    $commentLog[] = 'trạng thái từ <strong>'.$commentOld.'</strong> thành <strong>'.$commentNew.'</strong>';
                    $this->Mactionlogs->saveLog($userId, ID_LOG_CUSTOMER, ID_STATUS, $user, $commentLog);
                }
            } else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));

        } else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
    }

    public function listAgentAjax(){
        $this->checkUserLogin();
        $searchText = $this->input->post('SearchText');
        $typeId = $this->input->post('TypeId');
        $data = $this->Mstaffs->getListManagerUnit($searchText,$typeId);
        echo json_encode($data);
    }
    public function member($roleId = 2){
        $staff = $this->checkUserLogin();
		$data = $this->commonData($staff,
            'Danh sách khách hàng',
            array(
                    'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css','css/member.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/member_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/search_filter.js'))
                )
		);
		if($this->Mactions->checkAccess($data['listActions'], 'member')) {
            $this->loadModel(array('Mfilters'));
            $data['staffLogin'] = $staff['UserId'];
            $data['roleId'] = $roleId;
            $itemTypeId = $roleId;
            $data['itemTypeId'] = $roleId;
            $data['listFilters'] = $this->Mfilters->getList($roleId);
            $data['listUser'] = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED));
			$this->load->view('user/member/list', $data);
		}
		else $this->load->view('user/permission', $data);
    }
    public function ajaxModalInfoUser(){
        $user = $this->checkUserLogin();
        $userId = $this->input->post('UserId');
        $data['userLogin'] = $user;
        $data['userLoginRole'] = $this->Musers->getFieldValue(array('UserId' => $user['UserId']), 'OwnerId','');
        $data['userInfo'] = $this->Musers->getBy(array('UserId' =>$userId));
        $flag = $this->load->view('user/member/_modal_info_user',$data);
        echo json_encode($flag);
    }
    public function groupUpdate(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('RoleName','Note'));
        $userRoleId = $this->input->post('UserRoleId');
        $roleMenuId = json_decode($this->input->post('RoleMenu'),true);
        $this->loadModel(array('Muserroledetails','Mrolemenus','Muserroles'));
            if($userRoleId > 0){
                $postData['UpdateUserId'] = $user['UserId'];
                $postData['UpdateDateTime'] = getCurentDateTime();
            }else{
                if ($this->Muserroles->checkExist($userRoleId, $postData['RoleName'])) {
                    echo json_encode(array('code' => -1, 'message' => "Tên vai trò đã tồn tại, vui lòng nhập lại!!!"));
                    die;
                }
                $postData['UserId'] = $user['UserId'];
                $postData['CrUserId'] = $user['UserId'];
                $postData['CrDateTime'] = getCurentDateTime();
                $postData['StatusId'] = STATUS_ACTIVED;
            }
            $flag = $this->Muserroles->update($postData, $userRoleId, $roleMenuId);
            if($flag) echo json_encode(array('code' => 1, "message" => 'Cập nhật thành công', 'data' => $flag,'user' => $user));
            else echo json_encode(array('code' => 0, "message" => "Có lỗi ảy ra, vui lòng thử lại."));
    }

    public function editRoleUser(){
        $user = $this->checkUserLogin();
        $userRoleId = $this->input->post('Id');
        $this->loadModel(array('Muserroledetails','Mrolemenus','Muserroles'));
        $data['listMenuCustomer'] = $this->Musers->checkPermissionMenu($user['UserId'], $user['UserLevelId'], $user['OwnerId']);
        $data['activeUserRole'] = $this->Muserroledetails->getListFieldValue(array('UserRoleId' => $userRoleId),'RoleMenuId');
        $data['nameRoleInfo'] = $this->Muserroles->getFieldValue(array('UserRoleId' =>$userRoleId),'RoleName','');
        $data['Note'] = $this->Muserroles->getFieldValue(array('UserRoleId' =>$userRoleId),'Note','');
        $data['userRoleId'] = $userRoleId;
        $flag = $this->load->view('user/member/_modal_edit_role_user',$data);
        echo json_encode($flag);
    }
    public function showAjaxVehicle(){
        $user = $this->checkUserLogin();
        $this->loadModel(array('Mssls','Mvehicles','Muservehicles'));
        $data['typeUser'] = $this->input->post('Id');
        $data['userId'] = $userId = $this->input->post('UserId');
        if($userId > 0){
            $data['listVehicleUser'] = $this->Muservehicles->getListVehicleUser($userId);
        }
        $data['listVehicle'] = $this->Mvehicles->getListVehicle($user['UserId']);
        $flag = $this->load->view('user/member/_ajax_show_tab3',$data);
        echo json_encode($flag);
    }
	public function updateMember(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'customer/addMember');
        $permissionView = $this->Mactions->checkAccess($data['listActions'], 'customer/viewMember');
        if(!$permissionAdd) $this->load->view('user/permission', $data);
        else if(!$permissionView)  $this->load->view('user/permission', $data);
		$postData = $this->arrayFromPost(array('FullName', 'NickName', 'GenderId', 'Avatar', 'Description', 'PhoneNumber', 
			'Email', 'BirthDay', 'IDCardNumber','CardDate','CardPossition','AvatarBegin','AvatarBehind','JobDate','JobLevelId','JobDepartment','Comment','UserName','UserLevelId','UserPass'));
		if(!empty($postData['FullName']) && $postData['GenderId'] > 0 && $postData['PhoneNumber'] > 0 ) {
			$this->loadModel(array('Muserjobtitles', 'Muservehicles','Muserrolemembers'));
			$userId = $this->input->post('UserId');
			if ($this->Musers->checkExist($userId, $postData['Email'], $postData['PhoneNumber'], $postData['UserName'])) {
				echo json_encode(array('code' => -1, 'message' => "Email, số điện thoại hoặc user name đã tồn tại!!!"));
				die;
			}
			else {
				$itemTypeId = ID_LOG_CUSTOMER;
				$jobTitles = json_decode($this->input->post('JobTitles'), true);
				$vehicleMember = json_decode($this->input->post('vehicleMember'), true);
                $groupStaff = json_decode($this->input->post('GroupStaff'), true);
				$tagNames = json_decode($this->input->post('Tags'), true);

				$postData['BirthDay'] = ddMMyyyyToDate($postData['BirthDay']);
				$postData['CardDate'] = ddMMyyyyToDate($postData['CardDate']);
				$postData['JobDate'] = ddMMyyyyToDate($postData['JobDate']);
				if(empty($postData['Avatar'])) $postData['Avatar'] = NO_IMAGE;
				else $postData['Avatar'] = replaceFileUrl($postData['Avatar'], USER_PATH);
				if ($userId == 0){
                    if($user['UserLevelId'] == 1){
                        $postData['OwnerId'] = $user['UserId'];
                    }
                    else if($user['UserLevelId'] == 2){
                        $postData['AdminId'] = $user['UserId'];
                    }
                    else{
                        echo json_encode(array('code' => 0, 'message' => 'Tài khoản của bạn không có quyền thêm member, vui lòng kiểm tra lại!!!'));
                        die; 
                    }
					$postData['RoleId'] = 1;
					$postData['StatusId'] = STATUS_ACTIVED;
					$postData['UserPass'] = md5($postData['UserPass']);
					$postData['CrUserId'] = ($user) ? $user['UserId'] : 0;
					$postData['CrDateTime'] = getCurentDateTime();
				}
				else{
					$oldPass = $this->input->post('OldPass');
					$statusId = $this->input->post('StatusId');
					if($oldPass){
						$checkExist = $this->Musers->getBy(['UserId' => $userId, 'UserPass !=' => md5($oldPass)], true);
						if(!empty($checkExist)) {
							echo json_encode(array('code' => -1, 'message' => "Mật khẩu cũ không đúng, vui lòng nhập lại!!!"));
							die;
						}
						else{
							$newPass = $this->input->post('NewPass');
							$rePass = $this->input->post('RePass');
							if($newPass == $rePass){
								$postData['UserPass'] = md5($newPass);
							}
							else{
								echo json_encode(array('code' => -2, 'message' => "Mật khẩu lần 1 và lần 2 không khớp, vui lòng nhập lại!!!"));
								die;

							}
						}
					}
					else{
						$postData['UserPass'] = $this->Musers->getFieldValue(array('UserId' => $userId), 'UserPass', '');
					}
					if($oldPass){
						$postData['statusId'] = $statusId;
                    }
                    $isEdit = $this->input->post('IsEdit');
					if(($postData['UserLevelId'] == 2) && ($isEdit ==1)){
						$checkAdmin = $this->Musers->getFieldValue(array('UserLevelId' => 2), 'UserId', '');
						if($checkAdmin){
							echo json_encode(array('code' => -2, 'message' => "Đã có tài khoản Admin đang tồn tại, vui lòng chọn tài khoản member hoặc loại bỏ Admin cũ!!!"));
							die;
						}
					}
					$postData['UpdateUserId'] = $user['UserId'];
					$postData['UpdateDateTime'] = getCurentDateTime();
				}
				$userId = $this->Musers->updateMember($postData, $userId, $groupStaff, $jobTitles, $vehicleMember, $tagNames, $itemTypeId, $user);
				if ($userId > 0) {
                    $postData['CodeUser'] = $this->Musers->getFieldValue(array('UserId' => $userId), 'CodeUser', '');;
					echo json_encode(array('code' => 1, 'message' => "Cập nhật người dùng thành công", 'postData' => $postData));
				}
				else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
			}
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }
    public function getListUser(){
        $searchText = $this->input->post('SearchText');
        $pagination = $this->input->post('Pagination');
        $limit = DEFAULT_LIMIT;
        $this->loadModel(array('Musers'));
        $data['listUsers'] = $this->Musers->getListUser($searchText, $pagination, $limit,1);
        $data['searchText'] = $searchText;
        $data['pagination'] = $pagination;
        return $this->load->view('includes/customer/_search_customer',$data);
    }
    public function getListUserDrivers(){
        $searchText = $this->input->post('SearchText');
        $pagination = $this->input->post('Pagination');
        $limit = DEFAULT_LIMIT;
        $this->loadModel(array('Musers','Muserdetails'));
        $driverList = $this->Musers->getListUser($searchText, $pagination, $limit,2);
            for ($i = 0; $i < count($driverList); $i++) {
            $userDetail = $this->Muserdetails->getBy(['UserId' => $driverList[$i]['UserId']], true);
            $driverList[$i]['DriverLicence'] = !empty($userDetail) ? $userDetail['DriverLicence'] : '';
        }
        $data['listUsers'] = $driverList;
        $data['searchText'] = $searchText;
        $data['pagination'] = $pagination;
        return $this->load->view('vehicle/_search_user_driver',$data);
    }
}