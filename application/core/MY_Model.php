<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $_table_name = '';
    protected $_primary_key = '';

    function __construct() {
        parent::__construct();
    }

    public function get($id = 0, $single = false, $orderBy = "", $select = "", $limit = 0, $offset = 0, $orderType = 'desc') {
        if(!empty($select)) $this->db->select($select);
        if ($id > 0) {
            $this->db->where($this->_primary_key, $id);
            $method = 'row_array';
        }
        elseif ($single == TRUE) $method = 'row_array';
        else {
            $method = 'result_array';
            if ($offset > 0 && $limit > 0) $this->db->limit($limit, $offset);
            elseif ($limit > 0) $this->db->limit($limit);
            if (!empty($orderBy)) $this->db->order_by($orderBy, $orderType);
        }
        return $this->db->get($this->_table_name)->$method();
    }

    public function getBy($where, $single = false, $orderBy = "", $select = "", $limit = 0, $offset = 0, $orderType = 'desc') {
        $this->db->where($where);
        return $this->get(0, $single, $orderBy, $select, $limit, $offset, $orderType);
    }

    public function getByQuery($query, $param = array()){
        if(!empty($query)) return $this->db->query($query, $param)->result_array();
        return array();
    }

    public function getListFieldValue($where, $tableField){
        $retVal = array();
        $records = $this->getBy($where, false, '', $tableField);
        foreach($records as $rd) $retVal[] = $rd[$tableField];
        return $retVal;
    }

    public function getFieldValue($where, $tableField, $defaultValue = '') {
        $query = $this->db->select($tableField)->where($where)->get($this->_table_name);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->$tableField;
        }
        return $defaultValue;
    }

    public function countRows($where) {
        $this->db->select($this->_primary_key);
        $this->db->where($where);
        $query = $this->db->get($this->_table_name);
        if($query->num_rows() > 0) return $query->num_rows();
        return 0;
    }

    public function save($data, $id = 0, $fieldNull = array()) {
        if ($id == 0) {
            foreach($fieldNull as $field){
                if(!isset($data[$field]) || empty($data[$field])){
                    $this->db->set($field, null);
                    unset($data[$field]);
                }
            }
            $this->db->insert($this->_table_name, $data);
            return $this->db->insert_id();
        }
        else {
            foreach($fieldNull as $field){
                if(!isset($data[$field]) || empty($data[$field])){
                    $this->db->set($field, null);
                    unset($data[$field]);
                }
            }
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name, $data);
            return $id;
        }
    }

    public function changeStatus($statusId, $id, $fieldName = 'StatusId', $updateUserId = 0){
        $retVal = false;
        if($statusId >= 0 && $id > 0){
            if(empty($fieldName)) $fieldName = 'StatusId';
            if($updateUserId > 0) $id =  $this->save(array($fieldName => $statusId, 'UpdateUserId' => $updateUserId, 'UpdateDateTime' => getCurentDateTime()), $id);
            else $id = $this->save(array($fieldName => $statusId), $id);
            $retVal = $id > 0;
        }
        return $retVal;
    }

    public function updateBy($where, $data) {
        $this->db->where($where);
        return $this->db->update($this->_table_name, $data);
    }

    public function delete($id) {
        if ($id > 0){
            $this->db->where($this->_primary_key, $id);
            $this->db->limit(1);
            $this->db->delete($this->_table_name);
            return true;
        }
        return false;
    }

    public function deleteMultiple($where) {
        $this->db->where($where);
        $this->db->delete($this->_table_name);
    }
}