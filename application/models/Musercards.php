<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musercards extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "usercards";
        $this->_primary_key = "UserCardId";
    }

    public function getRFIDs($userId){
        $retVal = array();
        $tags = $this->getByQuery('SELECT RFID FROM usercards WHERE UserId = ?', array($userId));
        foreach($tags as $tag) $retVal[] = $tag['RFID'];
        return $retVal;
    }
}