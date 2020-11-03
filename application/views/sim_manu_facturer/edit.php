<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php if($simManufacturerId): ?>
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
            <ul class="list-inline">
                <li><button class="btn btn-primary submit">Cập nhật</button></li>
                <li><a href="<?php echo base_url('simmanufacturer'); ?>" class="btn btn-default">Đóng</a></li>
            </ul>
        </section>
        <section class="content">
            <?php echo form_open('simmanufacturer/update', array('id' => 'simManuFacturerForm')); ?>
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box box-default padding15">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_1" data-toggle="tab">Thông tin</a></li>
                                    </ul><br>
                                    <div class="form-group">
                                        <label class="control-label">Mã ID</label>
                                        <input type="text" class="form-control" id="simManufacturerCode" readonly
                                            value="<?php echo $simmanufacturer['SimManufacturerCode']; ?>">
                                    </div>
                                    <div class=" box-padding">
                                        <div class="form-group">
                                            <label class="control-label">Thông tin chung</label>
                                        </div>
                                        <div class="with-border">
                                            <div class="form-group">
                                                <div class="radio-group">
                                                    <span class="item"><input type="radio" name="SimManufacturerTypeId"
                                                            class="iCheck iCheckCustomerType" value="1"
                                                            <?php echo $simmanufacturer['SimManufacturerTypeId'] == 1 ? 'checked' : ''; ?>>
                                                        Cá nhân</span>
                                                    <span class="item"><input type="radio" name="SimManufacturerTypeId"
                                                            class="iCheck iCheckCustomerType" value="2"
                                                            <?php echo $simmanufacturer['SimManufacturerTypeId'] == 2 ? 'checked' : ''; ?>>
                                                        Công ty</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body row">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Tên <span
                                                                class="required">*</span></label>
                                                        <input type="text" name="SimManufacturerName"
                                                            id="simManufacturerName"
                                                            class="form-control hmdrequired inputReset"
                                                            value="<?php echo $simmanufacturer['SimManufacturerName']; ?>"
                                                            data-field="Tên *">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Ngày sinh </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            <input type="text"
                                                                class="form-control datepicker inputReset" id="birthDay"
                                                                name="BirthDay"
                                                                value="<?php echo ddMMyyyy($simmanufacturer['BirthDay']) ?>"
                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Giới tính</label>
                                                        <div class="radio-group">
                                                            <span class="item"><input type="radio" name="GenderId"
                                                                    class="iCheck genderId" value="1"
                                                                    <?php echo $simmanufacturer['GenderId'] == 1 ? 'checked' : ''; ?>>
                                                                Nam</span>
                                                            <span class="item"><input type="radio" name="GenderId"
                                                                    class="iCheck genderId" value="2"
                                                                    <?php echo $simmanufacturer['GenderId'] == 2 ? 'checked' : ''; ?>>
                                                                Nữ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">CMND </label>
                                                        <input type="text" class="form-control inputReset"
                                                            id="iDCardNumber" name="IDCardNumber"
                                                            value="<?php echo $simmanufacturer['IDCardNumber']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">SĐT <span
                                                                class="required">*</span></label>
                                                        <input type="text" id="phoneNumber" name="PhoneNumber"
                                                            class="form-control inputReset"
                                                            value="<?php echo $simmanufacturer['PhoneNumber']; ?>"
                                                            data-field="SĐT *" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Email</label>
                                                        <input type="text" id="email" name="Email"
                                                            class="form-control inputReset"
                                                            value="<?php echo $simmanufacturer['Email']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Quốc gia </label>
                                                        <?php $this->Mconstants->selectObject($listCountries, 'CountryId', 'CountryName', 'CountryId', $simmanufacturer['CountryId'], false, '', ' select2'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 VNon">
                                                    <div class="form-group">
                                                        <label class="control-label">Tỉnh <span
                                                                class="required">*</span></label>
                                                        <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ProvinceId', $simmanufacturer['ProvinceId'], true, '--Tỉnh / Thành--', ' select2'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Địa chỉ</label>
                                                        <input type="text" id="address" class="form-control inputReset"
                                                            name="Address"
                                                            value="<?php echo $simmanufacturer['Address']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-sm-12 form-group">
                                                        <label class="control-label">Loại nhà mạng</label>
                                                        <?php $this->Msimmanufacturers->selectConstantMultiple('telcoIds', 'TelcoId[]',$listTelcoi,true,'',' select2','multiple="multiple"'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="genHtml">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Ngày thêm</label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <span><?php echo ddMMyyyy($simmanufacturer['CrDateTime'], 'd/m/Y'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Người thêm</label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <span><i class="fa fa-fw fa-user"></i>
                                                                <?php echo $CrName; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Trạng thái hoạt động</label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <?php $this->Mconstants->selectConstants('userStatus', 'SimManufacturerStatusId', $simmanufacturer['SimManufacturerStatusId']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="box box-default mh-wrap-customer " id="divCustomer">
                                    <div class="with-border">
                                        <h3 class="box-title">Thông tin khách hàng</h3>
                                        <div class="box-tools pull-right">

                                        </div>
                                        <div class="mh-info-customer">
                                            <img class="avatar-user" src="assets/vendor/dist/img/users.png">
                                            <div class="name-info">
                                                <h4><a href="javascript:void(0)"
                                                        class="i-name"><?php echo $simmanufacturer['SimManufacturerName']; ?></a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="item">
                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                    <span
                                                        class="i-phone"><?php echo $simmanufacturer['PhoneNumber']; ?></span>
                                                </div>
                                                <div class="item">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                    <span
                                                        class="i-email"><?php echo $simmanufacturer['Email']; ?></span>
                                                </div>
                                                <div class="item i-address">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                            <span class="i-ward"><span class="spanAddress"><?php echo $this->Mprovinces->getFieldValue(array('ProvinceId' => $simmanufacturer['ProvinceId']),'ProvinceName','') ?></span></span>

                                                </div>
                                                <div class="item">
                                                    <i class="fa fa-id-card" aria-hidden="true"></i>
                                                    <span class="i-country" data-id="232" data-province="0"
                                                        data-district="0" data-ward="0" data-zip="">
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
                                        <input type="text" class="add-text" id="comment1" value=""
                                            placeholder="Thêm nội dung ghi chú">
                                    </div>
                                    <div class="listComment" id="listComment1"
                                        style="<?php echo count($itemComments) > 5 ? 'height:300px; overflow:auto' : ''; ?>">
                                        <?php $i = 0;
                                                            $now = new DateTime(date('Y-m-d'));
                                                            foreach ($itemComments as $oc) {
                                                                $fullName = $this->Mstaffs->getFieldValue(array('StaffId' => $oc['CrUserId']), 'FullName', '');
                                                                $avatar = (empty($oc['Avatar']) ? NO_IMAGE : $oc['Avatar']);
                                                                $i++; ?>
                                        <div class="box-customer mb10">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <th rowspan="2" valign="top" style="width: 50px;">
                                                            <img src="<?php echo USER_PATH . $avatar; ?>" alt="">
                                                        </th>
                                                        <th><a href="javascript:void(0)"
                                                                class="name"><?php echo $fullName; ?></a>
                                                        </th>
                                                        <th class="time">
                                                            <?php $dayDiff = getDayDiff($oc['CrDateTime'], $now);
                                                                                        echo getDayDiffText($dayDiff) . ddMMyyyy($oc['CrDateTime'], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'); ?>
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
                                            <button class="btn-updaten save btn-sm pull-right" type="button"
                                                id="btnUpdateTag">Lưu
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-inline pull-right">
                <li><button class="btn btn-primary submit" type="submit">Cập nhật</button></li>
                <li><a href="<?php echo base_url('simmanufacturer'); ?>" id="simManuFacturerListUrl"
                        class="btn btn-default">Đóng</a></li>
                <input type="text" hidden="hidden" value="<?php echo $simmanufacturer['SimManufacturerId'] ?>"
                    name="SimManufacturerId" id="simManufacturerId">
                <input type="text" hidden="hidden" value="<?php echo $itemTypeId ?>" id="itemTypeId">
                <input type="text" hidden="hidden" id="insertCommentUrl"
                    value="<?php echo base_url('itemcomment/insertComment'); ?>">
                <input type="text" hidden="hidden" id="updateItemTagUrl"
                    value="<?php echo base_url('api/tag/updateItem'); ?>">
            </ul>
            <?php foreach($tagNames as $tagName){ ?>
            <input type="text" hidden="hidden" class="tagName" value="<?php echo $tagName; ?>">
            <?php } ?>
            <?php echo form_close(); ?>
        </section>
        <?php else: ?>
        <?php $this->load->view('includes/error/not_found'); ?>
        <?php endif; ?>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>