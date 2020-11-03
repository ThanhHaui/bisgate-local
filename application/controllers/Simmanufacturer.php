<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simmanufacturer extends MY_Controller{

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'D/S Nhà cung cấp Sim',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/sim_manu_facturer_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/sim_manu_facturer_update.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'simmanufacturer')) {
            $this->loadModel(array('Mfilters', 'Msimmanufacturers', 'Mprovinces','Mcountries'));
            $itemTypeId = 5;
            $data['itemTypeId'] = $itemTypeId;
            $data['listProvinces'] = $this->Mprovinces->getList();
            $data['listCountries'] = $this->Mcountries->getList();
            $data['genSimManufacturerCode'] = 'NM'.($this->Msimmanufacturers->getCount(array('SimManufacturerStatusId >' => 0)) + 10001);
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['permissionAdd'] = $this->Mactions->checkAccess($data['listActions'], 'simmanufacturer/add');
            $this->load->view('sim_manu_facturer/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit($simManufacturerId = 0){
        if($simManufacturerId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật NCC Sim ',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/sim_manu_facturer_update.js'))
                )
            );
            if($this->Mactions->checkAccess($data['listActions'], 'simmanufacturer/edit')) {
                $this->loadModel(array('Mcountries', 'Msimmanufacturers', 'Mprovinces', 'Mtags', 'Mitemcomments','Mtelcoidetails','Musercomments'));
                $simmanufacturer  = $this->Msimmanufacturers->get($simManufacturerId);
                if($simmanufacturer['SimManufacturerStatusId'] > 0){
                    $itemTypeId = 5;
                    $data['itemTypeId'] = $itemTypeId;
                    $data['simManufacturerId'] = $simManufacturerId;
                    $data['simmanufacturer'] = $simmanufacturer;
                    $data['listProvinces'] = $this->Mprovinces->getList();
                    $data['listCountries'] = $this->Mcountries->getList();
                    $data['listTelcoi'] = $this->Mtelcoidetails->getListFieldValue(array('SimManufacturerId' => $simManufacturerId),'TelcoId');
                    $data['CrName'] = $this->Mstaffs->getFieldValue(array('StaffId' => $simmanufacturer['CrStaffId']), 'FullName', '');
                    $data['itemComments'] = $this->Mitemcomments->getBy(array('ItemId' => $simManufacturerId));
                    $data['tagNames'] = $this->Mtags->getTagNames($simManufacturerId, $itemTypeId);
                    $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
                }else{
                    $data['simManufacturerId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                $this->load->view('sim_manu_facturer/edit', $data);
            }else $this->load->view('user/permission', $data);
        } else redirect('simmanufacturer');
    }

    public function update(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'simmanufacturer/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'simmanufacturer/edit');
        if(!$permissionAdd)  $this->load->view('user/permission', $data);
        if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $postData = $this->arrayFromPost(array('SimManufacturerTypeId', 'SimManufacturerName', 'BirthDay', 'GenderId', 'IDCardNumber', 'PhoneNumber', 'Email', 'CountryId','ProvinceId','Address'));
        $simManufacturerId = $this->input->post('SimManufacturerId');
        $telcoId = $this->input->post('TelcoId');
        $this->loadModel(array('Msimmanufacturers','Mtelcoidetails'));
        if(empty($postData['GenderId'])) $postData['GenderId'] = 0;
        $postData['BirthDay'] = !empty($postData['BirthDay']) ? ddMMyyyyToDate($postData['BirthDay']): null;
        if ($this->Msimmanufacturers->checkExist($simManufacturerId, $postData['PhoneNumber'])) {
            echo json_encode(array('code' => -1, 'message' => "SĐT đã tồn tại, vui lòng nhập lại."));
            die;
        }
        if($simManufacturerId > 0){
            $postData['SimManufacturerStatusId'] = $this->input->post('SimManufacturerStatusId');
            $postData['UpdateStaffId'] = $user['StaffId'];
            $postData['UpdateDateTime'] = getCurentDateTime();
        }else{
         if($this->Msimmanufacturers->getFieldValue(array('SimManufacturerName' => $postData['SimManufacturerName'], 'SimManufacturerId !=' => '' ), 'SimManufacturerName', '') != '') {
            echo json_encode(array('code' => -1, 'message' => "Tên bị trùng, vui lòng nhập tên khác."));
            die;}
            $postData['CrStaffId'] = $user['StaffId'];
            $postData['CrDateTime'] = getCurentDateTime();
            $postData['SimManufacturerStatusId'] = STATUS_ACTIVED;
        }
        $flag = $this->Msimmanufacturers->update($postData, $simManufacturerId, $telcoId, $user);
        if($flag) echo json_encode(array('code' => 1, "message" => 'Cập nhật thành công', 'data' => $flag));
        else echo json_encode(array('code' => 0, "message" => "Có lỗi ảy ra, vui lòng thử lại."));
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
        $this->loadModel(array('Msimmanufacturers'));
        $data1 = $this->Msimmanufacturers->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}