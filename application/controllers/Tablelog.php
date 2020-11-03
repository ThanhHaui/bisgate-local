<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tablelog extends MY_Controller {

    private $tableInfo = array(
        ID_LOG_CUSTOMER_OWNER => array(
            'TableName' => 'users',
            'PrimaryKeyName' => 'UserId',
            'StatusFieldName' => 'StatusId',
            'ItemTypeName' => 'D/S khách hàng Owner'
        ),
        ID_LOG_CUSTOMER_MEMBER => array(
            'TableName' => 'users',
            'PrimaryKeyName' => 'UserId',
            'StatusFieldName' => 'StatusId',
            'ItemTypeName' => 'D/S Khách hàng member'
        ),
        ID_LOG_DRIVER => array(
            'TableName' => 'users',
            'PrimaryKeyName' => 'UserId',
            'StatusFieldName' => 'StatusId',
            'ItemTypeName' => 'D/S Lái xe của tôi'
        ),
        ID_LOG_STAFF => array(
            'TableName' => 'staffs',
            'PrimaryKeyName' => 'StaffId',
            'StatusFieldName' => 'StatusId',
            'ItemTypeName' => 'D/S Nhân viên nội bộ bisgate', // bao gồm Owner, admin, member
        ),
        ID_LOG_AGENT => array(
            'TableName' => 'staffs',
            'PrimaryKeyName' => 'StaffId',
            'StatusFieldName' => 'StatusId',
            'ItemTypeName' => 'D/S Đại lý', // bao gồm Owner, admin, member
        ),
        ID_LOG_SIM => array(
            'TableName' => 'sims',
            'PrimaryKeyName' => 'SimId',
            'StatusFieldName' => 'SimStatusId',
            'ItemTypeName' => 'Danh sách Sim'
        ),
        ID_LOG_SIMMANUFACTURER => array(
            'TableName' => 'simmanufacturers',
            'PrimaryKeyName' => 'SimManufacturerId',
            'StatusFieldName' => 'SimManufacturerStatusId',
            'ItemTypeName' => 'Nhà cung cấp Sim'
        ),
        ID_LOG_VEHICLE => array(
            'TableName' => 'vehicles',
            'PrimaryKeyName' => 'VehicleId',
            'StatusFieldName' => 'VehicleStatusId',
            'ItemTypeName' => 'D/S Xe của tôi'
        ),
        ID_LOG_DEVICE => array(
            'TableName' => 'devices',
            'PrimaryKeyName' => 'DeviceId',
            'StatusFieldName' => 'StatusId',
            'ItemTypeName' => 'Danh sách thiết bị'
        ),
        ID_LOG_SSL => array(
            'TableName' => 'ssls',
            'PrimaryKeyName' => 'SSLId',
            'StatusFieldName' => 'SSLStatusId',
            'ItemTypeName' => 'Danh sách thuê bao SSL'
        ),
        ID_LOG_DEADLINE => array(
            'TableName' => 'deadlines',
            'PrimaryKeyName' => 'DeadlineId',
            'StatusFieldName' => 'DeadlineStatusId',
            'ItemTypeName' => 'D/S lệnh kích hoạt phần mềm'
        ),
    );

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Lịch sử xóa',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/sortable/Sortable.min.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/tablelog_list.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'tablelog')) {
            $this->load->model(array('Mfilters','Mtags'));
            $itemTypeId = 34;
            $data['listUsers'] = $this->Musers->getListForSelect();
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
            $this->load->view('tablelog/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function insert(){
        $user = $this->checkUserLogin(true);
        // if($user['UserId'] == 3) {
            $itemIds = trim($this->input->post('ItemIds'));
            $itemTypeId = $this->input->post('ItemTypeId');
            $comment = trim($this->input->post('Comment'));
            if (!empty($itemIds) && !empty($comment) && $itemTypeId > 0) {
                if (isset($this->tableInfo[$itemTypeId])) {
                    $tableInfo = $this->tableInfo[$itemTypeId];
                    $tableName = $tableInfo['TableName'];
                    $primaryKeyName = $tableInfo['PrimaryKeyName'];
                    $statusFieldName = $tableInfo['StatusFieldName'];
                    $itemTypeName = $tableInfo['ItemTypeName'];
                    $modelName = 'M' . $tableName;
                    $this->loadModel(array($modelName, 'Mtablelogs', 'Mssldevices'));
                    $crDateTime = getCurentDateTime();
                    $tableLogs = array();
                    $actionLogs = array();
                    $itemIds = json_decode($itemIds, true);
                    foreach ($itemIds as $itemId) {
                        if($itemTypeId == 6) {
                            $this->Mssldevices->updateBy(['VehicleId' => $itemId], ['StatusId' => 0]);
                        }
                        $tableLogs[] = array(
                            'ItemId' => $itemId,
                            'ItemTypeId' => $itemTypeId,
                            'TableName' => $tableName,
                            'PrimaryKeyName' => $primaryKeyName,
                            'StatusIdOld' => $this->$modelName->getFieldValue(array($primaryKeyName => $itemId), $statusFieldName, 0),
                            'IsBack' => 1,
                            'Comment' => $comment,
                            'CrUserId' => $user['UserId'],
                            'CrDateTime' => $crDateTime
                        );
                        $actionLogs[] = array(
                            'ItemId' => $itemId,
                            'ItemTypeId' => $itemTypeId,
                            'ActionTypeId' => 2,
                            'Comment' => $user['FullName'] . ' xóa ' . $itemTypeName,
                            'CrUserId' => $user['UserId'],
                            'CrDateTime' => $crDateTime
                        );
                    }
                    $tableInfo['UserId'] = $user['UserId'];
                    $tableInfo['CrDateTime'] = $crDateTime;
                    $tableInfo['ItemIds'] = $itemIds;
                    $flag = $this->Mtablelogs->insert($tableLogs, $actionLogs, $tableInfo);
                    if ($flag) echo json_encode(array('code' => 1, 'message' => "Xóa {$itemTypeName} thành công"));
                    else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
                }
                else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }
            else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        // }
        // else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function changeStatus(){
        $user = $this->checkUserLogin(true);
        if($user['UserId'] == 3) {
            $tableLogId = $this->input->post('TableLogId');
            if($tableLogId > 0) {
                $this->loadModel(array('Mtablelogs', 'Mactionlogs'));
                $tableLog = $this->Mtablelogs->get($tableLogId);
                if($tableLog) {
                    $crDateTime = getCurentDateTime();
                    $postData = array(
                        'IsBack' => 2,
                        'UpdateUserId' => $user['UserId'],
                        'UpdateDateTime' => $crDateTime
                    );
                    $itemTypeId = $tableLog['ItemTypeId'];
                    $actionLog = array(
                        'ItemId' => $tableLog['ItemId'],
                        'ItemTypeId' => $itemTypeId,
                        'ActionTypeId' => 2,
                        'Comment' => $user['FullName'] . ' phục hồi ' . $this->tableInfo[$itemTypeId]['ItemTypeName'],
                        'CrUserId' => $user['UserId'],
                        'CrDateTime' => $crDateTime
                    );
                    $modelName = "M" . $tableLog["TableName"];
                    $this->load->model($modelName);
                    $tableInfo = array(
                        'ModelName' => $modelName,
                        'ItemId' => $tableLog['ItemId'],
                        'StatusIdOld' => $tableLog['StatusIdOld'],
                        'StatusFieldName' => $this->tableInfo[$itemTypeId]['StatusFieldName']
                    );
                    $flag = $this->Mtablelogs->restore($postData, $tableLogId, $actionLog, $tableInfo);
                    if($flag) echo json_encode(array('code' => 1, 'message' => 'Khôi phục thành công'));
                    else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
                }
                else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }
            else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function searchByFilter($searchTypeId = 0){
        $this->checkUserLogin(true);
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
        $postData['SearchTypeId'] = $searchTypeId;
        $this->load->model('Mtablelogs');
        $data1 = $this->Mtablelogs->searchByFilter($searchText, $itemFilters, $limit, $page, $postData);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}