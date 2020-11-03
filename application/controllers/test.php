<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

    public function index(){
		phpinfo();
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css','vendor/plugins/datepicker/datepicker3.css')),
                'scriptFooter' => array('js' => array('js/test.js','vendor/plugins/datepicker/bootstrap-datepicker.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/test1', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function cambien1(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            '',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/cambien1.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/cambien1', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function kichhoat1(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'TH1 - Tạo SSL mới : Free 24H',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/kichhoat1.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/kichhoat1', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function kichhoat2(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'TH2 - Tạo SSL mới : Mannual',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/kichhoat2.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/kichhoat2', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function kichhoat3(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'TH3 - Tạo SSL mới : SSL CODE',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/kichhoat2.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/kichhoat3', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function kichhoat4(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'TH3 - Tạo SSL mới : SSL CODE',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/kichhoat2.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/kichhoat4', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function ketthuc(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'BƯỚC 4 - KCS VÀ KẾT THÚC',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/kichhoat2.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/ketthuc', $data);
        }
        else $this->load->view('user/permission', $data);
    }
    public function viewid(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Trang view ID chi tiết xem lại | Không sửa',
            array(
                'scriptHeader' => array('css' => array('css/test.css')),
                'scriptFooter' => array('js' => array('js/kichhoat2.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'group')) {
            $this->load->model('Mgroups');
            $data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('test/viewid', $data);
        }
        else $this->load->view('user/permission', $data);
    }
}
