<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fakedata extends MY_Controller
{

    // danh sách xe
    public function listVehicles() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $result = [
            'success' => 1,
            'data' => [
                [
                    'vehicleTypeId' => 1,
                    'vehicleTypeName' => 'Xe máy',
                    'vehicles' => [
                        [
                            'trackingData' => [
                                'imei'                => '09182371992502304',
                                'cid'                 => '219238',
                                'vehicleTypeId'       => 1,
                                'speedMax'            => 80,
                                'distance'            => 45,
                                'location'            => ['lat' => 21.032467, 'lng' => 105.780095],
                                'address'             => '10 Phạm Hùng, Nam Từ Liêm, Hà Nội',
                                'speed'               => 40,
                                'airConditionStatus'  => 1,
                                'engineStatus'        => 1,
                                'doorStatus'          => 0,
                                'oil1Status'          => 20,
                                'oil2Status'          => 20,
                                'temp1Status'         => 28,
                                'temp2Status'         => 27,
                                'lastSignal'          => '',
                                'lostSignal'          => 0,
                                'uiSpeedStatus'       => '40/80 km/h',
                                'uiLastSignal'        => '',
                                'uiOil1Status'        => '20/70 lít',
                                'uiOil2Status'        => '20/70 lít',
                                'uiTemp1Status'       => '28 độ C',
                                'uiTemp2Status'       => '27 độ C',
                                'uiDoorStatus'        => 'Mở',
                                'uiEngineStatus'      => 'Bật',
                                'consumption'         => 24,
                                'fuelLevel'           => 70,
                                'driver'              => 'Tuấn Anh',
                                'driverId'            => 31,
                                'driverPhone'         => '0986.526.525',
                                'driverLicense'       => '13551005',
                                'driverLicenseExpire' => '20/3/2025',
                                'course'              => 90
                            ],
                            'vehicle' => [
                                'vehicleId'               => 10,
                                'licensePlate'            => '29H354801',
                                'proviceId'               => 88,
                                'provinceName'            => 'Vĩnh Phúc',
                                'imei'                    => '09182371992502304',
                                'vehicleStatus'           => 2,
                                'vehicleStatusName'       => 'Đang dùng',
                                'vehicleTypeId'           => 1,
                                'vehicleTypeName'         => 'Xe máy',
                                'vehicleKindId'           => 5,
                                'vehicleKindName'         => 'Kia morning',
                                'vehicleManufacturerId'   => 5,
                                'vehicleManufacturerName' => 'Kia',
                                'vehicleModelId'          => 2,
                                'vehicleModelName'        => 2020,
                                'favoriteStatusId'        => 1
                            ],
                            'ssl' => [
                                'sslId'            => 1,
                                'sslCode'          => 'SSL-base',
                                'userId'           => 2481,
                                'userFullName'     => 'Tuấn Anh',
                                'vehicleId'        => 10,
                                'sslStatusId'      => 2,
                                'sslStatusName'    => 'Bình thường',
                                'packageId'        => 1,
                                'packageName'      => 'Vip 1',
                                'statusUpdateTime' => '2020-09-01T10:22:30.167Z'
                            ],
                        ],
                        [
                            'trackingData' => [
                                'imei'                => '09182371992504',
                                'cid'                 => '219238',
                                'vehicleTypeId'       => 1,
                                'speedMax'            => 70,
                                'distance'            => 45,
                                'location'            => ['lat' => 21.027814, 'lng' => 105.785253],
                                'address'             => '72 Tôn Thất Thuyết, Mai Dịch, Cầu Giấy, Hà Nội',
                                'speed'               => 40,
                                'airConditionStatus'  => 1,
                                'engineStatus'        => 1,
                                'doorStatus'          => 0,
                                'oil1Status'          => 20,
                                'oil2Status'          => 20,
                                'temp1Status'         => 28,
                                'temp2Status'         => 27,
                                'lastSignal'          => '2020-09-08T08:40:30.000Z',
                                'lostSignal'          => 1,
                                'uiSpeedStatus'       => '40/70 km/h',
                                'uiLastSignal'        => '',
                                'uiOil1Status'        => '20/70 lít',
                                'uiOil2Status'        => '20/70 lít',
                                'uiTemp1Status'       => '28 độ C',
                                'uiTemp2Status'       => '27 độ C',
                                'uiDoorStatus'        => 'Mở',
                                'uiEngineStatus'      => 'Bật',
                                'consumption'         => 24,
                                'fuelLevel'           => 70,
                                'driver'              => 'Tuấn Anh',
                                'driverId'            => 31,
                                'driverPhone'         => '0986.526.525',
                                'driverLicense'       => '13551005',
                                'driverLicenseExpire' => '20/3/2024',
                                'course'              => 90
                            ],
                            'vehicle' => [
                                'vehicleId'               => 10,
                                'licensePlate'            => '29H331501',
                                'proviceId'               => 88,
                                'provinceName'            => 'Vĩnh Phúc',
                                'imei'                    => '09182371992504',
                                'vehicleStatus'           => 2,
                                'vehicleStatusName'       => 'Đang dùng',
                                'vehicleTypeId'           => 1,
                                'vehicleTypeName'         => 'Xe máy',
                                'vehicleKindId'           => 5,
                                'vehicleKindName'         => 'SH110',
                                'vehicleManufacturerId'   => 5,
                                'vehicleManufacturerName' => 'Honda',
                                'vehicleModelId'          => 2,
                                'vehicleModelName'        => 2020,
                                'favoriteStatusId'        => 0
                            ],
                            'ssl' => [
                                'sslId'            => 1,
                                'sslCode'          => 'SSL-base',
                                'userId'           => 2481,
                                'userFullName'     => 'Tuấn Anh',
                                'vehicleId'        => 10,
                                'sslStatusId'      => 2,
                                'sslStatusName'    => 'Bình thường',
                                'packageId'        => 1,
                                'packageName'      => 'Vip 1',
                                'statusUpdateTime' => '2020-09-01T10:22:30.167Z'
                            ],
                        ]
                    ]
                ],
                [
                    'vehicleTypeId' => 2,
                    'vehicleTypeName' => 'Xe tải',
                    'vehicles' => [
                        [
                            'trackingData' => [
                                'imei'                => '0144241',
                                'cid'                 => '219238',
                                'vehicleTypeId'       => 1,
                                'speedMax'            => 80,
                                'distance'            => 45,
                                'location'            => ['lat' => 21.024438, 'lng' => 105.762605],
                                'address'             => '32 Đỗ Xuân Hợp, Mỹ Đình, Nam Từ Liêm, Hà Nội',
                                'speed'               => 0,
                                'airConditionStatus'  => 0,
                                'engineStatus'        => 0,
                                'doorStatus'          => 0,
                                'oil1Status'          => 20,
                                'oil2Status'          => 20,
                                'temp1Status'         => 32,
                                'temp2Status'         => 32,
                                'lastSignal'          => '',
                                'lostSignal'          => 0,
                                'uiSpeedStatus'       => '0/80 km/h',
                                'uiLastSignal'        => '',
                                'uiOil1Status'        => '20/70 lít',
                                'uiOil2Status'        => '20/70 lít',
                                'uiTemp1Status'       => '32 độ C',
                                'uiTemp2Status'       => '32 độ C',
                                'uiDoorStatus'        => 'Mở',
                                'uiEngineStatus'      => 'Tắt',
                                'consumption'         => 24,
                                'fuelLevel'           => 70,
                                'driver'              => 'Tuấn Anh',
                                'driverId'            => 31,
                                'driverPhone'         => '0986.526.525',
                                'driverLicense'       => '13551005',
                                'driverLicenseExpire' => '20/3/2025',
                                'course'              => 90
                            ],
                            'vehicle' => [
                                'vehicleId'               => 10,
                                'licensePlate'            => '88S41320',
                                'proviceId'               => 88,
                                'provinceName'            => 'Vĩnh Phúc',
                                'imei'                    => '0144241',
                                'vehicleStatus'           => 2,
                                'vehicleStatusName'       => 'Đang dùng',
                                'vehicleTypeId'           => 1,
                                'vehicleTypeName'         => 'Xe tải',
                                'vehicleKindId'           => 5,
                                'vehicleKindName'         => 'Kia morning',
                                'vehicleManufacturerId'   => 5,
                                'vehicleManufacturerName' => 'Kia',
                                'vehicleModelId'          => 2,
                                'vehicleModelName'        => 2020,
                                'favoriteStatusId'        => 1
                            ],
                            'ssl' => [
                                'sslId'            => 1,
                                'sslCode'          => 'SSL-base',
                                'userId'           => 2481,
                                'userFullName'     => 'Tuấn Anh',
                                'vehicleId'        => 10,
                                'sslStatusId'      => 2,
                                'sslStatusName'    => 'Bình thường',
                                'packageId'        => 1,
                                'packageName'      => 'Vip 1',
                                'statusUpdateTime' => '2020-09-01T10:22:30.167Z'
                            ],
                        ],
                    ]
                ],
            ]
        ];
        echo json_encode($result);
    }

    // chi tiết xe
    public function detailVehicle() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => array (
                    'path' => array (
                        array (
                            'location' => array (
                                'lat' => 21.035707,
                                'lng' => 105.774724,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.035769,
                                'lng' => 105.774433,
                            ),
                            'speed' => 0,
                            'airConditionStatus' => 0,
                            'engineStatus' => 1,
                            'doorStatus' => 1,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.035834,
                                'lng' => 105.774171,
                            ),
                            'speed' => 0,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.035939,
                                'lng' => 105.773703,
                            ),
                            'speed' => 24,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036084,
                                'lng' => 105.773177,
                            ),
                            'speed' => 37,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036139,
                                'lng' => 105.772995,
                            ),
                            'speed' => 30,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036209,
                                'lng' => 105.772801,
                            ),
                            'speed' => 30,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036363,
                                'lng' => 105.772315,
                            ),
                            'speed' => 35,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036448,
                                'lng' => 105.77209,
                            ),
                            'speed' => 32,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036526,
                                'lng' => 105.771827,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036607,
                                'lng' => 105.771567,
                            ),
                            'speed' => 32,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036688,
                                'lng' => 105.771318,
                            ),
                            'speed' => 35,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036965,
                                'lng' => 105.771484,
                            ),
                            'speed' => 37,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037188,
                                'lng' => 105.77161,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037451,
                                'lng' => 105.77176,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037653,
                                'lng' => 105.771866,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037851,
                                'lng' => 105.77198,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.038057,
                                'lng' => 105.77252,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037963,
                                'lng' => 105.772817,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037879,
                                'lng' => 105.773138,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037832,
                                'lng' => 105.773339,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037704,
                                'lng' => 105.773792,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037619,
                                'lng' => 105.774068,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037479,
                                'lng' => 105.774578,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037326,
                                'lng' => 105.775085,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.037146,
                                'lng' => 105.775664,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036978,
                                'lng' => 105.776217,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036978,
                                'lng' => 105.776753,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036662,
                                'lng' => 105.777289,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036537,
                                'lng' => 105.777801,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036467,
                                'lng' => 105.778512,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036464,
                                'lng' => 105.779149,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.036442,
                                'lng' => 105.779786,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.035884,
                                'lng' => 105.780202,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.0352,
                                'lng' => 105.780127,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.034507,
                                'lng' => 105.779964,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.033766,
                                'lng' => 105.779842,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.032899,
                                'lng' => 105.779712,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.032243,
                                'lng' => 105.779621,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.031497,
                                'lng' => 105.779471,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.030811,
                                'lng' => 105.779369,
                            ),
                            'speed' => 45,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.03025,
                                'lng' => 105.779294,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.029584,
                                'lng' => 105.779187,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.028568,
                                'lng' => 105.778999,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.028187,
                                'lng' => 105.778913,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.027706,
                                'lng' => 105.778822,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                        array (
                            'location' => array (
                                'lat' => 21.02723,
                                'lng' => 105.778763,
                            ),
                            'speed' => 40,
                            'airConditionStatus' => 1,
                            'engineStatus' => 1,
                            'doorStatus' => 0,
                            'generated' => 1,
                            'oil1Status' => 20,
                            'oil2Status' => 10,
                            'uiOil1Status' => '20/70 lít',
                            'uiOil2Status' => '10/70 lít',
                            'temp1Status' => 32,
                            'temp2Status' => 30,
                            'uiTemp1Status' => '32 độ',
                            'uiTemp2Status' => '30 độ',
                        ),
                    ),
                    'stats'=> array (
                        'imei' => '5e5a35d34ebcfa1aa0ffd5da',
                        'cid' => '1',
                        'dateTime' => '2020-02-29 16:50:40',
                        'distance' => 300,
                        'countParkingStop' => 2,
                        'countParkingPause' => 1,
                        'timeParkingStop' => 20,
                        'timeParkingPause' => 15,
                        'countOverSpeed' => 0,
                        'fromLocation' => array (
                            'lat' => 20.9598178,
                            'lng' => 105.8649368,
                        ),
                        'endLocation' => array (
                            'lat' => 20.9600257,
                            'lng' => 105.8649368,
                        ),
                        'fuelConsumeSensor' => 0,
                        'fuelConsumeQuota' => 0,
                        'timeParkingEngine' => 10,
                        'timeEngine' => 0,
                        'countDoorOpen' => 1,
                        'countAirConditionOpen' => 1,
                        'distanceGps' => 1,
                        'countBendAuto' => 0,
                        'countBendManual' => 0,
                        'distanceBends' => array (
                            array (
                                'imei' => '',
                                'type' => 1,
                                'fromLocation' => array (
                                    'lat' => 21.035834,
                                    'lng' => 105.774171,
                                ),
                                'endLocation' => array (
                                    'lat' => 21.036139,
                                    'lng' => 105.772995,
                                ),
                                'fromTime' => '2020-02-29 16:51:40',
                                'endTime' => '2020-02-29 16:58:40',
                                'distanceBend' => 1,
                                'status' => 1,
                                'memo' => '',
                            ),
                        ),
                        'parkings' => array (
                            array (
                                'imei' => '5e5a35d34ebcfa1aa0ffd5da',
                                'type' => 1,
                                'location' => array (
                                    'lat' => 21.036688,
                                    'lng' => 105.771318,
                                ),
                                'fromTime' => '2020-02-29 16:52:40',
                                'endTime' => '2020-02-29 16:55:12',
                                'timeEngine' => 1,
                                'driver' => '',
                                'status' => 1,
                                'memo' => '',
                            ),
                            array (
                                'imei' => '5e5a35d34ebcfa1aa0ffd5da',
                                'type' => 2,
                                'location' => array (
                                    'lat' => 21.036537,
                                    'lng' => 105.777801,
                                ),
                                'fromTime' => '2020-02-29 17:20:40',
                                'endTime' => '2020-02-29 17:30:32',
                                'timeEngine' => 1,
                                'driver' => '',
                                'status' => 1,
                                'memo' => '',
                            ),
                            array (
                                'imei' => '5e5a35d34ebcfa1aa0ffd5da',
                                'type' => 2,
                                'location' => array (
                                    'lat' => 21.02723,
                                    'lng' => 105.778763,
                                ),
                                'fromTime' => '2020-02-29 17:42:40',
                                'endTime' => '2020-02-29 17:58:58',
                                'timeEngine' => 1,
                                'driver' => '',
                                'status' => 1,
                                'memo' => '',
                            ),
                        ),
                        'overSpeeds' => array (
                            array (
                                'imei' => '5e5a35d34ebcfa1aa0ffd5da',
                                'speedMax' => 300,
                                'fromTime' => '2020-02-29 17:35:40',
                                'endTime' => '2020-02-29 17:37:22',
                                'fromLocation' => array (
                                    'lat' => 21.032243,
                                    'lng' => 105.779621,
                                ),
                                'endLocation' => array (
                                    'lat' => 21.030811,
                                    'lng' => 105.779369,
                                ),
                                'speedStartOver' => 200,
                                'driver' => 'Nguyen van A',
                                'driverId' => 1,
                                'status' => 0,
                                'memo' => '',
                            ),
                        ),
                        'fuelChanges' => array (
                            array (
                                'imei' => '5e5a35d34ebcfa1aa0ffd5da',
                                'type' => 1,
                                'time' => '2020-02-29 16:40:40',
                                'location' => array (
                                    'lat' => 21.035769,
                                    'lng' => 105.774433,
                                ),
                                'fuelExistStart' => 10,
                                'fuelExistEnd' => 12,
                                'status' => 1,
                                'value' => 0,
                                'driverId' => 1,
                                'memo' => '',
                            ),
                            array (
                                'imei' => '5e5a35d34ebcfa1aa0ffd5da',
                                'type' => 2,
                                'time' => '2020-02-29 18:00:40',
                                'location' => array (
                                    'lat' => 21.027706,
                                    'lng' => 105.778822,
                                ),
                                'fuelExistStart' => 10,
                                'fuelExistEnd' => 12,
                                'status' => 1,
                                'value' => 0,
                                'driverId' => 1,
                                'memo' => '',
                            ),
                        ),
                        'speedMax' => 100,
                        'fuelExistsStart' => 2,
                        'consumePerChunk' => 3,
                        'consumeValue' => 1,
                        'chargeValue' => 2,
                        'dischargeValue' => 3,
                        'fuelExistsEnd' => 4,
                        'locations' => array (
                            array (
                            'lat' => 20.9600257,
                            'lng' => 105.8649368,
                            ),
                        ),
                        'consumption' => 35,
                        'fuelLevel' => 35,
                    ),
                ),
            )
        );
    }

    // get summary km report
    public function listSummaryKmReport(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $vehicles_arr = [];
        for($i = 0; $i <= 10000; $i++){
            $key = '29A-'.str_pad($i,5,"0",STR_PAD_LEFT);
            $vehicles_arr[$key] = array (
                'fromTime' => '2020-07-01',
                'endTime' => '2020-07-02',
                'imei' => 123,
                'cid' => 123,
                'licensePlate' => $key,
                'time' => '2020-07-01T00:00:00.000Z',
                'distance' => 10,
                'distanceGps' => 8,
                'countBendAuto' => 2,
                'countBendManual' => 1,
                'bendRatio' => 30,
            );
        }
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $vehicles_arr
            )
        );
    }
	
	// get sumary parking report
	public function listSummaryParkingReport(){
		header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
		$data = [];
		for($i = 0; $i <= 99; $i++){
			$key = '29A-'.str_pad($i,5,"0",STR_PAD_LEFT);
			$data[$key] = array (
				'fromTime' => '2020-07-01T10:00:00.000Z',
				'endTime' => '2020-07-02T11:00:00.000Z',
				'imei' => 123,
				'cid' => 123,
				'licensePlate' => $key,
				'countParkingStop' => 10,
				'countParkingPause' => 30,
				'timeParkingStop' => 123,
				'timeParkingPause' => 321,
				'timeParkingEngine' => 222,
			);
		}
		echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
	}
	
	//  fake data của báo cáo chi tiết km chuẩn
	public function listDailyKmReport(){
		header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
		$data = [];
		for($i = 0; $i <= 99; $i++){
			$data['2020-07-01'] = array (
				"imei" => 123,
				"cid" => 123,
				"licensePlate" => '29A-'.str_pad($i,5,"0",STR_PAD_LEFT),
				"distance" => 10,
				"distanceGps" => 8,
				"countBendAuto" => 2,
				"countBendManual" => 1,
				"bendRatio" => 30
			);
		}
		echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
	}
	
	//fake data của api sự kiện mất kết nối trong báo cáo chi tiết km chuẩn
	public function listDisconnectEventReport(){
		header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = [];
        for($i = 0; $i <= 99; $i++){
            $data[] = array (
                "imei" => "",
                "type" => 1,
                "fromLocation" => array(
                    "lat" => 21.029055,
                    "lng" => 105.777091
                ),
                "endLocation" => array(
                    "lat" => 21.020736,
                    "lng" => 105.786772
                ),
                "fromAddress" => "8 Cầu giấy, Hà Nội, Việt Nam",
                "endAddress" => "12 Cầu giấy, Hà Nội, Việt Nam",
                "fromTime" => "2020-07-28T01:51:22.492Z",
                "endTime" => "2020-07-28T04:45:22.492Z",
                "distanceBend" => 1,
                "status" => 1,
                "driverId" => -100000000,
                "driverName" => "Tuấn Anh",
                "memo" => "Ghi chú ". $i,
                "locations" => array(
                    [
                        "lat" => 21.029055,
                        "lng" => 105.777091
                    ],
                    [
                        "lat" => 21.028733, 
                        "lng" => 105.779042
                    ],
                    [
                        "lat" => 21.027680,
                        "lng" => 105.778812
                    ],
                    [
                        "lat" => 21.026573,
                        "lng" => 105.778651
                    ],
                    [
                        "lat" => 21.024861,
                        "lng" => 105.778436
                    ],
                    [
                        "lat" => 21.022958,
                        "lng" => 105.778586
                    ],
                    [
                        "lat" => 21.021531,
                        "lng" => 105.779074
                    ],
                    [
                        "lat" => 21.020124,
                        "lng" => 105.779975
                    ],
                    [
                        "lat" => 21.019183, 
                        "lng" => 105.780694
                    ],
                    [
                        "lat" => 21.017435,
                        "lng" => 105.782095
                    ],
                    [
                        "lat" => 21.018811, 
                        "lng" => 105.784027
                    ],
                    [
                        "lat" => 21.020142,
                        "lng" => 105.785859
                    ],
                    [
                        "lat" => 21.020736,
                        "lng" => 105.786772
                    ]
                )
            );
        }
		echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );

	}
	
	//data sự kiện dừng đỗ theo ngày
	public function listParkingReport(){
		header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
		$data = array(
			'2020-07-01' => array (
				"imei" => 123,
				"cid" => 123,
				"licensePlate" => '29A-00014',
				"countParkingStop" => 10,
				"countParkingPause" => 8,
				"timeParkingStop" => 351,
				"timeParkingPause" => 388,
				"timeParkingEngine" => 120
			),
			'2020-07-02' => array (
				"imei" => 123,
				"cid" => 123,
				"licensePlate" => '29A-02154',
				"countParkingStop" => 10,
				"countParkingPause" => 8,
				"timeParkingStop" => 351,
				"timeParkingPause" => 388,
				"timeParkingEngine" => 120
			),
			'2020-07-03' => array (
				"imei" => 123,
				"cid" => 123,
				"licensePlate" => '29A-03451',
				"countParkingStop" => 10,
				"countParkingPause" => 8,
				"timeParkingStop" => 351,
				"timeParkingPause" => 388,
				"timeParkingEngine" => 120
			),
			'2020-07-04' => array (
				"imei" => 123,
				"cid" => 123,
				"licensePlate" => '29A-32150',
				"countParkingStop" => 10,
				"countParkingPause" => 8,
				"timeParkingStop" => 351,
				"timeParkingPause" => 388,
				"timeParkingEngine" => 120
			),
			'2020-07-05' => array (
				"imei" => 123,
				"cid" => 123,
				"licensePlate" => '29A-47682',
				"countParkingStop" => 10,
				"countParkingPause" => 8,
				"timeParkingStop" => 351,
				"timeParkingPause" => 388,
				"timeParkingEngine" => 120
			),
			'2020-07-06' => array (
				"imei" => 123,
				"cid" => 123,
				"countParkingStop" => 10,
				"countParkingPause" => 8,
				"timeParkingStop" => 351,
				"timeParkingPause" => 388,
				"timeParkingEngine" => 120
			),
		);
		
		echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
	}
	
	//danh sách sự kiện dừng đỗ đi kèm
	
	public function listParkingEventReport(){
		header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
		$data = [];
		for($i = 0; $i <= 99; $i++){
			$data[] = array (
				"imei" => "",
				"type" => $i%2,
				"location" => array(
					"lat" => -100000000,
					"lng" => -100000000
				),
				"address" => "8 Cầu giấy, Hà Nội, Việt Nam",
				"fromTime" => "2020-07-28T01:51:22.492Z",
				"endTime" => "2020-07-28T04:45:22.492Z",
				"timeEngine" => 121,
				"driverId" => -100000000,
				"driverName" => "",
				"status" => -100000000,
				"memo" => ""
			);
		}
		echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }
    
    public function getSummaryGeneralReport(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = [];

        for($i = 0; $i<=99; $i++){
            $key = '29A-'.str_pad($i,5,"0",STR_PAD_LEFT);
            $data[$key] = array(
                "fromTime" => "2020-07-01T10:00:00.000Z",
                "endTime" => "2020-07-02T11:00:00.000Z",
                "imei" => 123,
                "cid" => 123,
                "licensePlate" => $key,
                "distance" => 1000,
                "countParking" => 10,
                "timeParking" => 100,
                "timeParkingEngine" => 80,
                "countOverSpeed" => 10,
                "maxOverSpeed" => 120,
                "fromLocation" => [
                    "lat" => 1,
                    "lng" => 1
                ],
                "fromAddress" => "Cầu Giấy, Hà Nội, Việt Nam",
                "endLocation" => [
                    "lat" => 1,
                    "lng" => 1
                ],
                "endAddress" => "Hoàn Kiếm, Hà Nội, Việt Nam",
                "stdConsume" => 12,
                "consumeValue" => 80,
                "timeEngine" => 1209,
                "countDoorOpen" => 120,
                "timeAirConditionOpen" => 130
            );
        }

        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }

    public function getDailyGeneralReport(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = array (
            '2020-07-01' => array (
                'imei' => 123,
                'cid' => 123,
                'licensePlate' => '29A-11111',
                'distance' => 1000,
                'countParking' => 10,
                'timeParking' => 100,
                'timeParkingEngine' => 80,
                'countOverSpeed' => 10,
                'maxOverSpeed' => 120,
                'fromLocation' => array (
                        'lat' => 1,
                        'lng' => 1
                    ),
                'fromAddress' => 'Cầu Giấy, Hà Nội, Việt Nam',
                'endLocation' => array (
                        'lat' => 1,
                        'lng' => 1
                    ),
                'endAddress' => 'Hoàn Kiếm, Hà Nội, Việt Nam',
                'stdConsume' => 12,
                'consumeValue' => 80,
                'timeEngine' => 1209,
                'countDoorOpen' => 120,
                'timeAirConditionOpen' => 130
            ),
            '2020-07-02' => Array (
                'imei' => 123,
                'cid' => 123,
                'licensePlate' => '29A-11111',
                'distance' => 1000,
                'countParking' => 10,
                'timeParking' => 100,
                'timeParkingEngine' => 80,
                'countOverSpeed' => 10,
                'maxOverSpeed' => 120,
                'fromLocation' => Array (
                        'lat' => 1,
                        'lng' => 1
                    ),
                'fromAddress' => 'Cầu Giấy, Hà Nội, Việt Nam',
                'endLocation' => Array (
                        'lat' => 1,
                        'lng' => 1
                    ),
                'endAddress' => 'Hoàn Kiếm, Hà Nội, Việt Nam',
                'stdConsume' => 12,
                'consumeValue' => 80,
                'timeEngine' => 1209,
                'countDoorOpen' => 120,
                'timeAirConditionOpen' => 130
            ),
            '2020-07-03' => Array (
                'imei' => 123,
                'cid' => 123,
                'licensePlate' => '29A-11111',
                'distance' => 1000,
                'countParking' => 10,
                'timeParking' => 100,
                'timeParkingEngine' => 80,
                'countOverSpeed' => 10,
                'maxOverSpeed' => 120,
                'fromLocation' => Array (
                        'lat' => 1,
                        'lng' => 1
                    ),
                'fromAddress' => 'Cầu Giấy, Hà Nội, Việt Nam',
                'endLocation' => Array (
                        'lat' => 1,
                        'lng' => 1
                    ),
                'endAddress' => 'Hoàn Kiếm, Hà Nội, Việt Nam',
                'stdConsume' => 12,
                'consumeValue' => 80,
                'timeEngine' => 1209,
                'countDoorOpen' => 120,
                'timeAirConditionOpen' => 130
            )
        );
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }

    public function getSummaryFuelReport(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = [];
        for($i = 0; $i<=99; $i++){
            $key = '29A-'.str_pad($i,5,"0",STR_PAD_LEFT);
            $data[$key] = array(
                "fromTime"             => "2020-07-01T10:00:00.000Z",
                "endTime"              => "2020-07-02T11:00:00.000Z",
                "imei"                 => 123,
                "cid"                  => 123,
                "vehicleId"            => 1,
                "licensePlate"         => $key,
                "distance"             => 100,
                "fuelLevel"            => 80,
                "consumption"          => 10,
                "fuelExistsStart"      => 70,
                "fuelExistsEnd"        => 30,
                "chargeValue"          => 40,
                "dischargeValue"       => 10,
                "consumeValue"         => 70,
                "consumePerChunk"      => 7,
                "stdConsume"           => 20,
                "fuelConsumption"      => 20,
                "timeEngine"           => 351,
                "timeAirConditionOpen" => 324
            );
        }
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }

    public function getDailyFuelReport(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = array(
            "2020-07-01"=> [
                "imei"                 => 121,
                "cid"                  => 121,
                "licensePlate"         => "29A-11111",
                "distance"             => 100,
                "fuelLevel"            => 80,
                "consumption"          => 10,
                "fuelExistsStart"      => 70,
                "fuelExistsEnd"        => 30,
                "chargeValue"          => 40,
                "dischargeValue"       => 10,
                "consumeValue"         => 70,
                "consumePerChunk"      => 7,
                "stdConsume"           => 20,
                "fuelConsumption"      => 20,
                "timeEngine"           => 1000,
                "timeAirConditionOpen" => 1000
            ],
            "2020-07-02"=> [
                "imei"                 => 122,
                "cid"                  => 122,
                "licensePlate"         => "29A-11111",
                "distance"             => 100,
                "fuelLevel"            => 80,
                "consumption"          => 10,
                "fuelExistsStart"      => 70,
                "fuelExistsEnd"        => 30,
                "chargeValue"          => 40,
                "dischargeValue"       => 10,
                "consumeValue"         => 70,
                "consumePerChunk"      => 7,
                "stdConsume"           => 20,
                "fuelConsumption"      => 20,
                "timeEngine"           => 1000,
                "timeAirConditionOpen" => 1000
            ],
            "2020-07-03"=> [
                "imei"                 => 123,
                "cid"                  => 123,
                "licensePlate"         => "29A-11111",
                "distance"             => 100,
                "fuelLevel"            => 80,
                "consumption"          => 10,
                "fuelExistsStart"      => 70,
                "fuelExistsEnd"        => 30,
                "chargeValue"          => 40,
                "dischargeValue"       => 10,
                "consumeValue"         => 70,
                "consumePerChunk"      => 7,
                "stdConsume"           => 20,
                "fuelConsumption"      => 20,
                "timeEngine"           => 1000,
                "timeAirConditionOpen" => 1000
            ],
        );
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }

    public function getFuelEventReport(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = array(
            "fromTime"       => "2020-08-10T01:05:44.006Z",
            "endTime"        => "2020-08-10T01:05:44.007Z",
            "fuelExistStart" => 40,
            "chargeValue"    => 20,
            "dischargeValue" => 10,
            "consumeValue"   => 20,
            "fuelExistEnd"   => 30,
            "events"         => array(
                [
                    "objectId" => "1",
                    "code"     => "NL-0031",
                    "imei"     => "",
                    "type"     => -100000000,
                    "typeName" => "Cảm biến nhiên liệu",
                    "time"     => "2020-08-10T01:05:44.007Z",
                    "location" => [
                        "lat" => -100000000,
                        "lng" => -100000000
                    ],
                    "address"        => "8 Xuân Thuỷ, Cầu Giấy, Hà Nội",
                    "fuelExistStart" => -100000000,
                    "fuelExistEnd"   => -100000000,
                    "status"         => -100000000,
                    "value"          => -100000000,
                    "driverId"       => -100000000,
                    "driverName"     => "Tuấn Anh",
                    "memo"           => ""
                ],
                [
                    "objectId" => "2",
                    "code"     => "XL-5015",
                    "imei"     => "",
                    "type"     => -100000000,
                    "typeName" => "Cảm biến nhiên liệu",
                    "time"     => "2020-08-10T01:05:44.007Z",
                    "location" => [
                        "lat" => -100000000,
                        "lng" => -100000000
                    ],
                    "address"        => "8 Xuân Thuỷ, Cầu Giấy, Hà Nội",
                    "fuelExistStart" => -100000000,
                    "fuelExistEnd"   => -100000000,
                    "status"         => -100000000,
                    "value"          => -100000000,
                    "driverId"       => -100000000,
                    "driverName"     => "Tuấn Anh",
                    "memo"           => ""
                ],
            )
        );
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }

    public function reportsOverSpeedMix(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = [];
        for($i = 0; $i<=99; $i++){
            $key = '29A-'.str_pad($i,5,"0",STR_PAD_LEFT);
            $data[$key] = array(
                "fromTime" => "2020-07-01T10:00:00.000Z",
                "endTime" => "2020-07-02T11:00:00.000Z",
                "imei" => 123,
                "cid" => 123,
                "licensePlate" => "29A-11111",
                "countOverSpeed" => 10,
                "speedMax" => 80,
                "maxOverSpeed" => 100
            );
        }
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }

    public function reportsOverSpeedEvents(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $data = array(
            "fromTime"          => "2020-07-01T10:00:00.000Z",
            "endTime"           => "2020-07-02T11:00:00.000Z",
            "countOverSpeed"    => 10,
            "maxOverSpeed"      => 120,
            "speedMax"          => 80,
            "avgCountOverSpeed" => 10,
            "events"            => [
                [
                    "code" => "VTD-11111",
                    "imei" => 123,
                    "speedMax" => 80,
                    "fromTime" => "2020-07-01T12:30:00.000Z",
                    "endTime" => "2020-07-01T13:30:00.000Z",
                    "fromLocation" => [
                        "lat" => 1,
                        "lng" => 1
                    ],
                    "endLocation" => [
                        "lat" => 2,
                        "lng" => 2
                    ],
                    "fromAddress" => "Cầu Giấy, Hà Nội, Việt Nam",
                    "endAddress" => "Hoàn Kiếm, Hà Nội, Việt Nam",
                    "speedStartOver" => 20,
                    "driverId" => 1234,
                    "driverName" => "Nguyễn Văn A",
                    "status" => 1,
                    "memo" => "vượt nhiều quá, phạt"
                ],
                [
                    "code" => "VTD-11112",
                    "imei" => 123,
                    "speedMax" => 80,
                    "fromTime" => "2020-07-01T15:30:00.000Z",
                    "endTime" => "2020-07-01T16:00:00.000Z",
                    "fromLocation" => [
                        "lat" => 1,
                        "lng" => 1
                    ],
                    "endLocation" => [
                        "lat" => 2,
                        "lng" => 2
                    ],
                    "fromAddress" => "Cầu Giấy, Hà Nội, Việt Nam",
                    "endAddress" => "Hoàn Kiếm, Hà Nội, Việt Nam",
                    "speedStartOver" => 20,
                    "driverId" => 1234,
                    "driverName" => "Nguyễn Văn A",
                    "status" => 1,
                    "memo" => "vượt nhiều quá, phạt"
                ]
            ]
        );
        echo  json_encode(
            array (
                'success' => 1,
                'message' => 'Dữ liệu thành công',
                'data'   => $data
            )
        );
    }
}