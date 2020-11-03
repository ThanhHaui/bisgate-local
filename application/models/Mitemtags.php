<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitemtags extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "itemtags";
        $this->_primary_key = "ItemTagId";
    }

    public function update($postData){
        $itemTagId = $this->getFieldValue($postData, 'ItemTagId', 0);
        if($itemTagId == 0) $this->save($postData);
    }

}