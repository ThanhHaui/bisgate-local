<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mssldevices extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "ssldevices";
        $this->_primary_key = "SSLDeviceId";
    }

    public function getList($searchText, $userId) {
        $query = "select {selects} from ssldevices {joins} where {wheres} ORDER BY ssldevices.SSLDeviceId DESC";
        $selects = [
            'ssldevices.*'
        ];
        $joins = [

        ];
        $wheres = array('ssldevices.SSLStatusId > 1 AND ssldevices.UserId = '.$userId);
        $dataBind = [];
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'ssldevices.CrDateTime like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'ssldevices.LicensePlate like ? or ssldevices.GroupList like ? or ssldevices.VehicleTypeName like ? ';
                for( $i = 0; $i < 3; $i++) $dataBind[] = "%$searchText%";
            }
        }
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }

        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $data = $this->getByQuery($query, $dataBind);
        return $data;
    }

}