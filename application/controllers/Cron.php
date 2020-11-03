<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {

    public function timeOutSSLS(){
        $this->loadModel(array('Mssls', 'Mssldetails', 'Mpackages', 'Mactionlogs'));
        $ssls = $this->Mssls->getBy(array('SSLStatusId' => STATUS_ACTIVED));
        // set 0h sẽ trừ đi số ngày còn lại mà khách sử dụng 
        // ví dụ có 40 ngày sau 0h sẽ trừ dần đi 1 ngay còn 39, 38,...
        if($ssls){
            $flag = false;
            foreach($ssls as $ssl){
                // $logSSL = array(
                //     'ItemId' => $ssl['SSLId'],
                //     'ItemTypeId' => 8,
                //     'CrUserId' => 1,
                //     'CrDateTime' => getCurentDateTime(),
                //     'ActionTypeId' => 2,
                // );
                    
                if($ssl['PackageId'] > 0){
                    $sslActiveExpiryStartDate = strtotime('+1 days', strtotime($ssl['ActiveExpiryStartDate']));
                    $sslStrStartDate = strtotime(date('Y-m-d', $sslActiveExpiryStartDate));
                    $sslStrEndDate = strtotime(date('Y-m-d', strtotime($ssl['ActiveExpiryEndDate'])));
                    $dataSSL = array();
                    
                    $packageCode = $this->Mpackages->getFieldValue(array('PackageId' => $ssl['PackageId'], 'StatusId' => STATUS_ACTIVED), 'PackageCode', '');
                    if($sslStrStartDate < $sslStrEndDate){
                        $dataSSL = array(
                            'ActiveExpiryStartDate' => date('Y-m-d H:i:s', $sslActiveExpiryStartDate),
                            'UpdateUserId' => 1,
                            'UpdateDateTime' => getCurentDateTime()
                        );
                        // $logSSL['Comment'] = 'Admin Hệ thống: Trừ 1 ngày trong gói PM Base ->'.$packageCode;

                    } else if($sslStrStartDate >= $sslStrEndDate){
                        $dataSSL = array(
                            'ActiveExpiryStartDate' => $ssl['ActiveExpiryEndDate'],
                            'UpdateUserId' => 1,
                            'UpdateDateTime' => getCurentDateTime(),
                            'SSLStatusId' => 4
                        );
                        // $logSSL['Comment'] = 'Admin Hệ thống: Gói PM Base ->'.$packageCode.' Đã hết hạng';
                    }

                    $flag = $this->Mssls->save($dataSSL, $ssl['SSLId']);
                    // $flag = $this->Mactionlogs->save($logSSL);
                }
                $ssldetails = $this->Mssldetails->getBy(array('SSLId' => $ssl['SSLId'], 'SSLDetailStatusId' => STATUS_ACTIVED));
                foreach($ssldetails as $detail){
                    if($detail['PackageId'] > 0 && !empty($detail['ActiveExpiryStartDate']) && !empty($detail['ActiveExpiryEndDate'])){
                        $packageCode2 = $this->Mpackages->getFieldValue(array('PackageId' => $detail['PackageId'], 'StatusId' => STATUS_ACTIVED), 'PackageCode', '');

                        $detailActiveExpiryStartDate = strtotime('+1 days', strtotime($detail['ActiveExpiryStartDate']));
                        $detailStrStartDate = strtotime(date('Y-m-d', $detailActiveExpiryStartDate));
                        $detailStrEndDate = strtotime(date('Y-m-d', strtotime($detail['ActiveExpiryEndDate'])));
                        $dataDetail = array();
                        if($detailStrStartDate < $detailStrEndDate){
                            // $logSSL['Comment'] = 'Admin Hệ thống: Trừ 1 ngày trong gói PM Mở rộng ->'.$packageCode2;
                            $dataDetail = array(
                                'ActiveExpiryStartDate' => date('Y-m-d H:i:s', $detailActiveExpiryStartDate),
                            );
                        } else if($detailStrStartDate >= $detailStrEndDate) {
                            // $logSSL['Comment'] = 'Admin Hệ thống: Gói PM Mở rộng ->'.$packageCode2.' Đã hết hạng';
                            $dataDetail = array(
                                'ActiveExpiryStartDate' => $detail['ActiveExpiryEndDate'],
                            );
                        }
                        $flag = $this->Mssldetails->save($dataDetail, $detail['SSLDetailId']);
                        // $flag = $this->Mactionlogs->save($logSSL);
                    }
                }
                
            }
            if($flag) echo 'Cập nhật thành công' . PHP_EOL;
			else echo 'Thất bại' . PHP_EOL;
        } else echo 'Không có dữ liệu' . PHP_EOL;	
        
    }

    public function fakeData()
    {
        $sql_rolemenus = "Select RoleMenuId, RoleMenuName, RoleMenuChildId, RoleMenuUrl, RoleLevel from rolemenus";    
        $query_rolemenus = $this->db->query($sql_rolemenus);
        $data_rolemenus = $query_rolemenus->result_array();

        $sql_ssls = "Select VehicleId, UserId from vehicles";    
        $query_ssls = $this->db->query($sql_ssls);
        $data_ssls = $query_ssls->result_array();

        $result = Array();
        foreach($data_ssls as $key => $value) {
            foreach ($data_rolemenus as $k2 => $v2) {
                $result[] = [
                    'MenuId' => $v2['RoleMenuId'],
                    'MenuName' => $v2['RoleMenuName'],
                    'MenuChildId' => $v2['RoleMenuChildId'],
                    'MenuUrl' => $v2['RoleMenuUrl'],
                    'MenuLevel' => $v2['RoleLevel'],
                    'StatusId' => 2,
                    'UserId' => $value['UserId'],
                    'SSLId' => '',
                    'SSLStatusId' => 2,
                    'VehicleId' => $value['VehicleId']
                ];
            } 
        }

        foreach ($result as $key => $value) {
            $this->db->insert('bislogmenus', $value);
        }
    }
}