<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconstants extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
     public $agentLevelId = array(
        1 => 'Bistech',
        2 => 'Đại lý cấp 1',
        3 => 'Đại lý cấp 2',
    );
    public $userStatus = array(
        2 => 'Bình thường',
        1 => 'Đang tạm cắt',
        3 => 'Đã dừng dịch vụ'
    );
    public $diplomaTypeId = array(
      1 => 'Trung cấp',
      2 => 'Cao đẳng',
      3 => 'Cử nhân',
      4 => 'Kỹ sư',
      5 => 'Thạc sỹ',
      6 => 'P. Giáo sư',
      7 => 'Tiến sỹ',
  );
    public $jobLevelId = array(
        1 => 'Bậc 1',
        2 => 'Bậc 2',
        3 => 'Bậc 3',
        4 => 'Bậc 4',
        5 => 'Bậc 5',
    );

    public $staffRoleId = array(
        1 => 'Owner',
        2 => 'Admin',
        3 => 'Member'
    );

    public $simTypes = array(
        1 => 'Trả trước',
        2 => 'Trả sau',
    );

    public $telcoIds = array(
        1 => 'Viettel',
        2 => 'Mobifone',
        3 => 'Vinaphone',
        4 => 'Vietnamobile',
        5 => 'Gmobile',
    );

    public $connectTypes = array(
        1 => 'Trực tiếp công ty',
        2 => 'Đại lý',
    ); 
    public $customerTypeId = array(
        1 => 'Cá nhân',
        2 => 'Công ty',
    );

