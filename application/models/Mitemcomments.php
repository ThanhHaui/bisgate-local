<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mitemcomments extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "itemcomments";
        $this->_primary_key = "ItemCommentId";
    }
}