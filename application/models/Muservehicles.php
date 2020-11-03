<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muservehicles extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = "uservehicles";
        $this->_primary_key = "UserVehicleId";
    }

    public function getListBy($where) {
        $this->db->select('uservehicles.*, users.PhoneNumber, users.TaxCode, users.FullName');
        $this->db->from($this->_table_name);
        $this->db->join('users','users.UserId=uservehicles.UserId');
        $this->db->order_by('uservehicles.UserVehicleId', 'DESC');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getItemBy($where) {
        $this->db->select('uservehicles.*, users.PhoneNumber, users.TaxCode, users.FullName');
        $this->db->from($this->_table_name);
        $this->db->join('users','users.UserId=uservehicles.UserId');
        $this->db->order_by('uservehicles.UserVehicleId', 'DESC');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getListVehicleUser($userId){
        $query = " SELECT vehicles.VehicleId,vehicles.LicensePlate, ssls.SSLStatusId FROM uservehicles 
        JOIN vehicles ON uservehicles.VehicleId =  vehicles.VehicleId
        JOIN ssls ON ssls.VehicleId =  vehicles.VehicleId
        WHERE uservehicles.StatusId = ? AND uservehicles.UserId = ? ORDER BY uservehicles.UserVehicleId ASC";
        return $this->getByQuery($query, array(STATUS_ACTIVED, $userId));
    }
}