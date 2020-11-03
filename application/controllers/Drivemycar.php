<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drivemycar extends MY_Controller{

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'D/S Lái xe của tôi',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/drive_my_car_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/drive_my_car_update.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'drivemycar')) {
            $this->loadModel(array('Mfilters'));
            $itemTypeId = 4;
            $data['itemTypeId'] = $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['genCode'] = 'LX'.($this->Musers->getCount(array('RoleId' => 4)) + 10001);
            $data['roleId'] = 4;
            $this->load->view('drive_my_car/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit($userId = 0){
        if($userId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật Lái Xe của tôi ',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css', 'vendor/plugins/datepicker/datepicker3.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/drive_my_car_update.js'))
                )
            );
            if($this->Mactions->checkAccess($data['listActions'], 'drivemycar/edit')) {
                $this->load->model(array('Muserdetails', 'Musercards'));
                $driveMyCar = $this->Musers->get($userId);
                if($driveMyCar && $driveMyCar['StatusId'] > 0 && $driveMyCar['RoleId'] == 4 &&  $driveMyCar['CrUserId'] == $user['UserId']){
                    $driveMyCar['CrDateTime'] = ddMMyyyy($driveMyCar['CrDateTime']);
                    $driveMyCar['BirthDay'] = ddMMyyyy($driveMyCar['BirthDay']);
                    $userDetail = $this->Muserdetails->getBy(array('UserId' => $driveMyCar['UserId']));
                    if($userDetail && count($userDetail) > 0){
                        $userDetail = $userDetail[0];
                        $userDetail['LicenceDate'] = ddMMyyyy($userDetail['LicenceDate']);
                        $userDetail['LicenceExpDate'] = ddMMyyyy($userDetail['LicenceExpDate']);
                        $userDetail['IDCardDate'] = ddMMyyyy($userDetail['IDCardDate']);
                        $userDetail['WorkDate'] = ddMMyyyy($userDetail['WorkDate']);
                        $userDetail['IDCardFront'] = $userDetail['IDCardFront'] ? USER_PATH.$userDetail['IDCardFront'] :'';
                        $userDetail['IDCardBack'] = $userDetail['IDCardBack'] ? USER_PATH.$userDetail['IDCardBack'] : '';
                    }
                    $data['userId'] = $userId;
                    $data['driveMyCar'] = $driveMyCar;
                    $data['userDetail'] = $userDetail;
                    $data['userCards'] = $this->Musercards->getRFIDs($driveMyCar['UserId']);
                }else{
                    $data['userId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                $this->load->view('drive_my_car/edit', $data);
            }else $this->load->view('user/permission', $data);
        } else redirect('vehicle');
    }

    public function update(){
    	$user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('FullName', 'ShortName', 'GenderId', 'PhoneNumber', 'Email', 'BirthDay', 'iDCardNumber'));

        $dataDetail = $this->arrayFromPost(array('UserDetailId', 'LicenceTypeId', 'IDCardFront', 'IDCardBack', 'IDCardDate', 'IDCardAddress', 'LicenceDate', 'LicenceExpDate', 'DriverLicence', 'WorkDate'));
        $this->loadModel(['Mssldevices']);
        if(!empty($postData['FullName']) && !empty($postData['PhoneNumber'])){
        	$userId = $this->input->post('UserId');

            $userCards = json_decode(trim($this->input->post('UserCards')), true);
        	$postData['BirthDay'] = !empty($postData['BirthDay']) ? ddMMyyyyToDate($postData['BirthDay']): null;
  
        	$dataDetail['LicenceDate'] =  !empty($dataDetail['LicenceDate']) ? ddMMyyyyToDate($dataDetail['LicenceDate']) : null;
        	$dataDetail['LicenceExpDate'] =  !empty($dataDetail['LicenceExpDate']) ? ddMMyyyyToDate($dataDetail['LicenceExpDate']): null;
        	$dataDetail['WorkDate'] =  !empty($dataDetail['WorkDate']) ? ddMMyyyyToDate($dataDetail['WorkDate']): null;
        	$dataDetail['IDCardDate'] =  !empty($dataDetail['IDCardDate']) ? ddMMyyyyToDate($dataDetail['IDCardDate']) : null;

        	$dataSslDevice = [
                'LicenceExpDate' => $dataDetail['LicenceExpDate'],
                'DriverLicence' => $dataDetail['DriverLicence']
            ];
            $this->Mssldevices->updateBy(['DriverId' => $userId], $dataSslDevice);
        	if(empty($dataDetail['IDCardFront'])) $dataDetail['IDCardFront'] = NO_IMAGE;
			else $dataDetail['IDCardFront'] = replaceFileUrl($dataDetail['IDCardFront'], USER_PATH);

			if(empty($dataDetail['IDCardBack'])) $dataDetail['IDCardBack'] = NO_IMAGE;
			else $dataDetail['IDCardBack'] = replaceFileUrl($dataDetail['IDCardBack'], USER_PATH);

        	$postData['RoleId'] = 4;
        	if($userId > 0){
        		$postData['UpdateUserId'] = $user['UserId'];
            	$postData['UpdateDateTime'] = getCurentDateTime();
        	}else{
        		$postData['CrUserId'] = $user['UserId'];
	            $postData['CrDateTime'] = getCurentDateTime();
	            $postData['StatusId'] = STATUS_ACTIVED;
        	}

        	$flag = $this->Musers->update($postData, $userId, false, array(), array(), $user, $dataDetail, $userCards);
        	if($flag) echo json_encode(array('code' => 1, "message" => 'Cập nhật thành công', 'data' => $flag));
        	else echo json_encode(array('code' => 0, "message" => "Có lỗi ảy ra, vui lòng thử lại."));
        }else echo json_encode(array('code' => -1, "message" => "Có lỗi ảy ra, vui lòng thử lại."));
    }

    public function searchByFilter($roleId = 4){
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
        $data1 = $this->Musers->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId'], $roleId);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}