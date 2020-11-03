<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php $this->load->view('includes/breadcrumb'); ?>
        <section class="content">
            <?php echo form_open('api/user/updateProfile', array('id' => 'profileForm')); ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Họ và tên <span class="required">*</span></label>
                        <input type="text" name="FullName" class="form-control hmdrequired" value="<?php echo $user['FullName']; ?>" data-field="Họ và tên">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Email <span class="required">*</span></label>
                        <input type="text" name="Email" class="form-control hmdrequired" value="<?php echo $user['Email']; ?>" data-field="Email">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Ngày sinh <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="form-control hmdrequired datepicker" name="BirthDay" value="<?php echo ddMMyyyy($user['BirthDay']); ?>" autocomplete="off" data-field="Ngày sinh">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Giới tính</label>
                        <?php $this->Mconstants->selectConstants('genders', 'GenderId', $user['GenderId']); ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Di động</label>
                        <input type="text" name="PhoneNumber" id="phoneNumber" class="form-control hmdrequired" value="<?php echo $user['PhoneNumber']; ?>" data-field="Di động">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Tỉnh/ Thành phố</label>
                        <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ResProvinceId', $user['ResProvinceId'], false, '', ' select2'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Quận huyện</label>
                        <?php echo $this->Mdistricts->selectHtml($user['ResDistrictId'],'ResDistrictId'); ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Phường xã</label>
                        <?php echo $this->Mwards->selectHtml($user['ResWardId'],'ResWardId'); ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label">Địa chỉ <span class="required">*</span></label>
                        <input type="text" name="ResAddress" class="form-control hmdrequired" value="<?php echo $user['ResAddress']; ?>" data-field="Địa chỉ">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?php $avatar = (empty($user['Avatar']) ? NO_IMAGE : $user['Avatar']); ?>
                        <img src="<?php echo USER_PATH.$avatar; ?>" class="chooseImage" id="imgAvatar" style="width: 100%;display: block;">
                        <input type="text" hidden="hidden" name="Avatar" id="avatar" value="<?php echo $avatar; ?>">
                    </div>
                    <div class="progress" id="fileProgress" style="display: none;">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <input type="file" style="display: none;" id="inputFileImage">
                    <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('file/upload'); ?>">
                </div>
                <div class="col-sm-8">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Tên đăng nhập <span class="required">*</span></label>
                                <input type="text" name="StaffName" id="userName" class="form-control" value="<?php echo $user['StaffName']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mật khẩu cũ</label>
                                <input type="password" name="StaffPass" id="userPass" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mật khẩu mới</label>
                                <input type="password" id="newPass" name="NewPass" class="form-control" data-field="Mật khẩu">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Gõ lại Mật khẩu</label>
                                <input type="password" id="rePass" class="form-control" data-field="Mật khẩu">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <input class="btn btn-primary" id="submit" type="submit" name="submit" value="Cập nhật">
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </section>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>