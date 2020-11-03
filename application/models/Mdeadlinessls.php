<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdeadlinessls extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "deadlinessls";
        $this->_primary_key = "DeadlineSSLId";
    }

    public function getListSSLActive($sslId = 0){
        $query = " SELECT deadlines.*, ssls.VehicleId FROM deadlines 
            INNER JOIN deadlinessls ON  deadlinessls.DeadlineId = deadlines.DeadlineId
            LEFT JOIN ssls ON ssls.SSLId =  deadlinessls.SSLId
                    WHERE deadlines.DeadlineStatusId = ? AND deadlinessls.SSLId = ? ORDER BY deadlines.UpdateDateTime ASC";
        return $this->getByQuery($query, array(STATUS_ACTIVED, $sslId));
    }
    public function getListSSLDetailActive($sslId = 0){
        $query = " SELECT deadlinedetails.*, deadlines.DeadlineCode, deadlines.UpdateDateTime, ssls.VehicleId 
            FROM deadlines INNER JOIN deadlinessls ON  deadlinessls.DeadlineId = deadlines.DeadlineId
            INNER JOIN deadlinedetails ON  deadlinedetails.DeadlineId = deadlines.DeadlineId
            LEFT JOIN ssls ON ssls.SSLId =  deadlinessls.SSLId
            WHERE deadlines.DeadlineStatusId = ? AND deadlinessls.SSLId = ? ORDER BY deadlines.UpdateDateTime ASC";
        return $this->getByQuery($query, array(STATUS_ACTIVED, $sslId));
    }
}