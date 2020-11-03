<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdevicesims extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = "devicesims";
        $this->_primary_key = "DeviceSimId";
    }

    public function getListBy($where) {
        $this->db->select('devicesims.*, sims.PhoneNumber, sims.SeriSim,sims.SimTypeId');
        $this->db->from($this->_table_name);
        $this->db->join('sims','sims.SimId=devicesims.SimId');
        $this->db->order_by('devicesims.DeviceSimId', 'DESC');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getItemBy($where) {
        $this->db->select('devicesims.*, sims.PhoneNumber, sims.SeriSim, sims.SimTypeId');
        $this->db->from($this->_table_name);
        $this->db->join('sims','sims.SimId=devicesims.SimId');
        $this->db->order_by('devicesims.DeviceSimId', 'DESC');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
}