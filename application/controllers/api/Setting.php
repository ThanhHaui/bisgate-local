<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller
{
    public function __construct($params = array())
    {
        parent::__construct();
        $this->load->library('redis_sentinel');
    }

    public function checkExist()
    {
        $this->loadModel(array('Mdevices', 'Msims'));
        $type = $this->input->post('type');
        if ($type == 'IMEI') {
            $message = 'ID thiết bị không tồn tại';
            $field = 'IMEI';
            $IMEI = $this->input->post('IMEI');
            $DeviceTypeId = $this->input->post('DeviceTypeId');
            $item = $this->Mdevices->getBy(['DeviceCodeId' => $IMEI, 'DeviceTypeId' => $DeviceTypeId, 'StatusId' => 2], true);
            if (!empty($item)) {
                $id = $item['DeviceId'];
                if ($item['VehicleId'] > 0) {
                    echo json_encode(['code' => 0, 'message' => 'Thiết bị này đã được gán vào xe', 'field' => $field]);
                    die;
                }
            }
        } else {
            $field = 'SeriSim';
            $message = 'Số sim khai báo LĐ không tồn tại';
            $SeriSim = $this->input->post('SeriSim');
            $item = $this->Msims->getBy(['SeriSim' => $SeriSim, 'SimStatusId' => 2], true);
            if (!empty($item)) {
                $id = $item['SimId'];
            }
        }
        if (!empty($item)) {
            echo json_encode(['code' => 1, 'id' => $id]);
        } else {
            echo json_encode(['code' => 0, 'message' => $message, 'field' => $field]);
        }
    }

    public function SaveVehicleDevice()
    {
        $user = $this->checkUserLogin(true);
        $this->loadModel(array('Mdeadlines','Mvehicledevices', 'Mssls', 'Msslitems', 'Mdevices', 'Mvehicledevicesensors', 'Mdevicesensors', 'Mdevicesims', 'Mssldevices', 'Mvehicles'));

        $dataSetting = $this->input->post('dataSetting');
        $dataDevice = $dataSetting['dataDevice'];
        if (isset($dataSetting['dataSSL'])) {
            $dataSSL = $dataSetting['dataSSL'];
        }
        $dataCB = isset($dataSetting['dataCB']) ? $dataSetting['dataCB'] : [];
        $DeviceItem = $this->Mdevices->getBy(['DeviceId' => $dataDevice['DeviceId']], true);
        $SSLTypeId = $dataSetting['SSLTypeId'];

        $sslActiveExpiryStartDate = strtotime('+1 days', strtotime(getCurentDateTime()));

        $dataSSLSave = [
            'CrUserId' => $user['StaffId'],
            'UpdateDateTime' => getCurentDateTime(),
            'ActiveExpiryStartDate' => getCurentDateTime(),
            'ActiveExpiryEndDate' => date('Y-m-d H:i:s', $sslActiveExpiryStartDate),
            'SSLTypeId' => $SSLTypeId,
            'IsModule' => $dataSetting['IsModule'],
            'SSLStatusId' => 2,
            'PackageId' => 1,
            'UserId' => $dataDevice['UserId']
        ];
        if ($SSLTypeId == 3 || $dataDevice['SSLIsOld'] == 1) {
            $dataSSL = [];
            if ($SSLTypeId == 3) {
                $SSLCode = $dataSetting['SSLCode'];
                $SSLItem = $this->Mssls->getBy(['SSLCode' => $SSLCode], true);
                $SSLItem['SSLTypeId'] = 3;
            } else {
                $SSLId = $dataSetting['SSLId'];
                $SSLItem = $this->Mssls->getBy(['SSLId' => $SSLId], true);
            }
            if (!empty($SSLItem)) {
                $SSLOldId = $SSLItem['SSLId'];
                unset($SSLItem['SSLId']);
                unset($SSLItem['SSLCode']);
                $SSLItem['UserId'] = $dataDevice['UserId'];
                $SSLItem['SSLStatusId'] = 2;
                $SSLItem['SSLOldId'] = $SSLOldId;
                $ListItem = $this->Msslitems->getBy(['SSLId' => $SSLOldId]);
                $SSLId = $this->Mssls->save($SSLItem);
                if (!empty($ListItem)) {
                    foreach ($ListItem as $it) {
                        unset($it['SSLItemId']);
                        $it['SSLId'] = $SSLId;
                        $this->Msslitems->save($it);
                    }
                }
            } else {
                echo json_encode(['code' => 0, 'message' => 'Có lỗi xảy ra trong quá trình thực hiện']);
                die;
            }
        } else
            {
            $SSLId = $this->Mssls->save($dataSSLSave);
            if ($SSLId) {
                $updateData['SSLCode'] = $this->Mssls->genSSLCode($SSLId);
                $this->Mssls->save($updateData, $SSLId);
            }
        }


        $arrDeadlineSslsarr = [];
        $arrDeadlineSsls = array("SSLId" => $SSLId);
        array_push($arrDeadlineSslsarr,$arrDeadlineSsls);
        $arrDatas = json_decode($dataSetting['ArrDatas'], true);
        if (!empty($arrDatas)) {
            $flag = false;
            $itemTypeId = 9;
            foreach ($arrDatas as $data) {
                $logDeadline = array(
                    'ItemTypeId' => 9,
                    'CrUserId' => $user['StaffId'],
                    'CrDateTime' => getCurentDateTime(),
                    'ActionTypeId' => 1,
                );
                $postData = $data['arrDeadlines'][0];
                $postData['DeadlineStatusId'] = 2;
                $postData['UserId'] = $dataSetting['UserId'];

                $postData['CrUserId'] = $user['StaffId'];
                $postData['CrDateTime'] = getCurentDateTime();

                if ($postData['DeadlineStatusId'] == 2) { // trạng thái kích hoạt, và kích hoạt gia hạng cho ssls
                    $postData['ActiveExpiryStartDate'] = getCurentDateTime(); // ngày bắt đầu kích hoạt
                    // ngày hết hạn
                    $postData['ActiveExpiryEndDate'] = date('Y-m-d H:i:s', $sslActiveExpiryStartDate);
                    $logDeadline['Comment'] = $user['FullName'] . ': Tạo và kích hoạt gia hạn phần mềm';

                    $postData['UpdateUserId'] = $user['StaffId'];
                    $postData['UpdateDateTime'] = getCurentDateTime();
                    $postData['SSLStatusId'] = 2;
                } else {
                    $logDeadline['Comment'] = $user['FullName'] . ': Tạo lệnh gia hạn phần mềm';
                }
                $this->Mdeadlines->update($postData, 0, $data['arrDeadlineDetails'], $arrDeadlineSslsarr, $logDeadline, $user);
            }
        }


        $dataVehicleDeviceLSave = [
            'StatusId' => 2,
            'CrUserId' => $user['StaffId'],
            'UserId' => $dataDevice['UserId'],
            'VehicleId' => $dataDevice['VehicleId'],
            'DeviceId' => $dataDevice['DeviceId'],
            'SimId' => $dataDevice['SimId'],
            'SSLId' => $SSLId,
            'CrDateTime' => getCurentDateTime()
        ];
        $VehicleDeviceId = $this->Mvehicledevices->save($dataVehicleDeviceLSave);
        $dataDeviceSensor = [
            'VehicleId' => $dataDevice['VehicleId'],
            'DeviceId' => $dataDevice['DeviceId'],
            'StatusId' => 2,
            'VehicleDeviceId' => $VehicleDeviceId,
            'Comment' => $dataDevice['Comment'],
            'BeginDate' => getCurentDateTime(),
            'CrUserId' => $user['StaffId'],
            'CrDateTime' => getCurentDateTime()
        ];
        $DeviceSensorId = $this->Mdevicesensors->save($dataDeviceSensor);
        if (!empty($dataSSL)) {
            foreach ($dataSSL as $key => $item) {
                $item['SSLId'] = $SSLId;
                $this->Msslitems->save($item);
            }
        }
        $this->saveDeviceSim($dataDevice['DeviceId'], $dataDevice['SimId'], $user, $DeviceSensorId, $dataDevice['VehicleId']);
        $dataSSLDevice = [
            'DeviceStatusId' => 2,
            'DeviceId' => $dataDevice['DeviceId'],
            'InstallationDate' => getCurentDateTime()
        ];
        if (!empty($dataCB)) {
            foreach ($dataCB as $key => $value) {
                // $this->convertCB($DeviceItem, $value, false);
                $value['DeviceSensorId'] = $DeviceSensorId;
                $value['IsRevert'] = isset($value['IsRevert']) ? $value['IsRevert'] : 0;
                $value['LookupTable'] = isset($value['LookupTable']) ? json_encode($value['LookupTable']) : '';
                $this->Mvehicledevicesensors->save($value);
            }
            if(count($listCB) > 0) $this->convertConfig($dataCB, $DeviceItem['IMEI']);
        }
        $flag1 = $this->Mssldevices->updateBy(['VehicleId' => $dataDevice['VehicleId']], $dataSSLDevice);
        if ($VehicleDeviceId) {
            echo json_encode(['code' => 1, 'message' => 'cập nhật thành công', 'VehicleDeviceId' => $VehicleDeviceId]);
            //goi redis them IMEI va bien so
            $sslStatusId = $this->Mssls->getFieldValue(array('SSLId' => $dataSetting['SSLId']), 'SSLStatusId', 0); 
            $imei = $this->Mdevices->getFieldValue(array('DeviceId' => $dataDevice['DeviceId']), 'IMEI');
            if(in_array($sslStatusId, [2,3,4])) {
                $this->redis_sentinel->setHS('LOGIN', $imei, 1);
                $this->redis_sentinel->setHS('LICENSE_PLATE_ADMIN', $imei, $this->Mvehicles->getFieldValue(array('VehicleId' => $dataDevice['VehicleId']), 'LicensePlate'));
            }  else {
                $this->redis_sentinel->delHS('LOGIN', $imei);
                $this->redis_sentinel->delHS('LICENSE_PLATE_ADMIN', $imei);
            }
        } else {
            echo json_encode(['code' => 0, 'message' => 'Có lỗi xảy ra trong quá trình thực hiện']);
        }
    }

    function saveDeviceSim($DeviceId, $SimId, $user, $DeviceSensorId, $VehicleId)
    {
        $dataSave = [
            'DeviceId' => $DeviceId,
            'SimId' => $SimId,
            'DeviceSensorId' => $DeviceSensorId,
            'BeginDate' => getCurentDateTime(),
            'StatusId' => 2,
            'CrUserId' => $user['StaffId']
        ];
        $this->Mdevices->updateBy(['DeviceId' => $DeviceId], ['SimId' => $SimId, 'InstallationStatusId' => 2, 'VehicleId' => $VehicleId]);
        $this->Mdevicesims->save($dataSave);
    }

    public function checkCode()
    {
        $this->loadModel(array('Mvehicledevices', 'Mssls', 'Msslitems', 'Mvehicledevicesensors', 'Mactions'));
        $SSLCode = $this->input->post('SSLCode');
        $SSLId = $this->input->post('SSLId');
        if ($SSLCode && !empty($SSLCode)) {
            $SSL = $this->Mssls->getBy(['SSLCode' => $SSLCode], true);
        } else {
            $SSL = $this->Mssls->getBy(['SSLId' => $SSLId], true);
        }
        $softwareList = $this->Mconstants->softwareList;
        $dataModule = [];
        $dataNotModule = [];
        if (!empty($SSL)) {
            $SSLItem = $this->Msslitems->getBy(['SSLId' => $SSL['SSLId']]);
            if (!empty($SSLItem)) {
                foreach ($SSLItem as $item) {
                    if ($item['IsModule'] == 0) {
                        $dataNotModule = [
                            'Month' => $item['Month'] . ' tháng',
                            'ItemName' => $softwareList[$item['ItemId']]['name']
                        ];
                    } else {
                        $actionItem = $this->Mactions->getBy(['ActionId' => $item['ItemId']], true);
                        $dataModule[] = [
                            'Month' => $item['Month'] . ' tháng',
                            'ItemName' => $actionItem['ActionName']
                        ];
                    }
                }
            }
            echo json_encode(['code' => '1', 'dataModule' => $dataModule, 'SSLItem' => $SSL, 'dataNotModule' => $dataNotModule]);
        } else {
            echo json_encode(['code' => '0', 'message' => 'Mã code không hợp lệ hoặc đã được sử dụng']);
        }
    }

    public function getListSSL()
    {
        $this->loadModel(array('Mvehicledevices', 'Mssls', 'Msslitems', 'Mvehicledevicesensors', 'Mactions'));
        $UserId = $this->input->post('UserId');
        $SSLList = $this->Mssls->getBy(['UserId' => $UserId]);
        echo json_encode(['code' => '1', 'SSLList' => $SSLList]);
    }

    public function UpdateVehicleDevice()
    {
        $user = $this->checkUserLogin(true);
        $this->loadModel(array('Mvehicledevices', 'Mvehicledevicesensors', 'Mdevices'));
        $VehicleDeviceId = $this->input->post('VehicleDeviceId');
        $StatusId = $this->input->post('StatusId');
        $dataUpdate = [
            'UpdateDateTime' => getCurentDateTime(),
            'UpdateUserId' => $user['StaffId'],
            'StatusId' => $StatusId
        ];
        $result = $this->Mvehicledevices->updateBy(['VehicleDeviceId' => $VehicleDeviceId], $dataUpdate);
        if ($StatusId == 0 && $VehicleDeviceId > 0) {
            $dataDevice = $this->Mvehicledevices->getBy(['VehicleDeviceId' => $VehicleDeviceId], true);
            $listCB = $this->Mvehicledevicesensors->getBy(['VehicleDeviceId' => $VehicleDeviceId]);
            $DeviceItem = $this->Mdevices->getBy(['DeviceId' => $dataDevice['DeviceId']], true);
            // if (!empty($listCB)) {
            //     foreach ($listCB as $value) {
            //         $this->convertCB($DeviceItem, $value, true);
            //     }
            // }
            if(count($listCB) > 0) $this->convertConfig($listCB, $DeviceItem['IMEI']);
        }
        if ($result) {
            echo json_encode(['code' => '1']);
        } else {
            echo json_encode(['code' => '0', 'message' => 'Có lỗi xảy ra trong quá trình thực hiện']);
        }
    }
    public function convertCB($DeviceItem, $value, $checkDel)
    {
        return true;
        // $IMEI = $DeviceItem['IMEI'];
        // $IsRevert = $value['IsRevert'];
        // $LookupTable = isset($value['LookupTable']) ? $value['LookupTable'] : [];
        // switch ($value['SensorPort']) {
        //     case 'AD1':
        //         $this->convertInNa('IN_ANALOG_5V1', $IMEI, $LookupTable, $checkDel);
        //         break;
        //     case 'GIN5':
        //         $this->convertInvol('IN_VOL_2_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_2_TYPE');
        //         break;
        //     case 'GIN6':
        //         $this->convertInvol('IN_VOL_3_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_3_TYPE');
        //         break;
        //     case 'Door':
        //         $this->convertInvol('IN_VOL_1_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_1_TYPE');
        //         break;
        //     case '10':
        //         $this->convertInvol('IN_VOL_1_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_1_TYPE');
        //         break;
        //     case '4':
        //         $this->convertInvol('IN_VOL_2_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_2_TYPE');
        //         break;
        //     case '5':
        //         $this->convertInvol('IN_VOL_3_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_3_TYPE');
        //         break;
        //     case '8':
        //         $this->convertInNa('IN_ANALOG_5V1', $IMEI, $LookupTable, $checkDel);
        //         break;
        //     case '2':
        //         $this->convertInNa('IN_ANALOG_5V2', $IMEI, $LookupTable, $checkDel);
        //         break;
        //     default :
        //         return true;
        // }
    }

    function convertInNa($field, $key, $LookupTable, $checkDel)
    {
        return true;
        // $dataItem = [];
        // if ($checkDel) {
        //     $this->redis_sentinel->delHS($field, $key);
        // } else {
        //     if ($LookupTable) {
        //         foreach ($LookupTable as $item) {
        //             $dataItem[] = $item['voltage'] . ',' . $item['oil'];
        //         }
        //     }
        //     $dataString = implode(';', $dataItem);
        //     $this->redis_sentinel->setHS($field, $key, $dataString);
        // }
    }

    function convertInvol($field, $key, $IsRevert, $checkDel, $SensorFunctionId = 0, $type) {
        return true;
        // if($IsRevert == 0) {
        //     $IsRevert = 'False';
        // } else {
        //     $IsRevert = 'True';
        // }
        // if($checkDel) {
        //     $this->redis_sentinel->delHS($field, $key);
        //     $this->redis_sentinel->delHS($type, $key);
        // } else {
        //     if($SensorFunctionId == 1) {
        //         $this->redis_sentinel->setHS($type, $key, 1);
        //     } else if ($SensorFunctionId == 2) {
        //         $this->redis_sentinel->setHS($type, $key, 2);
        //     } else if($SensorFunctionId == 3) {
        //         $this->redis_sentinel->setHS($type, $key, 3);
        //     }
        //     $this->redis_sentinel->setHS($field, $key, $IsRevert);
        // }
    }

    public function convertConfig($datas, $imei = 0){
        try {
            if($imei) {
                $arrDataConvert = array();
                foreach ($datas as $value) {
                    $isRevert = $value['IsRevert'];
                    $lookupTable = isset($value['LookupTable']) ? $value['LookupTable'] : [];
                    $arrLooupTable = array();
                    foreach ($lookupTable as $item) {
                        $arrLooupTable[] = $item['voltage'] . ',' . $item['oil'];
                    }
                    $IN_VOL_1_REVERSE = $IN_VOL_2_REVERSE = $IN_VOL_3_REVERSE = false;
                    $IN_ANALOG_5V1 = $IN_ANALOG_5V2 = [];
                    $IN_VOL_1_TYPE = $IN_VOL_2_TYPE = $IN_VOL_3_TYPE = 0;
                    switch ($value['SensorPort']) {
                        case 'AD1':
                            $IN_ANALOG_5V1 = $arrLooupTable;
                            break;
                        case 'GIN5':
                            $IN_VOL_2_REVERSE = true;
                            $IN_VOL_2_TYPE = 2;
                            break;
                        case 'GIN6':
                            $IN_VOL_3_REVERSE = true;
                            $IN_VOL_3_TYPE = 3;
                            break;
                        case 'Door':
                            $IN_VOL_1_REVERSE = true;
                            $IN_VOL_1_TYPE = 1;
                            break;
                        case '10':
                            $IN_VOL_1_REVERSE = true;
                            $IN_VOL_1_TYPE = 1;
                            break;
                        case '4':
                            $IN_VOL_2_REVERSE = true;
                            $IN_VOL_2_TYPE = 2;
                            break;
                        case '5':
                            $IN_VOL_3_REVERSE = true;
                            $IN_VOL_3_TYPE = 3;
                            break;
                        case '8':
                            $IN_ANALOG_5V1 = $arrLooupTable;
                            break;
                        case '2':
                            $IN_ANALOG_5V2 = $arrLooupTable;
                            break;
                        default :
                            break;
                    }

                    $arrDataConvert[] = array(
                        'IN_VOL_1_REVERSE' => $IN_VOL_1_REVERSE,
                        'IN_VOL_2_REVERSE' => $IN_VOL_2_REVERSE,
                        'IN_VOL_3_REVERSE' => $IN_VOL_3_REVERSE,
                        'IN_ANALOG_5V1' => $IN_ANALOG_5V1,
                        'IN_ANALOG_5V2' => $IN_ANALOG_5V2,
                        'IN_VOL_1_TYPE' => $IN_VOL_1_TYPE,
                        'IN_VOL_2_TYPE' => $IN_VOL_2_TYPE, 
                        'IN_VOL_3_TYPE' => $IN_VOL_3_TYPE
                    );
                }

                $this->redis_sentinel->setHS("CONVERT_CONFIG", $imei, json_encode($arrDataConvert));
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}