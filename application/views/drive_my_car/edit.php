<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                <?php if($userId): ?>
                    <li><button class="btn btn-primary submit">Cập nhật</button></li>
                <?php endif; ?>
                    <li><a href="<?php echo base_url('drivemycar'); ?>" class="btn btn-default">Đóng</a></li>
                </ul>
            </section>
            <section class="content">
            <?php if($userId): ?>
                <?php echo form_open('drivemycar/update', array('id' => 'driveMyCarForm')); ?>
                <div class="row">
                    <div class="box box-default padding15">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Thông tin Lái Xe</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Hiệu xuất xế</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Lương thưởng</a></li>
                            <li><a href="#tab_3" data-toggle="tab">CRM xế</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <br>
                                <div class="box box-default padding15">
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <h4><strong>Thông tin cá nhân</strong></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Mã số lái xe: <span  id="userName"><?php echo $driveMyCar['UserName'] ?></span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Tên đầy đủ <span class="required">*</span></label>
                                            <input type="text" class="form-control inputReset hmdrequired" id="fullName" name="FullName" data-field="Tên đầy đủ" value="<?php echo $driveMyCar['FullName'] ?>">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Tên thường gọi</label>
                                            <input type="text" class="form-control inputReset" id="shortName" name="ShortName" value="<?php echo $driveMyCar['ShortName'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Giới tính</label>
                                                <div class="radio-group">
                                                    <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" value="1" <?php echo $driveMyCar['GenderId'] == 1 ? 'checked':''; ?> > Nam</span>
                                                    <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" value="2" <?php echo $driveMyCar['GenderId'] == 2 ? 'checked':''; ?> > Nữ</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">SĐT <span class="required">*</span></label>
                                            <input type="text" class="form-control inputReset cost hmdrequired" id="phoneNumber" name="PhoneNumber" data-field="SĐT" value="<?php echo $driveMyCar['PhoneNumber'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control inputReset" id="email" name="Email" value="<?php echo $driveMyCar['Email'] ?>">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Ngày sinh</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker inputReset" name="BirthDay" id="birthDay" autocomplete="off" value="<?php echo $driveMyCar['BirthDay'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Số CMND</label>
                                            <input type="text" class="form-control inputReset cost" id="iDCardNumber" name="IDCardNumber" value="<?php echo $driveMyCar['IDCardNumber'] ?>">
                                            
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label class="control-label">Ảnh CMND mặt trước</label>
                                            <div class="form-group">
                                                <img src="<?php echo $userDetail['IDCardFront'] ?>" class="chooseImageIDCardFront" id="imgIDCardFront" style="width: 50%;display: <?php echo $userDetail['IDCardFront'] != '' ? 'block':'none'; ?>;">
                                                <input type="text" hidden="hidden" name="IDCardFront" id="iDCardFront" value="<?php echo $userDetail['IDCardFront'] ?>">
                                            <input type="file" style="display: none;" id="inputFileImageIDCardFront">
                                            
                                            <a href="javascript:void(0)" class="chooseImageIDCardFront btn btn-default">Chọn file</a>
                                            </div>
                                            <div class="progress" id="fileProgress_1" style="display: none;">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 form-group">
                                            <label class="control-label">Ảnh CMND mặt sau</label>
                                            <div class="form-group">
                                                <img src="<?php echo $userDetail['IDCardBack'] ?>" class="chooseImageIDCardBack" id="imgIDCardBack" style="width: 50%;display: <?php echo $userDetail['IDCardBack'] != '' ? 'block':'none'; ?>;">
                                                <input type="text" hidden="hidden" name="IDCardBack" id="iDCardBack" value="<?php echo $userDetail['IDCardBack'] ?>">
                                            <input type="file" style="display: none;" id="inputFileImageIDCardBack">
                                            <a href="javascript:void(0)" class="chooseImageIDCardBack btn btn-default">Chọn file</a>
                                            </div>
                                            <div class="progress" id="fileProgress_2" style="display: none;">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('file/upload'); ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Ngày cấp</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker inputReset" name="IDCardDate" id="iDCardDate" autocomplete="off" value="<?php echo $userDetail['IDCardDate'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Nơi cấp</label>
                                            <input type="text" class="form-control inputReset" id="iDCardAddress" name="IDCardAddress" value="<?php echo $userDetail['IDCardAddress'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="box box-default padding15">
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <h4><strong>Thông tin hành nghề</strong></h4>
                                            <label class="control-label">Giấy phép lái xe</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Ngày cấp <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker inputReset hmdrequired" name="LicenceDate" id="licenceDate" autocomplete="off" value="<?php echo $userDetail['LicenceDate'] ?>"  data-field="Ngày cấp">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Ngày hết hạn <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker inputReset hmdrequired" name="LicenceExpDate" id="licenceExpDate" autocomplete="off" value="<?php echo $userDetail['LicenceExpDate'] ?>"  data-field="Ngày hết hạn">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Mã GPLX <span class="required">*</span></label>
                                            <input type="text" class="form-control inputReset hmdrequired" id="driverLicence" name="DriverLicence" value="<?php echo $userDetail['DriverLicence'] ?>" data-field="Mã GPLX">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Loại bằng <span class="required">*</span></label>
                                            <?php $this->Mconstants->selectConstants('licenceTypes', 'LicenceTypeId', $userDetail['LicenceTypeId']); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label class="control-label">Mã thẻ RFID <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="tagsRFID">
                                        </div>
                                    </div>
                                </div>
                                <div class="box box-default padding15">
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <h4><strong>Thông tin nhân sự</strong></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="control-label">Ngày vào làm</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control datepicker inputReset" name="WorkDate" id="workDate" autocomplete="off" value="<?php echo $userDetail['WorkDate'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                            </div>
                            <div class="tab-pane" id="tab_3">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><button class="btn btn-primary submit" type="submit">Cập nhật</button></li>
                    <li><a href="<?php echo base_url('drivemycar'); ?>" id="vehicleListUrl" class="btn btn-default">Đóng</a></li>
                    <input type="text" hidden="hidden" value="<?php echo $userId ?>" name="UserId" id="myCarUserId">
                    <input type="text" hidden="hidden" value="<?php echo $userDetail['UserDetailId']; ?>" name="UserDetailId" id="">
                    <?php foreach($userCards as $tagName){ ?>
                        <input type="text" hidden="hidden" class="inputTagRFID" value="<?php echo $tagName; ?>">
                    <?php } ?>
                </ul>
                <?php echo form_close(); ?>
            <?php else: ?>
                <?php $this->load->view('includes/error/not_found'); ?>
            <?php endif; ?>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>