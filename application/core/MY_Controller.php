<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Bangkok');
//        $user = $this->Mstaffs->get(1);$this->session->set_userdata('user', $user);
    }

    protected function commonData($user, $title, $data = array()){
        $data['user'] = $user;
        $data['title'] = $title;
        $data['listActions'] = $this->Mactions->getByUserId($user);
        //$data['listProductTypes'] = $this->Mproducttypes->getBy(array('StatusId' => STATUS_ACTIVED));
        return $data;
    }

    protected function checkUserLogin($isApi = false){
        // $userName = $this->session->userdata('StaffName');
        // $userPass = $this->session->userdata('StaffPass');
        // $user = $this->Mstaffs->login($userName, $userPass);
        // $this->session->unset_userdata('user');
        // $this->session->set_userdata('user', $user);
        $user = $this->session->userdata('user');
        if($user){
            // $statusId = $this->Mstaffs->getFieldValue(array('StaffId' => $user['StaffId']), 'StatusId', 0);
            if($user['StatusId'] == STATUS_ACTIVED){
                // if(empty($user['Avatar'])) $user['Avatar'] = NO_IMAGE;
                return $user;
            } 
            else{
                $fields = array('user', 'configs');
                foreach($fields as $field) $this->session->unset_userdata($field);
                if($isApi) echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
                else redirect('admin?redirectUrl='.current_url());
                die();
            }
        }
        else{
            if($isApi) echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
            else redirect('admin?redirectUrl='.current_url());
            die();
        }
    }

    protected function loadModel($models = array()){
        foreach($models as $model) $this->load->model($model);
    }

    protected function arrayFromPost($fields) {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->post($field));
        return $data;
    }

    protected function arrayFromGet($fields) {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->get($field));
        return $data;
    }

    //api mobile
    protected function openAllCors(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Content-Type: application/json');
    }

    protected function getDataRequest(){
        return @json_decode(file_get_contents('php://input'), true);
    }

    protected function errorOutput($message = ERROR_COMMON_MESSAGE){
        echo json_encode(array('code' => 0, 'message' => $message));
    }

    protected function successOutput($data = array(), $message = ''){
        echo json_encode(array('code' => 1, 'message' => $message, 'data' => $data));
    }


    protected function sendMail($emailFrom, $nameFrom, $emailTo, $subject, $messageBody, $files = array()){
        require_once APPPATH.'third_party/swiftmailer/autoload.php';
        $transport = (new Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl'))
            ->setUsername('lines.f2016@gmail.com')
            ->setPassword('bjizsvtgimtvjsmj')
        ;
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($subject))
            ->setFrom([$emailFrom => $nameFrom])
            ->setTo($emailTo)
            ->setBody($messageBody)
            ->setContentType("text/html");
        if(!empty($files)) {
            foreach ($files as $file) {
                $message->attach(
                    Swift_Attachment::fromPath($file['url'])->setFilename($file['name'])
                );
            }
        }
        return $mailer->send($message);
    }

}