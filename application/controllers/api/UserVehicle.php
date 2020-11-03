<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserVehicle extends MY_Controller
{
    public function __construct($params = array())
    {
        parent::__construct();
        $this->load->library('redis_sentinel');
    }

    public function update()
    {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mvehicles', 'Muservehicles', 'Mssldevices', 'Muserdetails']);
        $VehicleId = $this->input->post('VehicleId');
        $UserId = $this->input->post('UserId');
        $dataSave = [
            'VehicleId' => $VehicleId,
            'UserId' => $UserId,
            'BeginDate' => getCurentDateTime(),
            'StatusId' => 2,
            'CrUserId' => $user['UserId']
        ];
        $this->Mvehicles->updateBy(['VehicleId' => $VehicleId], ['DriverId' => $UserId]);
        $UserVehicleId = $this->Muservehicles->save($dataSave);
        $UserItem = $this->Musers->getBy(['UserId' => $UserId], true);
        if (!empty($UserItem)) {
            $UserDetail = $this->Muserdetails->getBy(['UserId' => $UserId], true);
            $dataSslDevice = [
                'FullName' => $UserItem['FullName'],
                'DriverId' => $UserItem['UserId'],
                'DriverLicence' => !empty($UserDetail) ? $UserDetail['DriverLicence'] : '',
                'LicenceExpDate' => !empty($UserDetail) ? $UserDetail['LicenceExpDate'] : '',
                'PhoneNumber' => $UserItem['PhoneNumber']
            ];
            $this->Mssldevices->updateBy(['VehicleId' => $VehicleId], $dataSslDevice);
        }
        if ($UserVehicleId) {
            echo json_encode(['code' => 1, 'message' => 'Thay lái xe thành công', 'UserVehicleId' => $UserVehicleId]);
        } else {
            echo json_encode(['code' => 1, 'message' => 'Có lỗi xảy ra trong quá trình thực hiện']);
        }
    }

    public function updateFuelLevel()
    {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mvehicles', 'Muservehicles', 'Mssldevices', 'Muserdetails']);
        $VehicleId = $this->input->post('VehicleId');
        $FuelLevel = $this->input->post('FuelLevel');
        $flag = $this->Mvehicles->updateBy(['VehicleId' => $VehicleId], ['FuelLevel' => $FuelLevel]);
        if ($flag) {
            $this->Mssldevices->updateBy(['VehicleId' => $VehicleId], ['FuelLevel' => $FuelLevel]);
            echo json_encode(['code' => 1, 'message' => 'Cập nhật thành công']);
        } else {
            echo json_encode(['code' => 1, 'message' => 'Có lỗi xảy ra trong quá trình thực hiện']);
        }
    }

    public function delete()
    {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mvehicles', 'Msims', 'Muservehicles', 'Mssldevices', 'Muserdetails']);
        $UserVehicleId = $this->input->post('UserVehicleId');
        $UserVehicleItem = $this->Muservehicles->getBy(['UserVehicleId' => $UserVehicleId], true);
        if (!empty($UserVehicleItem)) {
            $this->Mvehicles->updateBy(['VehicleId' => $UserVehicleItem['VehicleId']], ['DriverId' => 0]);
            $dataSslDevice = [
                'FullName' => '',
                'DriverId' => 0,
                'DriverLicence' => '',
                'LicenceExpDate' => '',
                'PhoneNumber' => ''
            ];
            $this->Mssldevices->updateBy(['VehicleId' => $UserVehicleItem['VehicleId']], $dataSslDevice);
        }
        $this->Muservehicles->updateBy(['UserVehicleId' => $UserVehicleId], ['StatusId' => 0, 'EndDate' => getCurentDateTime()]);
        echo json_encode(['code' => 1, 'message' => 'Gỡ lái xe thành công']);
    }

    public function getListHistory()
    {
        $this->loadModel(['Mdevices', 'Msims', 'Muservehicles', 'Muserdetails']);
        $VehicleId = $this->input->post('VehicleId');
        $ListHistory = $this->Muservehicles->getListBy(['uservehicles.VehicleId' => $VehicleId, 'uservehicles.StatusId' => 0]);
        for ($i = 0; $i < count($ListHistory); $i++) {
            $userDetail = $this->Muserdetails->getBy(['UserId' => $ListHistory[$i]['UserId']], true);
            $ListHistory[$i]['DriverLicence'] = !empty($userDetail) ? $userDetail['DriverLicence'] : '';
        }
        $this->load->view('vehicle/view_history', ['ListHistory' => $ListHistory]);
    }
}