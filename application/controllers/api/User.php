<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function updateProfile(){
		$user = $this->checkUserLogin(true);
		$postData = $this->arrayFromPost(array('StaffPass', 'NewPass', 'FullName', 'Email', 'GenderId', 'ResProvinceId', 'ResDistrictId', 'ResWardId', 'ResAddress', 'BirthDay', 'PhoneNumber', 'Avatar'));
		if(!empty($postData['FullName']) && $postData['GenderId'] > 0) {
			$flag = false;
			if (!empty($postData['NewPass'])) {
				if ($user['StaffPass'] == md5($postData['StaffPass'])) {
					$flag = true;
					$postData['StaffPass'] = md5($postData['NewPass']);
					unset($postData['NewPass']);
				}
				else echo json_encode(array('code' => -1, 'message' => "Old Password is wrong"));
			}
			else {
				$flag = true;
				unset($postData['StaffPass']);
				unset($postData['NewPass']);
			}
			if ($flag) {
				if($this->Mstaffs->checkExistLogin($user['StaffId'], $postData['Email'], $postData['PhoneNumber'])) {
					echo json_encode(array('code' => -1, 'message' => "Email hoặc số điện thoại đã tồn tại, vui lòng nhập lại !!!"));
				}
				else {
					$postData['BirthDay'] = ddMMyyyyToDate($postData['BirthDay']);
					if(empty($postData['Avatar'])) $postData['Avatar'] = NO_IMAGE;
					else $postData['Avatar'] = replaceFileUrl($postData['Avatar'], USER_PATH);
					$postData['UpdateStaffId'] = $user['StaffId'];
					$postData['UpdateDateTime'] = getCurentDateTime();
					$userId = $this->Mstaffs->save($postData, $user['StaffId']);
					if($userId > 0){
						$user = array_merge($user, $postData);
						$this->session->set_userdata('user', $user);
						echo json_encode(array('code' => 1, 'message' => "Update profile thành công"));
					}
					else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
				}
			}
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

	public function changeStatus(){
		$user = $this->checkUserLogin(true);
		$userId = $this->input->post('UserId');
		$statusId = $this->input->post('StatusId');
		if($userId > 0 && $statusId >= 0 && $statusId <= count($this->Mconstants->status)) {
			$flag = $this->Musers->changeStatus($statusId, $userId, '', $user['UserId']);
			if($flag) {
				$statusName = "";
				if($statusId == 0) $txtSuccess = "Delete {$this->input->post('UserTypeName')} success";
				else{
					$txtSuccess = "Change status success";
					$statusName = '<span class="' . $this->Mconstants->labelCss[$statusId] . '">' . $this->Mconstants->status[$statusId] . '</span>';
				}
				echo json_encode(array('code' => 1, 'message' => $txtSuccess, 'data' => array('StatusName' => $statusName)));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

	public function saveUser(){
		$user = $this->session->userdata('user');
		$postData = $this->arrayFromPost(array('FullName', 'NickName', 'GenderId', 'Avatar', 'Description', 'PhoneNumber', 'Email', 'BirthDay', 'Comment'));
		if(!empty($postData['FullName']) && $postData['GenderId'] > 0 && $postData['PhoneNumber'] > 0 ) {
			$userId = $this->input->post('UserId');
			if ($this->Musers->checkExist($userId, $postData['Email'], $postData['PhoneNumber'])) {
				echo json_encode(array('code' => -1, 'message' => "Email hoặc số điện thoại đã tồn tại!!!"));
			}
			else {
				$postData['BirthDay'] = ddMMyyyyToDate($postData['BirthDay']);
				if(empty($postData['Avatar'])) $postData['Avatar'] = NO_IMAGE;
				else $postData['Avatar'] = replaceFileUrl($postData['Avatar'], USER_PATH);
				if ($userId == 0){
					$postData['StatusId'] = STATUS_ACTIVED;
					$postData['UserPass'] = '123456';
					$postData['CrUserId'] = ($user) ? $user['UserId'] : 0;
					$postData['CrDateTime'] = getCurentDateTime();
				}
				else{
					$postData['UpdateUserId'] = ($user) ? $user['UserId'] : 0;
					$postData['UpdateDateTime'] = getCurentDateTime();
				}
				$userId = $this->Musers->save($postData);
				if ($userId > 0) {
					if($user && $user['UserId'] == $userId){
						$user = array_merge($user, $postData);
						$this->session->set_userdata('user', $user);
					}
					if ($this->input->post('IsSendPass') == 'on') {
						$message = "Xin chào {$postData['FullName']}<br/>Your Login info: <br/>URL: " . base_url() . "<br/>Username: {$postData['PhoneNumber']}<br/>Password: {$userPass}";
						$configs = $this->session->userdata('configs');
						if (!$configs) $configs = array();
						$emailFrom = isset($configs['EMAIL_COMPANY']) ? $configs['EMAIL_COMPANY'] : 'ricky@gmail.com';
						$companyName = isset($configs['COMPANY_NAME']) ? $configs['COMPANY_NAME'] : 'Ricky';
						$this->sendMail($emailFrom, $companyName, $postData['Email'], 'Login info', $message);
					}
					echo json_encode(array('code' => 1, 'message' => "Thêm người dùng thành công", 'data' => $userId));
				}
				else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
			}
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
	function updateGroupUser(){
		$user = $this->checkUserLogin();
		$group = $this->input->post('group');
		$userId = $this->input->post('id');
		$namelogin = $this->input->post('namelogin');
		$this->loadModel(array('Mpermissions'));
		$username = $this->Musers->userCodeName($userId,'UID');
		$postData['NameLogin'] = $namelogin;
		$postData['UserName'] = $username;
		$userId = $this->Musers->save($postData,$userId);
		foreach ($group as $value) {
			$postDataPer['GroupId'] = $value['GroupId'];
			$postDataPer['UserId'] = $userId;
			$postDataPer['StatusId'] = STATUS_ACTIVED;
			$permissionId = $this->Mpermissions->save($postDataPer);
		}
		if($permissionId>0){
			echo json_encode(array('code' => 1, 'message' => "Phân quyền người dùng thành công", 'data' => $userId));
		}
		else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
	}

	public function checkLogin(){
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		$postData = $this->arrayFromPost(array('StaffName', 'StaffPass', 'IsRemember', 'IsGetConfigs'));
		$userName = $postData['StaffName'];
		$userPass = $postData['StaffPass'];
		if(!empty($userName) && !empty($userPass)) {
			$configs = array();
			$user = $this->Mstaffs->login($userName, $userPass);
			if ($user) {
				$this->session->set_userdata('StaffName', $postData['StaffName']);
				$this->session->set_userdata('StaffPass', $postData['StaffPass']);
				if(empty($user['Avatar'])) $user['Avatar'] = NO_IMAGE;
				if(isset($user['StaffId'])){
					$this->Mstaffs->save(array('LoginTimes' => getCurentDateTime()), $user['StaffId']);
					$this->session->set_userdata('user', $user);
				}
				// if ($postData['IsGetConfigs'] == 1) {
				// 	$this->load->model('Mconfigs');
				// 	$configs = $this->Mconfigs->getListMap();
				// 	$this->session->set_userdata('configs', $configs);
				// }
				if ($postData['IsRemember'] == 'on') {
					$this->load->helper('cookie');
					$this->input->set_cookie(array('name' => 'userName', 'value' => $userName, 'expire' => '86400'));
					$this->input->set_cookie(array('name' => 'userPass', 'value' => $userPass, 'expire' => '86400'));
				}
				$user['SessionId'] = uniqid();
				echo json_encode(array('code' => 1, 'message' => "Đăng nhập thành công", 'data' => array('User' => $user, 'Configs' => $configs, 'message' => "Đăng nhập thành công")));
			} 
			else echo json_encode(array('code' => 0, 'message' => "Đăng nhập thất bại"));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

	public function forgotPass(){
		header('Content-Type: application/json');
		$email = trim($this->input->post('Email'));
		if(!empty($email)){
			$user = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'Email' => $email), true, "", "UserId,FullName");
			if($user){
				$userPass = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_RANDOM));
				$message = "Hi {$user['FullName']}.<br/> Your new password is {$userPass}";
				$this->load->model('Mconfigs');
				$configs = $this->Mconfigs->getListMap();
				$emailFrom = isset($configs['EMAIL_COMPANY']) ? $configs['EMAIL_COMPANY'] : 'ricky@gmail.com';
				$companyName = isset($configs['COMPANY_NAME']) ? $configs['COMPANY_NAME'] : 'Ricky';
				$flag = $this->sendMail($emailFrom, $companyName, $email, 'Your new password', $message);
				if($flag){
					$this->Musers->save(array('UserPass' => md5($userPass)), $user['UserId']);
					echo json_encode(array('code' => 1, 'message' => "Sent password to {$email}", 'data' => array('message' => "Sent password to {$email}")));
				}
				else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
			}
			else echo json_encode(array('code' => 0, 'message' => "User is not existed"));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

	// public function requestSendToken(){
	// 	$email = trim($this->input->post('Email'));
	// 	if(!empty($email)){
	// 		$user = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'Email' => $email), true, "", "UserId,FullName");
	// 		if($user){
	// 			$token = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_RANDOM));
	// 			$token = substr($token, 0, 14);
	// 			$message = "Hello {$user['FullName']}<br/>Click ".base_url('user/changePass/'.$token).' to change password.';
	// 			$configs = $this->session->userdata('configs');
	// 			if(!$configs) $configs = array();
	// 			$emailFrom = isset($configs['EMAIL_COMPANY']) ? $configs['EMAIL_COMPANY'] : 'ricky@gmail.com';
	// 			$companyName = isset($configs['COMPANY_NAME']) ? $configs['COMPANY_NAME'] : 'Ricky';
	// 			$flag = $this->sendMail($emailFrom, $companyName, $email, 'Get new password', $message);
	// 			if($flag){
	// 				$this->Musers->save(array('Token' => $token), $user['UserId']);
	// 				echo json_encode(array('code' => 1, 'message' => "Check your mail and follow the guide"));
	// 			}
	// 			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
	// 		}
	// 		else echo json_encode(array('code' => 0, 'message' => "User is not existed"));
	// 	}
	// 	else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	// }

	// public function login(){
	// 	$this->openAllCors();
	// 	$input = $this->getDataRequest();
	// 	if (!empty($input)) {
	// 		if (!empty($input['username']) && !empty($input['password'])){
	// 			$user = $this->Musers->login($input['username'], $input['password'], 1);
	// 			if($user){
	// 				$fields = array('UserName', 'FullName', 'PhoneNumber', 'Email', 'Avatar');
	// 				$data = array('SessionId' => uniqid('bistech', true));
	// 				$this->Musers->save($data, $user['UserId']);
	// 				foreach($fields as $field) $data[$field] = $user[$field];
	// 				$data['Configs'] = array(
	// 					'secondCallRealtime' => 10
	// 				);
	// 				$data['Avatar'] = empty($data['Avatar']) ? base_url('assets/images/logo.png') : base_url(IMAGE_PATH.$data['Avatar']);
	// 				$this->successOutput($data, 'Đăng nhập thành công');
	// 			}
	// 			else $this->errorOutput('Không tìm thấy người dùng');
	// 		}
	// 		else $this->errorOutput();
	// 	}
	// 	else $this->errorOutput();
	// }

	// public function logout(){
    //     /*$fields = array('user', 'configs');
    //     foreach($fields as $field) $this->session->unset_userdata($field);*/
    //     $this->openAllCors();
    //     $input = $this->getDataRequest();
    //     if (!empty($input)) {
    //     	if (!empty($input['sessionId'])) {
    //     		$this->Musers->updateBy(array('SessionId' => $input['sessionId']), array('SessionId' => ''));
    //     		$this->successOutput(array(), 'Đăng xuất thành công');
    //     	}
    //     	else $this->errorOutput();
    //     }
    //     else $this->errorOutput();
    // }

    // public function changePassword(){
    // 	$this->openAllCors();
    // 	$input = $this->getDataRequest();
    // 	if (!empty($input)) {
    // 		if (!empty($input['sessionId']) && !empty($input['oldPass']) && !empty($input['newPass'])){
    // 			$user = $this->Musers->getBySessionId($input['sessionId'], 'UserId, UserPass');
    // 			if($user){
    // 				if($user['UserPass'] == md5($input['oldPass'])){
    // 					$userId = $this->Musers->save(array('UserPass' => md5($input['newPass'])), $user['UserId']);
    // 					$userId > 0 ? $this->successOutput(array(), 'Đổi mật khẩu thành công') : $this->errorOutput();
    // 				}
    // 				else $this->errorOutput('Mật khẩu cũ không đúng');
    // 			}
    // 			else $this->errorOutput('Không tìm thấy người dùng');
    // 		}
    // 		else $this->errorOutput();
    // 	}
    // 	else $this->errorOutput();
    // }

    public function updateMaxSpeed() {
    	$user = $this->checkUserLogin(true);
    	$this->loadModel(['Mtypespeed']);
    	$CustomerId = $this->input->post('CustomerId');
    	$VehicleTypeId = $this->input->post('VehicleTypeId');
    	$MaxSpeed = $this->input->post('MaxSpeed');
		$checkExist = $this->Mtypespeed->getBy(['CustomerId' => $CustomerId, 'VehicleTypeId' => $VehicleTypeId], true);
		$flag = false;
    	if(!empty($checkExist)) {
    		$flag = $this->Mtypespeed->updateBy(['TypeSpeedId' => $checkExist['TypeSpeedId']], ['MaxSpeed' => $MaxSpeed]);
    	} else {
			$flag = $this->Mtypespeed->save(['CustomerId' => $CustomerId, 'MaxSpeed' => $MaxSpeed, 'VehicleTypeId' => $VehicleTypeId]);
			if($flag) {
				$this->load->helper('slug');
			 	// Fetch and update vehicle tracking.
			 	$urlApiVehicleTracking = API_VEHICLE_TRACKING_INTERNAL.'?user_id='.$CustomerId;
				 $vehicleTracking = callApi($urlApiVehicleTracking, METHOD_PUT);
			 	$messageLog = "--------Fetch and update vehicle tracking---------";
				$messageLog .= $urlApiVehicleTracking." ==Fetch and update vehicle tracking==> ".$vehicleTracking."===method===>".METHOD_PUT;
				$messageLog .= "--------END---------";
				log_message('error', $messageLog);
			}
    	}
		if($flag) echo json_encode(['code' => 1, 'message' => 'Cập nhật thành công']);
		else echo json_encode(['code' => 0, 'message' => 'Có lỗi xảy ra, vui lòng thử lại']);
    }
}
