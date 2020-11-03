<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends MY_Controller {

    public function index(){
        $title = 'Đại lý';
        $code = "DL";
        $controller = 'agent';
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách '.$title,
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css', 'css/custom.css', 'vendor/plugins/dragndrop/dragndrop.table.columns.css','css/agent.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/sortable/jquery-ui.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/search_item_modal.js', 'js/customer_list.js', 'js/header_table.js', 'vendor/plugins/dragndrop/dragndrop.table.columns.js', 'js/customer_update.js', 'js/search_filter.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], ''.$controller.'')) {
            $this->loadModel(array('Mfilters', 'Mprovinces', 'Mcountries', 'Mtransporttypes', 'Magents', 'Magenttypes','Mstaffs','Magents'));
            $itemTypeId = ID_LOG_AGENT;
            $data['itemTypeId'] = $itemTypeId;
            $data['listFilters'] = $this->Mfilters->getList($itemTypeId);
            $data['listProvinces'] = $this->Mprovinces->getList();
            $data['listCountries'] = $this->Mcountries->getList();
            $data['listTransportTypes'] = $this->Mtransporttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listAgentTypes'] = $this->Magenttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listAgents1'] = $this->Mstaffs->getBy(array('StatusId' => STATUS_ACTIVED, 'AgentLevelId' => 1));
            $data['listAgents2'] = $this->Mstaffs->getBy(array('StatusId' => STATUS_ACTIVED, 'AgentLevelId' => 2));
            $data['permissionAdd'] = $this->Mactions->checkAccess($data['listActions'], 'agent/add');
            $this->load->view('agent/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function add() {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Thêm mới đại lý',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css', 'css/agent.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/agent_update.js'))
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'agent/add')) {
            $itemTypeId = ID_LOG_AGENT;
            $this->loadModel(array('Mtags', 'Mprovinces', 'Mcountries', 'Mtransporttypes', 'Mstaffs','Magenttypes'));
            $data['listProvinces'] = $this->Mprovinces->getList();
            $data['listCountries'] = $this->Mcountries->getList();
            $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
            $data['listTransportTypes'] = $this->Mtransporttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $data['listStaffs'] = $this->Mstaffs->getBy(array('AgentLevelId' => 1));
            $data['listAgentTypes'] = $this->Magenttypes->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('agent/add', $data);
        } else $this->load->view('user/permission', $data);
    }

    public function edit($staffId = 0){
        if ($staffId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật đại lý',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/datepicker/datepicker3.css', 'vendor/plugins/tagsinput/jquery.tagsinput.min.css', 'css/agent.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/agent_update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'agent/edit')) {
                $this->loadModel(array('Mitemcomments','Mtags', 'Mprovinces', 'Mcountries', 'Mtags', 'Mtransporttypes', 'Mstaffs','Mitemtags','Mitemcontacts','Magenttypes','Magentprovinces'));
                $itemTypeId = ID_LOG_AGENT;
                $data['listProvinces'] = $this->Mprovinces->getList();
                $data['listCountries'] = $this->Mcountries->getList();
                $data['listTags'] = $this->Mtags->getBy(array('ItemTypeId' => $itemTypeId));
                $data['listTransportTypes'] = $this->Mtransporttypes->getBy(array('StatusId' => STATUS_ACTIVED));
                $data['listStaffs'] = $this->Mstaffs->getBy(array('AgentLevelId' => 2));
                $staff = $this->Mstaffs->get($staffId);
                if ($staff && $staff['StatusId'] == STATUS_ACTIVED) {
                    $data['staff'] = $staff;
                    $data['user'] = $user;
                    $data['itemTypeId'] = $itemTypeId;
                    $data['listAgentTypes'] = $this->Magenttypes->getBy(array('StatusId' => STATUS_ACTIVED));
                    $data['listTagStaff'] = $this->Mitemtags->getBy(array('ItemTypeId' => $itemTypeId,'ItemId' => $staffId));
                    $data['listTagName']=$this->Mtags->getTagNames($staffId,$itemTypeId);
                    $data['listAgentProvinces']=$this->Magentprovinces->getListFieldValue(array('AgentId'=>$staffId),'ProvinceId','');
                    $data['listItemContact'] = $this->Mitemcontacts->getBy(array('ItemTypeId' => $itemTypeId,'ItemId' => $staffId));
                    $data['listComment'] = $this->Mitemcomments->getBy(array('ItemId'=>$staffId,'ItemTypeId'=>$itemTypeId),false,'ItemCommentId');
                }else{
                    $data['staffId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                return $this->load->view('agent/edit', $data);
            } else $this->load->view('user/permission', $data);
        }else{
            return redirect('agent');
        }
    }
    
    public function update(){
        $staff = $this->checkUserLogin();
        $data = $this->commonData($staff,'',[]);
        $permissionAdd = $this->Mactions->checkAccess($data['listActions'], 'agent/add');
        $permissionEdit = $this->Mactions->checkAccess($data['listActions'], 'agent/edit');
        if(!$permissionAdd) $this->load->view('user/permission', $data);
        else if(!$permissionEdit)  $this->load->view('user/permission', $data);
        $postData = $this->arrayFromPost(array('StaffTypeId','FullName','BirthDay','GenderId','CardId','ShortName',
            'TaxCode','TransportTypeId','PhoneNumber','Email','CountryId','HTProvinceId','HTAddress','AgentLevelId','ManagementUnitId',
            'AgentTypeId','Note','StaffName','StaffPass'));
        $postData['ManagementUnitId'] = $postData['AgentLevelId'] == 2?1:$postData['ManagementUnitId'];
        if(!empty($postData['FullName']) && !empty($postData['PhoneNumber']) && !empty($postData['StaffName'])) {
            $this->loadModel(array('Mstaffs', 'Magentprovinces', 'Mactionlogs'));
            $staffId = $this->input->post('StaffId');
            // lấy dữ liệu cũ để ghi log
            $dataOld = $this->Mstaffs->get($staffId);
            $dataExceptionOld = $this->Magentprovinces->getBy(array('AgentId' => $staffId));
			if ($this->Mstaffs->checkExist($staffId, $postData['Email'], $postData['PhoneNumber'], $postData['StaffName'])) {
				echo json_encode(array('code' => -1, 'message' => "Email, số điện thoại hoặc user name đã tồn tại!!!"));
				die;
			}
			else {
                $itemTypeId = ID_LOG_AGENT;
                $postData['ManagementUnitId'] = $postData['AgentLevelId'] == 2?1:$postData['ManagementUnitId'];
                
                if($postData['StaffTypeId'] == 1) {
                    $postData['BirthDay'] = !empty($postData['BirthDay']) ? ddMMyyyyToDate($postData['BirthDay']) : NULL;
                    unset($postData['ShortName'], $postData['TaxCode'], $postData['TransportTypeId']);
                } else {
                    unset($postData['BirthDay'], $postData['GenderId'], $postData['CardId']);
                }

                if($staffId > 0) {
                    $oldPass = $this->input->post('OldPass');
					$statusId = $this->input->post('StatusId');
					if($oldPass){
						$checkExist = $this->Mstaffs->getBy(['StaffId' => $staffId, 'StaffPass !=' => md5($oldPass)], true);
						if(!empty($checkExist)) {
							echo json_encode(array('code' => -1, 'message' => "Mật khẩu cũ không đúng, vui lòng nhập lại!!!"));
							die;
						}
						else{
							$newPass = $this->input->post('NewPass');
							$rePass = $this->input->post('RePass');
							if($newPass == $rePass){
								$postData['StaffPass'] = md5($newPass);
							}
							else{
								echo json_encode(array('code' => -2, 'message' => "Mật khẩu lần 1 và lần 2 không khớp, vui lòng nhập lại!!!"));
								die;

							}
						}
					}
					else{
						$postData['StaffPass'] = $this->Mstaffs->getFieldValue(array('StaffId' => $staffId), 'StaffPass', '');
					}
					if($oldPass){
						$postData['statusId'] = $statusId;
					}
					$postData['UpdateStaffId'] = $staff['StaffId'];
					$postData['UpdateDateTime'] = getCurentDateTime();
                } else {
                    $postData['StatusId'] = STATUS_ACTIVED;
					$postData['StaffPass'] = md5('123456');
					$postData['CrStaffId'] = ($staff) ? $staff['StaffId'] : 0;
					$postData['CrDateTime'] = getCurentDateTime();
                }

                $provinceIds = $this->input->post('ProvinceIds1');
                if(!is_array($provinceIds)) $provinceIds = array();
                $contactUsers = json_decode(trim($this->input->post('ContactUsers')), true);
                $tagNames = json_decode($this->input->post('Tags'), true);
                $flag = $this->Mstaffs->update($postData, $staffId, array(), array(), array(), array(), $tagNames, $itemTypeId, $contactUsers, $provinceIds, $staff);
                if ($flag > 0) {
                    $staffCode = $this->Mstaffs->genStaffCode($flag,$itemTypeId);
                    echo json_encode(array('code' => 1, 'message' => "Cập nhật thành công.", 'data' => $flag, 'staffCode' =>$staffCode));
                    if($staffId > 0) {
                        // lúc cập nhật
                        $nameText = 'Tên';
                        if(intval($postData['StaffTypeId']) == 2) $nameText = 'Tên công ty';
                        $actionTypeId = ID_UPDATE;
                        $formDataNew = $this->arrayFromPost(array('FullName','PhoneNumber','Email', 'AgentLevelId'));
                        $dataExceptionNew = $provinceIds;
                        $models = array(
                            array(
                                'model' => 'Mprovinces',
                                'primaryKey' => 'ProvinceId',
                                'columnName' => 'ProvinceName',
                                'commentText' => ' Khu vực phụ trách',
                            )
                        );
                        $commentLog = $this->Mactionlogs->conVertCommentUpdate($formDataNew, $dataOld, $dataExceptionNew, $dataExceptionOld, $models, $nameText);
                        // trường họp đặt biệt tính tại đây
                        if($dataOld['ManagementUnitId'] != $postData['ManagementUnitId']) {
                            if(intval($formDataNew['AgentLevelId']) == 3) {
                                if(intval($formDataNew['AgentLevelId']) == intval($dataOld['AgentLevelId'])) {
                                    $managementUnitOld = $this->Mstaffs->getFieldValue(array('AgentLevelId' => 2,'StaffId' => $dataOld['ManagementUnitId']), 'StaffName', '');
                                    $managementUnitNew = $this->Mstaffs->getFieldValue(array('AgentLevelId' => 2,'StaffId' => $postData['ManagementUnitId']), 'StaffName', '');
                                    $commentLog[] = '<strong>Đơn vị quản lý</strong> từ <strong>'.$managementUnitOld.'</strong> thành <strong>'.$managementUnitNew.'</strong>';
                                } else {
                                    $commentLog[] = '<strong>Đơn vị quản lý</strong> từ <strong>Bistech</strong> thành <strong>'.$this->Mstaffs->getFieldValue(array('AgentLevelId' => 2,'StaffId' => $postData['ManagementUnitId']), 'StaffName', '').'</strong>';
                                }
                            } else if (intval($formDataNew['AgentLevelId']) == 2){
                                $commentLog[]  = '<strong>Đơn vị quản lý</strong> từ <strong>'.$this->Mstaffs->getFieldValue(array('AgentLevelId' => 2,'StaffId' => $postData['ManagementUnitId']), 'StaffName', '').'</strong> thành <strong>Bistech</strong>';
                            }
                        }
                    } else {
                        // lúc tạo mới
                        $commentLog[] = 'Đại lý mới';
                        $actionTypeId = ID_CREATE;
                    }
                    $this->Mactionlogs->saveLog($flag, ID_LOG_AGENT, $actionTypeId, $staff, $commentLog);
                    
                   
				} else echo json_encode(array("code" => 0, "message" => "Có lỗi xảy ra, vui lòng thử lại sau."));
            }
        } else echo json_encode(array("code" => -1, "message" => "Có lỗi xảy ra, vui lòng thử lại sau."));
       
    }

    public function getListManagerUnit(){
        $this->checkUserLogin();
        $searchText = $this->input->post('SearchText');
        $staffId = $this->input->post('StaffId');
        $typeId = 2;
        $this->load->model('Mstaffs');
        $data = $this->Mstaffs->getListManagerUnit($searchText,$typeId,$staffId);
        echo json_encode($data);

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
        $this->load->model('Magents');
        $page = $this->input->post('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $limit = $this->input->post('limit');
        if (!is_numeric($limit) || $limit < 1) $limit = DEFAULT_LIMIT;
        $data1 = $this->Magents->searchByFilter($searchText, $itemFilters, $limit, $page, $user['StaffId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }

}
