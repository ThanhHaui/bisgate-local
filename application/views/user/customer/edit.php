<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?><?php echo $roleId == 1 ? 'Khách hàng' : 'Đại lý'; ?></h1>
        </section>
        <section class="content">
            <?php if ($userId) : ?>
                <?php echo form_open('customer/update', array('id' => 'customerForm'));
                ?>
                <div class="row">
                    <div class="box box-default padding15 bg-f5">
                        <ul class="nav nav-tabs ul-log-actions">
                            <li class="active" action-type-ids="<?php echo json_encode(array(ID_CREATE,ID_UPDATE)); ?>">
                                <a href="#tab_1" data-toggle="tab">Thông tin <?php echo $roleId == 1 ? 'Khách hàng' : 'Đại lý'; ?></a>
                            </li>
                            <?php if (($roleId == 1) && ($checkvehicle > 0)) { ?>
                                <li><a href="#tab_4" data-toggle="tab">Cấu hình tốc độ max</a></li>
                            <?php } ?>
                            <li action-type-ids="<?php echo json_encode(array(ID_STATUS,ID_RESET)); ?>"><a href="#tab_5" data-toggle="tab">Tài khoản owner khách hàng</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="box box-default box-padding  mgt-30">
                                                <div class="form-group">
                                                    <label class="control-label" id="label-customer">Mã <?php echo $roleId == 1 ? 'Khách hàng' : 'Đại lý'; ?></label>
                                                    <input type="text" class="form-control" readonly value="<?php echo $customer['CodeUser']; ?>" id="customerCode">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Thông tin chung</label>
                                                </div>
                                                <div class="with-border">
                                                    <div class="form-group">
                                                        <div class="radio-group">
                                                            <span class="item"><input type="radio" name="CustomerTypeId" class="iCheck iCheckCustomerType" value="1" <?php echo $customer['CustomerTypeId'] == 1 ? 'checked' : ''; ?>> Cá nhân</span>
                                                            <span class="item"><input type="radio" name="CustomerTypeId" class="iCheck iCheckCustomerType" value="2" <?php echo $customer['CustomerTypeId'] == 2 ? 'checked' : ''; ?>> Công ty</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-body row">
                                                    <div class="personalType" style="display: <?php echo $customer['CustomerTypeId'] == 1 ? 'block' : 'none'; ?>">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tên <span class="required">*</span></label>
                                                                    <input type="text" id="personalName" class="form-control hmdrequired inputReset" value="<?php echo $customer['FullName']; ?>" data-field="Tên *">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Ngày sinh </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control datepicker inputReset" id="birthDay" name="BirthDay" value="<?php echo ddMMyyyy($customer['BirthDay']) ?>" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Giới tính</label>
                                                                    <div class="radio-group">
                                                                        <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" value="1" <?php echo $customer['GenderId'] == 1 ? 'checked' : ''; ?>> Nam</span>
                                                                        <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" value="2" <?php echo $customer['GenderId'] == 2 ? 'checked' : ''; ?>> Nữ</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">CMND </label>
                                                                    <input type="text" class="form-control inputReset" id="iDCardNumber" name="IDCardNumber" value="<?php echo $customer['IDCardNumber']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="companyType" style="display: <?php echo $customer['CustomerTypeId'] == 2 ? 'block' : 'none'; ?>">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tên công ty <span class="required">*</span></label>
                                                                    <input type="text" id="companyName" class="form-control inputReset hmdrequired" value="<?php echo $customer['FullName']; ?>" data-field="Tên công ty *">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tên viết gọn</label>
                                                                    <input type="text" id="shortName" name="ShortName" class="form-control inputReset" value="<?php echo $customer['ShortName']; ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Mã số thuế </label>
                                                                    <input type="text" id="taxCode" name="TaxCode" class="form-control inputReset" value="<?php echo $customer['TaxCode']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Lĩnh vực vận tải </label>
                                                                    <?php $this->Mconstants->selectObject($listTransportTypes, 'TransportTypeId', 'TransportTypeName', 'TransportTypeId', $customer['TransportTypeId'], true, '--Lĩnh vực vận tải--', ' select2'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">SĐT <span class="required">*</span></label>
                                                                <input type="text" id="phoneNumber" name="PhoneNumber" class="form-control inputReset" value="<?php echo $customer['PhoneNumber']; ?>" data-field="SĐT *" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Email</label>
                                                                <input type="text" id="email" name="Email" class="form-control inputReset" value="<?php echo $customer['Email']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Quốc gia </label>
                                                                <?php $this->Mconstants->selectObject($listCountries, 'CountryId', 'CountryName', 'CountryId', $customer['CountryId'], false, '', ' select2'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 VNon">
                                                            <div class="form-group">
                                                                <label class="control-label">Tỉnh <span class="required">*</span></label>
                                                                <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ProvinceId', $customer['ProvinceId'], true, '--Tỉnh / Thành--', ' select2'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Địa chỉ</label>
                                                                <input type="text" id="address" class="form-control inputReset" name="Address" value="<?php echo $customer['Address']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row companyType" style="display: <?php echo $customer['CustomerTypeId'] == 2 ? 'block' : 'none'; ?>">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Đầu mối liên hệ</label>
                                                                <div class="box box-default htmlUserGroup">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title title">Đầu mối liên hệ 1</h3>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <?php
                                                                        $itemContact = '';
                                                                        if ($itemContacts) {
                                                                            $itemContact = $itemContacts[0];
                                                                        }
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Tên</label>
                                                                                    <input type="text" class="form-control inputReset contactFullName" value="<?php echo $itemContact ? $itemContact['ContactName'] : ''; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Chức
                                                                                    vụ</label>
                                                                                    <input type="text" class="form-control inputReset contactPosition" value="<?php echo $itemContact ? $itemContact['PositionName'] : ''; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">SĐT</label>
                                                                                    <input type="text" class="form-control inputReset contactPhone" value="<?php echo $itemContact ? $itemContact['PhoneNumber'] : ''; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Email</label>
                                                                                    <input type="text" class="form-control inputReset contactEmail" value="<?php echo $itemContact ? $itemContact['Email'] : ''; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="divHtmlUserGroup">
                                                                    <?php
                                                                    if ($itemContacts && count($itemContacts) > 1) {
                                                                        for ($i = 1; $i < count($itemContacts); $i++) {
                                                                            ?>
                                                                            <div class="box box-default htmlUserGroup">
                                                                                <div class="box-header with-border">
                                                                                    <h3 class="box-title title">Đầu mối liên
                                                                                        hệ <?php echo $i + 1; ?></h3>
                                                                                        <div class="box-tools pull-right">
                                                                                            <button type="button" class="removeUserGroup"><i class="fa fa-trash-o"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Tên</label>
                                                                                                    <input type="text" class="form-control contactFullName" value="<?php echo $itemContacts[$i]['ContactName']; ?>" />
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Chức
                                                                                                    vụ</label>
                                                                                                    <input type="text" class="form-control contactPosition" value="<?php echo $itemContacts[$i]['PositionName']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">SĐT</label>
                                                                                                    <input type="text" class="form-control contactPhone" value="<?php echo $itemContacts[$i]['PhoneNumber']; ?>" />
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Email</label>
                                                                                                    <input type="text" class="form-control contactEmail" value="<?php echo $itemContacts[$i]['Email']; ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php }
                                                                        } ?>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button type="button" class="btn btn-primary" id="addUserGroup">Thêm đầu mối liên hệ
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if ($roleId == 1) : ?>
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="col-sm-12 form-group">
                                                                        <label class="control-label">Đơn vị quản lý <span class="required">*</span></label>
                                                                        <div class="radio-group">
                                                                            <span class="item"><input type="radio" name="AgentLevelId" class="iCheck connectTypeId" value="1" <?php echo ($customer['AgentLevelId'] == 1)?'checked':'' ?>> Bistech</span>
                                                                            <span class="item"><input type="radio" name="AgentLevelId" class="iCheck connectTypeId" value="2" <?php echo ($customer['AgentLevelId'] == 2)?'checked':'' ?>> Đại lý cấp 1</span>
                                                                            <span class="item"><input type="radio" name="AgentLevelId" class="iCheck connectTypeId" value="3" <?php echo ($customer['AgentLevelId'] == 3)?'checked':'' ?>> Đại lý cấp 2</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 agentCheck mgbt-10">
                                                                    <?php if($customer['AgentLevelId'] != 1) {?>
                                                                        <?php $this->Mconstants->selectObject($listStaff, 'StaffId', 'FullName', 'ManagementUnitId', $customer['ManagementUnitId'], false, '', ' select2 managementUnitId'); ?>
                                                                    <?php }?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php else : ?>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Thông tin đại lý <span class="required">*</span></label>
                                                                    </div>
                                                                </div>
                                                                <div class="box-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Loại đại lý </label>
                                                                                <?php $this->Mconstants->selectObject($listAgentTypes, 'AgentTypeId', 'AgentTypeName', 'AgentTypeId', $customer['AgentTypeId'], true, '--Loại đại lý--', ' select2'); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 VNon">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Khu vực phụ
                                                                                trách</label>
                                                                                <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ProvinceIds1[]', $provinceIds, true, '--Tỉnh / Thành--', ' select2', ' multiple'); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6" id="div_agent_start" style="display:none">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Xếp hạng đại
                                                                                lý </label>
                                                                                <?php $this->Mconstants->selectObject($listAgentStars, 'AgentStarId', 'AgentStarName', 'AgentStarId', $customer['AgentStarId'], true, '--Xếp hạng đại lý--', ' select2'); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div id="genHtml">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label">Ngày thêm</label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <span><?php echo strpos(ddMMyyyy($customer['CrStaffDateTime'], 'd/m/Y H:s'),'00:00')?ddMMyyyy($customer['CrStaffDateTime'], 'd/m/Y'):ddMMyyyy($customer['CrStaffDateTime'], 'd/m/Y H:s'); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label">Người thêm</label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <span><i class="fa fa-fw fa-user"></i> <?php echo $customer['CrName']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label">Trạng thái hoạt
                                                                            động</label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <?php $statusName = $this->Mconstants->status[$customer['StatusId']];
                                                                            ?>
                                                                            <span class="<?php $this->Mconstants->labelCss[$customer['StatusId']] ?>"><?php echo $statusName ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="box box-default mh-wrap-customer  mgt-30" id="divCustomer">
                                                        <div class="with-border">
                                                            <h3 class="box-title">Thông tin khách hàng</h3>
                                                            <div class="box-tools pull-right">

                                                            </div>
                                                            <div class="mh-info-customer">
                                                                <img class="avatar-user" src="assets/vendor/dist/img/users.png">
                                                                <div class="name-info">
                                                                    <h4><a href="javascript:void(0)" class="i-name"><?php echo $customer['FullName']; ?></a>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="box-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="item">
                                                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                                                        <span class="i-phone"><?php echo $customer['PhoneNumber']; ?></span>
                                                                    </div>
                                                                    <div class="item">
                                                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                        <span class="i-email"><?php echo $customer['Email']; ?></span>
                                                                    </div>
                                                                    <div class="item i-address">
                                                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                                        <span class="i-ward"><span class="spanAddress"><?php echo $this->Mprovinces->getFieldValue(array('ProvinceId' => $customer['ProvinceId']),'ProvinceName','') ?></span></span>
                                                                    </div>
                                                                    <div class="item">
                                                                        <i class="fa fa-id-card" aria-hidden="true"></i>
                                                                        <span class="i-country" data-id="232" data-province="0" data-district="0" data-ward="0" data-zip="">
                                                                        Viet Nam </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box box-default classify padding20">
                                                        <label class="light-blue">Ghi chú</label>
                                                        <div class="box-transprt clearfix mb10">
                                                            <button type="button" class="btn-updaten save" id="btnInsertComment1">
                                                                Lưu
                                                            </button>
                                                            <input type="text" class="add-text" id="comment1" value="" placeholder="Thêm nội dung ghi chú">
                                                        </div>
                                                        <div class="listComment" id="listComment1" style="<?php echo count($userComments) > 5 ? 'height:300px; overflow:auto' : ''; ?>">
                                                            <?php $i = 0;
                                                            $now = new DateTime(date('Y-m-d'));
                                                            foreach ($userComments as $oc) {
                                                                $fullName = $this->Mstaffs->getFieldValue(array('StaffId' => $oc['CrUserId']), 'FullName', '');
                                                                $avatar = (empty($oc['Avatar']) ? NO_IMAGE : $oc['Avatar']);
                                                                $i++; ?>
                                                                <div class="box-customer mb10">
                                                                    <table>
                                                                        <tbody>
                                                                            <tr>
                                                                                <th rowspan="2" valign="top" style="width: 50px;">
                                                                                    <img src="<?php echo USER_PATH . $avatar; ?>" alt=""></th>
                                                                                    <th><a href="javascript:void(0)" class="name"><?php echo $fullName; ?></a>
                                                                                    </th>
                                                                                    <th class="time">
                                                                                    <?php  echo $oc['CrDateTime']; ?>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="2">
                                                                                        <p class="pComment"><?php echo $oc['Comment']; ?></p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="box box-default more-tabs padding20">
                                                            <div class="form-group">
                                                                <label class="control-label" style="width: 100%;line-height: 28px;">Thẻ
                                                                    tag
                                                                    <button class="btn-updaten save btn-sm pull-right" type="button" id="btnUpdateTag">Lưu
                                                                    </button>
                                                                </label>
                                                                <input type="text" class="form-control" id="tags">
                                                            </div>
                                                            <p class="light-gray">Có thể chọn những thẻ tag đã được sử dụng</p>
                                                            <ul class="list-inline" id="ulTagExist">
                                                                <?php foreach ($listTags as $t) { ?>
                                                                    <li>
                                                                        <a href="javascript:void(0)"><?php echo $t['TagName']; ?></a>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                        <div class="box box-default padding20">
                                                            <?php 
                                                                $this->load->view('includes/action_logs', 
                                                                        array(
                                                                            'listActionLogs' =>  $this->Mactionlogs->getList($customer['UserId'], $itemTypeId, [ID_CREATE,ID_UPDATE]),
                                                                            'itemId' => $customer['UserId'],
                                                                            'itemTypeId' => $itemTypeId
                                                                        )
                                                                    );
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php if (($roleId == 1) && ($checkvehicle > 0)) { ?>
                                            <div class="tab-pane" id="tab_4">
                                                <div class="box box-body table-responsive no-padding divTable  mgt-30">
                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Chủng loại xe</th>
                                                                <th>Tốc độ tối đa cấu hình (Km/h)</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbodyVehicleType">
                                                            <?php
                                                            foreach ($listVehicletypes as $bt) {
                                                                ?>
                                                                <tr id="vehicleType_<?php echo $bt['VehicleTypeId']; ?>" data-id="<?php echo $bt['VehicleTypeId']; ?>">
                                                                    <td class="vehicleTypeName"><?php echo $bt['VehicleTypeName']; ?></td>
                                                                    <td class="maxSpeed"><?= isset($bt['MaxSpeed']) ? $bt['MaxSpeed'] : '80' ?></td>
                                                                    <td class="actions">
                                                                        <a href="javascript:void(0)" class="link_edit_type" data-id="<?php echo $bt['VehicleTypeId']; ?>" data-tonage="<?php echo $bt['TonnageId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                                            <!--                                        <a href="javascript:void(0)" class="link_delete" data-id="--><?php //echo $bt['VehicleTypeId']; 
                                                            ?>
                                                            <!--" title="Xóa"><i class="fa fa-trash-o"></i></a>-->
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="pointer-events-none"><input type="" class="form-control" id="vehicleTypeName" name="VehicleTypeName" data-field="Chủng loại xe"></td>
                                                    <td><input type="text" class="form-control" id="maxSpeed" name="MaxSpeed"></td>
                                                    <td class="actions">
                                                        <a href="javascript:void(0)" id="link_update_type" title="Cập nhật"><i class="fa fa-save"></i></a>
                                                        <a href="javascript:void(0)" id="link_cancel_type" title="Thôi"><i class="fa fa-times"></i></a>
                                                        <input type="text" name="VehicleTypeId" id="vehicleTypeId" value="0" hidden="hidden">
                                                        <input type="text" name="TonnageId" id="TonnageId" value="0" hidden="hidden">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="tab-pane" id="tab_5">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="box box-default box-padding customer_border">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="row mb-10">
                                                        <div class="col-sm-6">
                                                            <p>@user name</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="customer_name pointer-event-none" value="<?php echo $customer['UserName']; ?>" id="userName" disabled>
                                                        </div>
                                                    </div>              
                                                    <div class="row mb-10">
                                                        <div class="col-sm-6">
                                                            <p>Reset pass</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <a href="javascript:void(0)" class="customer_reset" data-id="<?php echo $customer['UserId']; ?>">Refresh</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $status = $this->Mconstants->userStatus;
                                                $labelCss = $this->Mconstants->labelCss; ?>
                                                <div class="col-sm-7">
                                                    <div class="row mb-10">
                                                    <?php
                                                        $userStatusList = $this->Mconstants->userStatusList;
                                                        $userStatusLableCss = $this->Mconstants->userStatusLableCss;
                                                    ?>
                                                        <div class="col-sm-6">
                                                            <p><span class="bold">Trạng thái SSA</span> ("user owner KH")</p>
                                                        </div>
                                                        <div class="col-sm-4 item-w100 customer-ssa">
                                                            <span class="<?php echo $userStatusLableCss[$checkLabelSsls]; ?>"><?php echo $userStatusList[$checkLabelSsls] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-10">
                                                        <div class="col-sm-6">
                                                            <p class="pl-5">Tình trạng hợp đồng</p>
                                                        </div>
                                                        <div class="col-sm-4 item-w100">
                                                            <span data-status="<?php echo $customer['StatusId']; ?>" class="customer-contract-status <?php echo $labelCss[$customer['StatusId']]; ?>"><?php echo $status[$customer['StatusId']]; ?></span>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?php if(($customer['StatusId'] == 1) || ($customer['StatusId'] == 2)){?>
                                                               <a href="javascript:void(0)" id="btnShowModalChangeStaff"><i class="fa fa-fw fa-cog"></i></a>
                                                           <?php } ?>
                                                       </div>
                                                   </div>
                                                   <div class="row mb-10">
                                                    <div class="col-sm-6">
                                                        <p class="pl-5">Khả dụng thuê bao</p>
                                                    </div>
                                                    <div class="col-sm-4 item-w100">
                                                        <?php if($checkSsls != NULL){ ?>
                                                            <span class="label label-primary customer-checkssl" data-ssl="2">Bình thường</span>
                                                        <?php }else{ ?>
                                                            <span class="label label-danger customer-checkssl" data-ssl="1">Không khả dụng</span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $arrActive = array();
                                    foreach($listMenuactive as $menuId){
                                        if($menuId['RoleStatusId'] != 3) array_push($arrActive,$menuId['RoleMenuId']);
                                    } $arrActive = array_unique($arrActive);?>
                                    <p>Tổng chức năng trong bislog của owner khách hàng (<?php echo count($arrActive) ?>/<?php echo count($listMenuCustomer) ?>)</p>
                                    <div class="customer_border box box-default box-padding">
                                        <ul style="pointer-events: none;">
                                           <?php $listMenuCustomer1 = $listMenuCustomer2 = $listMenuCustomer3 = array();
                                           foreach($listMenuCustomer as $act){
                                            if($act['RoleLevel'] == 1) $listMenuCustomer1[] = $act;
                                            elseif($act['RoleLevel'] == 2) $listMenuCustomer2[] = $act;
                                            elseif($act['RoleLevel'] == 3) $listMenuCustomer3[] = $act;
                                        }
                                        foreach($listMenuCustomer1 as $act1) {
                                            $listActionLv2 = array();
                                            foreach($listMenuCustomer2 as $act2){
                                                if($act2['RoleMenuChildId'] == $act1['RoleMenuId']) $listActionLv2[] = $act2;
                                            }
                                            if(!empty($listActionLv2)){ ?>
                                                <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act1['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act1['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act1['RoleMenuName']; ?></span>
                                                    <ul class="mgt-10">
                                                     <?php foreach($listActionLv2 as $act2){
                                                        $listActionLv3 = array();
                                                        foreach($listMenuCustomer3 as $act3){
                                                            if($act3['RoleMenuChildId'] == $act2['RoleMenuId']) $listActionLv3[] = $act3;
                                                        }
                                                        if(!empty($listActionLv3)){ ?>
                                                            <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act2['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act2['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act2['RoleMenuName']; ?></span>
                                                                <ul>
                                                                    <?php foreach($listActionLv3 as $act3){ ?>
                                                                     <li class="mgbt-10">
                                                                        <input type="checkbox" class="checktran iCheck icheckitem" value="<?php echo $act3['RoleMenuId']; ?>" <?php echo in_array($act3['RoleMenuId'], $arrActive) ?'checked':'' ?>> 
                                                                        <span><?php echo $act3['RoleMenuName']; ?></span>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                    <?php } else{ ?>
                                                        <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act2['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act2['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act2['RoleMenuName']; ?></span></li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } else{ ?>
                                        <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act1['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act1['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act1['RoleMenuName']; ?></span></li>
                                    <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-default customer_border box-padding mgt-30">
                            <div class="row ">
                                <div class="col-sm-6">
                                    <p>Ngày cấp tài khoản</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><?php echo ddMMyyyy($customer['CrStaffDateTime'], 'd/m/Y H:i'); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>Ngày đăng nhập gần nhất</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><?php echo ddMMyyyy($customer['LoginTimes'], 'd/m/Y H:i') ; ?></p>
                                </div>
                            </div>
                            <?php if($customer['StatusId'] !=2){ ?>
                                <div class=" text-center mgbt-20 mgt-20">
                                    <button type="button" class="btn btn-primary" id="btnActiveStatusUser">BẬT LẠI HỢP ĐỒNG >> VỀ BÌNH THƯỜNG
                                    </button>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="box box-default padding20">
                            <?php 
                                $this->load->view('includes/action_logs', 
                                        array(
                                            'listActionLogs' => $this->Mactionlogs->getList($customer['UserId'], $itemTypeId, [ID_STATUS,ID_RESET]),
                                            'itemId' => $customer['UserId'],
                                            'itemTypeId' => $itemTypeId
                                        )
                                    );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<ul class="list-inline pull-right margin-right-10">
    <li>
        <button class="btn btn-primary submit" type="submit">Cập nhật</button>
    </li>
    <li><a href="<?php echo base_url('customer/' . $roleId); ?>" id="customerListUrl" class="btn btn-default">Đóng</a></li>
    <input type="text" hidden="hidden" id="userListUrl" value="<?php echo base_url('customer/edit/' . $customer['UserId'] ); ?>">
    <input type="text" hidden="hidden" value="<?php echo $userId; ?>" name="UserId" id="customerUserId">
    <input type="text" hidden="hidden" value="<?php echo $roleId; ?>" name="RoleId" id="roleId">
    <input type="text" hidden="hidden" id="insertCommentUrl" value="<?php echo base_url('customer/insertComment'); ?>">
    <input type="text" hidden="hidden" id="updateItemTagUrl" value="<?php echo base_url('api/tag/updateItem'); ?>">
    <input type="text" hidden="hidden" value="<?php echo $itemTypeId ?>" id="itemTypeId">
    <input type="text" hidden="hidden" id="urlRefreshPass" value="<?php echo base_url('customer/refreshPass'); ?>">
    <input type="text" hidden="hidden" id="urlChangeStatus" value="<?php echo base_url('customer/changeStatus'); ?>">
    <input type="text" hidden="hidden" id="ajaxListAgentHtml" value="<?php echo base_url('customer/listAgentAjax'); ?>">
    <input type="text" hidden="hidden" value="<?php echo $staffIdBis ?>" name="" id="staffIdBis">
    <?php foreach ($tagNames as $tagName) { ?>
        <input type="text" hidden="hidden" class="tagName" value="<?php echo $tagName; ?>">
    <?php } ?>
</ul>
<?php echo form_close(); ?>
<?php else : ?>
    <?php $this->load->view('includes/error/not_found'); ?>
<?php endif; ?>
</section>
</div>
</div>
<input type="hidden" id="updateMaxSpeedUrl" value="<?= base_url('api/user/updateMaxSpeed') ?>" >
<div class="modal fade" role="dialog" id="modalActiveContract">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Dừng hoạt động tài khoản</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="radio-group">
                            <span class="item"><input type="radio" name="ContractStatusId" class="iCheck" value="1" checked> Tạm cắt - LOCK</span> 
                            <br><br>
                            <span class="item"><input type="radio" name="ContractStatusId" class="iCheck" value="3">Dừng hẳn luôn - STOP</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="btnActiveContract">Cắt</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="modalActiveOrCancel">
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
<?php $this->load->view('includes/footer'); ?>