<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends MY_Controller {

    public function index($transactionTypeId = 0){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách các Tag',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/sortable/Sortable.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/search_item.js', 'js/tags_list.js'))
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'tag')) {
            $this->loadModel(array('Mfilters','Mtags'));
            $itemTypeId = 36;
            $data['itemTypeId'] = $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
             $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
            $this->load->view('setting/tag', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function searchByFilter(){
        $user = $this->checkUserLogin(true);
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
        if(!is_numeric($page) || $page < 1) $page = 1;
        $limit = $this->input->post('limit');
        if(!is_numeric($limit) || $limit < 1) $limit = DEFAULT_LIMIT;
        $this->loadModel(array('Mtags'));
        $data1 = $this->Mtags->searchByFilter($searchText, $itemFilters, $limit, $page);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }

    public function deleteTag(){
        $user = $this->checkUserLogin(true);
        $tagIds = json_decode(trim($this->input->post('TagId')), true);
        if(count($tagIds) > 0){
            $this->db->where_in('TagId', $tagIds);
            $flag =  $this->db->delete('tags');
            $this->db->where_in('TagId', $tagIds);
            $flag_2 =  $this->db->delete('itemtags');
            if($flag == true && $flag_2 == true) echo json_encode(array('code' => 1, 'message' => 'Xóa tag thành công'));
            else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra, vui lòng thử lại?'));
        }else echo json_encode(array('code' => -1, 'message' => 'Có lỗi xảy ra, vui lòng thử lại?'));
    }
}