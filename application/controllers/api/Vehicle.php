<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_Controller
{
    public function __construct($params = array())
    {
        parent::__construct();
        // $this->load->library('redis_sentinel');
        // $this->load->library('mongo_db');
    }

    public function save() {
        $user = $this->checkUserLogin();
        $vehicles = $this->input->post('vehicles');
        $LicensePlate = $vehicles['LicensePlate'];
        $this->loadModel(array('Mvehicles', 'Mssldevices', 'Mprovinces', 'Mvehicletypes', 'Mvehiclemanufacturers', 'Mdevicetypes'));
        $checkExist = $this->Mvehicles->getBy(['LicensePlate' => $LicensePlate, 'VehicleId !=' => $vehicles['VehicleId']], true);
        if(!empty($checkExist)) {
            echo json_encode(['code' => 0, 'message' => 'Biển số xe đã tồn tại', 'field' => 'LicensePlate']);
            die;
        }
        $vehicles['VehicleStatusId'] = 2;
        $vehicles['LastRegistryDate'] = !empty($vehicles['LastRegistryDate']) ? ddMMyyyyToDate($vehicles['LastRegistryDate']) : '';
        $vehicles['FuelLevel'] = !empty($vehicles['FuelLevel']) ? $vehicles['FuelLevel']: null;
        $ProvinceItem = $this->Mprovinces->getBy(['ProvinceId' => $vehicles['ProvinceId']], true);
        $VehicleTypeItem = $this->Mvehicletypes->getBy(['VehicleTypeId' => $vehicles['VehicleTypeId']], true);
        $VehicleManufacturerItem = $this->Mvehiclemanufacturers->getBy(['VehicleManufacturerId' => $vehicles['VehicleManufacturerId']], true);
        $dataSslDevice = [
            'LicensePlate' => $vehicles['LicensePlate'],
            'VehicleTypeId' => $vehicles['VehicleTypeId'],
            'VehicleTypeName' => isset($VehicleTypeItem['VehicleTypeName']) ? $VehicleTypeItem['VehicleTypeName']: '',
            'VehicleKindName' => isset($vehicles['VehicleKindName']) ? $vehicles['VehicleKindName']: '',
            'ProvinceName' => !empty($ProvinceItem) ? $ProvinceItem['ProvinceName'] : '',
            'VehicleModelName' => isset($vehicles['VehicleModelId']) && $vehicles['VehicleModelId'] > 0 ? $vehicles['VehicleModelId']: '',
            'VehicleManufacturerName' => !empty($VehicleManufacturerItem) ? $VehicleManufacturerItem['VehicleManufacturerName'] : '',
            'UserId' => $vehicles['UserId'],
            'StatusId' => 2
        ];
        
        $method = METHOD_PATCH;
        if($vehicles['VehicleId'] == 0) {
            $vehicles['CrUserId'] = $user['StaffId'];
            $vehicles['CrDateTime'] = getCurentDateTime();
            $message = 'Thêm mới thành công';
            $method = METHOD_PATCH;
        } else {
            $vehicles['UpdateUserId'] = $user['StaffId'];
            $vehicles['UpdateDateTime'] = getCurentDateTime();
            $message = 'Cập nhật thành công';
            $method = METHOD_PUT;
            $dataOld = $this->Mvehicles->get($vehicles['VehicleId']);
        }
        $VehicleId = $vehicles['VehicleId'];
        $checkVehicleId = $vehicles['VehicleId'];
        unset($vehicles['VehicleId']);
        $VehicleId = $this->Mvehicles->save($vehicles, $VehicleId, array('LastRegistryDate'));
        if($VehicleId) {
            echo json_encode(['code' => 1, 'VehicleId' => $VehicleId, 'LicensePlate' => $vehicles['LicensePlate'], 'message' => $message]);

            $dataSslDevice['VehicleId'] = $VehicleId;
            $checkExistVehicle = $this->Mssldevices->getBy(['VehicleId' => $VehicleId], true);
            if(!empty($checkExistVehicle)) {
                $this->Mssldevices->save($dataSslDevice, $checkExistVehicle['SSLDeviceId']);
            } else {
                $this->Mssldevices->save($dataSslDevice);
            }
            $this->load->helper('slug');

            //Fetch and update vehicle tracking.
            $urlApiVehicleTracking = API_VEHICLE_TRACKING_INTERNAL.'?user_id='.$vehicles['UserId'];
            $vehicleTracking = callApi($urlApiVehicleTracking, $method);
            $messageLog = "--------Fetch and update vehicle tracking---------";
            $messageLog .= $urlApiVehicleTracking." ==Fetch and update vehicle tracking==> ".$vehicleTracking."===method===>".$method;
            $messageLog .= "--------END---------";
            log_message('error', $messageLog);

            //Regenerate report
            // $imei = '868926039510133';
            // $time = strtotime(getCurentDateTime());
            // $urlApiRegenerateReport = API_REGENERATE_REPORT_INTERNAL.'?imei='.$imei.'&time='.$time;
            // $regenerateReport = callApi($urlApiRegenerateReport, METHOD_PUT);
            // var_dump("========regenerateReport=======", $regenerateReport);

            
            if($checkVehicleId > 0) {
                if($vehicles['FuelLevel'] != $dataOld['FuelLevel']) $actionTypeId = ID_TAB_CONFIG_IN_VEHICLE;
                else $actionTypeId = ID_UPDATE;
                $formDataNew = array('LicensePlate' => $vehicles['LicensePlate'], 'PurposeId' => $vehicles['PurposeId'], 'FuelLevel' => $vehicles['FuelLevel']);
                $commentLog = $this->Mactionlogs->conVertCommentUpdate($formDataNew, $dataOld);
            } else {
                $actionTypeId = ID_CREATE;
                $commentLog[] = '<strong>xe mới</strong>';
            }
            $this->Mactionlogs->saveLog($VehicleId, ID_LOG_VEHICLE, $actionTypeId, $user, $commentLog);
        } else {
            echo json_encode(['code' => 0, 'message' => 'Có lỗi xảy ra trong quá trình thực hiện']);
        }
    }

    public function getVehicle() {
        $this->loadModel(array('Mvehicles'));
        $VehicleId = $this->input->post('VehicleId');
        $UserId = $this->input->post('UserId');
        if($VehicleId) {
            $VehicleItem = $this->Mvehicles->getBy(['VehicleId' => $VehicleId], true);
            $VehicleItem['LastRegistryDate'] = !empty((int)$VehicleItem['LastRegistryDate']) ? date('d/m/Y', strtotime($VehicleItem['LastRegistryDate'])) : '';
            echo json_encode($VehicleItem);
            die;
        } else {
            $VehicleList = $this->Mvehicles->getBy(['UserId' => $UserId, 'VehicleStatusId' => 2]);
            if(!empty($VehicleList)){
                echo json_encode(['VehicleList' => $VehicleList]);
            }
            die;
        }
    }

    public function getList() {
        $this->openAllCors();
        $this->loadModel(['Mssldevices']);
        //$data = $this->Mvehicles->getList('29A-3131', 130);
        $input = $this->getDataRequest();
        $searchText = isset($input['searchText']) ? $input['searchText'] : '';
        if(!isset($input['sessionId'])) {
            echo json_encode(['code' => 0, 'message' => 'Sai param', 'data' => []]);die;
        }
        $checkUser = $this->Musers->getBy(['SessionId' => $input['sessionId']], true);
        if(empty($checkUser)) {
            echo json_encode(['code' => 0, 'message' => 'Khách hàng không tồn tại', 'data' => []]);die;
        }
        $ListVehicle = $this->Mssldevices->getList($searchText, $checkUser['UserId']);
        $IMEI[] = 0;
        if(!empty($ListVehicle)) {
            foreach ($ListVehicle as $vehicle) {
                $dataStatus = $this->getStatusSSL($vehicle['SSLStatusId']);
                if($vehicle['SSLStatusId'] == 2 && $vehicle['DeviceStatusId'] != 2) {
                    $dataStatus['SSLStatusId'] = 6;
                    $dataStatus['SSLStatusName'] = 'Không có thiết bị nào';
                } else if($vehicle['SSLStatusId'] == 2 && $vehicle['DeviceStatusId'] == 2) {
                    $IMEI[] = $vehicle['IMEI'];
                }
            }
        }

        $pipeline = [
            ['$match' => ['imei' => ['$in' => $IMEI], 'event' => ['$in' => ['realtime', 'resend']]]],
            [ '$sort' => ['svt' => 1]],
            [ '$group' => ['_id' => '$imei', 'result' => ['$last' => '$_id']] ]
        ];
        $listDeviceLog = $this->mongo_db->aggregate('device_logs', $pipeline);

        $DeviceLogIds[] = 0;
        if(!empty($listDeviceLog)) {
            foreach ($listDeviceLog as $log) {
                $DeviceLogIds[] =  $this->mongo_db->getNewObject($log->result);;
            }
        }
        $listDeviceLogArr = [];
        $listDeviceLog = $this->mongo_db->where_in('_id', $DeviceLogIds)->get('device_logs');
        for ($i = 0; $i < count($listDeviceLog); $i++) {
            //$listDeviceLogArr[$listDeviceLog[$i]['imei']] = $this->getValueField($listDeviceLog, $i, 500);
        };
//        var_dump($listDeviceLog);die;
//        var_dump($ListVehicle);die;
        $this->openAllCors();
        $input = $this->getDataRequest();
        $data = [];
        $dataLatLon = [
            1 => [
                'lat' => 20.997014,
                'lon' => 105.799202,
                'angle' => 60
            ],
            2 => [
                'lat' => 20.994951,
                'lon' => 105.800811,
                'angle' => 50
            ],
            3 => [
                'lat' => 20.993969,
                'lon' => 105.801616,
                'angle' => 80
            ],
            4 => [
                'lat' => 20.995668,
                'lon' => 105.799874,
                'angle' => 30
            ],
            5 => [
                'lat' => 20.996362,
                'lon' => 105.799303,
                'angle' => 70
            ],
            6 => [
                'lat' => 20.994021,
                'lon' => 105.801060,
                'angle' => 50
            ],
            7 => [
                'lat' => 20.992248,
                'lon' => 105.802350,
                'angle' => 35
            ],
            8 => [
                'lat' => 20.991403,
                'lon' => 105.803186,
                'angle' => 90
            ],
            9 => [
                'lat' => 20.990947,
                'lon' => 105.803532,
                'angle' => 120
            ],
            10 => [
                'lat' => 20.990466,
                'lon' => 105.803910,
                'angle' => 45
            ],
            11 => [
                'lat' => 20.989181,
                'lon' => 105.804870,
                'angle' => 80
            ],
            12 => [
                'lat' => 20.988330,
                'lon' => 105.805527,
                'angle' => 60
            ]
        ];
        for($i = 1; $i <= 12; $i++) {
            if(in_array($i, [2,4,6,8,9])) {
                $data[] = [
                    'VehicleId' => $i,
                    'LicensePlate' => '39A - 2341995',
                    'ServiceStatusId' => $i == 2 || $i == 4 ? 2 : 3, //Dừng dịch vụ
                    'ServiceStatusName' => $i == 2 || $i == 4 ? 'Hoạt động bình thường' : 'Dừng dịch vụ',
                    'Comment' => $i == 2 || $i == 4 ? '' : 'Lý do tạm dừng dịch vụ',
                    'ProvinceName' => 'Hồ chí minh',
                    'VehicleStatusId' =>  $i == 6 ? 1 : 3,//Dừng đỗ
                    'VehicleStatusName' => $i == 6 ?  'Đang dừng/đỗ' : 'Mất kết nối',
                    'spd' => 60,
                    'DateTimeCurrent' => date('H:i d/m/Y'),
                    'MapLocation' => 'Cao tốc Hà Nội - Hải phòng',
                    'DateMonitor' => '15/02/2020',
                    'sumKm' => 145,
                    'StopNumber' => 20,
                    'MotorStatusId' => 0,
                    'MotorStatusName' => 'Tắt',
                    'AirStatusId' => 0,
                    'AirStatusName' => 'Tắt',
                    'oil' => '20/30',
                    'DoorStatusId' => 0,
                    'DoorStatusName' => 'Tắt',
                    'Temperature' => 20,
                    'BlackBoxStatusId' => 0,//mất kết nối
                    'BlackBoxStatusName' => 'mất kết nối',
                    'TextDateTimeMin' => '6 ngày trước',
                    'FullName' => 'Trần Văn B',
                    'ID' => 'TB - 10000'.$i,
                    'InstallationDate' => '15/04/2020',
                    'lat' => $dataLatLon[$i]['lat'],
                    'lon' =>  $dataLatLon[$i]['lon'],
                    'angle' => $dataLatLon[$i]['angle'],
                    'RFID' => '01010202002',
                    'PhoneNumber' => '0985344567',
                    'FavoriteStatusId' => 1,// Yêu thích
                    'SSLList' => [
                        [
                            'PackageName' => 'Gói phần mềm A',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ],
                        [
                            'PackageName' => 'Gói phần mềm B',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ]
                    ]
                ];
            } else {
                $data[] = [
                    'VehicleId' => $i,
                    'LicensePlate' => '39A - 2341995',
                    'ServiceStatusId' => $i == 3 ? 1 : 4,
                    'Comment' => $i == 3 ? 'Lý do tạm khóa' : '',
                    'ServiceStatusName' => $i == 3 ? 'Khóa dịch vụ' : 'Mất kết nối',
                    'ProvinceName' => 'Hồ chí minh',
                    'VehicleStatusId' => $i == 3 ? 3 : 2,//Dừng đỗ
                    'VehicleStatusName' =>  $i == 3 ? 'Mất kết nối' : 'Đang di chuyển',//,
                    'spd' => 60,
                    'DateTimeCurrent' => date('H:i d/m/Y'),
                    'MapLocation' => 'Cao tốc Hà Nội - Hải phòng',
                    'DateMonitor' => '15/02/2020',
                    'sumKm' => 145,
                    'StopNumber' => 20,
                    'MotorStatusId' => 1,
                    'MotorStatusName' => 'Bật',
                    'AirStatusId' => 1,
                    'AirStatusName' => 'Bật',
                    'oil' => '20/30',
                    'DoorStatusId' => 1,
                    'DoorStatusName' => 'Bật',
                    'Temperature' => 20,
                    'BlackBoxStatusId' => 2,//kết nối tốt
                    'BlackBoxStatusName' => 'kết nối tốt',
                    'TextDateTimeMin' => '25 tiếng trước',
                    'FullName' => 'Trần Văn A',
                    'ID' => 'TB - 10000'.$i,
                    'PhoneNumber' => '098532523',
                    'InstallationDate' => '15/04/2020',
                    'lat' => $dataLatLon[$i]['lat'],
                    'lon' =>  $dataLatLon[$i]['lon'],
                    'angle' => $dataLatLon[$i]['angle'],
                    'RFID' => '01010202002',
                    'FavoriteStatusId' => 0,// Không thích
                    'SSLList' => [
                        [
                            'PackageName' => 'Gói phần mềm A',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ],
                        [
                            'PackageName' => 'Gói phần mềm B',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ]
                    ]
                ];
            }
        }
        echo json_encode(['code' => 1, 'message' => '', 'data' => $data]);
    }

    function getStatusSSL($SSLStatusId) {
        $dataStatus = [
            'ServiceStatusId' => 0,
            'ServiceStatusName' => ''
        ];
        switch ($SSLStatusId) {
            case 2 :
                $dataStatus['ServiceStatusId'] = 2;
                $dataStatus['ServiceStatusName'] = 'Hoạt động bình thường';
                break;
            case 3 :
                $dataStatus['ServiceStatusId'] = 3;
                $dataStatus['ServiceStatusName'] = 'Dịch vụ tạm cắt';
                break;
            case 4 :
                $dataStatus['ServiceStatusId'] = 4;
                $dataStatus['ServiceStatusName'] = 'Đang hết hạn dịch vụ';
                break;
            case 5 :
                $dataStatus['ServiceStatusId'] = 5;
                $dataStatus['ServiceStatusName'] = 'Đã dừng dịch vụ';
                break;
        }
        return $dataStatus;
    }

    public function actionFavorite(){
        $this->openAllCors();
        $input = $this->getDataRequest();
        if(!empty($input)){
            if (!empty($input['sessionId']) && $input['vehicleId'] > 0 && $input['statusId'] > 0){
                $this->successOutput(array(), $input['statusId'] == 2 ? 'Thêm xe vào danh sách yêu thích thành công' : 'Bỏ xe khỏi danh sách yêu thích thành công');
            }
            else $this->errorOutput();
        }
        else $this->errorOutput();
    }

    public function getDetail() {
        $this->openAllCors();
        $input = $this->getDataRequest();
        $data = [];
        $dataLatLon = [
            1 => [
                'lat' => 20.997014,
                'lon' => 105.799202,
                'angle' => 60
            ],
            2 => [
                'lat' => 20.994951,
                'lon' => 105.800811,
                'angle' => 50
            ],
            3 => [
                'lat' => 20.993969,
                'lon' => 105.801616,
                'angle' => 80
            ],
            4 => [
                'lat' => 20.995668,
                'lon' => 105.799874,
                'angle' => 30
            ],
            5 => [
                'lat' => 20.996362,
                'lon' => 105.799303,
                'angle' => 70
            ],
            6 => [
                'lat' => 20.994021,
                'lon' => 105.801060,
                'angle' => 50
            ],
            7 => [
                'lat' => 20.992248,
                'lon' => 105.802350,
                'angle' => 35
            ],
            8 => [
                'lat' => 20.991403,
                'lon' => 105.803186,
                'angle' => 90
            ],
            9 => [
                'lat' => 20.990947,
                'lon' => 105.803532,
                'angle' => 120
            ],
            10 => [
                'lat' => 20.990466,
                'lon' => 105.803910,
                'angle' => 45
            ],
            11 => [
                'lat' => 20.989181,
                'lon' => 105.804870,
                'angle' => 80
            ],
            12 => [
                'lat' => 20.988330,
                'lon' => 105.805527,
                'angle' => 60
            ]
        ];
        for($i = 1; $i <= 12; $i++) {
            if(in_array($i, [2,4,6,8,9])) {

                $data[] = [
                    'VehicleId' => $i,
                    'LicensePlate' => '39A - 2341995',
                    'ServiceStatusId' => 3, //Dừng dịch vụ
                    'ServiceStatusName' => 'Dừng dịch vụ',
                    'Comment' => 'Lý do tạm dừng dịch vụ',
                    'ProvinceName' => 'Hồ chí minh',
                    'VehicleStatusId' =>  $i == 6 ? 1 : 3,//Dừng đỗ
                    'VehicleStatusName' => $i == 6 ?  'Đang dừng/đỗ' : 'Mất kết nối',
                    'spd' => 60,
                    'DateTimeCurrent' => date('H:i d/m/Y'),
                    'MapLocation' => 'Cao tốc Hà Nội - Hải phòng',
                    'DateMonitor' => '15/02/2020',
                    'sumKm' => 145,
                    'StopNumber' => 20,
                    'MotorStatusId' => 0,
                    'MotorStatusName' => 'Tắt',
                    'AirStatusId' => 0,
                    'AirStatusName' => 'Tắt',
                    'oil' => '20/30',
                    'DoorStatusId' => 0,
                    'DoorStatusName' => 'Tắt',
                    'Temperature' => 20,
                    'BlackBoxStatusId' => 0,//mất kết nối
                    'BlackBoxStatusName' => 'mất kết nối',
                    'TextDateTimeMin' => '6 ngày trước',
                    'FullName' => 'Trần Văn B',
                    'ID' => 'TB - 10000'.$i,
                    'InstallationDate' => '15/04/2020',
                    'lat' => $dataLatLon[$i]['lat'],
                    'lon' =>  $dataLatLon[$i]['lon'],
                    'angle' => $dataLatLon[$i]['angle'],
                    'RFID' => '01010202002',
                    'PhoneNumber' => '0985344567',
                    'FavoriteStatusId' => 1,// Yêu thích
                    'SSLList' => [
                        [
                            'PackageName' => 'Gói phần mềm A',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ],
                        [
                            'PackageName' => 'Gói phần mềm B',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ]
                    ]
                ];
            } else {
                $data[] = [
                    'VehicleId' => $i,
                    'LicensePlate' => '39A - 2341995',
                    'ServiceStatusId' => 4, //Mất kết nối
                    'ServiceStatusName' => 'Mất kết nối',
                    'ProvinceName' => 'Hồ chí minh',
                    'VehicleStatusId' => $i == 3 ? 1 : 2,//Dừng đỗ
                    'VehicleStatusName' =>  $i == 3 ? 'Mất kết nối' : 'Đang di chuyển',//,
                    'spd' => 60,
                    'DateTimeCurrent' => date('H:i d/m/Y'),
                    'MapLocation' => 'Cao tốc Hà Nội - Hải phòng',
                    'DateMonitor' => '15/02/2020',
                    'sumKm' => 145,
                    'StopNumber' => 20,
                    'MotorStatusId' => 1,
                    'MotorStatusName' => 'Bật',
                    'AirStatusId' => 1,
                    'AirStatusName' => 'Bật',
                    'oil' => '20/30',
                    'DoorStatusId' => 1,
                    'DoorStatusName' => 'Bật',
                    'Temperature' => 20,
                    'BlackBoxStatusId' => 2,//kết nối tốt
                    'BlackBoxStatusName' => 'kết nối tốt',
                    'TextDateTimeMin' => '25 tiếng trước',
                    'FullName' => 'Trần Văn A',
                    'ID' => 'TB - 10000'.$i,
                    'PhoneNumber' => '098532523',
                    'InstallationDate' => '15/04/2020',
                    'lat' => $dataLatLon[$i]['lat'],
                    'lon' =>  $dataLatLon[$i]['lon'],
                    'angle' => $dataLatLon[$i]['angle'],
                    'RFID' => '01010202002',
                    'FavoriteStatusId' => 0,// Không thích
                    'SSLList' => [
                        [
                            'PackageName' => 'Gói phần mềm A',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ],
                        [
                            'PackageName' => 'Gói phần mềm B',
                            'TextDateTime' => 'Còn lại 15 ngày'
                        ]
                    ]
                ];
            }
        }
        echo json_encode(['code' => 1, 'message' => '', 'data' => $data]);
    }
}