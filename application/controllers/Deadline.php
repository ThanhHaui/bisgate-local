<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deadline extends MY_Controller {

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'D/S lệnh kích hoạt phần mềm',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/deadline_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'deadline')) {
            $this->loadModel(array('Mfilters'));
            $itemTypeId = ID_LOG_DEADLINE;
            $data['itemTypeId'] =  $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $this->load->view('deadline/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function add(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Tạo lệnh gia hạn phần mềm',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/rangeslider/rangeslider.css',)),
                'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js','js/deadline_update.js'))
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'deadline/add')) {
            $this->loadModel(array('Mdeadlines'));
            $itemTypeId = ID_LOG_DEADLINE;
            $data['itemTypeId'] =  $itemTypeId;
			$this->load->view('deadline/add', $data);
		}
		else $this->load->view('user/permission', $data);
    }

    public function edit($deadlineId = 0){
        if($deadlineId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Lệnh gia hạn phần mềm chi tiết',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/rangeslider/rangeslider.css',)),
                    'scriptFooter' => array('js' => array('vendor/plugins/rangeslider/ceoslider.js','js/deadline_update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'deadline/edit')) {
                $this->loadModel(array('Mdeadlines', 'Mdeadlinessls', 'Mdeadlinedetails', 'Mssls', 'Mssldetails', 'Mpackages', 'Mvehicles', 'Mactionlogs','Mprovinces'));
                $deadline   = $this->Mdeadlines->get($deadlineId);
                if($deadline && $deadline['DeadlineStatusId'] > 0){
                    $itemTypeId = ID_LOG_DEADLINE;
                    $data['itemTypeId']     =  $itemTypeId;
                    $data['title']          .= " | ".$deadline['DeadlineCode'];
                    $data['SSLTrial']       = $deadline['SSLStatusId'];
                    $data['deadlineId']     = $deadlineId;
                    $data['deadline']       = $deadline;
                    $data['listDeadlineDetails']    = $this->Mdeadlinedetails->getBy(array('DeadlineId' => $deadlineId));
                    $data['listDeadlinessls']       = $this->Mdeadlinessls->getBy(array('DeadlineId' => $deadlineId));
                    $data['customer'] = $this->Musers->get($deadline['UserId']);
                    $data['listActionLogs'] = $this->Mactionlogs->getList($deadlineId, $itemTypeId);
                    $checkEdit = false;
                    if($deadline['DeadlineStatusId'] == 1) $data['checkEdit'] = !$checkEdit;
                    else $data['checkEdit'] = $checkEdit;
                } else {
                    $data['deadlineId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                
                $this->load->view('deadline/edit', $data);
            }
            else $this->load->view('user/permission', $data);
        } else redirect('deadline');
    }

    public function addMuilt(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'deadline/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'deadline/edit');
        if(!$permissionAdd) $this->load->view('user/permission', $data);
        else if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $arrDatas = json_decode( $this->input->post('ArrDatas'), true);
        $deadlineId = $this->input->post('DeadlineId');
        $this->loadModel(array('Mdeadlines', 'Mssls', "Mdeadlinessls"));
        $checkSSLActive = false;
        foreach($arrDatas as $d) {
            $checkSSLActive = $this->Mssls->checkActiveSSL($d['SSLIds']);
            if(!$checkSSLActive) break;
        }
        if($checkSSLActive) {
            $deadline = $this->Mdeadlines->get($deadlineId);
            if(!empty($arrDatas)){
                $flag = false;
                $flagLog = false;
                foreach($arrDatas as $data){
                    $postData   = $data['arrDeadlines'][0];
                    $postData['DeadlineStatusId'] = $this->input->post('DeadlineStatusId');
                    $postData['UserId'] = $this->input->post('UserId');
                    if($deadlineId > 0){
                        $postData['UpdateUserId'] = $user['StaffId'];
                        $postData['UpdateDateTime'] = getCurentDateTime();
    
                        if($postData['DeadlineStatusId'] == 2){ // trạng thái kích hoạt, và kích hoạt gia hạng cho ssls
                            $postData['ActiveExpiryStartDate'] = getCurentDateTime(); // ngày bắt đầu kích hoạt
                            // ngày hết hạng
                            $postData['ActiveExpiryEndDate'] = date('Y-m-d H:i', strtotime("+".$postData['ExpiryDate']." month", strtotime($postData['ActiveExpiryStartDate'])));
                            $commentDeadline[] = 'trạng thái từ <strong>'.$this->Mconstants->deadlineStatus[$deadline['DeadlineStatusId']].'</strong> thành <strong>'.$this->Mconstants->deadlineStatus[$postData['DeadlineStatusId']].'</strong>';
                            $actionTypeId = ID_STATUS;
                        } else {
                            $actionTypeId = ID_UPDATE;
                            $dataOld = $this->Mdeadlines->get($deadlineId);
                            $formDataNew = array('PackagePrice' => $postData['PackagePrice'], 'ExpiryDate' => $postData['ExpiryDate']);
                            $commentDeadline = $this->Mactionlogs->conVertCommentUpdate($formDataNew, $dataOld);
                        }
                    }else{
                        $postData['CrUserId'] = $user['StaffId'];
                        $postData['CrDateTime'] = getCurentDateTime();
    
                        if($postData['DeadlineStatusId'] == 2){ // trạng thái kích hoạt, và kích hoạt gia hạng cho ssls
                            $postData['ActiveExpiryStartDate'] = getCurentDateTime(); // ngày bắt đầu kích hoạt
                            // ngày hết hạng
                            $postData['ActiveExpiryEndDate'] = date('Y-m-d H:i', strtotime("+".$postData['ExpiryDate']." month", strtotime($postData['ActiveExpiryStartDate'])));
    
                            $postData['UpdateUserId'] = $user['StaffId'];
                            $postData['UpdateDateTime'] = getCurentDateTime();
                        } else {
                            
                        }
                        $actionTypeId = ID_CREATE;
                        $commentDeadline[] = '<strong>tạo lệnh gia hạn phần mềm</strong>';
                    }
    
                    $flag = $this->Mdeadlines->update($postData, $deadlineId, $data['arrDeadlineDetails'], $data['arrDeadlineSsls'], $commentDeadline, $user, $actionTypeId);
                }
                if($flag){
                    echo json_encode(array('code' => 1, 'message' => "Cập nhật thành công.", 'data' => $flag ));
                    sleep(1); 
                    if($deadlineId == 0 && $postData['DeadlineStatusId'] == 2){
                        $commentDeadline1[] = 'trạng thái từ <strong>Chờ áp dụng</strong> thành <strong>'.$this->Mconstants->deadlineStatus[$postData['DeadlineStatusId']].'</strong>';
                        $actionTypeId1 = ID_STATUS;
                        $this->Mactionlogs->saveLog($flag, ID_LOG_DEADLINE, $actionTypeId1, $user, $commentDeadline1);
                    }
                } 
                else echo json_endcode(array('code' => -1, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
            } else echo json_endcode(array('code' => 0, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
        } else echo json_encode(array('code' => -2, 'message' => 'Gói SSL đang bị hủy bỏ không thể gia hạng.'));
        
    }

    //Hủy gia hạng
    public function cancelDeadline(){
        $user = $this->checkUserLogin();
        $deadlineId = $this->input->post('DeadlineId');
        $this->loadModel(array('Mdeadlines', 'Mactionlogs'));
        $deadline = $this->Mdeadlines->get($deadlineId);
        if($deadlineId > 0 && $deadline){
            $flag = $this->Mdeadlines->changeStatus(3, $deadlineId, 'DeadlineStatusId', $user['StaffId']);
            if($flag) {
                $commentDeadline[] = 'trạng thái từ <strong>'.$this->Mconstants->deadlineStatus[$deadline['DeadlineStatusId']].'</strong> thành <strong>'.$this->Mconstants->deadlineStatus[3].'</strong>';
                $this->Mactionlogs->saveLog($deadlineId, ID_LOG_DEADLINE, ID_CANCEL, $user, $commentDeadline);
                echo json_encode(array('code' => 1, 'message' => "Cập nhật hủy bỏ thành công", 'data' => $deadlineId));
            } else echo json_encode(array('code' => 0, 'message' => "Hủy không thành công"));

        } else echo json_endcode(array('code' => 0, 'message' => 'Có lỗi xảy ra vui lòng thử  lại.'));
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
        $this->load->model('Mdeadlines');
        $data1 = $this->Mdeadlines->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}