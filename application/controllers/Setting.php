<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {

    public function index() {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Lắp đặt thiết bị mới Full',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/settings/list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js',  'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'device')) {
            $this->loadModel(array('Mfilters', 'Mdevicecodes', 'Mdevices', 'Mdevicetypes', 'Mdevicemanufacturers', 'Mvehicles'));
            $itemTypeId = 7;
            $data['itemTypeId'] =  $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['listDeviceCodes'] = $this->Mdevicecodes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listDeviceTypes'] = $this->Mdevicetypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listDeviceManuFacturers'] = $this->Mdevicemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listCustomers'] = $this->Musers->getBy(array('StatusId >' => 0, 'RoleId' => 4));
            $data['listVehicles'] = $this->Mvehicles->getBy(array('VehicleStatusId' => STATUS_ACTIVED));
            $this->load->view('setting_device/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function add()
    {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Lắp đặt thiết bị',
            array(
                'scriptHeader' => array('css' => array('css/custom_customer.css','vendor/plugins/datepicker/datepicker3.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js','js/settings/sensor.js', 'js/settings/activated.js','js/settings/device.js'))
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'sim')) {
            $this->loadModel(array('Mfilters', 'Mprovinces', 'Mvehicles', 'Mdevicetypes',
                'Msimmanufacturers', 'Mvehiclemanufacturers', 'Mvehiclekinds', 'Mvehiclemodels',
                'Mvehicletypes', 'Mtonnages', 'Mactions'
            ));
            $itemTypeId = 6;
            $data['itemTypeId'] = $itemTypeId;
            $data['dataId'] = [];
            $data = $this->getData($data);
            $data['checkDetail'] = 0;
            $this->load->view('setting_device/add', $data);
        } else $this->load->view('user/permission', $data);
    }

    public function edit($VehicleDeviceId = 0) {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Lắp đặt thiết bị',
            array(
                'scriptHeader' => array('css' => array('css/custom_customer.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','css/test.css','vendor/plugins/datepicker/datepicker3.css')),
                'scriptFooter' => array('js' => array('js/settings/sensor.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/settings/activated.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js','js/settings/device.js?time='.time()))
            )
        );
        $this->loadModel(array('Mfilters', 'Mprovinces', 'Mvehicles', 'Mdevicetypes',
            'Msimmanufacturers', 'Mvehiclemanufacturers', 'Mvehiclekinds', 'Mvehiclemodels',
            'Mvehicletypes', 'Mtonnages', 'Mactions','Mvehicledevices', 'Mssls', 'Msslitems', 'Mvehicledevicesensors'
        ));
        if ($this->Mactions->checkAccess($data['listActions'], 'sim')) {
            $VehicleDeviceItem = $this->Mvehicledevices->getDetailBy( $VehicleDeviceId);
            if (empty($VehicleDeviceItem)) {
                redirect('setting/list');
            }
            $SSLDetail = $this->Mssls->getBy(['SSLId' => $VehicleDeviceItem['SSLId']], true);
            $SSLItemList = [];
            $SSLList = $this->Mssls->getBy(['UserId' => $VehicleDeviceItem['UserId']]);
            $dataId = [];
            if (!empty($SSLDetail)) {
                $SSLItemList = $this->Msslitems->getBy(['SSLId' => $SSLDetail['SSLId']]);
                foreach ($SSLItemList as $item) {
                    if($item['IsModule'] == 1) {
                        $dataId[] = $item['ItemId'];
                    }
                }
            }
            $SSLCodeItem = $this->Mssls->getBy(['SSLId' => $VehicleDeviceItem['SSLOldId']], true);
            $VehicleDeviceItem['SSLCode'] = !empty($SSLCodeItem) ? $SSLCodeItem['SSLCode'] : '';
            $data['vehicleDeviceId'] = $VehicleDeviceId;
            $data['VehicleDeviceItem'] = $VehicleDeviceItem;
            $data['SSLDetail'] = $SSLDetail;
            $data['SSLItemList'] = $SSLItemList;
            $data['VehicleDeviceSensor'] = $this->Mvehicledevicesensors->getBy(['VehicleDeviceId' => $VehicleDeviceId]);
            $itemTypeId = 6;
            $data['itemTypeId'] = $itemTypeId;
            $data = $this->getData($data);
            $data['userDetail'] = $this->Musers->getBy(['UserId' => $VehicleDeviceItem['UserId']]);
            $data['dataId'] = $dataId;
            $data['SSLList'] = $SSLList;
            $data['checkDetail'] = 0;
            $this->load->view('setting_device/add', $data);
        }
    }


    public function detail($VehicleDeviceId = 0) {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Lắp đặt thiết bị',
            array(
                'scriptHeader' => array('css' => array('css/test.css','vendor/plugins/datepicker/datepicker3.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                'scriptFooter' => array('js' => array('js/settings/sensor.js', 'js/settings/activated.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','js/settings/device.js?time='.time()))
            )
        );
        $this->loadModel(array('Mfilters', 'Mprovinces', 'Mvehicles', 'Mdevicetypes',
            'Msimmanufacturers', 'Mvehiclemanufacturers', 'Mvehiclekinds', 'Mvehiclemodels',
            'Mvehicletypes', 'Mtonnages', 'Mactions','Mvehicledevices', 'Mssls', 'Msslitems', 'Mvehicledevicesensors'
        ));
        if ($this->Mactions->checkAccess($data['listActions'], 'sim')) {
            $VehicleDeviceItem = $this->Mvehicledevices->getDetailBy(['VehicleDeviceId' => $VehicleDeviceId]);
            if (empty($VehicleDeviceItem)) {
                redirect('setting/list');
            }
            $SSLDetail = $this->Mssls->getBy(['SSLId' => $VehicleDeviceItem['SSLId']], true);
            $SSLItemList = [];
            $SSLList = $this->Mssls->getBy(['UserId' => $VehicleDeviceItem['UserId']]);
            $dataId = [];
            if (!empty($SSLDetail)) {
                $SSLItemList = $this->Msslitems->getBy(['SSLId' => $SSLDetail['SSLId']]);
                foreach ($SSLItemList as $item) {
                    if($item['IsModule'] == 1) {
                        $dataId[] = $item['ItemId'];
                    }
                }
            }
            $SSLCodeItem = $this->Mssls->getBy(['SSLId' => $VehicleDeviceItem['SSLOldId']], true);
            $VehicleDeviceItem['SSLCode'] = !empty($SSLCodeItem) ? $SSLCodeItem['SSLCode'] : '';
            $data['VehicleDeviceItem'] = $VehicleDeviceItem;
            $data['SSLDetail'] = $SSLDetail;
            $data['SSLItemList'] = $SSLItemList;
            $data['VehicleDeviceSensor'] = $this->Mvehicledevicesensors->getBy(['VehicleDeviceId' => $VehicleDeviceId]);
            $itemTypeId = 6;
            $data['itemTypeId'] = $itemTypeId;
            $data = $this->getData($data);
            $data['userDetail'] = $this->Musers->getBy(['UserId' => $VehicleDeviceItem['UserId']]);
            $data['dataId'] = $dataId;
            $data['checkDetail'] = 1;
            $data['SSLList'] = $SSLList;
            $this->load->view('setting_device/detail', $data);
        }
    }

    public function getData($data) {
        $this->loadModel(array('Mpackages'));
        $data['ProvinceList'] = $this->Mprovinces->get();//danh sách tỉnh thành phố
        $data['VehicleManuFacturers'] =  $this->Mvehiclemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));//hãng xe
        $data['Vehiclemodels'] =  $this->Mvehiclemodels->getBy(array('StatusId' => STATUS_ACTIVED));//doi xe
        $data['Vehiclekinds'] =  $this->Mvehiclekinds->getBy(array('StatusId' => STATUS_ACTIVED));//dong xe
        $data['Devicetypes'] =  $this->Mdevicetypes->getBy(array('StatusId' => STATUS_ACTIVED));//dong thiết bị
        $data['Tonnages'] =  $this->Mtonnages->getBy(array('StatusId' => STATUS_ACTIVED));//dong thiết bị
        $data['UserList'] =  $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'RoleId' => 1));//list user
        $data['VehicleList'] =  $this->Mvehicles->getBy(array('VehicleStatusId' => STATUS_ACTIVED));//list xe
        $data['Vehicletypes'] =  $this->Mvehicletypes->getBy(array('StatusId' => STATUS_ACTIVED));//list chung loai xe
        $data['TypeFunctionId'] =  $this->Mconstants->TypeFunctionId;//Loại chức năng
        $data['ListPort'] =  $this->Mconstants->ListPort;//Loại chức năng
        $data['SensorLine'] =  $this->Mconstants->SensorLine;//Dòng cảm biến
        $data['ExpandedList'] =  $this->Mactions->getBy(['StatusId' => 2, 'IsExtend' => 1]);//Danh sách mở rộng
        $data['softwareList'] =  $this->Mconstants->softwareList;//Danh sách phần mềm
        $data['packageBase']    =  $this->Mpackages->get(1);
        $data['sslType'] =  $this->Mconstants->sslType;//Loại ssl
        return $data;
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
        $this->loadModel(array('Mvehicledevices'));
        $data1 = $this->Mvehicledevices->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}