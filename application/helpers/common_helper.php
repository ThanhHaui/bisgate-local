<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('outputScript')){
    function outputScript($scripts){
        if(is_array($scripts)){
            //$day = '201910232';
            foreach($scripts as $label=>$arr){
                if(is_array($arr)){
                    foreach($arr as $src){
                        if($label=='css') echo '<link href="assets/'.$src.'" rel="stylesheet"/>'."\n";
                        elseif($label=='js'){
                            if(strpos($src, 'http') !== false) echo '<script type="text/javascript" src="'.$src.'"></script>'."\n";
                            else echo '<script type="text/javascript" src="assets/'.$src.'"></script>'."\n";
                            //else echo '<script type="text/javascript" src="assets/'.$src.'?'.$day.'"></script>'."\n";
                        }
                    }
                }
                else{
                    $src = $arr;
                    if($label=='css') echo '<link href="assets/'.$src.'" rel="stylesheet"/>'."\n";
                    elseif($label=='js'){
                        if(strpos($src, 'http') !== false) echo '<script type="text/javascript" src="'.$src.'"></script>'."\n";
                        else echo '<script type="text/javascript" src="assets/'.$src.'"></script>'."\n";
                        //else echo '<script type="text/javascript" src="assets/'.$src.'?'.$day.'"></script>'."\n";
                    }
                }
            }
        }
    }
}

if(!function_exists('getVideoYoutubeId')){
    function getVideoYoutubeId($videoUrl){
        preg_match_all("#(?<=v=|v\/|vi=|vi\/|youtu.be\/)[a-zA-Z0-9_-]{11}#", $videoUrl, $matches);
        if(!empty($matches[0])) return $matches[0][0];
        return '';
    }
}

if(!function_exists("getDayDiff")){
    function getDayDiff($dateStr, $now, $isCheckDate = false){
        $retVal = 3;
        if(!empty($dateStr) && $dateStr != '0000-00-00 00:00:00') {
            $parts = explode(' ', $dateStr);
            if(count($parts) == 2) {
                $dStart = new DateTime($parts[0]);
                $diff = $dStart->diff($now);
                $retVal = $diff->days;
                if($isCheckDate){
                    if($now < $dStart) $retVal *= -1;
                }
            }
        }
        return $retVal;
    }
}

if(!function_exists("getDayDiffText")){
    function getDayDiffText($dayDiff){
        $dayText = '';
        if($dayDiff == 0) $dayText = 'Hôm nay ';
        elseif($dayDiff == 1) $dayText = 'Hôm qua ';
        elseif($dayDiff == 2) $dayText = 'Hôm kia ';
        elseif($dayDiff == -1) $dayText = 'Ngày mai ';
        elseif($dayDiff == -2) $dayText = 'Ngày kia ';
        return $dayText;
    }
}

if (!function_exists('ddMMyyyy')){
    function ddMMyyyy($dateStr, $dateFormat = "d/m/Y"){
        if(!empty($dateStr) && $dateStr != '0000-00-00 00:00:00' && $dateStr != '0000-00-00') return date_format(date_create(trim($dateStr)), $dateFormat);
        return '';
    }
}
if (!function_exists('ddMMyyyyToDate')){
    function ddMMyyyyToDate($dateStr, $from = 'd/m/Y', $to = 'Y-m-d'){
        if(!empty($dateStr)) return date_format(date_create_from_format($from, trim($dateStr)), $to);
        return '';
    }
}

