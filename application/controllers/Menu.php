<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Menu',
            array('scriptFooter' => array('js' => array('js/menu.js')))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'menu')) {
            $this->load->model('Mmenus');
            $data['listMenus'] = $this->Mmenus->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('menu/list', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function add(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Thêm menu',
            array('scriptFooter' => array('js' => array('js/menu_update.js')))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'menu')) {
            $this->load->view('menu/add', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function edit($menuId){
        if($menuId > 0){
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Sửa menu',
                array('scriptFooter' => array('js' => array('js/menu_update.js')))
            );
            $this->loadModel(array('Mmenus', 'Mmenuitems'));
            $menu = $this->Mmenus->get($menuId);
            if($menu) {
                if ($this->Mactions->checkAccess($data['listActions'], 'menu')) {
                    $data['menuId'] = $menuId;
                    $data['menu'] = $menu;
                    $data['listMenuItems'] = $this->Mmenuitems->getList($menuId);
                    $this->load->view('menu/edit', $data);
                }
                else $this->load->view('user/permission', $data);
            }
            else {
                $data['menuId'] = 0;
                $data['txtError'] = "Không tìm thấy menu";
            }
        }
        else redirect('menu');
    }

    public function update(){
        $user = $this->checkUserLogin(true);
        $postData = $this->arrayFromPost(array('MenuName', 'StatusId' , 'MenuPositionId'));
        if(!empty($postData['MenuName']) && $postData['StatusId'] > 0 && $postData['MenuPositionId'] > 0) {
            $menuId = $this->input->post('MenuId');
            $this->load->model('Mmenus');
            if($this->Mmenus->checkExist($postData['MenuPositionId'], $menuId)){
                echo json_encode(array('code' => -1, 'message' => "Vị trí này đã có menu"));
                die();
            }
            if ($menuId > 0) {
                $postData['UpdateUserId'] = $user['UserId'];
                $postData['UpdateDateTime'] = getCurentDateTime();
            }
            else {
                $postData['CrUserId'] = $user['UserId'];
                $postData['CrDateTime'] = getCurentDateTime();
            }

            $menuId = $this->Mmenus->save($postData, $menuId);
            if ($menuId > 0) echo json_encode(array('code' => 1, 'message' => "Cập nhật menu thành công", 'data' => $menuId));
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function changeStatus(){
        $user = $this->checkUserLogin(true);
        $menuId = $this->input->post('MenuId');
        $statusId = $this->input->post('StatusId');
        if($menuId > 0 && $statusId >= 0){
            $this->load->model('Mmenus');
            $flag = $this->Mmenus->changeStatus($statusId, $menuId, '', $user['UserId']);
            if($flag) {
                $msg = 'Xóa menu thành công';
                $statusName = '';
                if ($statusId > 0) {
                    $msg = 'Thay đổi trạng thái thành công';
                    $statusName = '<span class="' . $this->Mconstants->labelCss[$statusId] . '">' . $this->Mconstants->status[$statusId] . '</span>';
                }
                echo json_encode(array('code' => 1, 'message' => $msg, 'data' => $statusName));
            }
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function updateItem(){
        $this->checkUserLogin(true);
        $postData = $this->arrayFromPost(array('MenuId', 'ItemName', 'ItemUrl' , 'ParentItemId', 'DisplayOrder', 'MenuLevel'));
        if($postData['MenuId'] > 0 && !empty($postData['ItemName']) && $postData['DisplayOrder'] > 0 && $postData['MenuLevel'] > 0) {
            $menuItemId = $this->input->post('MenuItemId');
            $this->load->model('Mmenuitems');
            $flag = $this->Mmenuitems->update($postData, $menuItemId);
            if ($flag) echo json_encode(array('code' => 1, 'message' => "Cập nhật menu thành công", 'data' => $menuItemId));
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function deleteItem(){
        $this->checkUserLogin(true);
        $menuItemId = $this->input->post('MenuItemId');
        if($menuItemId > 0){
            $this->load->model('Mmenuitems');
            $flag = $this->Mmenuitems->delete($menuItemId);
            if ($menuItemId > 0) echo json_encode(array('code' => 1, 'message' => "Xóa menu thành công"));
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }
}