<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mactionlogs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "actionlogs";
        $this->_primary_key = "ActionLogId";
    }

    public function getList($itemId, $itemTypeId, $actionTypeIds = array()){
        $where = '';
        $actionTypeIds = join(",",$actionTypeIds);
        if(!empty($actionTypeIds)) $where = ' AND actionlogs.ActionTypeId IN ('.$actionTypeIds.')';
        $query = "SELECT actionlogs.*, staffs.Avatar, staffs.FullName, staffs.JobLevelId
                FROM actionlogs 
                LEFT JOIN staffs ON staffs.StaffId = actionlogs.CrUserId 
                WHERE actionlogs.ItemId = ? AND ItemTypeId = ? ".$where." ORDER BY actionlogs.CrDateTime DESC LIMIT 4";
        return $this->getByQuery($query, array($itemId, $itemTypeId));
    }

    public function getCount($postData){
        $query = "ActionLogId > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1, $actionTypeIds = array()){
        $where = '';
        if(!empty($actionTypeIds)) {
            $actionTypeIds = join(",",$actionTypeIds);
            $where = ' AND actionlogs.ActionTypeId IN ('.$actionTypeIds.')';
        } 
        $query = "SELECT actionlogs.*, staffs.Avatar, staffs.FullName, staffs.JobLevelId 
                FROM actionlogs 
                LEFT JOIN staffs ON staffs.StaffId = actionlogs.CrUserId 
                WHERE actionlogs.ActionLogId > 0 ".$where. $this->buildQuery($postData).' ORDER BY actionlogs.CrDateTime DESC';
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['ItemId']) && !empty($postData['ItemId'])) $query .= " AND actionlogs.ItemId = '{$postData['ItemId']}'";
        if(isset($postData['ItemTypeId']) && !empty($postData['ItemTypeId'])) $query .= " AND actionlogs.ItemTypeId = '{$postData['ItemTypeId']}'";
        if(isset($postData['UserId']) && !empty($postData['UserId'])) $query .= " AND actionlogs.CrUserId = '{$postData['UserId']}'";
        if(isset($postData['BeginDate']) && !empty($postData['BeginDate'])) $query .= " AND actionlogs.CrDateTime >= '{$postData['BeginDate']}'";
        if(isset($postData['EndDate']) && !empty($postData['EndDate'])) $query .= " AND actionlogs.CrDateTime <= '{$postData['EndDate']}'";
        return $query;
    }
    
    /**
     * Convert comment log từ data các trang
     */
    

    public function conVertCommentUpdate($formDataNew = array(), $dataOld = array(), $dataExceptionNew = array(), $dataExceptionOld = array(), $arrModels = array(), $nameText = 'Tên'){
        $commentLog = array();
        foreach($formDataNew as $key => $data) {
            if (is_array($dataOld) && array_key_exists($key,$dataOld)) {
                switch ($key) {
                    case 'FullName':
                        if($dataOld[$key] != $data) {
                            $commentLog[] = '<strong>'.$nameText.'</strong> từ <strong>'.$dataOld[$key] .'</strong> thành <strong>'.$data.'</strong>';
                        } 
                        break;
                    case 'PhoneNumber':
                        if($dataOld[$key] != $data) {
                            $commentLog[] = '<strong>Số điện thoại</strong> từ <strong>'.$dataOld[$key] .'</strong> thành <strong>'.$data.'</strong>';
                        } 
                        break;
                    case 'Email':
                        if($dataOld[$key] != $data) {
                            $dataOld = !empty($dataOld[$key]) ? $dataOld[$key]: 'Trống';
                            $data = !empty($data) ? $data: 'Trống';
                            $commentLog[] = '<strong>Email</strong> từ <strong>'.$dataOld.'</strong> thành <strong>'.$data.'</strong>';
                        }
                        break;
                    case 'LicensePlate':
                        if($dataOld[$key] != $data) {
                            $commentLog[] = '<strong>Biển số xe</strong> từ <strong>'.$dataOld[$key] .'</strong> thành <strong>'.$data.'</strong>';
                        }
                        break; 
                    case 'PurposeId':
                        if($dataOld[$key] != $data) {
                            $purposeOld =  $this->Mconstants->purposeId[$dataOld[$key]];
                            $purposeNew =  $this->Mconstants->purposeId[$data];
                            $commentLog[] = '<strong>Mục đích sử dụng</strong> từ <strong>'.$purposeOld .'</strong> thành <strong>'.$purposeNew.'</strong>';
                        }
                        break;
                    case 'AgentTypeId':
                        if($dataOld[$key] != $data) {
                            $this->load->model('Magenttypes');
                            $agentTypeOld = $this->Magenttypes->getFieldValue(array('AgentTypeId' => $dataOld[$key]), 'AgentTypeName', '');
                            $agentTypeNew = $this->Magenttypes->getFieldValue(array('AgentTypeId' => $data), 'AgentTypeName', '');
                            $commentLog[] = '<strong>Loại đại lý</strong> từ <strong>'.$agentTypeOld .'</strong> thành <strong>'.$agentTypeNew.'</strong>';
                        }
                        break;
                    case 'AgentLevelId':
                        if($dataOld[$key] != $data) {
                            // agentLevelId
                            $agentLevelOld = $this->Mconstants->agentLevelId[$dataOld[$key]];
                            $agentLevelNew = $this->Mconstants->agentLevelId[$data];
                            $commentLog[] = '<strong>Cấp độ đại lý</strong> từ <strong>'.$agentLevelOld .'</strong> thành <strong>'.$agentLevelNew.'</strong>';
                        }
                        break;
                    case 'ManagementUnitId':
                        if($dataOld[$key] != $data && $data != '') {
                            $managementUnitOld = $this->Mstaffs->getFieldValue(array('StaffId' => $dataOld[$key]), 'FullName', 'Trống');
                            $managementUnitNew = $this->Mstaffs->getFieldValue(array('StaffId' => $data), 'FullName', 'Trống');
                            $commentLog[] = '<strong>Tên đơn vị quản lý</strong> từ <strong>'.$managementUnitOld .'</strong> thành <strong>'.$managementUnitNew.'</strong>';
                        }
                        break;
                    case 'FuelLevel':
                        if($dataOld[$key] != $data) {
                            if(empty($dataOld[$key])) $dataOld[$key] = 'KHÔNG';
                            $commentLog[] = '<strong>Mức tiêu hao nhiên liệu TB</strong> từ <strong>'.$dataOld[$key] .'</strong> thành <strong>'.$data.'</strong>';
                        }
                        break;
                    case 'PackagePrice':
                        if($dataOld[$key] != $data) {
                            $commentLog[] = '<strong>Giá</strong> từ <strong>'.priceFormat($dataOld[$key]).'</strong> thành <strong>'.priceFormat($data).'</strong>';
                        }
                        break;
                    case 'ExpiryDate':
                        if($dataOld[$key] != $data) {
                            $commentLog[] = '<strong>Số tháng</strong> từ <strong>'.$dataOld[$key].'</strong> thành <strong>'.$data.'</strong>';
                        }
                        break;
                    case 'StaffRoleId':
                        if($dataOld[$key] != $data) {
                            $data = $this->Mconstants->staffRoleId[$data];
                            $dataOld = $this->Mconstants->staffRoleId[$dataOld[$key]];
                            $commentLog[] = '<strong>Loại tài khoản từ</strong> <strong>'.$dataOld.'</strong> thành <strong>'.$data.'</strong>';
                        }
                        break;
                    default:
                    // trường họp ngoại lệ gán cứng trường
                }
                
            }
        }
        $commentExp = '';
        if (!empty($arrModels)){
            
            foreach($arrModels as $models){
                $model = $models['model'];
                $primaryKey = $models['primaryKey'];
                $columnName = $models['columnName'];
                $commentText = $models['commentText'];
                
                $this->load->model($model);
              
                if(count($dataExceptionOld) > 0) {
                    $duplicates = [];
                    $flag = false;
                    if(count($dataExceptionNew) == count($dataExceptionOld)) {
                        $arrCheck = [];
                        foreach($dataExceptionOld as $old){
                            $arrCheck[] = $old[$primaryKey];
                        }
                        $duplicates = array_diff($dataExceptionNew, $arrCheck);
                        if(count($duplicates) > 0) {
                            $flag = true;
                        }
                    } else {
                        $flag = true;
                    }
                    if($flag) {
                        if(count($dataExceptionNew) > 0) {
                            $commentExp .= $commentText.' từ <strong>';
                            foreach($dataExceptionOld as $old){
                                $commentExp .= $this->$model->getFieldValue(array($primaryKey => $old[$primaryKey]), $columnName, 'KHÔNG').', ';
                            }
                            $commentExp = rtrim($commentExp, ', ');
                            $commentExp .= '</strong> thành <strong>';
                            foreach($dataExceptionNew as $new){
                                    $commentExp .= $this->$model->getFieldValue(array($primaryKey => $new), $columnName, 'KHÔNG').', ';
                            }
                            $commentExp = rtrim($commentExp, ', ');
                            $commentExp .= '</strong>';
                            
                        } else {
                            $commentExp .= $commentText.' từ <strong>';
                            foreach($dataExceptionOld as $old){
                                $commentExp .= $this->$model->getFieldValue(array($primaryKey => $old[$primaryKey]), $columnName, 'KHÔNG').', ';
                            }
                            $commentExp = rtrim($commentExp, ', ');
                            $commentExp .= '</strong> thành <strong>TRỐNG</strong>';
                        }
                    }
                } else {
                    if(count($dataExceptionNew) > 0) {
                        $commentExp .= $commentText.' từ <strong>TRỐNG</strong> thành <strong>';
                        foreach($dataExceptionNew as $new){
                            $commentExp .= $this->$model->getFieldValue(array($primaryKey => $new), $columnName, 'KHÔNG').', ';
                        }
                        $commentExp = rtrim($commentExp, ', ');
                        $commentExp .= '</strong>';
                    }
                }
            }
        }
        
        if(!empty($commentExp)) $commentLog[] = $commentExp;
        return $commentLog;
    }

    public function saveLog($itemId = 0, $itemTypeId = 0, $actionTypeId = 0, $user = array(), $comments = array(), $updateTypeId = 1){
        try {
            if(count($comments) > 0) {
                $datas = array();
                foreach($comments as $comment) {
                    if(!empty($comment)) {
                        switch ($actionTypeId) {
                            case ID_CREATE:
                                $comment = ' Đã tạo '.$comment; //: .' lúc {datetime}'
                                break;
                            case ID_UPDATE:
                                if($updateTypeId == 1) {
                                    $comment = ' Đã cập nhật thông tin '.$comment;
                                }elseif($updateTypeId == 2) {
                                    $comment = ' '.$comment;
                                }
                                break;
                            case ID_STATUS:
                                $comment = ' Đã thay đổi '.$comment;
                                break;
                            case ID_ASSIGN:
                                $comment = ' Đã gán '.$comment;
                                break;
                            case ID_UNASSIGN:
                                $comment = ' Đã gỡ '.$comment;
                                break;
                            case ID_DELETE:
                                break;
                            case ID_CANCEL:
                                $comment = ' Đã hủy '.$comment;
                                break;
                            case ID_RESET:
                                $comment = ' Đã bấm '.$comment;
                                break;
                            default:
                                $comment = ' Đã thay đổi '.$comment;
                                break;
                        }
            
                        $datas[] = array(
                            'ItemId' => $itemId,
                            'ItemTypeId' => $itemTypeId,
                            'ActionTypeId' => $actionTypeId,
                            'Comment' => $comment,
                            'CrUserId' => isset($user['StaffId']) ? $user['StaffId']: $user['UserId'],
                            'CrDateTime' => getCurentDateTime(),
                        );
                    }
                    
                }
                if(!empty($datas)) $this->db->insert_batch('actionlogs', $datas);
            }
        }
        catch(Exception $e) {
        //  Block of code to handle errors
        }
    }
}
