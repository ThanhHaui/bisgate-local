<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itemcomment extends MY_Controller {

	public function insertComment(){
		$user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('ItemId', 'Comment', 'ItemTypeId', 'Avatar'));
        if($postData['ItemId'] > 0 && !empty($postData['Comment']) && $postData['ItemTypeId'] > 0){
            $postData['CrDateTime'] = getCurentDateTime();
            if (isset($user['UserId'])){
                $postData['CrUserId'] = $user['UserId'];
            }else{
                $postData['CrUserId'] = $user['StaffId'];
            }
            $this->load->model('Mitemcomments');
            $flag = $this->Mitemcomments->save($postData);
            if($flag > 0) echo json_encode(array('code' => 1, 'message' => "Cập nhật ghi chú thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}
}