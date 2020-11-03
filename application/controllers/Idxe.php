<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Idxe extends MY_Controller {

    public function thongtinxe(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css','vendor/plugins/datepicker/datepicker3.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                'scriptFooter' => array('js' => array('js/thongtinxe.js','vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('idxe/thongtinxe', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function themcambien(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('idxe/themcambien', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function thaythietbi(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('idxe/thaythietbi', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function thayphutung(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/thongtinxe.js','vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('idxe/thayphutung', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function kiemtraf5(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/thongtinxe.js','vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('idxe/kiemtraf5', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function idthietbi(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css','vendor/plugins/datepicker/datepicker3.css','vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                'scriptFooter' => array('js' => array('js/thongtinxe.js','vendor/plugins/datepicker/bootstrap-datepicker.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('idxe/idthietbi', $data);
        }
        else $this->load->view('user/permission', $data);
    }
}

