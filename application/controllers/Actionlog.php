<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actionlog extends MY_Controller {
    
    public function getListData(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('ItemTypeId', 'ItemId'));
        if($postData['ItemTypeId'] > 0 && $postData['ItemId'] > 0) {
            $this->loadModel(array('Mactionlogs'));
            $actionTypeIds = json_decode($this->input->post('ActionTypeIds'), true);
            $rowCount = $this->Mactionlogs->getCount($postData);
            $listActionLogs = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('PageId');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $listActionLogs = $this->Mactionlogs->search($postData, $perPage, $page, $actionTypeIds);
                for($i = 0; $i < count($listActionLogs); $i++) {
                    $crDateTime = ddMMyyyy($listActionLogs[$i]['CrDateTime'], 'd/m/Y H:i');
                    $avatar = (empty($listActionLogs[$i]['Avatar']) ? NO_IMAGE : $listActionLogs[$i]['Avatar']);
                    $listActionLogs[$i]['Avatar'] = USER_PATH.$avatar;
                    $listActionLogs[$i]['CrDateTime'] = $crDateTime;
                    $listActionLogs[$i]['JobLevelName'] = isset($listActionLogs[$i]['JobLevelId']) && $listActionLogs[$i]['JobLevelId'] > 0 ? $this->Mconstants->jobLevelId[$listActionLogs[$i]['JobLevelId']]: '';
                }
                echo json_encode(array('code' => 1, 'message' => 'Dữ liệu trả về.', 'data' => $listActionLogs));
            }
        } else echo json_encode(array('code' => -1, 'message' => 'Có lỗi xảy ra trong quá trình xử lý, vui lòng thử lại.'));
    }


    
}