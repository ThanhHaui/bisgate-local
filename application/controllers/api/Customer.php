<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;
class Customer extends MY_Controller {

    /**
	 * Api login in bislog and zinza 
	 * 1: check user login
	 * 2: check permission rolemenu
	 */

	public function login() {
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		try {
			$phoneNumber = trim($this->input->get('PhoneNumber'));
			$passWord = trim($this->input->get('PassWord'));
			if (!empty($phoneNumber) && !empty($passWord)) {
                $customer = $this->Musers->apiLogin($phoneNumber, $passWord);
                if(!empty($customer)) {
					$this->Musers->save(array('LoginTimes' => getCurentDateTime()), $customer['UserId']);
                    $this->load->library('Authorization_Token');
                    // generte a token
                    $token = $this->authorization_token->generateToken(array('UserId' => $customer['UserId'], 'CrDateTime' => getCurentDateTime()));
                    $inforCustomer = $this->Musers->checkPermissionMenu($customer['UserId'], $customer['UserLevelId'], $customer['OwnerId']);
                    $customer['token'] = $token;
                    $customer['listMenus'] = $inforCustomer;
                    echo json_encode(array('success' => true, 'message' => 'Thông tin trả về.', 'data' => $customer));
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Thông tin đăng nhập không đúng, vui lòng thử lại.'));
                }
			} else {
				echo json_encode(array('success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin trước khi đăng nhập.'));
			}
		} catch ( Exception $ex) {
			echo json_encode(array('success' => false, "message" => "Có lỗi trong quá trình đăng nhập, vui lòng thử lại."));
		}
	}
}