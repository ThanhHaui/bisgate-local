<div class="box-body" style="background: #ecf0f5;">
    <ul class="nav nav-tabs mgbt-20">
        <li class="active"><a href="#tabSSL_1" data-toggle="tab" class="tab tabSSL_1" data-id="1">Gói thuê bao SSL - Đang được
                gán vào</a></li>
        <li><a href="#tabSSL_2" data-toggle="tab" class="tab tabSSL_2" data-id="2" data-vehicleId="<?php echo $vehicleId ?>" data-sslId="<?php echo isset($sslId)?$sslId:'0' ?>" data-statuss="3" data-sslvehiclelog="<?php echo isset($sslvehiclelogID)?$sslvehiclelogID:'0' ?>">Lịch sử thay đổi thuê bao| SSL

            </a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tabSSL_1">
            <?php if (isset($ssls)) { ?>
                <div class="row img-html">
                    <div class="col-sm-8">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <p>Gói phần mềm đang sử dụng</p>
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-11">
                                            <p>
                                                <i class="fa fa-fw fa-check-square-o"></i> Gói phần mềm base bắt
                                                buộc
                                            </p>
                                            <div class="box-body table-responsive divTable">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th style="width:60px">STT</th>
                                                        <th>Tên gói phần mềm</th>
                                                        <th>Mã gói PM</th>
                                                        <th>Tình trạng dung lượng</th>
                                                        <th>Tình trạng hợp đồng</th>
                                                        <th>Trạng thái sử dụng PM</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbodyBase" class=" text-ssltext-ssl">
                                                    <?php
                                                    $totalDay = 0;
                                                    $package = $this->Mpackages->get($ssls['PackageId']);
                                                    if (count($ssls) > 0 && $package['StatusId'] == STATUS_ACTIVED) {
                                                        $totalDay = $this->Mssls->convertActiveExpiryDateToDay($ssls['ActiveExpiryStartDate'], $ssls['ActiveExpiryEndDate']);
                                                        $statusBase = '<span class="' . $labelCss[$ssls['SSLStatusId']] . '">' . $this->Mconstants->sslStatus[$ssls['SSLStatusId']] . '</span>';
                                                        $textDays = 'Còn hạn';
                                                        if($totalDay < 30) $textDays = 'Săp hết hạn';
                                                        ?>
                                                        <tr data-id="<?php echo $ssls['PackageId']; ?>"
                                                            check-add="1">
                                                            <td>1</td>
                                                            <td><?php echo $package['PackageName']; ?></td>
                                                            <td><?php echo $package['PackageCode']; ?></td>
                                                            <?php
                                                            if (in_array($ssls['SSLStatusId'], [1, 2, 4])) {
                                                                if ($totalDay > 0) {
                                                                    ?>
                                                                    <td>
                                                                                    <span class="label label-primary">
                                                                                    <?php echo $textDays; ?>: <?php echo $totalDay; ?> ngày
                                                                                    </span>
                                                                    </td>
                                                                    <td><span class="label label-success">Đang dùng dịch vụ</span>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td>
                                                                        <span class="label label-danger">Đang hết hạn</span>
                                                                    </td>
                                                                    <td><span class="label label-success">Đang dùng dịch vụ</span>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } else if (in_array($ssls['SSLStatusId'], [3, 5])) {
                                                                if ($totalDay > 0) {
                                                                    ?>
                                                                    <td>
                                                                                    <span class="label label-primary">
                                                                                    <?php echo $textDays; ?>: <?php echo $totalDay; ?> ngày
                                                                                    </span>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td>
                                                                        <span class="label label-danger">Đang hết hạn</span>
                                                                    </td>
                                                                <?php } ?>
                                                                <?php if ($ssls['SSLStatusId'] == 1) { ?>
                                                                    <td>
                                                                        <span class="label label-danger">Đang hết hạn</span>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td><?php echo $statusBase; ?></td>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <td><span class="label label-danger">Đang hết hạn</span>
                                                                </td>
                                                                <td>
                                                                    <span class="label label-success">Đang dùng dịch vụ</span>
                                                                </td>
                                                            <?php } ?>
                                                            <?php if ($ssls['SSLStatusId'] == 1) { ?>
                                                                <td>
                                                                    <span class="label label-danger">Đang hết hạn</span>
                                                                </td>
                                                            <?php } else if ($ssls['SSLStatusId'] == 6) { ?>
                                                                <td>
                                                                    <span class="label label-default">Chờ active</span>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td><?php echo $statusBase; ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <div class="row">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-11">
                                            <p>
                                                Gói phần mềm mở rộng (<span id="totalSslDetail">0</span>)
                                            </p>
                                            <div class="box-body table-responsive divTable">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th style="width:60px">STT</th>
                                                        <th>Tên gói phần mềm</th>
                                                        <th>Mã gói PM</th>
                                                        <th>Tình trạng dung lượng</th>
                                                        <th>Tình trạng hợp đồng</th>
                                                        <th>Trạng thái sử dụng PM</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbodySslDetails">
                                                    <?php
                                                    foreach ($listSSLDetails as $key => $s) {
                                                        $packageDetail = $this->Mpackages->get($s['PackageId']);
                                                        if (!in_array($s['SSLDetailStatusId'], [3,5]) && $packageDetail['StatusId'] == STATUS_ACTIVED) {
                                                            $totalDayDetail = $this->Mssls->convertActiveExpiryDateToDay($s['ActiveExpiryStartDate'], $s['ActiveExpiryEndDate']);
                                                            $statusSSLDetail = '<span class="' . $labelCss[$s['SSLDetailStatusId']] . '">' . $this->Mconstants->sslStatus[$s['SSLDetailStatusId']] . '</span>';
                                                            $textDays = 'Còn hạn';
                                                            if($totalDay < 30) $textDays = 'Săp hết hạn';
                                                           ?>
                                                            <tr data-id="<?php echo $s['PackageId']; ?>"
                                                                check-add="1">
                                                                <td><?php echo $key + 1; ?></td>
                                                                <td><?php echo $packageDetail['PackageName']; ?></td>
                                                                <td><?php echo $packageDetail['PackageCode']; ?></td>
                                                                <?php
                                                                if (in_array($s['SSLDetailStatusId'], [1, 2, 4])) {
                                                                    if ($totalDayDetail > 0) {
                                                                        ?>
                                                                        <td>
                                                                                        <span class="label label-primary">
                                                                                        <?php echo $textDays; ?>: <?php echo $totalDayDetail; ?> ngày
                                                                                        </span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="label label-success">Đang dùng dịch vụ</span>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td>
                                                                            <span class="label label-danger">Đang hết hạn</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="label label-success">Đang dùng dịch vụ</span>
                                                                        </td>
                                                                    <?php } ?>
                                                                <?php } else if (in_array($s['SSLDetailStatusId'], [3, 5])) {
                                                                    if ($totalDayDetail > 0) {
                                                                        ?>
                                                                        <td>
                                                                                        <span class="label label-primary">
                                                                                        <?php echo $textDays; ?>: <?php echo $totalDayDetail; ?> ngày
                                                                                        </span>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td>
                                                                            <span class="label label-danger">Đang hết hạn</span>
                                                                        </td>
                                                                    <?php } ?>

                                                                    <td><?php echo $statusSSLDetail; ?></td>
                                                                <?php } ?>
                                                                <?php if (($s['SSLDetailStatusId'] == 1) || ($totalDayDetail <= 0)) { ?>
                                                                    <td>
                                                                        <span class="label label-danger">Đang hết hạn</span>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td><?php echo $statusSSLDetail; ?></td>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php }
                                                    } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($ssls['SSLStatusId'] != 1) { ?>
                            <div class="box box-default padding15">
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <p>Gói phần mềm đang tạm cắt hoặc dừng hoạt động</p>

                                        <div class="row">
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-11">
                                                <p>
                                                    Gói phần mềm mở rộng
                                                </p>
                                                <div class="box-body table-responsive divTable">
                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th style="width:60px">STT</th>
                                                            <th>Tên gói phần mềm</th>
                                                            <th>Mã gói PM</th>
                                                            <th>Tình trạng dung lượng</th>
                                                            <th>Tình trạng hợp đồng</th>
                                                            <th>Trạng thái sử dụng PM</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbodySslDetailsError">
                                                        <?php
                                                        foreach ($listSSLDetails as $key => $s) {
                                                            $packageDetail = $this->Mpackages->get($s['PackageId']);
                                                            if (in_array($s['SSLDetailStatusId'], [3,5]) && $packageDetail['StatusId'] == STATUS_ACTIVED) {
                                                                $totalDayDetail = $this->Mssls->convertActiveExpiryDateToDay($s['ActiveExpiryStartDate'], $s['ActiveExpiryEndDate']);
                                                                $statusSSLDetail = '<span class="' . $labelCss[$s['SSLDetailStatusId']] . '">' . $this->Mconstants->sslStatus[$s['SSLDetailStatusId']] . '</span>';
                                                                $textDays = 'Còn hạn';
                                                                if($totalDay < 30) $textDays = 'Săp hết hạn';
                                                               ?>
                                                                <tr data-id="<?php echo $s['PackageId']; ?>">
                                                                    <td><?php echo $key + 1; ?></td>
                                                                    <td><?php echo $packageDetail['PackageName']; ?></td>
                                                                    <td><?php echo $packageDetail['PackageCode']; ?></td>
                                                                    <?php if ($totalDayDetail > 0) { ?>
                                                                        <td>
                                                                                <span class="label label-primary">
                                                                                <?php echo $textDays; ?>: <?php echo $totalDayDetail; ?> ngày
                                                                                </span>
                                                                        </td>
                                                                        <!--                                                                                <td><span class="label label-success">Đang dùng dịch vụ</span></td>-->
                                                                        <td><span class="label label-danger">Đang tạm cắt</span>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td><span class="label label-danger">Đang hết hạn</span>
                                                                        </td>
                                                                        <td><?php echo $statusSSLDetail; ?></td>
                                                                    <?php } ?>
                                                                    <?php if ($s['SSLDetailStatusId'] == 3) { ?>
                                                                        <td><span class="label label-danger">Đang tạm cắt</span>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td><span class="label label-default">Đã dừng dịch vụ</span>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            <?php }
                                                        } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (count($listHistorySSLActives) > 0): ?>
                            <div class="box box-default padding15">
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <p>Lịch sử gia hạn gói phần mềm Base bắt buộc</p>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-11">
                                                    <div class="box-body table-responsive divTable">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Thời điểm gia hạn</th>
                                                                <th>Tên gói phần mềm</th>
                                                                <th>Mã gói phần mềm</th>
                                                                <th>Mã lệnh kích hoạt</th>
                                                                <th>Xe đang gắn lúc đó</th>
                                                                <th>Lần gia hạn thứ</th>
                                                                <th>Dung lượng gia hạn</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($listHistorySSLActives as $key => $h) {
                                                                $package = $this->Mpackages->get($h['PackageId']);
                                                                if ($h['PackageId'] > 0 && $package['StatusId'] == STATUS_ACTIVED) {
                                                                    $interval = date_diff(date_create(date('Y-m-d H:i', strtotime($h['ActiveExpiryStartDate']))), date_create(date('Y-m-d H:i', strtotime($h['ActiveExpiryEndDate']))))->format('%y %m %d');
                                                                    $parts = explode(' ', $interval);
                                                                    $day = '+ ';
                                                                    if ($parts[0] > 0) $day = '+ ' . $parts[0] . ' năm';
                                                                    else if ($parts[1] > 0) $day = '+ ' . $parts[1] . ' tháng';
                                                                    else if ($parts[2] > 0) $day = '+ ' . $parts[2] . ' ngày';
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo ddMMyyyy($h['UpdateDateTime'], 'd/m/Y H:i'); ?></td>
                                                                        <td><?php echo $package['PackageName'] ?></td>
                                                                        <td><?php echo $package['PackageCode'] ?></td>
                                                                        <td><?php echo $h['DeadlineCode'] ?></td>
                                                                        <td><?php echo $this->Mvehicles->getFieldValue(array('VehicleId' => $h['VehicleId']), 'LicensePlate', '') ?></td>
                                                                        <td><?php echo $key + 1; ?></td>
                                                                        <td><?php echo $day; ?></td>
                                                                    </tr>
                                                                <?php }
                                                            } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (count($listHistorySSLActives) > 0): ?>
                            <div class="box box-default padding15">
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <p>Lịch sử gia hạn gói phần mềm mở rộng</p>
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-11">
                                                    <div class="box-body table-responsive divTable">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Thời điểm gia hạn</th>
                                                                <th>Tên gói phần mềm</th>
                                                                <th>Mã gói phần mềm</th>
                                                                <th>Mã lệnh kích hoạt</th>
                                                                <th>Xe đang gắn lúc đó</th>
                                                                <th>Lần gia hạn thứ</th>
                                                                <th>Dung lượng gia hạn</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            $countActice = 0;
                                                            $arrCheck = [];
                                                            foreach ($listHistorySSLDetailActives as $k => $h):
                                                                $package = $this->Mpackages->get($h['PackageId']);
                                                                if($package['StatusId'] == STATUS_ACTIVED):
                                                                    if (!in_array($h['PackageId'], $arrCheck, true)) {
                                                                        array_push($arrCheck, $h['PackageId']);
                                                                        $countActice = 1;
                                                                    } else {
                                                                        $countActice++;
                                                                    }
                                                                    
                                                                    $interval = date_diff(date_create(date('Y-m-d H:i', strtotime($h['ActiveExpiryStartDate']))), date_create(date('Y-m-d H:i', strtotime($h['ActiveExpiryEndDate']))))->format('%y %m %d');
                                                                    $parts = explode(' ', $interval);
                                                                    $day = '+ ';
                                                                    if ($parts[0] > 0) $day = '+ ' . $parts[0] . ' năm';
                                                                    else if ($parts[1] > 0) $day = '+ ' . $parts[1] . ' tháng';
                                                                    else if ($parts[2] > 0) $day = '+ ' . $parts[2] . ' ngày';
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo ddMMyyyy($h['UpdateDateTime'], 'd/m/Y H:i'); ?></td>
                                                                    <td><?php echo $package['PackageName']; ?></td>
                                                                    <td><?php echo $package['PackageCode']; ?></td>
                                                                    <td><?php echo $h['DeadlineCode']; ?></td>
                                                                    <td><?php echo $this->Mvehicles->getFieldValue(array('VehicleId' => $h['VehicleId']), 'LicensePlate', '') ?></td>
                                                                    <td><?php echo $countActice; ?></td>
                                                                    <td><?php echo $day; ?></td>
                                                                </tr>
                                                                <?php endif; endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-12"
                                         style="background: #eeeeee;padding-top: 15px;padding-bottom: 15px;">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <span>Mã thuê bao&nbsp;&nbsp;&nbsp;</span>
                                                <span style="color:#169bd5"><strong><?php echo $ssls['SSLCode'] ?></strong></span>
                                            </div>
                                            <div class="col-sm-6" style="text-align:right">
                                                <span class="<?php echo $labelCss[$ssls['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$ssls['SSLStatusId']]; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 form-group" style="top: 30px;">
                                    <h4><i class="fa fa-fw fa-user"></i> Khách hàng</h4>
                                    <div class="boxInfo">
                                        <div class="col-sm-12" style="border: 1px solid;">
                                            <p class="fullName"><?php echo $customer['FullName']; ?></p>
                                            <p>ID : <span
                                                        class="userCode"><?php echo $customer['UserName']; ?></span>
                                            </p>
                                            <p>SĐT : <span
                                                        class="phoneNumber"><?php echo $customer['PhoneNumber']; ?></span>
                                            </p>
                                            <p>Địa chỉ : <span
                                                        class="address"><?php echo $this->Mprovinces->getFieldValue(array('ProvinceId' => $customer['ProvinceId']),'ProvinceName','') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group" style="top: 30px;">
                                    <h4><i class="fa fa-fw fa-car"></i> Đang gán cho xe</h4>
                                    <div class="boxInfo">
                                        <div class="col-sm-12" style="border: 1px solid;">
                                            <?php
                                            $licensePlate = $this->Mvehicles->getFieldValue(array('VehicleId' => $ssls['VehicleId']), 'LicensePlate', '');
                                            if (!empty($licensePlate)) echo "<p>" . $licensePlate . "</p> ";
                                            else { ?>
                                                <?php $this->Mconstants->selectObject($listVehicles, 'VehicleId', 'LicensePlate', 'VehicleId', 0, true, '--Chọn xe--', ' select2') ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group" style="top: 30px;">
                                    <h4><i class="fa fa-fw fa-flash"></i> Trạng thái SSL chi tiết</h4>
                                    <div class="boxInfo">
                                        <div class="col-sm-12" style="border: 1px solid;">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p>Tình trạng hợp đồng SSL </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php
                                                    if (count($ssls) > 0) {
                                                        if (!in_array($ssls['SSLStatusId'], [3, 5])) {
                                                            ?>
                                                            <span class="label label-success">Đang dùng dịch vụ</span>
                                                        <?php } else { ?>
                                                            <span class="<?php echo $labelCss[$ssls['SSLStatusId']]; ?>"><?php echo $this->Mconstants->sslStatus[$ssls['SSLStatusId']] ?></span>
                                                        <?php }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p>Tình trạng dung lượng SSL</p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php
                                                    if (count($ssls) > 0) {
                                                        if ($ssls['SSLStatusId'] > 0) {
                                                            if ($totalDay >= 30) {
                                                                echo '<span class="label label-primary">Còn hạn</span>';
                                                            } else if ($totalDay > 0 && $totalDay < 30) {
                                                                echo '<span class="label label-primary">Sắp hết hạn</span>';
                                                            } else {
                                                                echo '<span class="label label-danger">Đang hết hạn</span>';
                                                            }
                                                        }
                                                    } else {
                                                        echo "---";
                                                    }

                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row boxInfo">
                                        <p class="text-center">Được gán vào xe từ : <?php echo $daySsl ?> - Nay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($ssls) { ?>
                            <div class="row d-img-none">
                                <div class="col-sm-12 text-center">
                                    <button type="button" class="btn btn-primary" id="removeSslCart"
                                            data-ssl="<?php echo $sslId ?>" data-vehicleId="<?php echo $vehicleId ?>" data-sslvehiclelog="<?php echo isset($sslvehiclelogID)?$sslvehiclelogID:'0' ?>" data-statuss="2">Gỡ
                                        : Thuê bao SSL này khỏi xe
                                    </button>
                                    <input type="hidden" id="urlremoveSslCart"
                                           value="<?php echo base_url('ssl/removeSslCart'); ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <br>
                        <div class="box box-default classify padding20">
                            <?php 
                                $this->load->view('includes/action_logs', 
                                        array(
                                            'listActionLogs' =>  $this->Mactionlogs->getList($vehicleId, $itemTypeId, [ID_UNASSIGN, ID_ASSIGN]),
                                            'itemId' => $vehicleId,
                                            'itemTypeId' => $itemTypeId
                                        )
                                    );
                            ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row img-html-add">
                    <div class="col-sm-8">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <p>Gói phần mềm đang sử dụng</p>

                                    <p class="text-center">[ TRỐNG ]</p>
                                </div>
                            </div>
                        </div>
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <p>Gói phần mềm đang tạm cắt hoặc dừng hoạt động</p>

                                    <p class="text-center">[ TRỐNG ]</p>
                                </div>
                            </div>
                        </div>
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <p>Lịch sử gia hạn/kích hoạt</p>
                                    <p class="text-center">[ TRỐNG ]</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 d-img-none">
                        <div class="box box-default padding15">
                            <button type="button" class="btn btn-primary" id="btnShowModalSSL">+ Thêm SSL vào xe
                            </button>
                            <input type="hidden" id="urlShowModalSSL"
                                   value="<?php echo base_url('ssl/ShowModalSSL'); ?>">
                        </div>
                        <div class="box box-default classify padding20">
                            <?php 
                                $this->load->view('includes/action_logs', 
                                        array(
                                            'listActionLogs' =>  $this->Mactionlogs->getList($vehicleId, $itemTypeId, [ID_UNASSIGN, ID_ASSIGN]),
                                            'itemId' => $vehicleId,
                                            'itemTypeId' => $itemTypeId
                                        )
                                    );
                            ?>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>
        <div class="tab-pane" id="tabSSL_2">
            <div class="box box-default padding15 d-flex">
                <table style="width:50%" class="table table-hover table-bordered text-center">
                    <tr style="background: #c7c7c7;">
                        <th>Lần thay đổi</th>
                        <th>Từ ngày</th>
                        <th>Đến ngày</th>
                        <th>Người thay đổi</th>
                        <th>Trạng thái</th>
                        <th>Thuê bao</th>
                        <th>Nội dung thuê bao giai đoạn tương ứng</th>
                    </tr>
                    <?php
                                       $sslVehicleLog =  array_reverse($sslVehicleLog);
                                       $x= count($sslVehicleLog);
                    foreach ($sslVehicleLog as $k => $sslVehicleLogs) {
                        $nameUser = $this->Mstaffs->getFieldValue(array('StaffId' => $sslVehicleLogs['CrUserId']), 'FullName', '');
                        $sslsCode = $this->Mssls->getFieldValue(array('SSLID' => $sslVehicleLogs['SSLID']), 'SSLCode', '');
                        $i = $k + 1;
                        ?>
                        <tr>
                            <td><?php echo ($i == 1) ? 'Hiện tại' : '' . $x . '' ?></td>
                            <td><?php echo $sslVehicleLogs['CrDateTime'] ?></td>
                            <td><?php echo ($i == 1) ? 'Hiện tại' : '' . $sslVehicleLogs['UpDateTime'] . '' ?></td>
                            <td><?php echo $nameUser ?></td>
                            <td><?php echo ($sslVehicleLogs['ItemStatus'] == 1) ? 'Gán thuê bao' : 'Gỡ thuê bao' ?></td>
                            <?php if ($sslVehicleLogs['ItemStatus'] == 1) { ?>
                                <td>
                                    <a href="<?php echo base_url('ssl/view/' . $sslVehicleLogs['SSLID'] . ''); ?>"><?php echo $sslsCode ?></a>
                                </td>
                            <?php } else { ?>
                                <td style="background: #e8e8e8">
                                    ---
                                </td>
                            <?php } ?>
                            <?php if (($i == $i) && ($sslVehicleLogs['ItemStatus'] == 1)) {?>
                                <td><span style="cursor: pointer;" class="active_tabssl1" ><i
                                                class="fa fa-eye" style="font-size: 24px;color: #0e90d2"></i></span>
                                </td>
                            <?php } else { ?>
                                <?php if ($sslVehicleLogs['ItemStatus'] == 1) { ?>
                                    <td><span class="show-sslVehicleLog"
                                              data-sslVehicleLogId='#sslVehicleLog_<?php echo $sslVehicleLogs['SslvehiclelogId'] ?>'><i
                                                    class="fa fa-eye" style="font-size: 24px;color: #0e90d2"></i></span>
                                    </td>
                                <?php } else { ?>
                                    <td style="background: #e8e8e8">
                                        ---
                                    </td>
                                <?php } }?>
                        </tr>
                    <?php $x = $x - 1;
                } ?>
                </table>
                <div class="push-img-width">
                    <?php
                    foreach ($sslVehicleLog as $k => $sslhtml) {
                        ?>
                        <div class="push-img row" id="sslVehicleLog_<?php echo $sslhtml['SslvehiclelogId'] ?>">
                            <?php echo $sslhtml['htmlImg'] ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalRemoveSslCart">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Áp dụng vào hệ thống</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ceo_slider" id="btnYesOrNo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalShowListSSL">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Thêm mã thuê bao SSL</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group form-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="SSLCode"
                                   placeholder="Search mã SSL hoặc biển số xe">
                        </div>
                        <table class="table table-hover table-bordered" id="table-ssl">
                            <thead>
                            <tr>
                                <th style="width:60px"></th>
                                <th>SSL</th>
                                <th>Trạng thái thuê bao SSL</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="maxheight10">
                            <table class="table table-hover table-bordered" id="table-ssl">
                                <tbody id="tbodySSL"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="btnAddSSL" data-vehicleId="<?php echo $vehicleId ?>" data-sslvehiclelog="<?php echo isset($sslvehiclelogID)?$sslvehiclelogID:'0' ?>" data-statuss="1">
                    Thêm
                </button>
                <input type="hidden" id="urlAddSSLVehice" value="<?php echo base_url('ssl/AddSSLVehice'); ?>">
            </div>
        </div>
    </div>
</div>
<style>
    #modalShowListSSL table tr td:nth-child(2), #modalShowListSSL table tr td:nth-child(3), #modalShowListSSL table tr th:nth-child(2), #modalShowListSSL table tr th:nth-child(3) {
        width: 45% !important;
    }

    #modalShowListSSL table tr td:nth-child(1), #modalShowListSSL table tr th:nth-child(1) {
        width: 10% !important;
    }

    .push-img-width {
        width: 50%;
        padding: 0 15px;
        overflow: auto;
    }

    .push-img {
        display: none;
        min-width: 1200px;
    }

    .push-img.active {
        display: block;
    }

    .push-img input[type="hidden"] {
        display: none;
    }

    .push-img .d-img-none {
        display: none;
    }

    .push-img-width .col-sm-8 {
        width: 100%;
    }

    .show-sslVehicleLog {
        cursor: pointer;
    }
.maxheight10{
    max-height: 400px;
    overflow: auto;
}
    .show-sslVehicleLog:hover .fa.fa-eye {
        color: #0a4563 !important;
    }
</style>
