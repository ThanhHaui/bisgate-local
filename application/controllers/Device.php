<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends MY_Controller{

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách thiết bị',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/device_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/device_update.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'device')) {
            $this->loadModel(array('Mfilters', 'Mdevicecodes', 'Mdevices', 'Mdevicetypes', 'Mdevicemanufacturers', 'Mvehicles'));
            $itemTypeId = ID_LOG_DEVICE;
            $data['itemTypeId'] =  $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['listDeviceCodes'] = $this->Mdevicecodes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listDeviceTypes'] = $this->Mdevicetypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listDeviceManuFacturers'] = $this->Mdevicemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listCustomers'] = $this->Musers->getBy(array('StatusId >' => 0, 'RoleId' => 4));
            $data['listVehicles'] = $this->Mvehicles->getBy(array('VehicleStatusId' => STATUS_ACTIVED));
            $data['permissionAdd'] = $this->Mactions->checkAccess($data['listActions'], 'device/add');
            $this->load->view('device/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit($deviceId = 0){
        if($deviceId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật Thiết bị ',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/device_update.js'))
                )
            );
            if($this->Mactions->checkAccess($data['listActions'], 'device/edit')) {
                $this->loadModel(array('Mdevicecodes', 'Mdevices', 'Msims', 'Mdevicesims', 'Mdevicetypes', 'Mdevicemanufacturers', 'Mvehicles', 'Mitemcomments', 'Mtags'));
                $deviceItem = $this->Mdevices->getDetailBy(['DeviceId' => $deviceId]);
                if($deviceItem['StatusId'] > 0){
                    $itemTypeId = ID_LOG_DEVICE;
                    $data['itemTypeId'] =  $itemTypeId;
                    $data['deviceId'] = $deviceId;
                    if($deviceItem['InstallationStatusId'] == 1) {
                        $deviceItem['InstallationStatus'] = '<span class="label label-default">Đã gỡ</span>';
                    } else if($deviceItem['InstallationStatusId'] == 2) {
                        $InfoDeviceLog = $this->Mconstants->getInfoDeviceLog($deviceItem['IMEI']);
                        $deviceItem['TimeMin'] = $InfoDeviceLog['gtgn'];
                        $deviceItem['ConnectStatusId'] = $InfoDeviceLog['ConnectStatusId'];
                        $deviceItem['InstallationStatus'] = '<span class="label label-primary">Đang gán xe</span>';
                    } else {
                        $deviceItem['InstallationStatus'] = '<span class="label label-success">Chưa lắp đặt</span>';
                    }
                    $data['device'] = $deviceItem;
                    $telcoIds = $this->Mconstants->telcoIds;
                    $DevivceSim = $this->Mdevicesims->getItemBy(array('devicesims.StatusId' => STATUS_ACTIVED, 'devicesims.DeviceId' => $deviceId));
                    if(!empty($DevivceSim)) $DevivceSim['SimTypeId']= $this->Msims->getFieldValue(array('SimId'=>$DevivceSim['SimId']),'SimTypeId','');
                    $data['DevivceSim'] = $DevivceSim;
                    $data['listDeviceCodes'] = $this->Mdevicecodes->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listDeviceTypes'] = $this->Mdevicetypes->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listDeviceManuFacturers'] = $this->Mdevicemanufacturers->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listCustomers'] = $this->Musers->getBy(array('StatusId >' => 0, 'RoleId' => 4));
                    $data['listVehicles'] = $this->Mvehicles->getBy(array('VehicleStatusId' => STATUS_ACTIVED));
                    $data['itemComments'] = $this->Mitemcomments->getBy(array('ItemId' => $deviceId));
                    $data['tagNames'] = $this->Mtags->getTagNames($deviceId, $itemTypeId);
                    $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
                }else{
                    $data['deviceId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                $this->load->view('device/edit', $data);
            }else $this->load->view('user/permission', $data);
        } else redirect('device');
    }

    public function update(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'device/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'device/edit');
        if(!$permissionAdd)  $this->load->view('user/permission', $data);
        if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $postData = $this->arrayFromPost(array('IMEI', 'DeviceTypeId', 'DeviceCodeId'));
        if($postData['DeviceTypeId'] > 0 && !empty($postData['IMEI'])) {
            $deviceId = $this->input->post('DeviceId');
            $this->load->model('Mdevices');
            $messageError = $this->getMessageError($postData);
            if($messageError['code'] == 0) {
                echo json_encode($messageError);
                die;
            }
            $postData['CrUserId'] = $user['StaffId'];
            $postData['CrDateTime'] = getCurentDateTime();
            $postData['StatusId'] = STATUS_ACTIVED;
            $flag = $this->Mdevices->save($postData);
            if($flag){
                if($deviceId > 0) {

                } else {
                    $actionTypeId = ID_CREATE;
                    $commentLog[] = 'Thiết bị mới <strong>'.$postData['IMEI'].'</strong>';
                }
                $this->Mactionlogs->saveLog($flag, ID_LOG_DEVICE, $actionTypeId, $user, $commentLog);
                echo json_encode(array('code' => 1, "message" => 'Cập nhật thành công', 'data' => $flag));
            }
            else echo json_encode(array('code' => 0, "message" => "Có lỗi xảy ra, vui lòng thử lại."));
        } else echo json_encode(array('code' => -1, "message" => "Có lỗi xảy ra, vui lòng thử lại."));
        
    }

    public function getMessageError($postData) {
        if($postData['DeviceTypeId'] <= 0) {
            return [
                'code' => 0,
                'message' => 'Vui lòng chọn dòng thiết bị',
                'field' => 'DeviceTypeId'
            ];
        }

        if($postData['IMEI'] == '') {
            return [
                'code' => 0,
                'message' => 'Vui lòng chọn nhập IMEI thiết bị',
                'field' => 'IMEI'
            ];
        }

        if($postData['DeviceCodeId'] == '') {
            return [
                'code' => 0,
                'message' => 'Vui lòng chọn nhập ID thiết bị',
                'field' => 'DeviceCodeId'
            ];
        }

        $checkIMEI = $this->Mdevices->getBy(['IMEI' => $postData['IMEI'], 'StatusId' => 2], true);
        $checkDeviceCodeId = $this->Mdevices->getBy(['DeviceCodeId' => $postData['DeviceCodeId'], 'StatusId' => 2], true);
        if(!empty($checkIMEI)) {
            return [
                'code' => 0,
                'message' => 'IMEI thiết bị đã tồn tại',
                'field' => 'IMEI'
            ];
        }

        if(!empty($checkDeviceCodeId)) {
            return [
                'code' => 0,
                'message' => 'ID thiết bị đã tồn tại',
                'field' => 'DeviceCodeId'
            ];
        }
        return [
            'code' => 1
        ];
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
        $this->loadModel(array('Mdevices', 'Mssls'));
        $data1 = $this->Mdevices->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}