if (!function_exists('getCurentDateTime')){
    function getCurentDateTime(){
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('priceFormat')){
    function priceFormat($price, $formatDecimal = false){
        if($formatDecimal) $decimals = 2;
        else {
            $decimals = 0;
            if (strpos($price, ',00') !== false) $decimals = 0;
            if (strpos($price, ',0') !== false) $decimals = 0;
            elseif (strpos($price, ',') !== false) $decimals = 2;
        }
        $retVal = number_format($price, $decimals, '.', ',');
        if($formatDecimal && strpos($retVal, '.00') !== false) $retVal = substr($retVal, 0, strlen($retVal) - 3);
        return $retVal;
    }
}

if (!function_exists('replacePrice')){
    function replacePrice($price){
        return str_replace(',', '', $price);
    }
}

if (!function_exists('replaceFileUrl')){
    function replaceFileUrl($url, $filePath = IMAGE_PATH){
        $search = array($filePath);
        if(ROOT_PATH != '/' && ROOT_PATH != '//') $search[] = ROOT_PATH;
        return str_replace($search, '', $url);
    }
}

if (!function_exists('getFileUrl')){
    function getFileUrl($path, $url, $defaultUrl){
        if(empty($url)) return $defaultUrl;
        elseif(strpos($url, 'http') !== false) return $url;
        else return $path.$url;
    }
}

if (!function_exists('getPhoneFormatVN')) {
    function getPhoneFormatVN($hotline){
        if (strpos($hotline, '0') == 0) $hotline = substr($hotline, 1, strlen($hotline) - 1);
        $hotline = '84' . $hotline;
        return $hotline;
    }
}

if (!function_exists('isMobile')) {
    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}

if (!function_exists('makeSlug')){
    function makeSlug($string) {
        $table = array(
            'à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a', 'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
            'À' => 'a', 'Á' => 'a', 'Ả' => 'a', 'Ã' => 'a', 'Ạ' => 'a', 'Ă' => 'a', 'Ắ'  => 'a', 'Ằ' => 'a', 'Ẳ' => 'a', 'Ẵ'  => 'a', 'Ặ' => 'a', 'Â' => 'a', 'Ầ' => 'a', 'Ấ' => 'a', 'Ẩ' => 'a', 'Ẫ' => 'a', 'Ậ' => 'a',
            'đ' => 'd', 'Đ' => 'd' ,
            'è' => 'e', 'é' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e', 'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
            'È' => 'e', 'É' => 'e', 'Ẻ' => 'e', 'Ẽ' => 'e', 'Ẹ' => 'e', 'Ê' => 'e', 'Ề' => 'e', 'Ế' => 'e', 'Ể' => 'e', 'Ễ' => 'e', 'Ệ' => 'e',
            'ì' => 'i', 'í' => 'i' , 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
            'Ì' => 'i', 'Í' => 'i', 'Ỉ' => 'i', 'Ĩ' => 'i', 'Ị' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o', 'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o', 'ơ'  => 'o', 'ờ' => 'o', 'ớ'  => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
            'Ò' => 'o', 'Ó' => 'o', 'Ỏ' => 'o', 'Õ' => 'o', 'Ọ' => 'o', 'Ô' => 'o', 'Ồ' => 'o', 'Ố' => 'o', 'Ổ' => 'o', 'Ỗ' => 'o', 'Ộ' => 'o', 'Ơ'  => 'o', 'Ờ' => 'o', 'Ớ' => 'o', 'Ở' => 'o', 'Ỡ' => 'o', 'Ợ'  => 'o',
            'ù' => 'u', 'ú' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u', 'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
            'Ù' => 'u', 'Ú' => 'u', 'Ủ' => 'u', 'Ũ' => 'u', 'Ụ' => 'u', 'Ư' => 'u', 'Ừ' => 'u', 'Ứ' => 'u', 'Ử' => 'u', 'Ữ' => 'u', 'Ự' => 'u',
            'ỳ' => 'y', 'ý' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
            'Ỳ' => 'y', 'Ý' => 'y', 'Ỷ' => 'y', 'Ỹ' => 'y', 'Ỵ' => 'y',
            '/' => '-', ' ' => '-'
        );
        preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);
        return strtolower(strtr($string, $table));
    }
}

