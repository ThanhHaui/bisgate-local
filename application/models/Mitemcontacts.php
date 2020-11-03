<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitemcontacts extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "itemcontacts";
        $this->_primary_key = "ItemContactId";
    }
}