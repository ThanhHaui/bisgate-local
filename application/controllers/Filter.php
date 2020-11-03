<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends MY_Controller{

    public function save(){
        $user = $this->checkUserLogin(true);
        if($this->Mactions->checkAccessFromDb('filter/update', $user['UserId'])) {
            $postData = $this->arrayFromPost(array('FilterName', 'FilterData', 'TagFilter', 'ItemTypeId','DisplayOrder', 'FilterNote'));
            if($postData['ItemTypeId'] > 0) {
                $filterId = $this->input->post('FilterId');
                if ($filterId > 0) {
                    // unset($postData['FilterName']);
                    $postData['UpdateUserId'] = $user['UserId'];
                    $postData['UpdateDateTime'] = getCurentDateTime();
                }
                else {
                    $postData['StatusId'] = STATUS_ACTIVED;
                    $postData['CrUserId'] = $user['UserId'];
                    $postData['CrDateTime'] = getCurentDateTime();
                }
                $this->load->model('Mfilters');
                $filterId = $this->Mfilters->save($postData, $filterId);
                if ($filterId > 0){
                    $listFilters = $this->Mfilters->getList($postData['ItemTypeId']);
                    echo json_encode(array('code' => 1, 'message' => "Cập nhật bộ lọc thành công", 'data' => $filterId, 'listFilters' => $listFilters));
                } 
                else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }
            else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $user = $this->checkUserLogin(true);
        $flag = $this->Mactions->checkAccessFromDb('filter/update', $user['UserId']);
        $filterId = $this->input->post('FilterId');
        if($flag && $filterId > 0) {
            $this->load->model('Mfilters');
            $flag = $this->Mfilters->changeStatus(0, $filterId, '', $user['UserId']);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa bộ lọc thành công",'filterId' => $filterId));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function updateDisplayOrder(){
        $user = $this->checkUserLogin(true);
        if($this->Mactions->checkAccessFromDb('filter/update', $user['UserId'])) {
            $filterIds = trim($this->input->post('FilterIds'));
            $filterIds = str_replace('liFilter[]=', '', $filterIds);
            $filterIds = explode('&', $filterIds);
            if(!empty($filterIds)){
                $postData = array();
                $crDateTime = getCurentDateTime();
                $i = 0;
                foreach($filterIds as $filterId){
                    if($filterId > 0){
                        $i++;
                        $postData[] = array(
                            'FilterId' => $filterId,
                            'DisplayOrder' => $i,
                            'UpdateUserId' => $user['UserId'],
                            'UpdateDateTime' => $crDateTime
                        );
                    }
                }
                if(!empty($postData)) {
                    $flag = $this->db->update_batch('filters', $postData, 'FilterId');
                    if ($flag > 0) echo json_encode(array('code' => 1, 'message' => "Cập nhật vị trí thành công"));
                    else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
                }
                else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }
            else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function get(){
        $user = $this->checkUserLogin();
        $filterId = $this->input->post('FilterId');
        if($filterId > 0) {
            $this->load->model('Mfilters');
            $flag = $this->Mfilters->get($filterId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "", 'data' => $flag));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function searchByDataFilter(){
        $user = $this->checkUserLogin(true);
        $data = array();
        $itemTypeId = $this->input->post('itemTypeId');
         $filterId = $this->input->post('filterId');
        $searchText = $this->input->post('searchText');
        $page = $this->input->post('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $limit = $this->input->post('limit');
        if (!is_numeric($limit) || $limit < 1) $limit = 10;
        $this->loadModel(array('Mfilters'));
        $data1 = $this->Mfilters->searchByFilter($searchText, $limit, $page, $itemTypeId);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}