//    public $itemStatus = array(
//        2 => 'Đang hoạt động',
//        1 => 'Tạm dừng',
//        3 => 'Dừng hoạt động'
//    );
    public $userStatusList = array(
        2 => 'Bình thường',
        1 => 'Đang tạm cắt',
        3 => 'Đã dừng dịch vụ',
        4 => 'Không khả dụng',
    );
    public $userStatusLableCss = array(
        2 => 'label label-primary',
        1 => 'label label-default',
        3 => 'label label-danger',
        4 => 'label label-danger',
    );
    public $itemStaffStatus = array(
        2 => 'Đang hoạt động',
        1 => 'Đang tạm cắt',
        3 => 'Đã dừng hoạt động'
    );

    public $deviceStatus = array(
        2 => 'Đã lắp đặt',
        1 => 'Chưa lắp đặt',
        3 => 'Đang lắp đặt',
        4 => 'Đã tháo gỡ'
    );
    public $tonnage = array(
        2 => 'Người',
        1 => 'Tấn',
    );
    public $status = array(
        2 => 'Đang hợp tác',
        1 => 'Chưa hợp tác',
        3 => 'Đang tạm dừng',
        4 => 'Đã dừng hợp tác'
    );
    public $products = array(
        1 => 'Cable IO T5 ACC V1',
        2 => 'Cable IO IST2 ACC V1',
        3 => 'Cable IO KHC ACC V1',
        4 => 'Cable IO BIS T5 V1',
        5 => 'Cable IO IST2 V1',
        6 => 'Cable IO BIS T5 V1',
        7 => 'Cable IO IST2 V1',
        8 => 'NTC - 10K',
        9 => 'SOJI - A5'
    );
    public $simStatus = array(
        1 => 'Chưa kích hoạt',
        2 => 'Đang hoạt động',
        3 => 'Tạm cắt',
        4 => 'Đã hủy',
    );

    public $vehicleStatus = array(
        1 => 'Chưa dùng',
        2 => 'Đang dùng',
        3 => 'Đã dùng'
    );

    public $licenceTypes = array(
        1 => 'băng 1',
        2 => 'bagwf ',
    );

    public $genders = array(
        1 => 'Nam',
        2 => 'Nữ',
        3 => 'Khác'
    );
    public $relationshipStatus = array(
        1 => 'Độc thân',
        2 => 'Đã kết hôn',
        3 => 'Đã ly hôn'
    );

    public $sslType = array(
        // 1 => 'Free 24H',
        2 => 'Mannual',
        3 => 'SSL CODE'
    );

    public $sslStatus = array(
        1 => 'Chờ active',
        2 => 'Bình thường',
        3 => 'Đang tạm cắt',
        4 => 'Đang hết hạn',
        5 => 'Đã dừng dịch vụ',
        6 => 'Đã hủy bỏ'
    );  
    public $roleStatusId = array(
        0 => 'Đã xóa',
        1 => 'Chưa sử dụng',
        2 => 'Bình thường'
    );

    public $deadlineStatus = array(
        1 => 'Chờ áp dụng',
        2 => 'Đã áp dụng',
        3 => 'Đã hủy bỏ'
    );
    public $purposeId = array(
        1 => 'Kinh doanh vận tải',
        2 => 'Tự do cá nhân',
    );

    public $softwareList = array(
        1 => [
            'name' => 'Phần mềm 1',
            'url' => 'phanmem/1'
        ],
        2 => [
            'name' => 'Phần mềm 2',
            'url' => 'phanmem/2'
        ],
        3 => [
            'name' => 'Phần mềm 2',
            'url' => 'phanmem/3'
        ],
    );

    public $roleId = array(
        1 => 'Khách hàng - Chủ công ty',
        2 => 'Đại lý',
        3 => 'Nhà cung cấp Sim',
        4 => 'D/S lái xe của tôi',
    );

    public $SensorLine = array(
        1 => [
            1 => [
                'text' => 'Cable IO T5 ACC V1',
                'SensorId' => 1,
                'TypeFunctionId' => [1 => ['10', '4','5']]
            ],
            4 => [
                'text' => 'Cable IO BIS T5 V1',
                'SensorId' => 4,
                'TypeFunctionId' => [
                    2 => ['5', '10', '4'],
                    3 => ['4', '10','5']
                ],
            ],
            6 => [
                'text' => 'NTC - 10K',
                'SensorId' => 6,
                'TypeFunctionId' => [4 => ['9', '3']]
            ],
            7 => [
                'text' => 'SOJI - A5',
                'SensorId' => 7,
                'TypeFunctionId' => [5 =>  ['8', '2']]
            ]
        ],
        2 => [
            2 => [
                'text' => 'Cable IO IST2 ACC V1',
                'SensorId' => 2,
                'TypeFunctionId' => [1 => ['GIN6','GIN5','Door']]
            ],
            5 => [
                'text' => 'Cable IO IST2 V1',
                'SensorId' => 5,
                'TypeFunctionId' => [
                    2 => ['Door', 'GIN6','GIN5'],
                    3 => ['GIN5','GIN6','Door']
                ]
            ],
            7 => [
                'text' => 'SOJI - A5',
                'SensorId' => 7,
                'TypeFunctionId' => [5 =>  ['AD1']]
            ]
        ],
        3 => [
            3 => [
                'text' => 'Cable IO KHC ACC V1',
                'SensorId' => 3,
                'TypeFunctionId' => [1 => ['ACC']]
            ]
        ]
    );

    public $TypeFunctionId = array(
        1 => 'Cảm biến bật tắt động cơ',
        2 => 'Cảm biến đóng mở cửa',
        3 => 'Cảm biến bật tắt điều hòa',
        4 => 'Cảm biến nhiệt độ',
        5 => 'Cảm biến dầu'
    );
    public $ListPort = array(

    );

    public $contractStatusIds = array(
        2 => 'Đang dùng dịch vụ',
        3 => 'Đang tạm cắt',
        5 => 'Dừng hẳn dịch vụ',
    );

    public $labelCssContract = array(
        2 => 'label label-success',
        3 => 'label label-danger',
        5 => 'label label-danger',
    );

    public $labelCss = array(
        0 => 'label label-danger',
        1 => 'label label-default',
        2 => 'label label-primary',
        3 => 'label label-danger',
        4 => 'label label-warning',
        5 => 'label label-default',
        6 => 'label label-warning',
        7 => 'label label-warning',
        8 => 'label label-danger',
        9 => 'label label-default',
        10 => 'label label-success',
        11 => 'label label-warning',
        12 => 'label label-danger',
        13 => 'label label-danger',
        14 => 'label label-default',
        15 => 'label label-success',
        16 => 'label label-warning',
        17 => 'label label-danger'
    );

    public $labelStaffCss = array(
        1 => ' pause ',
        2 => ' active ',
        3 => ' stop ',
    );

    public $labelStaffTypeCss = array(
        1 => 'label owner staff',
        2 => 'label admin staff',
        3 => 'label member staff',
    );

    public function selectConstants($key, $selectName, $itemId = 0, $isAll = false, $txtAll = 'Tất cả', $selectClass = '', $attrSelect = '')
    {
        $obj = $this->$key;
        if ($obj) {
            echo '<select class="form-control' . $selectClass . '" name="' . $selectName . '" id="' . lcfirst($selectName) . '"' . $attrSelect . '>';
            if ($isAll) echo '<option value="0">' . $txtAll . '</option>';
            foreach ($obj as $i => $v) {
                if ($itemId == $i) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="' . $i . '"' . $selected . '>' . $v . '</option>';
            }
            echo "</select>";
        }
    }

    public function selectObject($listObj, $objKey, $objValue, $selectName, $objId = 0, $isAll = false, $txtAll = "Tất cả", $selectClass = '', $attrSelect = '')
    {
        $id = str_replace('[]', '', lcfirst($selectName));
        echo '<select class="form-control provinceId' . $selectClass . '" name="' . $selectName . '" id="' . $id . '"' . $attrSelect . '>';
        if ($isAll) echo '<option value="0">' . $txtAll . '</option>';
        /*if($isAll){
            if(empty($txtAll)) echo '<option value="0">Tất cả</option>';
            else echo '<option value="0">'.$txtAll.'</option>';
        }*/
        $isSelectMutiple = is_array($objId);
        foreach ($listObj as $obj) {
            $selected = '';
            if (!$isSelectMutiple) {
                if ($obj[$objKey] == $objId) $selected = ' selected="selected"';
            } elseif (in_array($obj[$objKey], $objId)) $selected = ' selected="selected"';
            echo '<option value="' . $obj[$objKey] . '"' . $selected . '>' . $obj[$objValue] . '</option>';
        }
        echo '</select>';
    }

    public function selectNumber($start, $end, $selectName, $itemId = 0, $asc = false, $attrSelect = '')
    {
        echo '<select class="form-control" name="' . $selectName . '" id="' . lcfirst($selectName) . '"' . $attrSelect . '>';
        if ($asc) {
            for ($i = $start; $i <= $end; $i++) {
                if ($i == $itemId) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
            }
        } else {
            for ($i = $end; $i >= $start; $i--) {
                if ($i == $itemId) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
            }
        }
        echo '</select>';
    }

    public function getObjectValue($listObj, $objKey, $objValue, $objKeyReturn, $returnObj = false)
    {
        foreach ($listObj as $obj) {
            if ($obj[$objKey] == $objValue) {
                if ($returnObj) return $obj;
                return $obj[$objKeyReturn];
            }
        }
        return $returnObj ? false : '';
    }

    public function getUrl($itemSlug, $itemId, $itemTypeId)
    {
        $retVal = 'javascript:void(0)';
        if ($itemTypeId == 1) $retVal = base_url('category/' . $itemSlug . '-c' . $itemId . '.html');
        elseif ($itemTypeId == 4) $retVal = base_url('article/' . $itemSlug . '-a' . $itemId . '.html');
        elseif ($itemTypeId == 5) $retVal = base_url('news/' . $itemSlug . '-c' . $itemId . '.html');
        return $retVal;
    }

    public function formatDate($startDate = '', $endDate = ''){
        $startDate = date('Y-m-d H:i', strtotime($startDate));
        if(empty($endDate)) $endDate = date('Y-m-d H:i');

        $diff = abs(strtotime(date('Y-m-d',  strtotime($startDate))) - strtotime(date('Y-m-d',  strtotime($endDate))));

        //Tính ra tông số ngày của 2 khoản thời gian
        $interval = date_diff(date_create(date('Y-m-d', strtotime($startDate))), date_create(date('Y-m-d', strtotime($endDate))))->format('%a %d %R %y');

        $parts = explode(' ', $interval);

        // Lấy ra tổng số ngày
        $totalDays = intval($parts[0]);
        $beforeOrAfter = $parts[2];

        // Tính ra ngày tháng năm
        
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        $hours = strtotime(date('H:i', strtotime($startDate))); // Giờ
        $showTime = '';
        //Nếu >= 365 lấy ra năm
        if ($totalDays >= 365) {
            //Nếu  Delta X >= 15 >> M = M + 1 Lên tháng
            if ($days >= 15) {
                $months += 1;
            }

            if ($beforeOrAfter == '-' && intval($parts[1]) == 1) {
                $showTime = "Ngày mai, ";
            } else if ($beforeOrAfter == '+' && intval($parts[1]) == 1) {
                $showTime = "Hôm qua, ";
            } else if ($beforeOrAfter == '-' && intval($parts[1]) == 2) {
                $showTime = "Hôm kia, ";
            } else if ($beforeOrAfter == '+' && intval($parts[1]) == 2) {
                $showTime = "Ngày kia, ";
            } else if (($beforeOrAfter == '+' || $beforeOrAfter == '-') && intval($parts[1]) == 0) {
                $showTime = "Hôm nay, ";
            }

            if (in_array($months, [1,2])) {
                $showTime .= 'Hơn '.$years. ' năm';
            } else if (in_array($months, [3,4,8,9])) {
                $showTime .= $years.' năm '.$months. ' tháng';
            } else if ($months == 5) {
                $showTime .= 'Gần '.$years.' năm rưỡi';
            } else if ($months == 6) { 
                $showTime .= $years.' năm rưỡi';
            } else if ($months == 7) {
                $showTime .= 'Hơn '.$years.' năm rưỡi';
            } else if (in_array($months, [10,11])) {
                $showTime .= 'Gần '.($years + 1). ' năm';
            } else if ($months == 0) {
                $showTime .= $years. ' năm';
            } else if ($months == 12){
                $showTime .= ($years + 1). ' năm';
            }
            
            $showTime .= $this->dateBeforeOrAgain($beforeOrAfter);
        } else if ($totalDays >= 30) {
            if ($days >=1 && $days <= 10) {
                $showTime = 'Hơn '.$months. ' tháng';
            } else if (in_array($days, [11,12])) {
                $showTime = 'Gần '.$months. ' tháng rưỡi';
            } else if ($days >= 13 && $days <= 17) {
                $showTime = $months. ' tháng rưỡi';
            } else if (in_array($days, [18,19])) {
                $showTime = 'Hơn '.$months. ' tháng rưỡi';
            } else if ($days >= 20 && $days <= 29) {
                $showTime = 'Gần '.($months + 1). ' tháng';
            }
            $showTime .= $this->dateBeforeOrAgain($beforeOrAfter);

        } else if ($totalDays >= 1) {
            //Nếu >= 1 lấy ra ngày
            if ($days == 1) {
                $showTime = $this->dateDiff($hours, $beforeOrAfter, $days);
            } else if ($days == 2) {
                $showTime = $this->dateDiff($hours, $beforeOrAfter, $days);
            } else if ($days >= 3 && $days <= 6) {
                $showTime = $days.' ngày';
            } else if ($days == 7) {
                $showTime = '1 tuần';
            } else if ($days >= 8 && $days <= 11) {
                $showTime = $days.' ngày';
            } else if (in_array($days, [12,13])) {
                $showTime = 'Gần 2 tuần';
            } else if ($days == 14) {
                $showTime = '2 tuần';
            } else if (in_array($days, [15,16,17])) {
                $showTime = 'Hơn nữa tháng';
            } else if (in_array($days, [18,19,20])) {
                $showTime = 'Gần 3 tuần';
            } else if ($days == 21) {
                $showTime = '3 tuần';
            } else if (in_array($days, [22,23,24])) {
                $showTime = 'Hơn 3 tuần';
            } else if ($days >= 25 && $days <= 29){
                $showTime = 'Gần 1 tháng';
            }

            if (!in_array($days, [0,1,2])){
                $showTime .= $this->dateBeforeOrAgain($beforeOrAfter);
            }

        } else if ($totalDays == 0){
            $showTime .= $this->dateDiff($hours, $beforeOrAfter, $days);
        }
        return $showTime;
        // echo json_encode(array('code' => 1, 'data' => $showTime));
    }

    public function dateDiff($time = 0, $beforeOrAfter = '', $days = 0){
        $dayTime = '';
        if ($time > strtotime("00:00") && $time < strtotime("11:00")) {
            $dayTime = 'Sáng ';
        } else if ($time >= strtotime("11:00") && $time < strtotime("13:30")) {
            $dayTime = 'Trưa ';
        } else if ($time >= strtotime("13:30") && $time < strtotime("17:30")) {
            $dayTime = 'Chiều ';
        } else if ($time >= strtotime("17:30") && $time < strtotime("24:00")) {
            $dayTime = 'Tối ';
        }

        /**
         * + là tương lai
         * - là quá khứ
         */

        if ($beforeOrAfter == '-' && $days == 1) {
            $dayTime .= "ngày mai";
        } else if ($beforeOrAfter == '+' && $days == 1) {
            $dayTime .= "hôm qua";
        } else if ($beforeOrAfter == '-' && $days == 2) {
            $dayTime .= "hôm kia";
        } else if ($beforeOrAfter == '+' && $days == 2) {
            $dayTime .= "ngày kia";
        } else if (($beforeOrAfter == '+' || $beforeOrAfter == '-') && $days == 0) {
            $dayTime .= "hôm nay";
        }


        return $dayTime;
    }

    public function dateBeforeOrAgain($beforeOrAfter = ''){
        $text = '';
        if ($beforeOrAfter == '-') {
            $text = ' nữa';
        } else if ($beforeOrAfter == '+') {
            $text = ' trước';
        }
        return $text;
    }

    function getInfoDeviceLog($IMEI) {
        return ['gtgn' => '', 'ConnectStatusId' => ''];
        $this->load->library('mongo_db');
        $DeviceLog = $this->mongo_db->order_by(['svt' => 'desc'])->where('imei', $IMEI)->limit(1)->get('device_logs');
        $gtgn = '';
        $checkConnect = '<span class="label label-primary">Bình thường</span>';
        if(isset($DeviceLog[0]['loc']->utc)) {
            $utcdatetime = $DeviceLog[0]['loc']->utc;
            $datetime = $utcdatetime->toDateTime();
            $time = $datetime->format(DATE_RSS);
            $timeDeff = $this->Mconstants->ax_getRoughTimeElapsedAsText(strtotime($time));
            $gtgn = $timeDeff;
            if(time() - strtotime($time) > 120) {
                $checkConnect = '<span class="label label-default">Mất kết nối</span>';
            }
        }
        return ['gtgn' => $gtgn, 'ConnectStatusId' => $checkConnect];
    }

    function ax_getRoughTimeElapsedAsText($iTime0, $iTime1 = 0) {
        if ($iTime1 == 0) { $iTime1 = time(); }
        $iTimeElapsed = $iTime1 - $iTime0;
        if ($iTimeElapsed < (60)) {
            return $iTimeElapsed.' giây';
        } else if ($iTimeElapsed < (60*60)) {
            return date('i', $iTimeElapsed).' phút '.date('s', $iTimeElapsed).' giây' ;
        } else if ($iTimeElapsed < (24*60*60)) {
            return date('H', $iTimeElapsed).' giờ '. date('i', $iTimeElapsed).' phút '.date('s', $iTimeElapsed).' giây' ;
        } else if ($iTimeElapsed < (30*24*60*60)) {
            return date('d', $iTimeElapsed).' ngày '. date('H', $iTimeElapsed).' giờ '. date('i', $iTimeElapsed).' phút '.date('s', $iTimeElapsed).' giây' ;
        } else if ($iTimeElapsed < (365*24*60*60)) {
            return date('m', $iTimeElapsed).' tháng '. date('d', $iTimeElapsed).' ngày '. date('H', $iTimeElapsed).' giờ '. date('i', $iTimeElapsed).' phút '.date('s', $iTimeElapsed).' giây' ;
        } else {
            return date('d H:i:s', $iTimeElapsed) ;
        }
    }
    public function getBistech(){
        return 'Bistech';
    }
}