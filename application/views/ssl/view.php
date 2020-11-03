<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php if ($sslId) { ?>
            <section class="content-header">
                <h1><?php echo $title; ?> <span
                    class="<?php echo $labelCss[$ssls['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$ssls['SSLStatusId']]; ?></span>
                </h1>
            </section>
            <section class="content">
                <?php echo form_open('ssl/update', array('id' => 'sslForm')); ?>
                <div class="box-body">
                    <div class="row">
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
                                                    buôc* (<span id="totalBase">0</span>)
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
                                                            $package = $this->Mpackages->get($ssls['PackageId']);
                                                            $totalDay = 0;
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
                                                                            <td class="out-of-date">
                                                                                <span class="label label-primary">
                                                                                    <?php echo $textDays; ?>: <?php echo $totalDay; ?> ngày
                                                                                </span>
                                                                            </td>
                                                                            <td><span class="label label-success">Đang dùng dịch vụ</span>
                                                                            </td>
                                                                        <?php } else { ?>
                                                                            <td><span class="label label-danger">Đang hết hạn</span>
                                                                            </td>
                                                                            <td><span class="label label-success">Đang dùng dịch vụ</span>
                                                                            </td>
                                                                        <?php } ?>
                                                                    <?php } else if (in_array($ssls['SSLStatusId'], [3, 5])) {
                                                                        if ($totalDay > 0) {
                                                                            ?>
                                                                            <td class="out-of-date">
                                                                                <span class="label label-primary">
                                                                                    <?php echo $textDays; ?>: <?php echo $totalDay; ?> ngày
                                                                                </span>
                                                                            </td>
                                                                        <?php } else { ?>
                                                                            <td><span class="label label-danger">Đang hết hạn</span>
                                                                            </td>
                                                                        <?php } ?>
                                                                        <?php if ($ssls['SSLStatusId'] == 1) { ?>
                                                                            <td><span class="label label-danger">Đang hết hạn</span>
                                                                            </td>
                                                                        <?php } else { ?>
                                                                            <td><?php echo $statusBase; ?></td>
                                                                        <?php } ?>
                                                                    <?php } else { ?>
                                                                        <td><span class="label label-danger">Đang hết hạn</span>
                                                                        </td>
                                                                        <td><span class="label label-success">Đang dùng dịch vụ</span>
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
                                                    <?php if (in_array($ssls['SSLStatusId'], [1, 2, 4])): ?>
                                                        <a href="javascript:void(0)"
                                                        class="base-package btnShowModalBase" data-id="2">
                                                        <i class="fa fa-fw fa-plus-circle"></i>
                                                    </a>
                                                <?php endif; ?>
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
                                                        $countDetailId = 0;
                                                        foreach ($listSSLDetails as $keyDetail => $s) {
                                                            $packageDetail = $this->Mpackages->get($s['PackageId']);
                                                            if ($s['ContractStatusId'] == 2 && $packageDetail['StatusId'] == STATUS_ACTIVED) {
                                                                $countDetailId++;
                                                                
                                                                $totalDayDetail = $this->Mssls->convertActiveExpiryDateToDay($s['ActiveExpiryStartDate'], $s['ActiveExpiryEndDate']);
                                                                $statusSSLDetail = '<span class="' . $labelCss[$s['SSLDetailStatusId']] . '">' . $this->Mconstants->sslStatus[$s['SSLDetailStatusId']] . '</span>';
                                                                $contractStatus = '<span class="'.$this->Mconstants->labelCssContract[$s['ContractStatusId']].'">'.$this->Mconstants->contractStatusIds[$s['ContractStatusId']].'</span>';
                                                                ?>
                                                                <tr data-id="<?php echo $s['PackageId']; ?>"
                                                                    check-add="<?php echo (($s['SSLDetailStatusId'] == 2)?'1':'0') ?>">
                                                                    <td><?php echo $countDetailId; ?></td>
                                                                    <td><?php echo $packageDetail['PackageName']; ?></td>
                                                                    <td><?php echo $packageDetail['PackageCode']; ?></td>
                                                                    <?php
                                                                    if (in_array($s['SSLDetailStatusId'], [1, 2, 4])) {
                                                                        if ($totalDayDetail > 0) {
                                                                            $textDays = 'Còn hạn';
                                                                            if($totalDayDetail < 30) $textDays = 'Săp hết hạn';
                                                                            ?>
                                                                            <td class="out-of-date">
                                                                                <span class="label label-primary">
                                                                                    <?php echo $textDays; ?>: <?php echo $totalDayDetail; ?> ngày
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $contractStatus; ?>
                                                                                <!-- <span class="label label-success">Đang dùng dịch vụ</span> -->
                                                                            </td>
                                                                        <?php } else { ?>
                                                                            <td>
                                                                                <span class="label label-danger">Đang hết hạn</span>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $contractStatus; ?>
                                                                                <!-- <span class="label label-success">Đang dùng dịch vụ</span> -->
                                                                            </td>
                                                                        <?php } ?>
                                                                    <?php } else if (in_array($s['SSLDetailStatusId'], [3, 5])) {
                                                                        if ($totalDayDetail > 0) {
                                                                            ?>
                                                                            <td class="out-of-date">
                                                                                <span class="label label-primary">
                                                                                    Còn hạn: <?php echo $totalDayDetail; ?> ngày
                                                                                </span>
                                                                            </td>
                                                                        <?php } else { ?>
                                                                            <td>
                                                                                <span class="label label-danger">Đang hết hạn</span>
                                                                            </td>
                                                                        <?php } ?>

                                                                        <td><?php echo $statusSSLDetail; ?></td>
                                                                    <?php } ?>
                                                                    <?php if ($s['SSLDetailStatusId'] == 1) { ?>
                                                                        <td>
                                                                            <span class="label label-danger">Đang hết hạn</span>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td><?php echo $statusSSLDetail; ?></td>
                                                                    <?php } ?>
                                                                    <?php if (in_array($ssls['SSLStatusId'], [2])) { ?> <!-- if (in_array($s['SSLDetailStatusId'], [2]) && $ssls['SSLStatusId'] != 6) -->
                                                                        <td><a href="javascript:void(0)"
                                                                           style="color:red"
                                                                           class="btnChangeStatus cutStatus"
                                                                           data-id="<?php echo $s['SSLDetailId']; ?>"
                                                                           package-code="<?php echo $packageDetail['PackageCode']; ?>"
                                                                           is-check="2"
                                                                           status-id="3">Cắt</a>
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
                                                        $countId = 0;
                                                        foreach ($listSSLDetails as $key => $s) {
                                                            $packageDetail = $this->Mpackages->get($s['PackageId']);
                                                            if (in_array($s['ContractStatusId'], [3,5]) && $packageDetail['StatusId'] == STATUS_ACTIVED) {
                                                                $countId++;
                                                                
                                                                $totalDayDetail = $this->Mssls->convertActiveExpiryDateToDay($s['ActiveExpiryStartDate'], $s['ActiveExpiryEndDate']);
                                                                $statusSSLDetail = '<span class="' . $labelCss[$s['SSLDetailStatusId']] . '">' . $this->Mconstants->sslStatus[$s['SSLDetailStatusId']] . '</span>';
                                                                $contractStatus = '<span class="'.$this->Mconstants->labelCssContract[$s['ContractStatusId']].'">'.$this->Mconstants->contractStatusIds[$s['ContractStatusId']].'</span>';
                                                                ?>
                                                                <tr data-id="<?php echo $s['PackageId']; ?>">
                                                                    <td><?php echo $countId; ?></td>
                                                                    <td><?php echo $packageDetail['PackageName']; ?></td>
                                                                    <td><?php echo $packageDetail['PackageCode']; ?></td>
                                                                    <?php if ($totalDayDetail > 0) { ?>
                                                                        <td class="out-of-date">
                                                                            <span class="label label-primary">
                                                                                Còn hạn: <?php echo $totalDayDetail; ?> ngày
                                                                            </span>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td><span class="label label-danger">Đang hết hạn</span></td>
                                                                    <?php } ?>
                                                                    <td><?php echo $contractStatus; ?></td>
                                                                    <td><?php echo $statusSSLDetail; ?></td>
                                                                    <?php if ($ssls['SSLStatusId'] == 2) { ?>
                                                                        <td><a href="javascript:void(0)"
                                                                            class="btnChangeStatus"
                                                                            data-id="<?php echo $s['SSLDetailId']; ?>"
                                                                            package-code="<?php echo $packageDetail['PackageCode']; ?>"
                                                                            is-check="4" status-id="<?php echo $s['ContractStatusId']; ?>"><i class="fa fa-fw fa-cog"></i></a>
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
                       <?php if ((count($listHistorySSLActives) <= 0) && (count($listHistorySSLActives) <= 0)): ?>
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
                                                            <tr>
                                                                <td colspan="7" style="text-align: center;background: #f5f5f5">Bạn chưa gia hạn lần nào cho thuê bao này
                                                                </td>
                                                            </tr>
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
                                                                $day = '';
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
                                                                $day = '';
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
                            <div class="col-sm-12" style="background: #eeeeee;padding-top: 15px;padding-bottom: 15px;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span>Mã thuê bao&nbsp;&nbsp;&nbsp;</span>
                                        <span style="color:#169bd5"><strong><?php echo $ssls['SSLCode'] ?></strong></span>
                                    </div>
                                    <div class="col-sm-6" style="text-align:right">
                                        <span class="<?php echo $labelCss[$ssls['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$ssls['SSLStatusId']]; ?></span>
                                        <?php if (($ssls['SSLStatusId'] != 1) && ($ssls['SSLStatusId'] != 6) && ($ssls['SSLStatusId'] != 5)): ?>
                                            <a href="javascript:void(0)"
                                            id="btnShowModalActiveContract"><i class="fa fa-fw fa-cog"></i></a>
                                        <?php endif; ?>
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
                                    <input type="hidden" id="userId" name="UserId"
                                    value="<?php echo $customer['UserId']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 form-group" style="top: 30px;">
                            <h4><i class="fa fa-fw fa-car"></i> Đang gán cho xe</h4>
                            <div class="boxInfo">
                                <div class="col-sm-12" style="border: 1px solid;">
                                    <?php
                                    $licensePlate = $this->Mvehicles->getFieldValue(array('VehicleId' => $ssls['VehicleId']), 'LicensePlate', '');
                                    if (!empty($licensePlate)) echo "<p>" . $licensePlate . "</p> <input type='hidden' id='vehicleId' name='VehicleId' value='" . $ssls['VehicleId'] . "'>";
                                    else { ?>
                                        <select class="form-control" id="vehicleId" name="VehicleId"><select>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 form-group" style="top: 30px;margin-bottom: 30px;">
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
                        </div>
                       
                    </div>
                </div>
                <?php if (in_array($ssls['SSLStatusId'], [3, 5])): ?>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="button" class="btn btn-primary" id="btnActiveStatusSSL">Bật
                                lại
                                thuê bao SSL
                            </button>
                        </div>
                    </div>
                    <br>
                <?php endif; ?>
                <div class="box box-default classify padding20">
                    <?php 
                        $this->load->view('includes/action_logs', 
                                array(
                                    'listActionLogs' =>  $this->Mactionlogs->getList($sslId, $itemTypeId),
                                    'itemId' => $sslId,
                                    'itemTypeId' => $itemTypeId
                                )
                            );
                    ?>
                </div>
            </div>
        </div>
        
    </div>

<ul class="list-inline pull-right">
    <?php if ($ssls['SSLStatusId'] == 1) { ?>
        <li>
            <button type="button" class="btn label-danger" id="btnRemoveStatusSSL">Hủy bỏ</button>
        </li>
    <?php }; ?>
    <li><a href="<?php echo base_url('ssl'); ?>" id="sslListUrl" class="btn btn-default">Đóng</a>
    </li>
    <?php if (in_array($ssls['SSLStatusId'], [1, 2, 4])): ?>
        <li>
            <button class="btn btn-primary submit" type="button">Cập nhật</button>
        </li>
        <input type="hidden" id="urlGetVehicleNotInSsl"
        value="<?php echo base_url('ssl/getVehicleNotInSsl'); ?>">
        <input type="hidden" id="urlGetPackages"
        value="<?php echo base_url('package/getPackages'); ?>">
    <?php endif; ?>
    <input type="hidden" id="urlChangeStatus" value="<?php echo base_url('ssl/changeStatus'); ?>">
    <input type="hidden" id="urlChangeStatusPackage"  value="<?php echo base_url('ssl/changeStatusPackage'); ?>">
    <input type="hidden" id="sslId" name="SSLId" value="<?php echo $sslId; ?>">
    <input type="hidden" id="sSLStatusId" value="<?php echo $ssls['SSLStatusId']; ?>">
    <input type="hidden" id="itemTypeId" name="ItemTypeId" value="<?php echo $itemTypeId ?>">
</ul>
<?php echo form_close(); ?>
</section>
<?php } else { ?>
    <?php $this->load->view('includes/error/not_found'); ?>
<?php } ?>
</div>

</div>
<?php $this->load->view('ssl/_modal'); ?>
<?php $this->load->view('includes/footer'); ?>