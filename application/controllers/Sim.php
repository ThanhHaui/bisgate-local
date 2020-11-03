<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sim extends MY_Controller{

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Sim',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/sim_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/sim_update.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'sim')) {
            $this->loadModel(array('Mfilters', 'Msimmanufacturers', 'Msims'));
            $itemTypeId = 6;
            $data['itemTypeId'] = $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['listSiMmanuFacturers'] = $this->Msimmanufacturers->getBy(array('SimManufacturerStatusId' => STATUS_ACTIVED));
            $data['permissionAdd'] = $this->Mactions->checkAccess($data['listActions'], 'sim/add');
            $this->load->view('sim/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit($simId = 0){
        if($simId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật Sim ',
                array(
                    'scriptHeader' => array('css' => array()),
                    'scriptFooter' => array('js' => array('js/sim_update.js'))
                )
            );
            if($this->Mactions->checkAccess($data['listActions'], 'sim/edit')) {
                $this->loadModel(array('Msimmanufacturers', 'Msims'));
                $sim  = $this->Msims->get($simId);
                if($sim['SimStatusId'] > 0){
                    $data['simId'] = $simId;
                    $data['sim'] = $sim;
                    $data['listSiMmanuFacturers'] = $this->Msimmanufacturers->getBy(array('SimManufacturerStatusId' => STATUS_ACTIVED));
                }else{
                    $data['simId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                $this->load->view('sim/edit', $data);
            }else $this->load->view('user/permission', $data);
        } else redirect('sim');
    }

    public function update(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'sim/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'sim/edit');
        if(!$permissionAdd)  $this->load->view('user/permission', $data);
        if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $postData = $this->arrayFromPost(array('PhoneNumber', 'SimManufacturerId', 'SeriSim', 'SimTypeId'));
        if(!empty($postData['PhoneNumber']) && !empty($postData['SeriSim'])){
            $this->load->model('Msims');
            $simId = $this->input->post('SimId');
            if ($this->Msims->checkExist($simId, $postData['SeriSim'], $postData['PhoneNumber'])) {
                echo json_encode(array('code' => -1, 'message' => "SeriSim hoặc SĐT đã tồn tại, vui lòng nhập lại."));
                die;
            }
            else{
                if($simId > 0){
                    $postData['UpdateUserId'] = $user['StaffId'];
                    $postData['UpdateDateTime'] = getCurentDateTime();
                }else{
                    $postData['CrUserId'] = $user['StaffId'];
                    $postData['CrDateTime'] = getCurentDateTime();
                    $postData['SimStatusId'] = STATUS_ACTIVED;
                }
                $flag = $this->Msims->save($postData, $simId);
                if($flag) echo json_encode(array('code' => 1, "message" => 'Cập nhật thành công', 'data' => $flag));
                else echo json_encode(array('code' => 0, "message" => "Có lỗi xảy ra, vui lòng thử lại."));
            }
        }else echo json_encode(array('code' => -1, "message" => "Có lỗi xảy ra, vui lòng thử lại."));
        
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
        $this->loadModel(array('Msims'));
        $data1 = $this->Msims->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }

    public function getListSims(){
        $this->checkUserLogin();
        $searchText = $this->input->post('SearchText');
        $this->loadModel(array('Mdevices', 'Msims'));
        $data = $this->Msims->getListSims($searchText);
        echo json_encode($data);
    }

    public function getBySimId(){
        $this->checkUserLogin();
        $simId = $this->input->post('SimId');
        $this->loadModel(array('Msims','Mconstants'));
        $data = $this->Msims->get($simId);
        $data['SimType'] = $this->Mconstants->telcoIds[$data['SimTypeId']];
        echo json_encode($data);
    }
}