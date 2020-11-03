<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redis extends MY_Controller {

    public function __construct($params = array())
    {
        parent::__construct();
        $this->load->library('redis_sentinel');
    }

	public function index(){
        $this->redis_sentinel->setHS('h', 'key1', 'true');
        $test = $this->redis_sentinel->delHS('h', 'key1');
        $test = $this->redis_sentinel->getAllKey();
        var_dump($test);die;
	}

	public function setRedis() {
	    $IMEI = $this->input->get('imei') ? $this->input->get('imei') : '862462032411992';
        $key = $this->input->get('key') ? $this->input->get('key') : 'LOGIN';
        $this->redis_sentinel->setHS($key, $IMEI, '1');
    }

    public function getRedis() {
        $IMEI = $this->input->get('imei') ? $this->input->get('imei') : '862462032411992';
        $key = $this->input->get('key') ? $this->input->get('key') : 'LOGIN';
        $redis = $this->redis_sentinel->getHS($key, $IMEI);
        var_dump($redis);
    }
}