<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_Controller{

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'D/S Xe của tôi',
            array(
                'scriptHeader' => array('css' => array('css/test.css','vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/vehicle_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/vehicle_update.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'vehicle')) {
            $this->loadModel(array('Mfilters', 'Mvehicletypes', 'Mvehiclemanufacturers',
                'Mvehiclekinds', 'Mvehiclemodels', 'Mprovinces', 'Mtonnages'
            ));
           
            $itemTypeId = ID_LOG_VEHICLE;
            $data['itemTypeId'] = $itemTypeId;
            $data['UserList'] =  $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'RoleId' => 1));//list user
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['listVehicleTypes'] = $this->Mvehicletypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listVehicleManuFacturers'] = $this->Mvehiclemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listVehicleKinds'] = $this->Mvehiclekinds->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listVehicleModels'] = $this->Mvehiclemodels->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listProvinces'] = $this->Mprovinces->getList();
            $data['Tonnages'] =  $this->Mtonnages->getBy(array('StatusId' => STATUS_ACTIVED));//trọng tải
            $data['permissionAdd'] = $this->Mactions->checkAccess($data['listActions'], 'vehicle/add');
            $this->load->view('vehicle/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit($vehicleId = 0){
        if($vehicleId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật Xe của tôi ',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/rangeslider/rangeslider.css','css/test.css','vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js','js/thongtinxe.js', 'js/vehicle/tab6.js', 'js/vehicle/tab5.js','js/vehicle/tab4.js','vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/vehicle_update.js'))
                )
            );
            if($this->Mactions->checkAccess($data['listActions'], 'vehicle/edit')) {
                $this->loadModel(array('Musers','Msslvehiclelogs','Mssls', 'Mpackages', 'Mssldetails','Mdeadlinessls','Mvehicles', 'Mvehicletypes',  'Mdevicetypes', 'Muservehicles',
                    'Mvehiclemanufacturers', 'Mdevicesensors', 'Mvehicledevicesensors', 'Mvehiclekinds', 'Muserdetails',
                    'Mvehiclemodels', 'Mprovinces', 'Mtonnages','Mitemcomments','Mtags','Mrolemenus'));
                $vehicle  = $this->Mvehicles->get($vehicleId);
                $sslvehiclelogID = $this->Msslvehiclelogs->getListFieldValue(array('VehicleId' => $vehicleId), 'SslvehiclelogId');
                $data['sslvehiclelogID'] = $this->Mvehicles->getValueMax($sslvehiclelogID);
                if($vehicle['VehicleStatusId'] > 0){
                    if($vehicle['RegistryCycle'] > 0){
                        $firstDate = strtotime('2020-03-04');
                        $month = '+'.$vehicle['RegistryCycle'].' months';
                        $secondDate = strtotime($month);
                        $retestSchedule = abs($firstDate - $secondDate);
                        $vehicle['RetestSchedule'] =  floor($retestSchedule / (60*60*24));
                    } else $vehicle['RetestSchedule'] = 0;
                    //tab6
                    $sslId = $this->Mssls->getFieldValue(array('VehicleId' => $vehicleId), 'SSLId', '');
                    if($sslId){
                        $ssls = $this->Mssls->get($sslId);
                        if($ssls && $ssls['SSLStatusId'] > 0){
                            $data['sslId'] = $sslId;
                            $data['ssls'] = $ssls;
                            $data['listSSLDetails'] = $this->Mssldetails->getBy(array('SSLId' => $sslId));
                            $data['customer'] = $this->Musers->get($ssls['UserId']);
                            $data['labelCss'] =  $this->Mconstants->labelCss;
                            $data['listHistorySSLActives'] = $this->Mdeadlinessls->getListSSLActive($sslId);
                            $data['listHistorySSLDetailActives'] = $this->Mdeadlinessls->getListSSLDetailActive($sslId);
                            $daySsls = $this->Msslvehiclelogs->getShowEditNew($vehicleId);
                            $data['daySsl'] = !empty($daySsls)?implode('',$daySsls[0]):'';
                        }
                    }
                    $data['sslVehicleLog'] = $sslvehiclelog = $this->Msslvehiclelogs->getBy(array('VehicleId' => $vehicleId));

                    //endtab6
                    //tab8
                    $data['listMenuactive'] = $this->Mssls->checkPermissionSSL($sslId);
                    $data['listMenuCustomer'] = $this->Mrolemenus->getHierachy();
                    //end tab8
                    $vehicle['LastRegistryDate'] = ddMMyyyy($vehicle['LastRegistryDate']);
                    $vehicle['CrDateTime'] = ddMMyyyy($vehicle['CrDateTime']);
                    $vehicle['CrName'] = $this->Mstaffs->getFieldValue(array('StaffId' => $vehicle['CrUserId']), 'FullName', '');
                    $statusName = $this->Mconstants->vehicleStatus[$vehicle['VehicleStatusId']];
                    $vehicle['StatusName'] = '<span class="'.$this->Mconstants->labelCss[$vehicle['VehicleStatusId']].'">'.$statusName.'</span>';
                    $data['UserInfo'] = $this->Musers->getBy(['UserId' => $vehicle['UserId']], true);
                    $data['vehicleId'] = $vehicleId;
                    $data['vehicle'] = $vehicle;
                    $itemTypeId = ID_LOG_VEHICLE;
                    $data['FuelLevel'] = $vehicle['FuelLevel'];
                    $DeviceSensorItem = $this->Mdevicesensors->getDetailBy(['devicesensors.VehicleId' => $vehicleId, 'devicesensors.StatusId' => 2]);
                    $data['PurposeId'] = $this->Mvehicles->getFieldValue(array('VehicleId' => $vehicleId), 'PurposeId', '');
                    $data['DeviceSensorItem'] = $DeviceSensorItem;
                    $data['VehicleDeviceSensor'] = !empty($DeviceSensorItem) ? $this->Mvehicledevicesensors->getBy(['DeviceSensorId' => $DeviceSensorItem['DeviceSensorId']]) : [];
                    $data['itemTypeId'] = $itemTypeId;
                    $data['UserList'] =  $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'RoleId' => 1));//list user
                    $data['listVehicleTypes'] = $this->Mvehicletypes->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listDeviceTypes'] = $this->Mdevicetypes->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listVehicleManuFacturers'] = $this->Mvehiclemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listVehicleKinds'] = $this->Mvehiclekinds->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listVehicleModels'] = $this->Mvehiclemodels->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listProvinces'] = $this->Mprovinces->getList();
                    $data['TypeFunctionId'] =  $this->Mconstants->TypeFunctionId;//Loại chức năng
                    $data['ListPort'] =  $this->Mconstants->ListPort;//Loại chức năng
                    $data['SensorLine'] =  $this->Mconstants->SensorLine;//Dòng cảm biến
                    $data['Tonnages'] =  $this->Mtonnages->getBy(array('StatusId' => STATUS_ACTIVED));//trọng tải
                    $UserVehicle = $this->Muservehicles->getItemBy(['uservehicles.VehicleId' => $vehicleId, 'uservehicles.StatusId' => 2]);
                    $userDetail = !empty($UserVehicle) ? $this->Muserdetails->getBy(['UserId' => $UserVehicle['UserId']], true) : [];
                    $data['itemComments'] = $this->Mitemcomments->getBy(array('ItemId' => $vehicleId, 'ItemTypeId' => $itemTypeId),false,'ItemCommentId');
                    $data['tagNames'] = $this->Mtags->getTagNames($vehicleId, $itemTypeId);
                    $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
                    if(!empty($UserVehicle)) {
                        $UserVehicle['DriverLicence'] = !empty($userDetail) ? $userDetail['DriverLicence'] : '';
                    }
                    $data['UserVehicle'] = $UserVehicle;
                }else{
                    $data['vehicleId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                $this->load->view('vehicle/edit', $data);
            }else $this->load->view('user/permission', $data);
        } else redirect('vehicle');
    }

    public function update(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'vehicle/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'vehicle/edit');
        if(!$permissionAdd)  $this->load->view('user/permission', $data);
        if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $postData = $this->arrayFromPost(array('PurposeId','VehicleTypeId', 'VehicleManufacturerId', 'VehicleKindId', 'VehicleModelId', 'VIN', 'RegisterProvinceId', 'LastRegistryDate', 'RegistryCycle'));
        $vehicleId = $this->input->post('VehicleId');
        $postData['LastRegistryDate'] = !empty($postData['LastRegistryDate']) ? ddMMyyyyToDate($postData['LastRegistryDate']) : null;
        $postData['RegistryCycle'] = !empty($postData['RegistryCycle']) ? $postData['RegistryCycle']: 0;
        $postData['FuelLevel'] = !empty($postData['FuelLevel']) ? $postData['FuelLevel']: null;
        if($vehicleId > 0){
            // $postData['UpdateUserId'] = $user['UserId'];
            // $postData['UpdateDateTime'] = getCurentDateTime();
        }else{
            $postData['LicensePlate'] = $this->input->post('LicensePlate');
            $postData['UserId'] = $user['UserId'];
            $postData['CrUserId'] = $user['UserId'];
            $postData['CrDateTime'] = getCurentDateTime();
            $postData['VehicleStatusId'] = STATUS_ACTIVED;
        }
        $this->loadModel(array('Mvehicles'));
        $flag = $this->Mvehicles->save($postData, $vehicleId);
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
        $this->loadModel(array('Mvehicles', 'Mssls'));
        $data1 = $this->Mvehicles->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
    public function showTonage(){
        $user = $this->checkUserLogin();
        $data = array();
        $vehicleTypeId = $this->input->post('VehicleTypeId');
        $vehicleId = $this->input->post('VehicleId');
        $this->loadModel(array('Mtonnages','Mvehicletypes','Mvehicles'));
        $vehicleTonage = $this->Mvehicles->getFieldValue(array('VehicleId' =>$vehicleId), 'TonnageId', '');
        $tonageId = $this->Mvehicletypes->getFieldValue(array('VehicleTypeId' =>$vehicleTypeId), 'TonnageId', '');
        $data = $this->Mtonnages->html($tonageId,$vehicleTonage);
        echo json_encode($data);
    }

    public function getVehicleInUser(){
        $user = $this->checkUserLogin();
        $userId = $this->input->post('UserId'); 
        $searchText = $this->input->post('SearchText');
        $this->load->model('Mvehicles');
        $data = $this->Mvehicles->getVehicleInUser($userId, $searchText);
        echo json_encode($data);
    }

    public function insertBislogmenus()
    {
        $this->load->model('Mrolemenus');
        $data = $this->Mrolemenus->fakeData();
    }
}