if (!function_exists('isValidEmail')) {
    function isValidEmail($email){
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (preg_match($regex, $email)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('checkPhoneNumber')) {
    function checkPhoneNumber($phone){
        $regex = '/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i';
        if (preg_match($regex, $phone)) {
            return true;
        } else {
            return false;
        }
    }
}

//HTML
if (!function_exists('sectionTitleHtml')){
    function sectionTitleHtml($title, $toolHtml = ''){ ?>
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title; ?></h3>
            <?php if(!empty($toolHtml)){ ?>
                <div class="box-tools pull-right">
                    <?php echo $toolHtml; ?>
                </div>
            <?php } ?>
        </div>
    <?php }
}

if (!function_exists('getPaggingHtml')){
    function getPaggingHtml($page, $pageCount, $functionJsName = 'pagging'){
        if($pageCount == 1) return '';
        $retVal = '<ul class="pagination pagination-sm no-margin pull-right">';
        if($page > 1){
            $retVal.='<li><a onclick="'.$functionJsName.'(\''.($page-1).'\')" href="javascript:void(0)">«</a></li>';
            $retVal.='<li><a onclick="'.$functionJsName.'(\'1\')" href="javascript:void(0)">1</a></li>';
        }
        else $retVal.='<li class="active"><a href="javascript:void(0)">1</a></li>';
        $start = ($page > 1)? ($page-1) : 1;
        if($start != 1) $retVal.='<li><a href="javascript:void(0)">...</a></li>';
        for($i= $start + 1; $i <= $page + 3 && $i <= $pageCount; $i++){
            if($i==$page) $retVal.='<li class="active"><a href="javascript:void(0)">'.$i.'</a></li>';
            else $retVal.='<li><a onclick="'.$functionJsName.'(\''.$i.'\')" href="javascript:void(0)">'.$i.'</a></li>';
        }
        if($page + 3 < $pageCount){
            $retVal.='<li><a href="javascript:void(0)">...</a></li>';
            $retVal.='<li><a onclick="'.$functionJsName.'(\''.($pageCount).'\')" href="javascript:void(0)">'.$pageCount.'</a></li>';
        }
        if($page < $pageCount) $retVal.='<li><a onclick="'.$functionJsName.'(\''.($page+1).'\')" href="javascript:void(0)">»</a></li>';
        $retVal.='</ul>';
        return $retVal;
    }
}

if (!function_exists('getPaggingHtmlFront')){
    function getPaggingHtmlFront($page, $pageCount, $baseUrl){
        if($pageCount == 1) return '';
        $retVal = '<div class="box-pager"><ul>';
        if($page > 1){
            $retVal.='<li><a href="'.str_replace('{$1}', $page - 1, $baseUrl).'">|&lt;</a></li>';
            $retVal.='<li><a href="'.str_replace('{$1}', 1, $baseUrl).'">1</a></li>';
        }
        else $retVal.='<li class="active"><a href="javascript:void(0)">1</a></li>';
        $start = ($page > 1)? ($page-1) : 1;
        if($start != 1) $retVal.='<li><a href="javascript:void(0)">...</a></li>';
        for($i= $start + 1; $i <= $page + 3 && $i <= $pageCount; $i++){
            if($i==$page) $retVal.='<li class="active"><a href="javascript:void(0)">'.$i.'</a></li>';
            else $retVal.='<li><a href="'.str_replace('{$1}', $i, $baseUrl).'">'.$i.'</a></li>';
        }
        if($page + 3 < $pageCount){
            $retVal.='<li><a href="javascript:void(0)">...</a></li>';
            $retVal.='<li><a href="'.str_replace('{$1}', $pageCount, $baseUrl).'">'.$pageCount.'</a></li>';
        }
        if($page < $pageCount) $retVal.='<li><a href="'.str_replace('{$1}', $page + 1, $baseUrl).'">&gt;|</a></li>';
        $retVal.='</ul></div>';
        return $retVal;
    }
}

if (!function_exists('preData')){
    function preData($data, $isDie = true){
        echo '<pre>'.print_r($data, true).'</pre>';
        if($isDie) die();
    }
}