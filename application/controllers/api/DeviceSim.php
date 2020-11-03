<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceSim extends MY_Controller
{
    public function __construct($params = array())
    {
        parent::__construct();
        $this->load->library('redis_sentinel');
    }

    public function update() {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mdevices', 'Msims', 'Mdevicesims']);
        $DeviceId = $this->input->post('DeviceId');
        $SimId = $this->input->post('SimId');
        $dataSave = [
            'DeviceId' => $DeviceId,
            'SimId' => $SimId,
            'BeginDate' => getCurentDateTime(),
            'StatusId' => 2,
            'CrUserId' => $user['StaffId']
        ];
        $checkSim = $this->Mdevices->getBy(['SimId' => $SimId, 'StatusId' => 2]);
        if(!empty($checkSim)) {
            echo json_encode(['code' => 0, 'message' => 'Sim này đã được gán trên thiết bị khác']);
            die;
        }
        $this->Mdevices->updateBy(['DeviceId' => $DeviceId], ['SimId' => $SimId]);
        $DeviceSimId = $this->Mdevicesims->save($dataSave);
        if($DeviceSimId) {
            echo json_encode(['code' => 1, 'message' => 'Thay sim thành công', 'DeviceSimId' => $DeviceSimId]);
        } else {
            echo json_encode(['code' => 0, 'message' => 'Có lỗi xảy ra trong quá trình thực hiện']);
        }
    }

    public function delete() {
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Mdevices', 'Msims', 'Mdevicesims']);
        $DeviceSimId = $this->input->post('DeviceSimId');
        $DeviceSimItem = $this->Mdevicesims->getBy(['DeviceSimId' => $DeviceSimId], true);
        if(!empty($DeviceSimItem)) {
            $this->Mdevices->updateBy(['DeviceId' => $DeviceSimItem['DeviceId']], ['SimId' => 0]);
        }
        $this->Mdevicesims->updateBy(['DeviceSimId' => $DeviceSimId], ['StatusId' => 0, 'EndDate' => getCurentDateTime()]);
        echo json_encode(['code' => 1, 'message' => 'Tháo sim thành công']);
    }

    public function getListHistory() {
        $this->loadModel(['Mdevices', 'Msims', 'Mdevicesims']);
        $DeviceId = $this->input->post('DeviceId');
        $ListHistory = $this->Mdevicesims->getListBy(['devicesims.DeviceId' => $DeviceId, 'devicesims.StatusId' => 0]);
        $telcoIds = $this->Mconstants->telcoIds;
        for($i = 0; $i < count($ListHistory); $i++) {
            $ListHistory[$i]['SimTypeId'] = isset($telcoIds[$ListHistory[$i]['SimTypeId']]) ? $telcoIds[$ListHistory[$i]['SimTypeId']] : '';
        }
        $this->load->view('device/show_history', ['ListHistory' => $ListHistory]);
    }
}