<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitemmetadatas extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "itemmetadatas";
        $this->_primary_key = "ItemMetadataId";
    }
}