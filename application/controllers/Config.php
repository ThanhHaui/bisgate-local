<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller {

	public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Cấu hình chung',
			array('scriptFooter' => array('js' => array('ckeditor/ckeditor.js', 'js/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config')) {
            $this->load->model('Mconfigs');
			$data['listConfigs'] = $this->Mconfigs->getListMap();
			$this->load->view('config/general', $data);
		}
		else $this->load->view('user/permission', $data);
	}

    public function home(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Cấu hình trang chủ',
            array('scriptFooter' => array('js' => array('ckeditor/ckeditor.js', 'js/config.js')))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'config/home')) {
            $this->load->model('Mconfigs');
            $data['listConfigs'] = $this->Mconfigs->getListMap(2);
            $this->load->view('config/home', $data);
        }
        else $this->load->view('user/permission', $data);
    }
}
