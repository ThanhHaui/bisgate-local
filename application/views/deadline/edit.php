<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php if ($deadlineId) { ?>
                <section class="content-header">
                    <h1><?php echo $title; ?> </h1>
                </section>
                <section class="content">
                    <div class="box-body">
                        <div class="col-sm-12">
                            <h3>Trạng thái lệnh gia hạn:
                                <span class="<?php echo $this->Mconstants->labelCss[$deadline['DeadlineStatusId']] ?>"><?php echo $this->Mconstants->deadlineStatus[$deadline['DeadlineStatusId']] ?></span>
                                <?php  if ($SSLTrial == 2) { ?>
                                    <span class="label label-danger">Gói dùng thử sau khi lắp đặt thiết bị</span>
                                <?php } ?>
                            </h3>
                        </div>
                        <div class="col-sm-8">
                            <div class="row htmlGroupExtension">
                                <div class="col-sm-12 form-group groupExtension" id="group_1" count-id="1">
                                    <div class="box box-default">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Nhóm gia hạn chung 1</h3>
                                            <?php if ($checkEdit): ?>
                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool"
                                                            data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    <button type="button" class="btn btn-box-tool remove_group"
                                                            count-id="1"><i class="fa fa-remove"></i></button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-2"></div>
                                                    <div class="col-sm-10">
                                                        <p>
                                                            <?php if ($checkEdit): ?>
                                                                <a href="javascript:void(0)" class="base-package"
                                                                   data-id="1" count-id="1">
                                                                    <input class="check-show-base" type="checkbox"
                                                                           value="">
                                                                </a>
                                                            <?php endif; ?>
                                                            Gói phần mềm base bắt buộc (<span
                                                                    id="totalBase_1"><?php echo $deadline['PackageId'] == 0 ? 0 : 1 ?></span>)
                                                        </p>
                                                        <div class="box-body table-responsive divTable">
                                                            <?php if ($SSLTrial == 2) { ?>
                                                                <table class="table table-hover table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width:60px">STT</th>
                                                                        <th>Tên gói phần mềm</th>
                                                                        <th>Số giờ</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="tbodyBase_1">
                                                                    <?php if ($deadline['PackageId']): ?>
                                                                        <tr data-id="<?php echo $deadline['PackageId']; ?>">
                                                                            <td>1</td>
                                                                            <td><?php echo $this->Mpackages->getFieldValue(array('PackageId' => $deadline['PackageId'], 'StatusId' => STATUS_ACTIVED), 'PackageName', ''); ?></td>
                                                                            <td>
                                                                                <?php $endDate = strtotime($deadline['ActiveExpiryEndDate']);
                                                                                $startDate = strtotime($deadline['ActiveExpiryStartDate']);
                                                                                $today = strtotime(getCurentDateTime());
                                                                                if ($startDate > $today) {
                                                                                    $gio = floor(($endDate - $startDate) / 3600);
                                                                                    if ($gio >= 1) {
                                                                                        ?>
                                                                                        <input class=" cost packagePriceBase"
                                                                                               value="<?php echo $gio ?>"
                                                                                               readonly>
                                                                                        giờ
                                                                                    <?php } else { ?>
                                                                                        Dưới 1 giờ
                                                                                    <?php } ?>
                                                                                <?php } else if (($startDate < $today) && ($today < $endDate)) {
                                                                                    $gio1 = floor(($endDate - $today) / 3600);
                                                                                    if ($gio1 >= 1) {
                                                                                        ?>
                                                                                        <input class=" cost packagePriceBase"
                                                                                               value="<?php echo $gio1 ?>"
                                                                                               readonly>
                                                                                        giờ
                                                                                    <?php } else { ?>
                                                                                        Dưới 1 giờ
                                                                                    <?php } ?>
                                                                                <?php } else { ?>
                                                                                    <span class="label label-danger">Đã hết hạn</span>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            <?php } else { ?>
                                                                <table class="table table-hover table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width:60px">STT</th>
                                                                        <th>Tên gói phần mềm</th>
                                                                        <th>Giá</th>
                                                                        <th>Số tháng</th>
                                                                        <th>Thành tiền</th>
                                                                        <?php if ($checkEdit): ?>
                                                                            <th></th>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="tbodyBase_1">
                                                                    <?php if ($deadline['PackageId']): ?>
                                                                        <tr data-id="<?php echo $deadline['PackageId']; ?>">
                                                                            <td>1</td>
                                                                            <td><?php echo $this->Mpackages->getFieldValue(array('PackageId' => $deadline['PackageId'], 'StatusId' => STATUS_ACTIVED), 'PackageName', ''); ?></td>
                                                                            <?php if ($checkEdit): ?>
                                                                                <td>
                                                                                    <input class=" cost packagePriceBase"
                                                                                           value="<?php echo priceFormat($deadline['PackagePrice']); ?>">
                                                                                    đ/tháng
                                                                                </td>
                                                                                <td><input class=" cost expiryDateBase"
                                                                                           value="<?php echo $deadline['ExpiryDate'] ?>">
                                                                                    tháng
                                                                                </td>
                                                                            <?php else: ?>
                                                                                <td><?php echo priceFormat($deadline['PackagePrice']); ?>
                                                                                    đ/tháng
                                                                                </td>
                                                                                <td><?php echo $deadline['ExpiryDate'] ?>
                                                                                    tháng
                                                                                </td>
                                                                            <?php endif; ?>
                                                                            <td class="packageTotalPrice"><?php echo priceFormat($deadline['ExpiryDate'] * $deadline['PackagePrice']); ?></td>
                                                                            <?php if ($checkEdit): ?>
                                                                                <td><a href="javascript:void(0)"
                                                                                       class="link_delete_base"
                                                                                       title="Xóa" count-id="1"><i
                                                                                                class="fa fa-trash-o"></i></a>
                                                                                </td>
                                                                            <?php endif; ?>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                    </tbody>
                                                                </table>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <div class="col-sm-2"></div>
                                                    <div class="col-sm-10">
                                                        <p>
                                                            <?php if ($checkEdit): ?>
                                                                <a href="javascript:void(0)"
                                                                   class="base-package btnShowModalBase" data-id="2"
                                                                   count-id="1">
                                                                    <i class="fa fa-fw fa-plus-circle"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            Gói phần mềm mở rộng (<span
                                                                    id="totalSslDetail_1"><?php echo count($listDeadlineDetails); ?></span>)
                                                        </p>
                                                        <div class="box-body table-responsive divTable">
                                                            <?php if ($SSLTrial == 2) { ?>
                                                                <table class="table table-hover table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width:60px">STT</th>
                                                                        <th>Tên gói phần mềm</th>
                                                                        <th>Số giờ</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="tbodySslDetails_1">
                                                                    <?php foreach ($listDeadlineDetails as $key => $detail1) {
                                                                        ?>
                                                                        <tr data-id="<?php echo $detail1['PackageId']; ?>">
                                                                            <td><?php echo $key + 1; ?></td>
                                                                            <td><?php echo $this->Mpackages->getFieldValue(array('PackageId' => $detail1['PackageId'], 'StatusId' => STATUS_ACTIVED), 'PackageName', ''); ?></td>
                                                                            <td>
                                                                                <?php $endDate1 = strtotime($detail1['ActiveExpiryEndDate']);
                                                                                $startDate1 = strtotime($detail1['ActiveExpiryStartDate']);
                                                                                $today1 = strtotime(getCurentDateTime());
                                                                                if ($startDate1 > $today1) {
                                                                                    $gio2 = floor(($endDate1 - $startDate1) / 3600);
                                                                                    if ($gio2 >= 1) {
                                                                                        ?>
                                                                                        <input class=" cost packagePriceBase"
                                                                                               value="<?php echo $gio2 ?>"
                                                                                               readonly>
                                                                                        giờ
                                                                                    <?php } else { ?>
                                                                                        Dưới 1 giờ
                                                                                    <?php } ?>
                                                                                <?php } else if (($startDate1 < $today1) && ($today1 < $endDate1)) {
                                                                                    $gio3 = floor(($endDate1 - $today1) / 3600);
                                                                                    if ($gio3 >= 1) {
                                                                                        ?>
                                                                                        <input class=" cost packagePriceBase"
                                                                                               value="<?php echo $gio3 ?>"
                                                                                               readonly>
                                                                                        giờ
                                                                                    <?php } else { ?>
                                                                                        Dưới 1 giờ
                                                                                    <?php } ?>
                                                                                <?php } else { ?>
                                                                                    <span class="label label-danger">Đã hết hạn</span>
                                                                                <?php } ?>

                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            <?php } else { ?>
                                                                <table class="table table-hover table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width:60px">STT</th>
                                                                        <th>Tên gói phần mềm</th>
                                                                        <th>Giá</th>
                                                                        <th>Số tháng</th>
                                                                        <th>Thành tiền</th>
                                                                        <?php if ($checkEdit): ?>
                                                                            <th></th>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="tbodySslDetails_1">
                                                                    <?php foreach ($listDeadlineDetails as $key => $detail) {
                                                                        ?>
                                                                        <tr data-id="<?php echo $detail['PackageId']; ?>">
                                                                            <td><?php echo $key + 1; ?></td>
                                                                            <td><?php echo $this->Mpackages->getFieldValue(array('PackageId' => $detail['PackageId'], 'StatusId' => STATUS_ACTIVED), 'PackageName', ''); ?></td>
                                                                            <?php if ($checkEdit): ?>
                                                                                <td>
                                                                                    <input class=" cost packagePriceSslDetails"
                                                                                           value="<?php echo priceFormat($detail['PackagePrice']); ?>">
                                                                                    đ/tháng
                                                                                </td>
                                                                                <td>
                                                                                    <input class=" cost expiryDateSslDetails"
                                                                                           value="<?php echo $detail['ExpiryDate'] ?>">
                                                                                    tháng
                                                                                </td>
                                                                            <?php else: ?>
                                                                                <td><?php echo priceFormat($detail['PackagePrice']); ?>
                                                                                    đ/tháng
                                                                                </td>
                                                                                <td><?php echo $detail['ExpiryDate'] ?>
                                                                                    tháng
                                                                                </td>
                                                                            <?php endif; ?>
                                                                            <td class="packageTotalPrice"><?php echo priceFormat($detail['ExpiryDate'] * $detail['PackagePrice']); ?></td>
                                                                            <?php if ($checkEdit): ?>
                                                                                <td><a href="javascript:void(0)"
                                                                                       class="link_delete_ssldetail"
                                                                                       title="Xóa"
                                                                                       count-id="<?php echo $key + 1; ?>"><i
                                                                                                class="fa fa-trash-o"></i></a>
                                                                                </td>
                                                                            <?php endif; ?>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="custom-hr">
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <div class="col-sm-2"></div>
                                                    <div class="col-sm-10">
                                                        <p>
                                                            <?php if ($checkEdit): ?>
                                                                <a href="javascript:void(0)"
                                                                   class="base-package btnShowModalSSL" count-id="1">
                                                                    <i class="fa fa-fw fa-plus-circle"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            Danh sách thuê bao SSL (<span
                                                                    id="totalSsl_1">0</span>)
                                                        </p>
                                                        <div class="box-body table-responsive divTable" style="max-height: 418px;overflow: auto;">
                                                            <table class="table table-hover table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th style="width:60px">STT</th>
                                                                    <th>Mã thuê bao SSL</th>
                                                                    <th>Biển số xe</th>
                                                                    <th>Lần gia hạn gần nhất</th>
                                                                    <th>Cảnh báo</th>
                                                                    <?php if ($checkEdit): ?>
                                                                        <th></th>
                                                                    <?php endif; ?>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbodySsl_1">
                                                                <?php foreach ($listDeadlinessls as $k => $deadlineSSL) {
                                                                    $ssl = $this->Mssls->get($deadlineSSL['SSLId']);
                                                                    // ngày gia hạng gần nhất
                                                                    $ssl['Extension'] = '';
                                                                    if (in_array($ssl['SSLStatusId'], [1, 2, 4])) {
                                                                    if ($ssl['SSLStatusId'] == 1) {
                                                                        $ssl['Extension'] = 'Đăng ký lần đầu, chờ kích hoạt';
                                                                    } else if (in_array($ssl['SSLStatusId'], [2, 4])) {
                                                                        $ssl['Extension'] = $this->Mconstants->formatDate($ssl['UpdateDateTime']);
                                                                    }
                                                                    ?>
                                                                    <tr data-id="<?php echo $deadlineSSL['SSLId'] ?>"
                                                                        vehicle-id="<?php echo $ssl['VehicleId'] ?>"
                                                                        style=""
                                                                        status-id="<?php echo $ssl['SSLStatusId'] ?>">
                                                                        <td><?php echo $k + 1; ?></td>
                                                                        <td><?php echo $ssl['SSLCode']; ?></td>
                                                                        <td><?php echo $this->Mvehicles->getFieldValue(array('VehicleId' => $ssl['VehicleId']), 'LicensePlate', ''); ?></td>
                                                                        <td><?php echo $ssl['Extension']; ?></td>
                                                                        <td></td>
                                                                        <?php if ($checkEdit): ?>
                                                                            <td><a href="javascript:void(0)"
                                                                                   class="link_delete_ssl" title="Xóa"
                                                                                   count-id="<?php echo $k + 1; ?>"><i
                                                                                            class="fa fa-trash-o"></i></a>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                    </tr>
                                                                <?php } } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($checkEdit): ?>
                                <div class="row">
                                    <p><a href="javascript:void(0)" class="base-package btnAddGroupExtension"
                                          style="font-size:30px">
                                            <i class="fa fa-fw fa-plus-circle"></i></a> Thêm nhóm gia hạn
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-4">
                            <div class="box box-default padding15">
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <h4><i class="fa fa-fw fa-sticky-note-o"></i> Khách hàng</h4>
                                    </div>
                                    <div class="box-search-advance customer">
                                        <div class="col-sm-12 form-group">
                                            <div>
                                                <div class="row boxInfo" style="display:block">
                                                    <div class="col-sm-10">
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-default classify padding20">
                                <?php 
                                    $this->load->view('includes/action_logs', 
                                            array(
                                                'listActionLogs' =>  $this->Mactionlogs->getList($deadline['DeadlineId'], $itemTypeId),
                                                'itemId' =>$deadline['DeadlineId'],
                                                'itemTypeId' => $itemTypeId
                                            )
                                        );
                                ?>
                            </div>

                        </div>
                    </div>
                    <ul class="list-inline pull-right">
                        <li><a href="<?php echo base_url('deadline'); ?>" id="deadlineListUrl" class="btn btn-default">Đóng</a>
                        </li>
                        <?php if ($checkEdit): ?>
                            <li><a href="javascript:void(0);" id="btnCancelDeadline"
                                   data-url="<?php echo base_url('deadline/cancelDeadline'); ?>" class="btn btn-danger"
                                   data-id="3">Hủy</a></li>
                            <li>
                                <button class="btn btn-primary submit" type="button" data-id="1">Cập nhật</button>
                            </li>
                            <li>
                                <button class="btn btn-success submit" type="button" data-id="2">Duyệt áp dụng</button>
                            </li>
                            <input type="hidden" id="urlGetVehicleNotInSsl"
                                   value="<?php echo base_url('ssl/getVehicleNotInSsl'); ?>">
                            <input type="hidden" id="urlGetSslInUser"
                                   value="<?php echo base_url('ssl/getSslInUser'); ?>">
                            <input type="hidden" id="urlGetPackages"
                                   value="<?php echo base_url('package/getPackages'); ?>">
                            <input type="hidden" id="deadlineId" name="DeadlineId" value="<?php echo $deadlineId; ?>">
                            <input type="hidden" id="itemTypeId" name="ItemTypeId" value="<?php echo $itemTypeId ?>">
                            <input type="hidden" id="urlAddMuiltDeadlines"
                                   value="<?php echo base_url('deadline/addMuilt') ?>">
                        <?php endif; ?>
                    </ul>
                </section>
                <?php if ($checkEdit): ?>
                    <?php $this->load->view('deadline/_modal'); ?>
                <?php endif; ?>
            <?php } else { ?>
                <?php $this->load->view('includes/error/not_found'); ?>
            <?php } ?>
        </div>
    </div>

<?php $this->load->view('includes/footer'); ?>