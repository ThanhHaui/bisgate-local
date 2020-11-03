<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Package extends MY_Controller
{

    public function index()
    {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Phần mềm',
            array('scriptFooter' => array('js' => array('js/package.js')))
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'package')) {
            $this->load->model('Mpackages');
            $data['listPackages'] = $this->Mpackages->getBy(array('PackageId >' => 0, 'StatusId' => STATUS_ACTIVED));
            $this->load->view('package/list', $data);
        } else $this->load->view('user/permission', $data);
    }

    public function getPackages()
    {
        $user = $this->checkUserLogin();
        $packageIds = json_decode(trim($this->input->post('PackageIds')), true);
        $searchText = $this->input->post('SearchText');
        $userId = $this->input->post('UserId');
        $isCheck = $this->input->post('IsCheck');
        $packageTypeId = $this->input->post('PackageTypeId');
        $this->load->model('Mpackages');
        $listPackages = $this->Mpackages->getPackages($packageIds, $searchText, $userId, $isCheck, $packageTypeId);
        echo json_encode(array('code' => 1, 'data' => $listPackages));
    }

    public function add()
    {
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Thêm phần mềm',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/package_update.js'))
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'package/add')) {
            $this->load->model(array('Mpackageroles','Mrolemenus'));
            $data['listRoles'] = $this->Mrolemenus->getHierachy();
            $data['listRoleMenuExits'] = $this->Mpackageroles->getRoleMenuExit();
            return $this->load->view('package/add', $data);
        } else $this->load->view('user/permission', $data);
    }

    public function edit($packageId = 0)
    {
        if ($packageId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Sửa phần mềm',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/package_update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'package/edit')) {
                $this->load->model(array('Mpackages','Mpackageroles','Mrolemenus'));
                $data['listRoles'] = $this->Mrolemenus->getHierachy();
                $data['arrayRolePackageId'] = $this->Mpackageroles->getArrayRolePackageId($packageId);
                $package = $this->Mpackages->get($packageId);
                if ($package && $package['StatusId'] == STATUS_ACTIVED) {
                    $data['packageId'] = $packageId;
                    $data['package'] = $package;
                    $data['listRoleMenuExits'] = $this->Mpackageroles->getRoleMenuExit($packageId);
                }else{
                    $data['packageId'] = 0;
                    $data['txtError'] = "Không tìm thấý trang";
                }
                return $this->load->view('package/edit', $data);
            } else $this->load->view('user/permission', $data);
        } else {
            return redirect('package');
        }
    }

    public function update()
    {
        $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('PackageName'));
        if (!empty($postData['PackageName'])) {
            $this->load->model(array('Mpackages','Mpackageroles', 'Mrolemenus'));
            $packageId = $this->input->post('PackageId');
            $packageRoles = json_decode($this->input->post('PackageRoles'), true);
            $listRoleMenuExits = array();
            if ($packageId == 0) {
                $postData['StatusId'] = STATUS_ACTIVED;
                $postData['PackageTypeId'] = 2;
                $listRoleMenuExits = $this->Mpackageroles->getRoleMenuExit();
            } else {
                $listRoleMenuExits = $this->Mpackageroles->getRoleMenuExit($packageId);
            }
            foreach($packageRoles as $r){
                if(in_array($r['RoleMenuId'], $listRoleMenuExits)) {
                    $roleName = $this->Mrolemenus->getFieldValue(array('RoleMenuId' => $r['RoleMenuId']), 'RoleMenuName', '');
                    echo json_encode(array('code' => -1, 'message' => 'Menu '.$roleName.' đã tồn tại trong gói phần mềm trước đó, vui lòng chọn lại.'));
                    die;
                }
            }
            $flag = $this->Mpackages->update($postData, $packageId, $packageRoles);
            if ($flag) {
                echo json_encode(array('code' => 1, 'message' => 'Cập nhật thành công', 'data' => $flag));
            } else echo json_encode(array("code" => 0, "message" => "Có lỗi xảy ra, vui lòng thử lại sau."));
        } else echo json_encode(array("code" => -1, "message" => "Có lỗi xảy ra, vui lòng thử lại sau."));
    }

    public function delete()
    {
        $this->checkUserLogin();
        $packageId = $this->input->post('PackageId');
        if($packageId > 0){
            $this->load->model(array('Mpackages'));
            $flag = $this->Mpackages->changeStatus(0, $packageId);
            if ($flag) {
                echo json_encode(array('code' => 1, 'message' => 'Xóa gói mở rộng thành công', 'data' => $flag));
            } else echo json_encode(array("code" => 0, "message" => "Có lỗi xảy ra, vui lòng thử lại sau."));
        } else echo json_encode(array("code" => -1, "message" => "Có lỗi xảy ra, vui lòng thử lại sau."));
    }
}
