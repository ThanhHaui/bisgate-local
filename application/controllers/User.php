<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function index(){
		if(!$this->session->userdata('user')){
			$data = array('title' => 'Đăng nhập');
			if ($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
			$this->load->helper('cookie');
			$data['userName'] = $this->input->cookie('userName', true);
			$data['userPass'] = $this->input->cookie('userPass', true);
			$this->load->view('user/login', $data);
		}
		else redirect('user/dashboard');
	}

	public function logout(){
		$fields = array('user', 'customer', 'configs');
		foreach($fields as $field) $this->session->unset_userdata($field);
		redirect('user');
	}

	public function forgotPass(){
		$this->load->view('user/forgotpass', array('title' => 'Quên mật khẩu'));
	}

	public function sendToken(){
		$email = trim($this->input->post('Email'));
		if(!empty($email)){
			$user = $this->Mstaffs->getBy(array('StatusId' => STATUS_ACTIVED, 'Email' => $email), true, "", "StaffId,FullName");
			if($user){
				$token = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_RANDOM));
				$token = substr($token, 0, 14);
				$message = "Xin chào {$user['FullName']}<br/>Xin vào link ".base_url('user/changePass/'.$token).' để đổi mật khẩu.';
				$configs = $this->session->userdata('configs');
				if(!$configs) $configs = array();
				$emailFrom = isset($configs['EMAIL_COMPANY']) ? $configs['EMAIL_COMPANY'] : 'contact@bistech.vn';
				$companyName = isset($configs['COMPANY_NAME']) ? $configs['COMPANY_NAME'] : 'Bistech';
				$flag = $this->sendMail($emailFrom, $companyName, $email, 'Lấy lại mật khẩu', $message);
				if($flag){
					$this->Mstaffs->save(array('Token' => $token), $user['StaffId']);
					$this->load->view('user/forgotpass_new', array('title' => 'Quên mật khẩu', 'txtSuccess' => 'Kiểm tra email và làm theo hướng dẫn'));
				}
			}
			else $this->load->view('user/forgotpass_new', array('title' => 'Quên mật khẩu', 'txtError' => 'Người dùng không tốn tại hoặc chưa kích hoạt!'));
		}
		else $this->load->view('user/forgotpass_new', array('title' => 'Quên mật khẩu', 'txtError' => 'Email không được bỏ trống!'));
	}

	public function changePass($token = ''){
		$data = array('title' => 'Đổi mật khẩu', 'token' => $token);
		$isWrongToken = true;
		if(!empty($token)){
			$user = $this->Mstaffs->getBy(array('StatusId' => STATUS_ACTIVED, 'Token' => $token), true, "", "StaffId");
			if($user){
				if($this->input->post('StaffPass')) {
					$postData = $this->arrayFromPost(array('StaffPass', 'RePass'));
					if (!empty($postData['StaffPass']) && $postData['StaffPass'] == $postData['RePass']){
						$this->Mstaffs->save(array('StaffPass' => md5($postData['StaffPass']), 'Token' => ''), $user['StaffId']);
						$this->session->set_flashdata('txtSuccess', "Đổi mật khẩu thành công");
						redirect('user');
						exit();
					}
					else $data['txtError'] = "Mật khẩu không trùng";
				}
			}
			else {
				$data['txtError'] = "Mã Token không dúng";
				$isWrongToken = false;
			}
		}
		else {
			$data['txtError'] = "Mã Token không dúng";
			$isWrongToken = false;
		}
		$data['isWrongToken'] = $isWrongToken;
		$this->load->view('user/changepass', $data);
	}

	public function dashboard(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Dashboard'
			//array('scriptFooter' => array('js' => array('vendor/plugins/jquery.matchHeight.js', 'js/dashboard.js')))
		);
		$this->load->view('user/dashboard', $data);
	}

	public function permission(){
		$this->load->view('user/permission');
	}

	public function profile(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Trang cá nhân - '.$user['FullName'],
			array(
				'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css'),
				'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/user_profile.js'))
			)
		);
		$this->loadModel(array('Mprovinces', 'Mdistricts', 'Mwards'));
		$this->load->model('Mprovinces');
		$data['listProvinces'] = $this->Mprovinces->getList();
		$this->load->view('user/profile', $data);
	}

	public function staff(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Danh sách Nhân viên',
            array(
                'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css'),
                'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/user_update.js', 'js/user_list.js'))
            )
		);
		if($this->Mactions->checkAccess($data['listActions'], 'user/staff')) {
			$this->loadModel(array('Mcountries','Mprovinces', 'Mdistricts', 'Mwards','Mgroups', 'Musergroups','Mtags'));
            $data['userId'] = $user['UserId'];
            $data['tagNames'] = $this->Mtags->getBy(array('ItemTypeId' => 8));
            $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => 8));
            $whereStatus = array('StatusId' => STATUS_ACTIVED);
			$data['listGroups'] = $this->Mgroups->getBy($whereStatus);
			$postData = $this->arrayFromPost(array('UserName', 'FullName', 'PhoneNumber', 'Email', 'StatusId', 'GenderId', 'GroupId'));
			$rowCount = $this->Musers->getCount($postData);
            $data['listProvinces'] = $this->Mprovinces->getList();
            $data['listCountries'] = $this->Mcountries->getList();
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
			$data['listUsers'] = array();
			if($rowCount > 0){
				$perPage = DEFAULT_LIMIT;
				$pageCount = ceil($rowCount / $perPage);
				$page = $this->input->post('PageId');
				if(!is_numeric($page) || $page < 1) $page = 1;
				$data['listUsers'] = $this->Musers->search($postData, $perPage, $page);
				$data['paggingHtml'] = getPaggingHtml($page, $pageCount);
			}
			$this->load->view('user/list', $data);
			
		}
		else $this->load->view('user/permission', $data);
	}

	public function edit($userId = 0){
		if($userId > 0) {
			$user = $this->checkUserLogin();
			$data = $this->commonData($user,
				'Cập nhật nhân viên',
				array(
					'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css'),
					'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/user_update.js'))
				)
			);
			$userEdit = $this->Musers->get($userId);
			if ($userEdit) {
				if ($this->Mactions->checkAccess($data['listActions'], 'user/staff')) {
					$data['canEdit'] = true;
					$data['userId'] = $userId;
					$data['userEdit'] = $userEdit;
					$this->loadModel(array('Mprovinces', 'Mdistricts', 'Mwards', 'Mgroups', 'Musergroups'));
					$data['listProvinces'] = $this->Mprovinces->getList();
					$whereStatus = array('StatusId' => STATUS_ACTIVED);
					$data['listGroups'] = $this->Mgroups->getBy($whereStatus);
					$data['groupIds'] = $this->Musergroups->getListFieldValue(array('UserId' => $userId), 'GroupId');
					$this->load->view('user/edit', $data);
				}
				else $this->load->view('user/permission', $data);
			}
			else {
				$data['userId'] = 0;
				$data['txtError'] = "Không tìm thấy nhân viên";
				$this->load->view('user/edit', $data);
			}
		}
		else redirect('user/profile');
	}
}