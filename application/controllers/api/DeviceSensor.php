<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceSensor extends MY_Controller
{
    public function __construct($params = array())
    {
        parent::__construct();
        $this->load->library('redis_sentinel');
    }

    public function SaveDeviceSensor() {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mdevicesensors', 'Mvehicledevicesensors', 'Mdevices', 'Mssldevices']);
        $DeviceId = $this->input->post('DeviceId');
        $DeviceSensorId = $this->input->post('DeviceSensorId');
        $Comment = $this->input->post('Comment');
        $dataCB = $this->input->post('dataCB');
        $dataDeviceSensor = [
            'VehicleId' => $this->input->post('VehicleId'),
            'DeviceId' => $DeviceId,
            'Comment' => $Comment,
            'StatusId' => 2,
            'CrDateTime' => getCurentDateTime(),
            'BeginDate' => getCurentDateTime(),
            'CrUserId' => $user['UserId']
        ];
        $DeviceItem = $this->Mdevices->getBy(['DeviceId' => $DeviceId], true);
        $this->Mdevices->updateBy(['DeviceId' => $DeviceId], ['VehicleId' => $this->input->post('VehicleId'), 'InstallationStatusId' => 2]);
        $dataSSLDevice = [
            'DeviceStatusId' => 2,
            'DeviceId' => $DeviceId,
            'IMEI' => $DeviceItem['IMEI'],
            'InstallationDate' => getCurentDateTime()
        ];
        if($DeviceSensorId == 0) {
            $DeviceSensorId = $this->Mdevicesensors->save($dataDeviceSensor);
        } else {
            $listCB = $this->Mvehicledevicesensors->getBy(['DeviceSensorId' => $DeviceSensorId]);
            if(!empty($listCB)) {
                $DeviceItem = $this->Mdevices->getBy(['DeviceId' => $DeviceId], true);
                foreach ($listCB as $value) {
                    $this->convertCB($DeviceItem, $value, true);
                }
            }
            $this->Mvehicledevicesensors->deleteMultiple(['DeviceSensorId' => $DeviceSensorId]);
        }
        if (!empty($dataCB)) {
            foreach ($dataCB as $key => $value) {
                $this->convertCB($DeviceItem, $value, false);
                $value['DeviceSensorId'] = $DeviceSensorId;
                $value['IsRevert'] = isset($value['IsRevert']) ? $value['IsRevert'] : 0;
                $value['Consumption'] = isset($value['Consumption']) ? $value['Consumption'] : '';
                $value['LookupTable'] = isset($value['LookupTable']) ? json_encode($value['LookupTable']) : '';
                $this->Mvehicledevicesensors->save($value);
            }
        }
        $this->Mssldevices->updateBy(['VehicleId' => $this->input->post('VehicleId')], $dataSSLDevice);
        echo json_encode(['code' => 1, 'message' => 'Cập nhật thành công']);
    }

    public function convertCB($DeviceItem, $value, $checkDel)
    {
        $IMEI = $DeviceItem['IMEI'];
        $IsRevert = $value['IsRevert'];
        $LookupTable = isset($value['LookupTable']) ? $value['LookupTable'] : [];
        switch ($value['SensorPort']) {
            case 'AD1':
                $this->convertInNa('IN_ANALOG_5V1', $IMEI, $LookupTable, $checkDel);
                break;
            case 'GIN5':
                $this->convertInvol('IN_VOL_2_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_2_TYPE');
                break;
            case 'GIN6':
                $this->convertInvol('IN_VOL_3_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_3_TYPE');
                break;
            case 'Door':
                $this->convertInvol('IN_VOL_1_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_1_TYPE');
                break;
            case '10':
                $this->convertInvol('IN_VOL_1_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_1_TYPE');
                break;
            case '4':
                $this->convertInvol('IN_VOL_2_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_2_TYPE');
                break;
            case '5':
                $this->convertInvol('IN_VOL_3_REVERSE', $IMEI, $IsRevert, $checkDel, $value['SensorFunctionId'], 'IN_VOL_3_TYPE');
                break;
            case '8':
                $this->convertInNa('IN_ANALOG_5V1', $IMEI, $LookupTable, $checkDel);
                break;
            case '2':
                $this->convertInNa('IN_ANALOG_5V2', $IMEI, $LookupTable, $checkDel);
                break;
            default :
                return true;
        }
    }

    function convertInNa($field, $key, $LookupTable, $checkDel) {
        $dataItem = [];
        if($checkDel) {
            $this->redis_sentinel->delHS($field, $key);
        } else {
            if($LookupTable) {
                foreach ($LookupTable as $item) {
                    $dataItem[] = $item['voltage'].','.$item['oil'];
                }
            }
            $dataString = implode(';', $dataItem);
            $this->redis_sentinel->setHS($field, $key, $dataString);
        }
    }

    function convertInvol($field, $key, $IsRevert, $checkDel, $SensorFunctionId = 0, $type) {
        if($IsRevert == 0) {
            $IsRevert = 'False';
        } else {
            $IsRevert = 'True';
        }
        if($checkDel) {
            $this->redis_sentinel->delHS($field, $key);
            $this->redis_sentinel->delHS($type, $key);
        } else {
            if($SensorFunctionId == 1) {
                $this->redis_sentinel->setHS($type, $key, 1);
            } else if ($SensorFunctionId == 2) {
                $this->redis_sentinel->setHS($type, $key, 2);
            } else if($SensorFunctionId == 3) {
                $this->redis_sentinel->setHS($type, $key, 3);
            }
            $this->redis_sentinel->setHS($field, $key, $IsRevert);
        }
    }

    public function getListHistory() {
        $this->loadModel(['Mdevicesensors', 'Mvehicledevicesensors', 'Mdevices']);
        $VehicleId = $this->input->post('VehicleId');
        $ListDeviceSensor = $this->Mdevicesensors->getListBy(['devicesensors.VehicleId' => $VehicleId, 'devicesensors.StatusId' => 0]);
        if(!empty($ListDeviceSensor)) {
            for ($i = 0; $i < count($ListDeviceSensor); $i++) {
                $ListDeviceSensor[$i]['VehicleDeviceSensor'] = $this->Mvehicledevicesensors->getBy(['DeviceSensorId' => $ListDeviceSensor[$i]['DeviceSensorId']]) ;
            }
        }
        $data['TypeFunctionId'] =  $this->Mconstants->TypeFunctionId;//Loại chức năng
        $data['ListPort'] =  $this->Mconstants->ListPort;//Loại chức năng
        $data['SensorLine'] =  $this->Mconstants->SensorLine;//Dòng cảm biến
        $data['ListDeviceSensor'] = $ListDeviceSensor;
        $this->load->view('vehicle/view_list_sensor', $data);
    }

    public function viewDetailSensor() {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mdevicesensors', 'Mvehicledevicesensors', 'Mdevices']);
        $DeviceSensorId = $this->input->post('DeviceSensorId');
        $DeviceSensorItem = $this->Mdevicesensors->getDetailApi(['DeviceSensorId' => $DeviceSensorId]);
        $data['TypeFunctionId'] =  $this->Mconstants->TypeFunctionId;//Loại chức năng
        $data['ListPort'] =  $this->Mconstants->ListPort;//Loại chức năng
        $data['SensorLine'] =  $this->Mconstants->SensorLine;//Dòng cảm biến
        $DeviceSensorItem['VehicleDeviceSensor'] = $this->Mvehicledevicesensors->getBy(['DeviceSensorId' => $DeviceSensorItem['DeviceSensorId']]) ;
        $data['DeviceSensorItem'] = $DeviceSensorItem;
        //var_dump($DeviceSensorItem);die;
        $this->load->view('vehicle/view_detail_sensor', $data);
    }

    public function DeleteDeviceSensor() {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mdevicesensors', 'Mvehicledevicesensors', 'Mdevices', 'Mssldevices']);
        $DeviceSensorId = $this->input->post('DeviceSensorId');
        $DeviceSensorItem = $this->Mdevicesensors->getBy(['DeviceSensorId' => $DeviceSensorId], true);
        $listCB = $this->Mvehicledevicesensors->getBy(['DeviceSensorId' => $DeviceSensorId]);
        $this->Mdevices->updateBy(['DeviceId' => $DeviceSensorItem['DeviceId']], ['VehicleId' => 0, 'InstallationStatusId' => 1]);
        if(!empty($listCB)) {
            $DeviceItem = $this->Mdevices->getBy(['DeviceId' => $DeviceSensorItem['DeviceId']], true);
            foreach ($listCB as $value) {
                $this->convertCB($DeviceItem, $value, true);
            }
        }
        $this->Mssldevices->updateBy(['VehicleId' => $DeviceSensorItem['VehicleId']], ['DeviceId' => 0, 'DeviceStatusId' => 0, 'InstallationDate' => date('Y-m-d H:i:s')]);
        $this->Mdevicesensors->updateBy(['DeviceSensorId' => $DeviceSensorId], ['StatusId' => 0, 'EndDate' => getCurentDateTime()]);
        echo json_encode(['code' => 1, 'message' => 'Xóa thành công']);
    }

    public function showItem() {
        $this->loadModel(['Mdevicesensors', 'Mvehicledevicesensors', 'Mdevices']);
        $vehicleId = $this->input->post('VehicleId');
        $DeviceSensorItem = $this->Mdevicesensors->getDetailBy(['devicesensors.VehicleId' => $vehicleId, 'devicesensors.StatusId' => 2]);
        $data['DeviceSensorItem'] = $DeviceSensorItem;
        $data['VehicleDeviceSensor'] = !empty($DeviceSensorItem) ? $this->Mvehicledevicesensors->getBy(['DeviceSensorId' => $DeviceSensorItem['DeviceSensorId']]) : [];
        $this->load->view('vehicle/show_infor_insert', $data);
    }
}