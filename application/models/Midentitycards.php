<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Midentitycards extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "identitycards";
        $this->_primary_key = "IdentityCardId";
    }
}