<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvehicledevices extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "vehicledevices";
        $this->_primary_key = "VehicleDeviceId";
    }

    public function getDetailBy($where) {
        $this->db->select('users.FullName, users.PhoneNumber, users.Address, users.UserId, ssls.SSLCode, vehicledevices.SSLId,  ssls.SSLOldId,
         ssls.SSLTypeId, vehicledevices.SSLIsOld, ssls.IsModule,
                            vehicledevices.VehicleId, vehicledevices.VehicleDeviceId, devices.DeviceTypeId, devices.IMEI, vehicledevices.DeviceId, vehicledevices.SimId,  
                            vehicledevices.Comment, sims.SeriSim, devicetypes.DeviceTypeName');
        $this->db->from($this->_table_name);
        $this->db->join('devicesensors','devicesensors.VehicleDeviceId=vehicledevices.VehicleDeviceId');
        $this->db->join('sims','sims.SimId=vehicledevices.SimId');
        $this->db->join('ssls','ssls.SSLId=vehicledevices.SSLId');
        $this->db->join('devices','devices.DeviceId=vehicledevices.DeviceId');
        $this->db->join('devicetypes','devicetypes.DeviceTypeId=devices.DeviceTypeId');
        $this->db->join('users','users.UserId=vehicledevices.UserId');
        $this->db->where('vehicledevices.VehicleDeviceId =' . $where);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page, $userId){
        $queryCount = "select vehicledevices.VehicleDeviceId AS totalRow from vehicledevices {joins} where {wheres}";
        $query = "select {selects} from vehicledevices {joins} where {wheres} ORDER BY vehicledevices.CrDateTime DESC LIMIT {limits}";
        $selects = [
            'vehicledevices.CrDateTime', 'vehicledevices.CrUserId', 'vehicledevices.VehicleDeviceId',
            'devices.IMEI','vehicles.LicensePlate','users.FullName','devicesensors.VehicleId'
        ];
        $joins = [
            'devicesensors' => 'LEFT JOIN devicesensors on devicesensors.VehicleDeviceId = vehicledevices.VehicleDeviceId',
            'vehicles' => 'LEFT JOIN vehicles on vehicles.VehicleId = devicesensors.VehicleId',
            'users' => 'JOIN users on users.UserId = vehicles.UserId',
            'devices' => 'LEFT JOIN devices on devices.DeviceId = devicesensors.DeviceId',
        ];
        $wheres = array('vehicledevices.StatusId > 0');
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'devices.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'vehicles.LicensePlate like ? or users.FullName like ? or devices.IMEI like ?';
                for( $i = 0; $i < 3; $i++) $dataBind[] = "%$searchText%";
            }
        }
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }
        //search theo bộ lọc ,
        if (!empty($itemFilters) && count($itemFilters)) {
            foreach ($itemFilters as $item) {
                $filed_name = $item['field_name'];
                $conds = $item['conds'];
                //$cond[0] là điều kiện ví dụ : < > = like .....   $cons[1] và $cond[2]  là gía trị điều kiện như 2017-01-02 và 2017-01-01
                switch ($filed_name) {
                    case 'status_id':
                        $wheres[] = "devices.StatusId $conds[0] ?";
                        $dataBind[] = $conds[1];
                        break;
                    default :
                        break;
                }
            }
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{joins}', $joins_string, $queryCount);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $dataConfigTable = $this->Mconfigtables->genHtmlThTable('vehicledevice', $userId);
        $tables = $dataConfigTable['tableTh'];

        $now = new DateTime(date('Y-m-d'));
        $datas = $this->getByQuery($query, $dataBind);
        $html = '';

        for ($i = 0; $i < count($datas); $i++) {
            $html .= '<tr id="trItem_'.$datas[$i]['VehicleDeviceId'].'" class="dnd-moved trItem ">';
            for ($z = 0; $z < count($tables); $z++) {
                $displayNone = '';
                if($tables[$z]['IsActive'] == 'OFF'){
                    $displayNone = 'display:none';
                }
                $columnName = $tables[$z]['ColumnName'];
                if($columnName == 'Check'){
                    $html .= '<td style="'.$displayNone.'" class="fix_width"><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="'.$datas[$i]['VehicleDeviceId'].'"></td>';
                } else if(!empty($tables[$z]['DateTime'])){
                    $dayDiff = getDayDiff($datas[$i][$columnName], $now);
                    $crDateTime = ddMMyyyy($datas[$i][$columnName], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i');
                    $html .= '<td style="'.$displayNone.'" >'.getDayDiffText($dayDiff).$crDateTime.'</td>';
                }else if(!empty($tables[$z]['Edit']) &&  !empty($tables[$z]['IdEdit'])){
                    $DeviceCodeId = $datas[$i][$columnName] + 10000;
                    $DeviceCode = 'CTPC-'.$DeviceCodeId;
                    $html .= '<td style="'.$displayNone.'" ><a href="'.$tables[$z]['Edit'].'/'.$datas[$i]['VehicleDeviceId'].'">'.$DeviceCode.'</a></td>';
                } else if(!empty($tables[$z]['ModelsDb']) && !empty($tables[$z]['NameRelationship'])){
                    $models = $tables[$z]['ModelsDb'];
                    if($columnName == 'UserId') {
                        $this->load->model($models);
                        $data = $this->Musers->getFieldValue(array($columnName => $datas[$i]['CrUserId']), 'FullName', '');
                        $html .= '<td style="'.$displayNone.'" >'.$data.'</td>';
                    } else {
                        $html .= '<td style="'.$displayNone.'" >'.$datas[$i][$columnName].'</td>';
                    }
                } else if($columnName == 'BusinessType'){
                    $html .= '<td style="'.$displayNone.'" class="text-center"><span class="label label-default">Lắp đặt thiết bị mới Full</span></td>';
                } else {
                    $html .= '<td style="'.$displayNone.'" >'.$datas[$i][$columnName].'</td>';
                }
            }
            $html .= '</tr>';
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = array('htmlTableTh' => $dataConfigTable['htmlTableTh'], 'dataTables' => $html, 'countIsLock' => $dataConfigTable['countIsLock']);
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentDevices';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        $data['totalDataShow'] = count($datas);
        return $data;
    }
}