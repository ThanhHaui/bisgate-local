<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musercomments extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "usercomments";
        $this->_primary_key = "UserCommentId";
    }
}