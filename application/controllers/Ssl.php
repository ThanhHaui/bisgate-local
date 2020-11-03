<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ssl extends MY_Controller {

    public function index() {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách thuê bao SSL',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css', 'vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/ssl_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/search_filter.js'))
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'ssl')) {
            $this->loadModel(array('Mfilters'));
            $itemTypeId = ID_LOG_SSL;
            $data['itemTypeId'] = $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $this->load->view('ssl/list', $data);
        } else $this->load->view('user/permission', $data);
    }

    public function add() {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Tạo SSL',
            array(
                'scriptHeader' => array('css' => array('css/custom_customer.css')),
                'scriptFooter' => array('js' => array('js/ssl_update.js'))
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'ssl/add')) {
            $this->loadModel(array('Mpackages'));
            $itemTypeId = ID_LOG_SSL;
            $data['itemTypeId'] = $itemTypeId;
            $data['packageBase'] = $this->Mpackages->get(1);
            $this->load->view('ssl/add', $data);
        } else $this->load->view('user/permission', $data);
    }

    public function view($sslId = 0) {
        if ($sslId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Danh sách SSL ',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/rangeslider/rangeslider.css', 'css/custom_customer.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js', 'js/ssl_update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'ssl/view')) {
                $this->loadModel(array('Mssls', 'Mpackages', 'Mssldetails', 'Mvehicles', 'Mactionlogs', 'Mdeadlinessls', 'Mdeadlinedetails','Mprovinces'));
                $ssls = $this->Mssls->get($sslId);
                if ($ssls && $ssls['SSLStatusId'] > 0) {
                    $data['title'] .= '| ' . $ssls['SSLCode'];
                    $itemTypeId = ID_LOG_SSL;
                    $data['itemTypeId'] = $itemTypeId;
                    $data['sslId'] = $sslId;
                    $data['ssls'] = $ssls;
                    $data['listUsers'] = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'RoleId' => 1));//list user

                    $data['listSSLDetails'] = $this->Mssldetails->getBy(array('SSLId' => $sslId));
                    $data['customer'] = $this->Musers->get($ssls['UserId']);
                    $data['labelCss'] = $this->Mconstants->labelCss;
                    $data['listHistorySSLActives'] = $this->Mdeadlinessls->getListSSLActive($sslId);
                    $data['listHistorySSLDetailActives'] = $this->Mdeadlinessls->getListSSLDetailActive($sslId);
                } else {
                    $data['SSLId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }


                $this->load->view('ssl/view', $data);
            } else $this->load->view('user/permission', $data);
        } else redirect('ssl');
    }

    public function update() {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'ssl/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'ssl/view');
        if(!$permissionAdd) $this->load->view('user/permission', $data);
        else if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $postData = $this->arrayFromPost(array('UserId', 'VehicleId', 'PackageId'));
        $deadline = array();
        if ($postData['UserId'] > 0 && $postData['PackageId'] > 0) {
            if (empty($postData['VehicleId'])) $postData['VehicleId'] = 0;
            $sslId = $this->input->post('SSLId');
            // $itemTypeId = $this->input->post('ItemTypeId');
            $checkAdd = $this->input->post('CheckAdd');
            if ($checkAdd == 0) {
                $deadline = $this->arrayFromPost(array('PackagePrice', 'ExpiryDate', 'PackageId'));
                $deadline['PackagePrice'] = replacePrice($deadline['PackagePrice']);
                $deadline['ExpiryDate'] = replacePrice($deadline['ExpiryDate']);
            }
            $deadline['UserId'] = $postData['UserId'];

            // Ghi log
            $actionTypeId = 0;
            $commentLogSSL = [];
            $commentLogDeadline = [];
            $message = 'Thêm mới';
            if ($sslId > 0) {
                $postData['UpdateUserId'] = $user['StaffId'];
                $postData['UpdateDateTime'] = getCurentDateTime();
                $actionTypeId = ID_UPDATE;
                $commentLogSSL[] = '';//COMMENT_UPDATE;
                $commentLogDeadline[] = COMMENT_UPDATE;
                $message = 'Cập nhật';
            } else {
                $postData['CrUserId'] = $user['StaffId'];
                $postData['CrDateTime'] = getCurentDateTime();
                $postData['SSLStatusId'] = 1; // Chờ active
                $actionTypeId = ID_CREATE;
                $commentLogSSL[] = '<strong>Lệnh gia hạn</strong>';
                $commentLogDeadline[] = '<strong>Liên đới tạo lệnh gia hạn</strong>';
            }
            $sslDetails = json_decode(trim($this->input->post('SSLDetails')), true);
            $this->load->model('Mssls');
            $flag = $this->Mssls->update($postData, $sslId, $sslDetails, $user, $commentLogSSL, $deadline, $commentLogDeadline, $actionTypeId);

            if ($flag) {
                if($postData['VehicleId'] > 0){
                    $this->loadModel(array('Msslvehiclelogs'));
                    $vehicleId = $postData['VehicleId'];
                        $log = array(
                            'SSLID' => $flag,
                            'VehicleId' => $vehicleId,
                            'CrUserId' => $user['StaffId'],
                            'CrDateTime' => getCurentDateTime(),
                            'ItemStatus' => 1,
                        );
                        $this->Msslvehiclelogs->save($log);
                }
                echo json_encode(array('code' => 1, 'message' => "" . $message . " thành công", 'data' => $flag));
            }
            else echo json_encode(array('code' => 0, "message" => "Có lỗi xảy ra, vui lòng thử lại."));
        } else echo json_encode(array('code' => -1, "message" => "Có lỗi xảy ra, vui lòng thử lại."));
    }

    public function getVehicleNotInSsl() {
        $user = $this->checkUserLogin();
        $searchText = $this->input->post('SearchText');
        $userId = $this->input->post('UserId');
        $this->loadModel(array('Mssls', 'Mvehicles'));
        $ssls = $this->Mssls->getListFieldValue(array('UserId' => $userId), 'VehicleId');
        if ($ssls) {
            $ssl = '(' . implode(',', $ssls) . ')';
        } else {
            $ssl = '(0)';
        }
        $vehicles = $this->Mvehicles->getVehicleNotInSsl($searchText, $userId, $ssl);
        echo json_encode($vehicles);
    }

    public function getSslInUser() {
        $user = $this->checkUserLogin();
        $userId = $this->input->post('UserId');
        $sslsIds = json_decode($this->input->post('SslsIds'), true);
        $searchText = $this->input->post('SearchText');
        $this->load->model(array('Mssls', 'Mssldetails'));
        $ssls = $this->Mssls->getSslInUser($sslsIds, $searchText, $userId);
        for ($i = 0; $i < count($ssls); $i++) {
            $ssldetail = $this->Mssldetails->getListFieldValue(array('SSLId' => $ssls[$i]['SSLId']), 'PackageId');
            if (!in_array($ssls[$i]['PackageId'], $ssldetail)) {
                array_push($ssldetail, $ssls[$i]['PackageId']);
            }
            $ssls[$i]['ssldetail'] = $ssldetail;
            $ssls[$i]['SSLStatus'] = $this->Mconstants->sslStatus[$ssls[$i]['SSLStatusId']];
            // ngày gia hạng gần nhất
            if ($ssls[$i]['SSLStatusId'] == 1) {
                $ssls[$i]['Extension'] = 'Đăng ký lần đầu, chờ kích hoạt';
            } else if (in_array($ssls[$i]['SSLStatusId'], [2, 4])) {
                $ssls[$i]['Extension'] = $this->Mconstants->formatDate($ssls[$i]['UpdateDateTime']);
            }
        }
        echo json_encode(array('code' => 1, 'data' => $ssls, 'labelCss' => $this->Mconstants->labelCss));

    }

    public function changeStatus() {
        $user = $this->checkUserLogin();
        $sSLStatusId = $this->input->post('SSLStatusId');
        $sslId = $this->input->post('SSLId');
        $this->loadModel(array('Mssls'));
        if($sSLStatusId == 2){
            $timeEndDate = $this->Mssls->getFieldValue(array('SSLId' => $sslId),'ActiveExpiryEndDate','');
            $sslStrEndDate = strtotime(date('Y-m-d', strtotime($timeEndDate)));
            $sslTimeNow = strtotime(date('Y-m-d', strtotime(getCurentDateTime())));
            if($sslStrEndDate < $sslTimeNow) $sSLStatusId = 4;
            else $sSLStatusId = 2;
        }
        if ($sSLStatusId > 0 && $sslId > 0) {
            $ssl = $this->Mssls->get($sslId);
            $comment = '';
            if (($sSLStatusId == 2) || ($sSLStatusId == 4)) {
                $comment = ' Đã kích hoạt lại gói SSL ';
            } else if ($sSLStatusId == 3) {
                $comment = ' Cắt dịch vụ tạm thời';
            } else {
                $comment = ' Dừng hẳn luôn';
            }
            $flag = $this->Mssls->changeStatus($sSLStatusId, $sslId, 'SSLStatusId', $user['StaffId']);
            if ($flag) {
                echo json_encode(array('code' => 1, 'message' => "" . $comment . " thành công", 'data' => $sslId));
                if($ssl['SSLStatusId'] != $sSLStatusId) {
                    $statusNameOld = $this->Mconstants->sslStatus[$ssl['SSLStatusId']];
                    $commentLog[] = 'trạng thái từ <strong>'.$statusNameOld.'</strong> thành <strong>'.$this->Mconstants->sslStatus[$sSLStatusId].'</strong>';
                    $idStatus = ID_STATUS;
                    if($sSLStatusId == 6) $idStatus = ID_CANCEL;
                    $this->Mactionlogs->saveLog($sslId, ID_LOG_SSL, $idStatus, $user, $commentLog);
                }
            } else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));

        } else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
    }

    public function changeStatusPackage() {
        $user = $this->checkUserLogin();
        $statusId = $this->input->post('StatusId');
        $id = $this->input->post('Id');
        $isCheck = $this->input->post('IsCheck');
        $packageCode = $this->input->post('PackageCode');
        $sslId = $this->input->post('SSLId');
        if ($statusId > 0 && $id > 0 && !empty($packageCode) && $sslId > 0) {
            $this->loadModel(array('Mssldetails', 'Mactionlogs'));
            $flag = false;
            if (in_array($isCheck, [2, 4])) {
                if ($isCheck == 2) {
                    if ($statusId == 2) {
                        $text = ' Đã kích hoạt lại gói SSL ';
                    } else if ($statusId == 3) {
                        $text = ' Cắt dịch vụ PM mở rộng có mã: ' . $packageCode;
                    } else {
                        $text = ' Dừng hẳn PM mở rộng có mã:' . $packageCode;
                    }
                } else $text = ' Bật lại dịch vụ PM mở rộng có mã: ' . $packageCode;
                $flag = $this->Mssldetails->changeStatus($statusId, $id, 'ContractStatusId', $user['StaffId']);
            }
            if ($flag) {
                // $log = array(
                //     'ItemId' => $sslId,
                //     'ItemTypeId' => 8,
                //     'CrUserId' => $user['StaffId'],
                //     'CrDateTime' => getCurentDateTime(),
                //     'ActionTypeId' => 2,
                //     'Comment' => $user['FullName'] . $text,
                // );
                // $this->Mactionlogs->save($log);
                echo json_encode(array('code' => 1, 'message' => "" . $user['FullName'] . $text . " thành công"));
            } else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));
        } else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
    }

    public function searchByFilter() {
        $user = $this->checkUserLogin();
        $data = array();
        $filterId = $this->input->post('filterId');
        $searchText = $this->input->post('searchText');
        $itemFilters = $this->input->post('itemFilters');
        if (!is_array($itemFilters)) $itemFilters = array();
        if ($filterId > 0 && empty($itemFilters)) {
            $this->load->model('Mfilters');
            $data = $this->Mfilters->getInfo($filterId);
            $itemFilters = $data['itemFilters'];
        }
        $page = $this->input->post('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $limit = $this->input->post('limit');
        if (!is_numeric($limit) || $limit < 1) $limit = DEFAULT_LIMIT;
        $this->load->model('Mssls');
        $data1 = $this->Mssls->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }

    public function checkExitUserToSsl() {
        $user = $this->checkUserLogin();
        $userId = $this->input->post('UserId');
        if ($userId) {
            $this->load->model('Mssls');
            $count = $this->Mssls->countRows(array('UserId' => $userId, 'SSLId !=' => 0));
            if ($count) echo json_encode(array('code' => 1, 'message' => '', 'data' => $count));
            else echo json_encode(array('code' => -1, 'message' => 'Vui lòng tạo thuê bao cho khách hàng này.'));
        } else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
    }

    function removeSslCart(){
        $user = $this->checkUserLogin();
        $id = $this->input->post('Id');
        $sslvehiclelogId = $this->input->post('sslvehiclelogId');
        $html = $this->input->post('html');
        $vehicleId = $this->input->post('VehicleId');
        if ($id) {
            $this->loadModel(array('Mssls', 'Msslvehiclelogs', 'Mvehicles'));
            $postData['VehicleId'] = 0;
            $flag = $this->Mssls->save($postData, $id);
            if ($flag) {
                if ($sslvehiclelogId > 0) {
                    $log = array(
                        'SSLID' => $id,
                        'VehicleId' => $vehicleId,
                        'CrUserId' => $user['StaffId'],
                        'CrDateTime' => getCurentDateTime(),
                        'ItemStatus' => 2,
                    );
                    $aa = $this->Msslvehiclelogs->save($log);
                    $postSave['htmlImg'] = $html;
                    $postSave['UpDateTime'] = getCurentDateTime();
                    $a = $this->Msslvehiclelogs->save($postSave, $sslvehiclelogId);
                } else {
                    $log = array(
                        'SSLID' => $id,
                        'VehicleId' => $vehicleId,
                        'CrUserId' => $user['StaffId'],
                        'CrDateTime' => getCurentDateTime(),
                        'ItemStatus' => 2,
                        'htmlImg' => $html,
                    );
                    $this->Msslvehiclelogs->save($log);
                }
                echo json_encode(array('code' => 1, 'message' => "Gỡ thuê bao ssl thành công"));
                $sslCode = $this->Mssls->get($id, true, 'SSLCode');
                $licensePlate = $this->Mvehicles->get($vehicleId, true, 'LicensePlate');
                $commentLog[] = 'thuê bao SSL <strong>'.$sslCode['SSLCode'].'</strong> khỏi xe <strong>'.$licensePlate['LicensePlate'].'</strong>';
                $this->Mactionlogs->saveLog($vehicleId, ID_LOG_VEHICLE, ID_UNASSIGN, $user, $commentLog);
            } else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));
            
        } else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));
    }


    function ShowModalSSL()
    {
        $user = $this->checkUserLogin();
        $this->load->model('Mssls');
        $userId = $this->input->post('UserId');
        $flag = $this->Mssls->getModalSSL($userId);
         echo json_encode(array('code' => 1, 'data' => $flag, 'labelCss' => $this->Mconstants->labelCss));
    }
    function AddSSLVehice() {
        $user = $this->checkUserLogin();
        $sslId = $this->input->post('Id');
        $sslvehiclelogId = $this->input->post('sslvehiclelogId');
        $html = $this->input->post('html');
        $vehicleId = $this->input->post('VehicleId');
        if ($sslId) {
            $this->loadModel(array('Mssls', 'Msslvehiclelogs', 'Mvehicles'));
            $postData['VehicleId'] = $vehicleId;
            $flag = $this->Mssls->save($postData, $sslId);
            if ($flag) {
                echo json_encode(array('code' => 1, 'message' => "Thêm thuê bao ssl thành công", 'data' => $flag));
                if ($sslvehiclelogId > 0) {
                    $log = array(
                        'SSLID' => $sslId,
                        'VehicleId' => $vehicleId,
                        'CrUserId' => $user['StaffId'],
                        'CrDateTime' => getCurentDateTime(),
                        'ItemStatus' => 1,
                    );
                    $aa = $this->Msslvehiclelogs->save($log);
                    $postSave['htmlImg'] = $html;
                    $postSave['UpDateTime'] = getCurentDateTime();
                    $a = $this->Msslvehiclelogs->save($postSave, $sslvehiclelogId);
                } else {
                    $log = array(
                        'SSLID' => $sslId,
                        'VehicleId' => $vehicleId,
                        'CrUserId' => $user['StaffId'],
                        'CrDateTime' => getCurentDateTime(),
                        'ItemStatus' => 1,
                        'htmlImg' => $html,
                    );
                    $this->Msslvehiclelogs->save($log);
                }

                $sslCode = $this->Mssls->get($sslId, true, 'SSLCode');
                $licensePlate = $this->Mvehicles->get($vehicleId, true, 'LicensePlate');
                $commentLog[] = 'thuê bao SSL <strong>'.$sslCode['SSLCode'].'</strong> vào xe <strong>'.$licensePlate['LicensePlate'].'</strong>';
                $this->Mactionlogs->saveLog($vehicleId, ID_LOG_VEHICLE, ID_ASSIGN, $user, $commentLog);
            } else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));
            
        } else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra vui lòng thử  lại."));
    }
    
}
