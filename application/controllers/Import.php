<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MY_Controller {

    public function viewVehicle(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Import Danh sách xe',
            array(
                'scriptHeader' => array('css' => array()),
                'scriptFooter' => array('js' => array())
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'import/viewVehicle')) {
            $this->load->view('import/view_vehicle', $data);
        } else $this->load->view('user/permission', $data);
    }

    public function importExcelVehicle(){
        $this->load->helper('common');
        $fileUrl = 'assets\uploads\files\2020-08-13\5f34ba5e05fa0.xlsx';

        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            // $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                for ($row = 2; $row <= $countRows; $row++) {
                    $fullName = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
                    if(!empty($fullName)){
                        $flag = $this->db->insert('test', array('name' => $fullName));
                        if($flag) {
                            echo 'Output save Success ==> '.$row.' ==>'.$fullName.PHP_EOL;
                            usleep(200000);
                        } else{
                            $message = $fileUrl." ====> ".$row." ====>".$fullName;
                            log_message('error', $message);
                            echo 'Error save ==> '.$row.' ==>'.$fullName.PHP_EOL;
                        } 
                    }else{
                        echo 'Data Empty'.PHP_EOL;
                    } 
                }
            } else echo 'No data'.PHP_EOL;
        } else echo 'File Error'.PHP_EOL;
    }

    public function agent(){
        $fileUrl = 'assets\import\IMPORT_BISGATE_V2_DATA_CHUAN\DS_DAI_LY.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                $this->load->model('Mstaffs');
                for ($row = 2; $row <= $countRows; $row++) {
                    $staffTypeId = 2; // Công ty
                    $fullName = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $staffCode = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $shortName = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $staffId = $this->Mstaffs->getFieldValue(array('StaffCode' => $staffCode, 'StaffTypeId' => $staffTypeId), 'StaffId', 0);
                    $agentLevelId  = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
                    
                    if(!empty($fullName) && !empty($staffCode) && !empty($shortName)) {
                        $managementUnit = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
                       
                        $managementUnitId = 1;
                        if($managementUnit != 'BISTECH') {
                            $managementUnitId = $this->Mstaffs->getFieldValue(array('StaffCode' => $managementUnit), 'StaffId', 0);
                        }
                        $contactName = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
                        $positionName = trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
                        $phoneNumber = trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
                        $contactUsers = array();
                        if(!empty($contactName)) {
                            $contactUsers[] = array(
                                'ContactName' => $contactName,
                                'PositionName' => $positionName,
                                'PhoneNumber' =>$phoneNumber
                            );
                        }
                        $phoneNumber = trim($objWorksheet->getCellByColumnAndRow(11, $row)->getValue());
                        $htProvinceId = trim($objWorksheet->getCellByColumnAndRow(12, $row)->getValue());
                        $htAddress = trim($objWorksheet->getCellByColumnAndRow(14, $row)->getValue());
                        $note = trim($objWorksheet->getCellByColumnAndRow(15, $row)->getValue());
                        
                        $postData = array(
                            'StaffTypeId' => $staffTypeId,
                            'FullName' => $fullName,
                            'StaffName' => $shortName,
                            'StaffCode' => $staffCode,
                            'ShortName' => $shortName,
                            'NickName' => $shortName,
                            'CountryId' => 232, // Việt Nam
                            'PhoneNumber' => $phoneNumber,
                            'AgentLevelId' => $agentLevelId,
                            'ManagementUnitId' => $managementUnitId,
                            'HTProvinceId' => $htProvinceId,
                            'HTAddress' => $htAddress,
                            'Note' => $note,
                            'StaffPass' => md5('123456'),
                            'StatusId' => STATUS_ACTIVED,
                            'CrStaffId' => 1, // admin dinh_thái mặc định có sẵn trong db
                            'CrDateTime' => getCurentDateTime()
                        );
                        $provinceIds = array();
                        $tagNames = array();
                        $staff = array(
                            'StaffId' => 1
                        );
                        $flag = $this->Mstaffs->update($postData, $staffId, array(), array(), array(), array(), $tagNames, $staffTypeId, $contactUsers, $provinceIds, $staff, false);
                        if($flag){
                            echo 'Output save Success ==> '.$row.' ==>'.$fullName.PHP_EOL;
                            usleep(50000);
                        }else{
                            $message = $fileUrl." ==Lưu không thành công==> ".$row."===Data Return Error===>".$postData;
                            log_message('error', $message);
                            echo 'Lưu không thành công ==> '.$row.PHP_EOL;
                        }
                    } else {
                        $message = $fileUrl." ==Lỗi thiếu dữ liệu==> ".$row." ==companyName==>".$fullName.'==staffCode==>'.$staffCode.'==shortName==>'.$shortName;
                        log_message('error', $message);
                        echo 'Error Lỗi thiếu dữ liệu ==> '.$row.PHP_EOL;
                    }
                }
            } else echo 'No data'.PHP_EOL;
        } else echo 'File Error'.PHP_EOL;
    }

    public function customer(){
        $fileUrl = 'assets\import\IMPORT_BISGATE_V2_DATA_CHUAN\DS_KHACH_HANG.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                for ($row = 2; $row <= $countRows; $row++) {
                    $customerTypeId = trim($objWorksheet->getCellByColumnAndRow(12, $row)->getValue());
                    $codeUser = trim($objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
                   
                    if(!empty($codeUser) && intval($customerTypeId) > 0) {
                        $userId = $this->Musers->getFieldValue(array('CodeUser' => $codeUser, 'CustomerTypeId' => $customerTypeId), 'UserId', 0);
                        $crDateTime = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue())));
                        $crUserId = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $fullName = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
                        $userName = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
                        $phoneNumber = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
                        $email = trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
                        $address = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
                        $provinceId = trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
                        $taxCode = trim($objWorksheet->getCellByColumnAndRow(13, $row)->getValue());
                        $agentCode = trim($objWorksheet->getCellByColumnAndRow(16, $row)->getValue());
                        $agentLevelId = 0;
                        $managementUnitId = 0;
                        $agent = $this->Mstaffs->getBy(array('StaffCode' => $agentCode));
                        if(count($agent) > 0){
                            $agentLevelId = $agent[0]['AgentLevelId'];
                            $managementUnitId = $agent[0]['StaffId'];
                        }else {
                            $agentLevelId = 1;
                            $managementUnitId = 1;
                        }
                        $countryId = 232;
                        $contactUsers = array();
                        $contactName = trim($objWorksheet->getCellByColumnAndRow(14, $row)->getValue());
                        if(!empty($contactName)) {
                            $contactUsers[] = array(
                                'ContactName' => $contactName,
                            );
                        }

                        $postData = array(
                            'CustomerTypeId' => $customerTypeId,
                            'CodeUser' => $codeUser,
                            'UserName' => $codeUser,
                            'CrDateTime' => $crDateTime,
                            'CrUserId' => $crUserId,
                            'FullName' => $fullName,
                            'UserName' => $userName,
                            'GenderId' => 0,
                            'TaxCode' => $taxCode,
                            'PhoneNumber' => $phoneNumber,
                            'Email' => $email,
                            'Address' => $address,
                            'CountryId' => $countryId,
                            'ProvinceId' => $provinceId,
                            'AgentLevelId' => $agentLevelId,
                            'ManagementUnitId' => $managementUnitId,
                            'UserPass' => md5('123456'),
                            'StatusId' => STATUS_ACTIVED,
                            'RoleId' => 1,
                            'UserLevelId' => 1,
                        );
                        $user = array(
                            'StaffId' => 1
                        );
                        $flag = $this->Musers->update($postData, $userId, false, array(), $contactUsers, $user,array(),array(), array());
                        if($flag){
                            echo 'Output save Success ==> '.$row.' ==>'.$codeUser.PHP_EOL;
                            usleep(90000);
                        }else{
                            $message = $fileUrl." ==Lưu không thành công==> ".$row."===Data Return Error===>".$postData;
                            log_message('error', $message);
                            echo 'Lưu không thành công ==> '.$row.PHP_EOL;
                        }
                    } else {
                        $message = $fileUrl." ==Lỗi thiếu dữ liệu==> ".$row." ==codeUser==>".$codeUser;
                        log_message('error', $message);
                        echo 'Error Lỗi thiếu dữ liệu ==> '.$row.PHP_EOL;
                    }
                    
                }
            } else echo 'No data'.PHP_EOL;
        } else echo 'File Error'.PHP_EOL;
    }

    public function vehicle(){
        $fileUrl = 'assets\import\IMPORT_BISGATE_V2_DATA_CHUAN\DS_XE.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                $this->load->model('Mvehicles');
                for ($row = 2; $row <= $countRows; $row++) {
                    $licensePlate = trim($objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
                    if(!empty($licensePlate)) {
                        $crDateTime = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue())));
                        $vehicleTypeId = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
                        if(empty($vehicleTypeId)) $vehicleTypeId = 0;
                        $purposeId = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
                        $userCustomer = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
                        $customerId = $this->Musers->getFieldValue(array('CodeUser' => $userCustomer), 'UserId', 0);
                        if($customerId > 0) {
                            if(!empty($licensePlate)) {
                                $vehicleId = $this->Mvehicles->getFieldValue(array('LicensePlate' => $licensePlate), 'VehicleId', 0);
                                $postData = array(
                                    'LicensePlate' => $licensePlate,
                                    'VehicleTypeId' => $vehicleTypeId,
                                    'PurposeId' => $purposeId,
                                    'CrDateTime' => $crDateTime,
                                    'CrUserId' => 1,
                                    'VehicleStatusId' => STATUS_ACTIVED,
                                    'UserId' => $customerId
                                );

                                $flag = $this->Mvehicles->save($postData, $vehicleId);
                                if($flag){
                                    echo 'Output save Success ==> '.$row.' ==>'.$licensePlate.PHP_EOL;
                                    usleep(9000);
                                }else{
                                    $message = $fileUrl." ==Lưu không thành công==> ".$row."===Data Return Error===>".$postData;
                                    log_message('error', $message);
                                    echo 'Lưu không thành công ==> '.$row.PHP_EOL;
                                }
                            } else {
                                $message = $fileUrl." ==No License Plate==> ".$row."===Data Return Error===>".$licensePlate;
                                log_message('error', $message);
                                echo 'No License Plate ==> '.$row."===> ".$licensePlate.PHP_EOL;
                            }
                        } else {
                            $message = $fileUrl." ==No Data Customer In system==> ".$row."===Data Return Error===>".$userCustomer;
                            log_message('error', $message);
                            echo 'No Data Customer In system ==> '.$row."==userCustomer==> ".$userCustomer.PHP_EOL;
                        }
                    } 
                }
            } else echo 'No data'.PHP_EOL;
        } else echo 'File Error'.PHP_EOL;
    }

    public function device(){
        $fileUrl = 'assets\import\IMPORT_BISGATE_V2_DATA_CHUAN\DS_THIET_BI_IMPORT.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                $this->load->model(array('Mdevices', 'Mvehicles', 'Mdevicesensors'));
                for ($row = 2; $row <= $countRows; $row++) {
                    $crDateTime = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue())));
                   
                    $IMEI = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $deviceCodeId = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $deviceTypeId = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue());
                    $licensePlate = trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
                    $dateOfInstallation = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue())));
                    // var_dump("===IMEI===".$IMEI,"===deviceCodeId===".$deviceCodeId,"===licensePlate===".$licensePlate);
                    if(!empty($licensePlate) && !empty($IMEI) && !empty($deviceCodeId)) {
                        $vehicleId = $this->Mvehicles->getFieldValue(array('LicensePlate' => $licensePlate), 'VehicleId', 0);
                        if($vehicleId > 0) {
                            $deviceId = $this->Mdevices->getFieldValue(array('IMEI' => $IMEI), 'DeviceId', 0);
                            $userId = $this->Mvehicles->getFieldValue(array('VehicleId' => $vehicleId), 'UserId', 0);
                            $postData = array(
                                'IMEI' => $IMEI,
                                'CrDateTime' => $crDateTime,
                                'DeviceCodeId' => $deviceCodeId,
                                'DeviceTypeId' => $deviceTypeId,
                                'VehicleId' => $vehicleId,
                                'DateOfInstallation' => $dateOfInstallation,
                                'CrUserId' => 1,
                                'StatusId' => STATUS_ACTIVED,
                                'InstallationStatusId' => STATUS_ACTIVED,
                                'UserId' => $userId,
                            );
                            $flag = $this->Mdevices->save($postData, $deviceId);
                            if($flag){
                                $dataDeviceSensor = array(
                                    'VehicleId' => $vehicleId,
                                    'DeviceId' => $flag,
                                    'StatusId' => STATUS_ACTIVED,
                                    'BeginDate' => $dateOfInstallation,
                                    'EndDate' => NULL,
                                    'Comment' => NULL,
                                    'CrUserId' => 1,
                                    'CrDateTime' => getCurentDateTime()
                                );

                                $deviceSensorId = $this->Mdevicesensors->getFieldValue(array('VehicleId' => $vehicleId, 'DeviceId' => $flag), 'DeviceSensorId', 0);
                                $flag2 = $this->Mdevicesensors->save($dataDeviceSensor, $deviceSensorId);
                                echo 'Output save Success ==> '.$row.' ==>'.$IMEI.PHP_EOL;
                                usleep(9000);
                            }else{
                                $message = $fileUrl." ==Lưu không thành công==> ".$row."===Data Return Error===>".$postData;
                                log_message('error', $message);
                                echo 'Lưu không thành công ==> '.$row.PHP_EOL;
                            }
                        } else {
                            $message = $fileUrl." ==Lỗi Biển số xe không tồn tại trong hệ thống==> ".$row." ==LicensePlate==>".$licensePlate;
                        log_message('error', $message);
                        echo 'Error Not Exit LicensePlate ==> '.$row." ==LicensePlate==>".$licensePlate.PHP_EOL;
                        }
                    } else {
                        $message = $fileUrl." ==Lỗi thiếu dữ liệu==> ".$row." ==licensePlate==>".$licensePlate."==IMEI==>".$IMEI."==deviceCodeId==>".$deviceCodeId;
                        log_message('error', $message);
                        echo 'Error Lỗi thiếu dữ liệu ==> '.$row.PHP_EOL;
                    }
                }
            } else echo 'No data'.PHP_EOL;
            
        } else echo 'File Error'.PHP_EOL;
    }

    public function sim() {
        $fileUrl = 'assets\import\IMPORT_BISGATE_V2_DATA_CHUAN\DS SIM -IMPORT IT.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                $this->load->model(array('Mdevices', 'Msims'));
                for ($row = 2; $row <= $countRows; $row++) {
                    $crDateTime = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue())));
                  
                    $phoneNumber = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $seriSim = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $simTypeId = trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
                    $deviceCodeId = trim($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
                    $dateOfInstallation = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(9, $row)->getValue())));
                    if(!empty($deviceCodeId)) {
                        if(!empty($phoneNumber) && !empty($seriSim)) {
                            $deviceId = $this->Mdevices->getFieldValue(array('DeviceCodeId' => $deviceCodeId), 'DeviceId', 0);
                            if($deviceId > 0) {
                                $simId = $this->Msims->getFieldValue(array('PhoneNumber' => $phoneNumber, 'SeriSim' => $seriSim), 'SimId', 0);
                                $postData = array(
                                    'PhoneNumber' => $phoneNumber,
                                    'SeriSim' => $seriSim,
                                    'SimManufacturerId' => 1,
                                    'SimTypeId' => $simTypeId,
                                    'CrDateTime' => $crDateTime,
                                    'DateOfInstallation' => $dateOfInstallation,
                                    'CrUserId' => 1,
                                    'SimStatusId' => STATUS_ACTIVED

                                );

                                $flag = $this->Msims->save($postData, $simId);
                                if($flag){
                                    $this->Mdevices->save(array('SimId' => $simId), $deviceId);
                                    echo 'Output save Success ==> '.$row.' ==>'.$phoneNumber.PHP_EOL;
                                    usleep(50000);
                                }else{
                                    $message = $fileUrl." ==Lưu không thành công==> ".$row."===Data Return Error===>".$postData;
                                    log_message('error', $message);
                                    echo 'Lưu không thành công ==> '.$row.PHP_EOL;
                                }

                            } else {
                                $message = $fileUrl." ==Not exit Device Id (deviceCodeId)==> ".$row."===Data Return Error===>".$deviceCodeId;
                                log_message('error', $message);
                                echo 'No Device Code Id ==> '.$row."===> ".$deviceCodeId.PHP_EOL;
                            }
                        } else {
                            $message = $fileUrl." ==No Data ==> ".$row."===Data Return Error==PhoneNumber=>".$phoneNumber.'==seriSim===>'.$seriSim;
                            log_message('error', $message);
                            echo 'No PhoneNumber && seriSim ==> '.$row."===> ".$phoneNumber.'====>'.$seriSim.PHP_EOL;
                        }
                    } else {
                        $message = $fileUrl." ==No Device Code Id==> ".$row."===Data Return Error===>".$deviceCodeId;
                        log_message('error', $message);
                        echo 'No Device Code Id ==> '.$row."===> ".$deviceCodeId.PHP_EOL;
                    }
                }
            } else echo 'No data'.PHP_EOL;
        } else echo 'File Error'.PHP_EOL;
    }

    public function ssl(){
        $fileUrl = 'assets\import\IMPORT_BISGATE_V2_DATA_CHUAN\DANH_SACH_SSL.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                $this->load->model(array('Mssls', 'Musers', 'Mvehicles'));
                for ($row = 2; $row <= $countRows; $row++) {
                    $customerCode = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $customerId = $this->Musers->getFieldValue(array('CodeUser' => $customerCode), 'UserId', 0);
                    if($customerId > 0) {
                        $licensePlate = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
                        $vehicleId = $this->Mvehicles->getFieldValue(array('LicensePlate' => $licensePlate), 'VehicleId', 0);
                        if($vehicleId > 0) {
                            $packageId  = 1;
                            $crDateTime = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(5, $row)->getValue())));
                            $activeExpiryStartDate = getCurentDateTime();
                            $activeExpiryEndDate = date('Y-m-d 23:59:59', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(6, $row)->getValue())));
                            $crUserId = 1;
                            $sslStatusId =  trim($objWorksheet->getCellByColumnAndRow(10, $row)->getValue());
                            $sslId = $this->Mssls->getFieldValue(array('UserId' => $customerId, 'VehicleId' => $vehicleId), 'SSLId', 0);
                            $statusUpdateTime = intval($sslStatusId) == 5 ? $activeExpiryStartDate : NULL; 
                            $postData = array(
                                'UserId' => $customerId,
                                'VehicleId' => $vehicleId,
                                'SSLStatusId' => $sslStatusId,
                                'StatusUpdateTime' =>  $statusUpdateTime,
                                'PackageId' => $packageId,
                                'ActiveExpiryStartDate' => $activeExpiryStartDate,
                                'ActiveExpiryEndDate' => $activeExpiryEndDate,
                                'SSLTypeId' => 0,
                                'CrUserId' => $crUserId,
                                'CrDateTime' => $crDateTime,
                                'UpdateUserId' => 1,
                                'UpdateDateTime' => getCurentDateTime(),
                            );

                            $flag = $this->Mssls->save($postData, $sslId);
                            if($flag){
                                $sslCode = $this->Mssls->genSSLCode($flag);
                                $this->db->update('ssls', array('SSLCode' => $sslCode), array('SSLId' => $flag));
                                echo 'Output save Success ==> '.$row.' ==>'.$sslCode.PHP_EOL;
                                usleep(50000);
                            }else{
                                $message = $fileUrl." ==Lưu không thành công==> ".$row."===Data Return Error===>".$postData;
                                log_message('error', $message);
                                echo 'Lưu không thành công ==> '.$row.PHP_EOL;
                            }
                        } else {
                            $message = $fileUrl." ==No License Plate==> ".$row."===Data Return Error===>".$licensePlate;
                            log_message('error', $message);
                            echo 'No License Plate==> '.$row."===> ".$licensePlate.PHP_EOL;
                        }
                        
                    } else {
                        $message = $fileUrl." ==No Customer Code Id==> ".$row."===Data Return Error===>".$customerCode;
                        log_message('error', $message);
                        echo 'No Customer Code Id ==> '.$row."===> ".$customerCode.PHP_EOL;
                    }
                    
                }
            } else echo 'No data'.PHP_EOL;
        } else echo 'File Error'.PHP_EOL;
    }

    public function deadlines(){
        $fileUrl = 'assets\import\IMPORT_BISGATE_V2_DATA_CHUAN\DS_LENH_GIA_HANG.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify($fileUrl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fileUrl);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $countRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $flag = false;
            if($countRows > 0){
                $this->load->model(array('Mssls', 'Musers', 'Mvehicles', 'Mdeadlines', 'Mdeadlinessls'));
                for ($row = 2; $row <= $countRows; $row++) {
                    $licensePlate = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getValue());
                    if(!empty($licensePlate)) {
                        $vehicleId = $this->Mvehicles->getFieldValue(array('LicensePlate' => $licensePlate), 'VehicleId', 0);
                        $customerCode = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $customerId = $this->Musers->getFieldValue(array('CodeUser' => $customerCode), 'UserId', 0);

                        if($vehicleId > 0 && $customerId > 0) {
                            
                            $activeExpiryStartDate = getCurentDateTime();
                            $activeExpiryEndDate = date('Y-m-d 23:59:59', PHPExcel_Shared_Date::ExcelToPHP(trim($objWorksheet->getCellByColumnAndRow(7, $row)->getValue())));
                            // $deadlineStatusId = trim($objWorksheet->getCellByColumnAndRow(10, $row)->getValue());

                            //===============//
                            $crDateTime = strtotime($activeExpiryStartDate);
                            $endDate = strtotime($activeExpiryEndDate);
                            $dateDiff = abs($crDateTime - $endDate);
                            $day = floor($dateDiff / (60*60*24));
                            //=============//
                            $expiryDate = $crDateTime > $endDate ? 0:$day;
                            $postData = array(
                                'DeadlineStatusId' => 2,
                                'UserId' => $customerId,
                                'PackageId' => 1,
                                'ExpiryDate' => $expiryDate,
                                'ActiveExpiryStartDate' => $activeExpiryStartDate,
                                'ActiveExpiryEndDate' => $activeExpiryEndDate,
                                'CrUserId' => 1,
                                'CrDateTime' => $activeExpiryStartDate,
                                'SSLStatusId' => 0,
                            );
                            $deadlineId = $this->Mdeadlines->getFieldValue(array('ActiveExpiryEndDate' => $activeExpiryEndDate, 'UserId' => $customerId), 'DeadlineId', 0);
                            if($deadlineId == 0) {
                                $flag = $this->Mdeadlines->save($postData, $deadlineId);
                                if($flag) {
                                    $deadlineCode = $this->Mssls->genSSLCode($flag, 'KHPM');
                                    $this->db->update('deadlines', array('DeadlineCode' => $deadlineCode), array('DeadlineId' => $flag));

                                    $sslId = $this->Mssls->getFieldValue(array('VehicleId' => $vehicleId), 'SSLId', 0);
                                    if($sslId > 0) {
                                        $deadlinessls = array(
                                            'DeadlineId' => $flag,
                                            'SSLId' => $sslId,
                                        );
                                        $deadlineSSLId =  $this->Mdeadlinessls->getFieldValue(array('SSLId' => $sslId), 'DeadlineSSLId', 0);
                                        $flag2 = $this->Mdeadlinessls->save($deadlinessls, $deadlineSSLId);
                                        if(!$flag2) {
                                            $message = $fileUrl." ==No deadlinessls ERRORS==> ".$row."===ERROR===>".$$deadlinessls;
                                            log_message('error', $message);
                                            echo  $messag.PHP_EOL;
                                        }
        
                                        echo 'Output save Success ==> '.$row.' ==>'.$deadlineCode.PHP_EOL;
                                        usleep(50000);
                                    } else {
                                        $message = $fileUrl." ==Lay sslId lỗi vi không có vehicleId ==> ".$row."===Data Return Error===>".$licensePlate;
                                        log_message('error', $message);
                                        echo 'Lay sslId lỗi vi không có vehicleId ==> '.$row.PHP_EOL;
                                    }
                                    
                                } else {
                                    $message = $fileUrl." ==Lưu không thành công==> ".$row."===Data Return Error===>".$postData;
                                    log_message('error', $message);
                                    echo 'Lưu không thành công ==> '.$row.PHP_EOL;
                                }
                            } else {
                                $sslId = $this->Mssls->getFieldValue(array('VehicleId' => $vehicleId), 'SSLId', 0);
                                if($sslId > 0) {
                                    $deadlinessls = array(
                                        'DeadlineId' => $flag,
                                        'SSLId' => $sslId,
                                    );
                                    $deadlineSSLId =  $this->Mdeadlinessls->getFieldValue(array('SSLId' => $sslId), 'DeadlineSSLId', 0);
                                    $flag2 = $this->Mdeadlinessls->save($deadlinessls, $deadlineSSLId);
                                    if(!$flag2) {
                                        $message = $fileUrl." ==No deadlinessls ERRORS==> ".$row."===ERROR===>".$$deadlinessls;
                                        log_message('error', $message);
                                        echo  $messag.PHP_EOL;
                                    }
    
                                    echo 'Output save Success ==> '.$row.' ==>'.$flag2.PHP_EOL;
                                    usleep(50000);
                                } else {
                                    $message = $fileUrl." ==Lay sslId lỗi vi không có vehicleId ==> ".$row."===Data Return Error===>".$licensePlate;
                                    log_message('error', $message);
                                    echo 'Lay sslId lỗi vi không có vehicleId ==> '.$row.PHP_EOL;
                                }
                            }
                        } else {
                            $message = $fileUrl." ==No Customer Code Id, License Plate==> ".$row."===License Plate===>".$licensePlate."==Customer Code===>".$customerCode;
                            log_message('error', $message);
                            echo 'No Customer Code Id ==> '.$row."===License Plate===>".$licensePlate."==Customer Code===>".$customerCode.PHP_EOL;
                        }
                    } else {
                        $message = $fileUrl." ==No License Plate==> ".$row."===Data Return Error===>".$licensePlate;
                        log_message('error', $message);
                        echo 'No License Plate==> '.$row."===> ".$licensePlate.PHP_EOL;
                    }
                    
                }
            } else echo 'No data'.PHP_EOL;
        } else echo 'File Error'.PHP_EOL;
    }

    // public function ssls(){
    //     $this->load->model(array('Mssls', 'Mssldetails', 'Mdeadlines', 'Mvehicles', 'Mdeadlinessls'));

    //     $vehicles = $this->Mvehicles->getBy(array('VehicleStatusId' => STATUS_ACTIVED));
    //     if($vehicles) {
    //         for($i = 0; $i < count($vehicles); $i++) {
    //             $postData = array(
    //                 'UserId' => $vehicles[$i]['UserId'],
    //                 'VehicleId' => $vehicles[$i]['VehicleId'],
    //                 'PackageId' => 1,
    //                 'SSLStatusId' => STATUS_ACTIVED,
    //                 'ActiveExpiryStartDate' => getCurentDateTime(),
    //                 'ActiveExpiryEndDate' => date('Y-m-d', strtotime(getCurentDateTime(). ' + 30 days')),
    //                 'SSLTypeId' => 3,
    //                 'CrUserId' => 1,
    //                 'CrDateTime' => getCurentDateTime()
    //             );

    //             $deadline = array(
    //                 'PackagePrice' => 0,
    //                 'ExpiryDate' => 30,
    //                 'PackageId' => 1,
    //                 'DeadlineStatusId' => STATUS_ACTIVED,
    //                 'UserId' => $vehicles[$i]['UserId'],
    //                 'ActiveExpiryStartDate' => getCurentDateTime(),
    //                 'ActiveExpiryEndDate' => date('Y-m-d', strtotime(getCurentDateTime(). ' + 30 days')),
    //                 'CrUserId' => 1,
    //                 'CrDateTime' => getCurentDateTime(),
    //                 'SSLStatusId' => STATUS_ACTIVED
    //             );
    //             $sslId = $this->Mssls->save($postData);
    //             if($sslId > 0) {
    //                 $this->db->update('ssls', array('SSLCode' => $this->Mssls->genSSLCode($sslId)), array('SSLId' => $sslId));

    //                 $deadlineId = $this->Mdeadlines->save($deadline);
    //                 if($deadlineId) {
    //                     $this->db->update('deadlines', array('DeadlineCode' => $this->Mssls->genSSLCode($deadlineId, 'KHPM')), array('DeadlineId' => $deadlineId));
    //                     $this->Mdeadlinessls->save(array('DeadlineId' => $deadlineId, 'SSLId' => $sslId));
    //                     echo 'Luu thành công ssl & deadlines'.PHP_EOL;
    //                     usleep(50000);
    //                 } else  echo 'Lỗi deadline'.PHP_EOL;
    //             } else echo 'Lỗi ssl'.PHP_EOL;
    //         }
    //     } else echo 'No data'.PHP_EOL;
    // }


}