<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdevicesensors extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = "devicesensors";
        $this->_primary_key = "DeviceSensorId";
    }

    public function getDetailBy($where) {
        $this->db->select('vehicles.LicensePlate, devices.DeviceCodeId, devices.DeviceId, devicetypes.DeviceTypeId,
        devicesensors.DeviceSensorId,devicesensors.BeginDate, devicetypes.DeviceTypeName, devicesensors.Comment, sims.SeriSim,
        devicesensors.CrDateTime, devices.DeviceCodeId, devicesensors.Comment, users.FullName, devicesensors.CrDateTime');
        $this->db->from($this->_table_name);
        $this->db->join('vehicles','vehicles.VehicleId=devicesensors.VehicleId');
        $this->db->join('users','devicesensors.CrUserId=users.UserId');
        $this->db->join('devices','devices.DeviceId=devicesensors.DeviceId');
        $this->db->join('devicetypes','devicetypes.DeviceTypeId=devices.DeviceTypeId');
        $this->db->join('devicesims','devicesims.DeviceSensorId=devicesensors.DeviceSensorId', 'left');
        $this->db->join('sims','devicesims.SimId=sims.SimId', 'left');
        $this->db->order_by('devicesensors.EndDate', 'DESC');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getListBy($where) {
        $this->db->select('vehicles.LicensePlate, devices.DeviceCodeId, devicetypes.DeviceTypeId, 
        devicesensors.DeviceSensorId,devicesensors.BeginDate, devicesensors.EndDate, devicetypes.DeviceTypeName, devicesensors.Comment, sims.SeriSim,
        devicesensors.CrDateTime, devices.DeviceCodeId, devicesensors.Comment, users.FullName, devicesensors.CrDateTime');
        $this->db->from($this->_table_name);
        $this->db->join('vehicles','vehicles.VehicleId=devicesensors.VehicleId');
        $this->db->join('users','devicesensors.CrUserId=users.UserId');
        $this->db->join('devices','devices.DeviceId=devicesensors.DeviceId');
        $this->db->join('devicetypes','devicetypes.DeviceTypeId=devices.DeviceTypeId');
        $this->db->join('devicesims','devicesims.DeviceSensorId=devicesensors.DeviceSensorId', 'left');
        $this->db->join('sims','devicesims.SimId=sims.SimId', 'left');
        $this->db->order_by('DeviceSensorId', 'DESC');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDetailApi($where) {
        $this->db->select('vehicles.LicensePlate, devices.DeviceCodeId, devicetypes.DeviceTypeId,
        devicesensors.DeviceSensorId,devicesensors.BeginDate, devicetypes.DeviceTypeName, devicesensors.Comment, 
        devicesensors.CrDateTime, devices.DeviceCodeId, devicesensors.Comment, users.FullName, users.Address, users.PhoneNumber, users.PhoneNumber, users.UserId, devicesensors.CrDateTime');
        $this->db->from($this->_table_name);
        $this->db->join('vehicles','vehicles.VehicleId=devicesensors.VehicleId');
        $this->db->join('users','vehicles.UserId=users.UserId');
        $this->db->join('devices','devices.DeviceId=devicesensors.DeviceId');
        $this->db->join('devicetypes','devicetypes.DeviceTypeId=devices.DeviceTypeId');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
}