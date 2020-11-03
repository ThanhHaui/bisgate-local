<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
        </section>
        <section class="content font16">
            <?php $this->load->view('includes/notice'); ?>
            <?php if($staffid > 0){?>
            <div class="box box-success">
                <div class="panel-body">
                    <ul class="nav nav-tabs mgbt-20 tab-edit-pession font20 ul-log-actions">
                        <li class="tab_modal_user1 active" action-type-ids="<?php echo json_encode(array(ID_CREATE,ID_UPDATE)); ?>"><a href="#tab_1" data-toggle="tab" class="tab" data-id="1">1, Thông tin profile</a>
                        </li>
                        <li class="tab_modal_user2"><a href="#tab_2" data-toggle="tab" class="tab" data-id="2">2, Phân quyền sử dụng trong hệ thống</a>
                        </li>
                    </ul>
                    <?php echo form_open('staff/update', array('id' => 'staffForm')); ?>
                    <div class="tab-content height80vh">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row mgbt-10">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Thông tin định danh</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <div class="mgbt-10">
                                            Mã id người dùng: <?php echo $staffEdit['StaffCode'] ?>
                                        </div>
                                        <div class="row mgbt-10">
                                            <div class="col-sm-6">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-4">
                                                        <p class="mt-6">Họ tên đầy đủ <span class="red">*</span></p>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control " name="FullName" id="fullName"
                                                               placeholder="họ và tên" value="<?php echo $staffEdit['FullName'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-4">
                                                        <p class="mt-6">Biệt danh hay gọi</p>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control " name="NickName" id="NickName"
                                                               placeholder="biệt danh" value="<?php echo $staffEdit['NickName'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mgbt-10">
                                            <div class="col-sm-2">
                                                <p class="mt-6">Giới tính*</p>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-2">
                                                        <p class="mt-6"><input type="radio" name="GenderId" id="genderId" class="iCheck Radio" value="1" <?php echo ($staffEdit['GenderId']==1)?'checked':'' ?>> <span>Nam</span></p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <p class="mt-6"><input type="radio" name="GenderId" id="genderId" class="iCheck Radio" value="2" <?php echo ($staffEdit['GenderId']==2)?'checked':'' ?>> <span>Nữ</span></p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <p class="mt-6"><input type="radio" name="GenderId" id="genderId" class="iCheck Radio" value="3" <?php echo ($staffEdit['GenderId']==3)?'checked':'' ?>> <span>Khác</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mgbt-10">
                                            <div class="col-sm-6">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-4">
                                                        <p class="mt-6">Avatar</p>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <?php $avatar = (empty($staffEdit['Avatar']) ? NO_IMAGE : $staffEdit['Avatar']); ?>
                                                            <img src="<?php echo USER_PATH.$avatar; ?>" class="chooseImage" id="imgAvatar" style="width: 150px;height: 150px;display: block;">
                                                            <input type="text" hidden="hidden" name="Avatar" id="avatar" value="<?php echo $avatar; ?>">
                                                        </div>
                                                        <div class="progress" id="fileProgress" style="display: none;">
                                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <input type="file" style="display: none;" id="inputFileImage">
                                                        <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('file/upload'); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="mt-6 mgbt-10">Đôi nét về bản thân</p>
                                                <textarea type="text" rows="6" class="form-control " name="Description" id="Description"><?php echo $staffEdit['Description'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mgbt-10">
                                            <div class="col-sm-6">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-4">
                                                        <p class="mt-6">SĐT <span class="red">*</span></p>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="PhoneNumber" class="form-control " id="phoneNumber"
                                                               placeholder="" value="<?php echo $staffEdit['PhoneNumber'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-4">
                                                        <p class="mt-6">Email</p>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control " name="Email" id="Email"
                                                               placeholder="" value="<?php echo $staffEdit['Email'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mgbt-10">
                                            <div class="col-sm-6">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-4">
                                                        <p class="mt-6">Sinh nhật</p>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control datepicker" name="BirthDay" id="BirthDay"
                                                               placeholder="" value="<?php echo ddMMyyyy($staffEdit['BirthDay']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="br"></div>
                                        <div class="extend_user show_hide">
                                            <p><i class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Mở rộng</p>
                                            <div class="extend_user-info show_hide_group">
                                                <div class="p-30">
                                                    <p class="mgbt-10">Cmnd/thẻ căn cước:</p>
                                                    <div class="row mgbt-20">
                                                        <div class="col-sm-6">
                                                            <p class="mt-6">Số</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="number" class="form-control " name="CardId" id="CardId" placeholder="" value="<?php echo $staffEdit['CardId'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mgbt-20">
                                                        <div class="col-sm-6">
                                                            <p class="mt-6">Ngày cấp</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control datepicker" name="CardDate" id="CardDate"
                                                                   value="<?php echo ddMMyyyy($staffEdit['CardDate']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mgbt-20">
                                                        <div class="col-sm-6">
                                                            <p class="mt-6">Nơi cấp</p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'CardPossition', $staffEdit['CardPossition'], true, '--Nơi cấp--', ' select2'); ?>

                                                        </div>
                                                    </div>
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-6">
                                                            <div class="row mgbt-10">
                                                                <div class="col-sm-4">
                                                                    <p class="mt-6">Ảnh mặt trước</p>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="form-group">
                                                                        <?php $avatarBegin = (empty($staffEdit['AvatarBegin']) ? NO_IMAGE : $staffEdit['AvatarBegin']); ?>
                                                                        <img src="<?php echo USER_PATH . $avatarBegin; ?>" class="chooseImage1" id="imgAvatarBegin" style="width: 100%;display: block;">
                                                                        <input type="text" hidden="hidden" name="AvatarBegin" id="avatarBegin"
                                                                               value="<?php echo $avatarBegin; ?>">
                                                                    </div>
                                                                    <div class="progress" id="fileProgress1" style="display: none;">
                                                                        <div class="progress-bar progress-bar-striped active"
                                                                             role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                    <input type="file" style="display: none;" id="inputFileImage1">
                                                                    <input type="text" hidden="hidden" id="uploadFileUrl"
                                                                           value="<?php echo base_url('file/upload'); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="row mgbt-10">
                                                                <div class="col-sm-4">
                                                                    <p class="mt-6">Ảnh mặt sau</p>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="form-group">
                                                                        <?php $avatarBehind = (empty($staffEdit['avatarBehind']) ? NO_IMAGE : $staffEdit['avatarBehind']); ?>
                                                                        <img src="<?php echo USER_PATH . $avatarBehind; ?>" class="chooseImage2"
                                                                             id="imgAvatarBehind" style="width: 100%;display: block;">
                                                                        <input type="text" hidden="hidden" name="AvatarBehind"
                                                                               id="avatarBehind"
                                                                               value="<?php echo $avatarBehind; ?>">
                                                                    </div>
                                                                    <div class="progress" id="fileProgress2" style="display: none;">
                                                                        <div class="progress-bar progress-bar-striped active"
                                                                             role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                    <input type="file" style="display: none;" id="inputFileImage2">
                                                                    <input type="text" hidden="hidden" id="uploadFileUrl"
                                                                           value="<?php echo base_url('file/upload'); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Nhân khẩu học</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <div class="row mgbt-10 mgbt-10">
                                            <div class="col-sm-2">
                                                <p>Quốc tịch</p>
                                            </div>
                                            <div class="col-sm-2">
                                            <span class="check_tab_show v1" data-tab="#tab_nkh1">
                                                <input type="radio" name="NationalityId" class="iCheck Radio" value="1" <?php echo ($staffEdit['NationalityId'] == 1)?'checked':'' ?>>Việt nam
                                            </span>
                                            </div>
                                            <div class="col-sm-3">
                                            <span class="check_tab_show v2" data-tab="#tab_nkh2">
                                                <input type="radio" name="NationalityId" class="iCheck Radio" value="2" <?php echo ($staffEdit['NationalityId'] == 2)?'checked':'' ?>>Khác
                                            </span>
                                            </div>
                                        </div>
                                        <div class="tab-hide active" id="tab_nkh1">
                                            <div class="row mgbt-10">
                                                <div class="col-sm-2">
                                                    <p class="mt-6">Tình trạng quan hệ</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="mt-6">
                                                        <input type="radio" name="SexStatusId" class="iCheck Radio" value="1" <?php echo ($staffEdit['SexStatusId'] == 1)?'checked':'' ?>> Độc
                                                        thân
                                                    </p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="mt-6">
                                                        <input type="radio" name="SexStatusId" class="iCheck Radio" value="2" <?php echo ($staffEdit['SexStatusId'] == 2)?'checked':'' ?>> Đã
                                                        kết hôn
                                                    </p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="radio" name="SexStatusId" class="iCheck Radio" value="3" <?php echo ($staffEdit['SexStatusId'] == 3)?'checked':'' ?>> Đã ly hôn
                                                </div>
                                            </div>
                                            <div class="row mgbt-10 parent_address">
                                                <div class="col-sm-12">
                                                    <p class="mt-6">Nơi đang sống :</p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Tỉnh/tp</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ResProvinceId', $staffEdit['ResProvinceId'], true, '--Tỉnh/Thành phố--', ' select2'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Quận/huyện</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php echo $this->Mdistricts->selectHtml($staffEdit['ResDistrictId'],'ResDistrictId'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Phường/xã</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php echo $this->Mwards->selectHtml($staffEdit['ResWardId'],'ResWardId'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Đ/chỉ chi tiết</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="ResAddress" class="form-control " value="<?php echo $staffEdit['ResAddress'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mgbt-10 parent_address">
                                                <div class="col-sm-12">
                                                    <p class="mt-6">Quê quán :</p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Tỉnh/tp</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'HTProvinceId', $staffEdit['HTProvinceId'], true, '--Tỉnh/Thành phố--', ' select2'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Quận/huyện</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php echo $this->Mdistricts->selectHtml($staffEdit['HTDistrictId'],'HTDistrictId'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Phường/xã</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php echo $this->Mwards->selectHtml($staffEdit['HTWardId'],'HTWardId'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="mt-6">Đ/chỉ chi tiết</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="HTAddress" class="form-control " value="<?php echo $staffEdit['HTAddress'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                             </div>
                            <div class="row mgbt-10 show_hide">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold" style="pointer-events: none"><i class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Học bạ</p>
                                </div>
                                <div class="col-sm-10 show_hide_group">
                                    <div class="arr-hb">
                                        <?php foreach ($schoolreports as $schoolreport) {?>
                                            <div class="border-hb mgbt-10">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-6">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-4">
                                                                <p>Tên bằng cấp</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" id= "diploma" class="form-control "
                                                                value="<?php echo $schoolreport['Diploma'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-4">
                                                                <p>Loại bằng</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <?php $this->Mconstants->selectConstants('diplomaTypeId', 'DiplomaTypeId', $schoolreport['DiplomaTypeId']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-6">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-4">
                                                                <p>Tên trường</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="schoolName" class="form-control "
                                                                value="<?php echo $schoolreport['SchoolName'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-4">
                                                                <p>Tên ngành</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="industryName" class="form-control "
                                                                value="<?php echo $schoolreport['IndustryName'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-6">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-4">
                                                                <p>Khóa học từ</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="startDate" class="form-control datepicker"
                                                                value="<?php echo ddMMyyyy($schoolreport['StartDate']); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-4">
                                                                <p>Đến</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="endDate" class="form-control datepicker"
                                                                value="<?php echo ddMMyyyy($schoolreport['EndDate']); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <p>
                                        <a href="javascript:void(0)" class="btnAddHb" data-id="2">
                                            <i class="fa fa-fw fa-plus-circle"></i>
                                        </a>Thêm bằng cấp khác
                                    </p>
                                </div>
                            </div>
                            <div class="row mgbt-20 show_hide border-work">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold" style="pointer-events: none"><i class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Công việc</p>
                                </div>
                                <div class="col-sm-10 show_hide_group">
                                    <div class="row mgbt-10">
                                        <div class="col-sm-3">
                                            <p class="mt-6">Ngày bắt đầu làm</p>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="JobDate" class="form-control datepicker" value="<?php echo ddMMyyyy($staffEdit['JobDate']);?>">
                                        </div>
                                    </div>
                                    <div class="row mgbt-10">
                                        <div class="col-sm-12">
                                            <p class="mt-6">Chức danh hiện tại :</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="row mgbt-10">
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-4">
                                                            <p class="mt-6">Cấp bậc</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <?php $this->Mconstants->selectConstants('jobLevelId', 'JobLevelId',$staffEdit['JobLevelId']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-4">
                                                            <p class="mt-6">Phòng ban</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="JobDepartment" class="form-control " value="<?php echo $staffEdit['JobDepartment'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mgbt-10">
                                        <div class="col-sm-12">
                                            <p class="mt-6">
                                                <a href="javascript:void(0)" class="btnAddCDKN" data-id="2">
                                                    <i class="fa fa-fw fa-plus-circle"></i>
                                                </a>
                                            Chức danh kiêm nhiệm khác :</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="arr-cdkn">
                                                <?php foreach ($jobtitles as $jobtitle) {?>
                                                    <div class="row mgbt-10 item-cdkn">
                                                        <div class="col-sm-2">
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="row mgbt-10">
                                                                <div class="col-sm-4">
                                                                    <p class="mt-6">Cấp bậc</p>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <?php $this->Mconstants->selectConstants('jobLevelId', 'JobLevelIdOther',$jobtitle['LevelId']); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="row mgbt-10">
                                                                <div class="col-sm-4">
                                                                    <p class="mt-6">Phòng ban</p>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <input type="text" id="jobDepartmentOther" class="form-control " value="<?php echo $jobtitle['Department'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mgbt-10">
                                        <div class="col-sm-12">
                                            <p class="mt-6">
                                                <a href="javascript:void(0)" class="btnAddKMCT" data-id="2">
                                                    <i class="fa fa-fw fa-plus-circle"></i>
                                                </a>
                                            Kinh nghiệm công tác :</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="arr-knct">
                                                <?php foreach ($experiences as $experience) {?>
                                                    <div class="border-hb mgbt-10">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-2">
                                                                Giai đoạn
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row mgbt-10">
                                                                    <div class="col-sm-4">
                                                                        <p class="mt-6">Từ</p>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" id="exStartDate" class="form-control datepicker" value="<?php echo ddMMyyyy($experience['StartDate']) ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row mgbt-10">
                                                                    <div class="col-sm-4">
                                                                        <p class="mt-6">Đến</p>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" id="exEndDate" class="form-control datepicker" value="<?php echo ddMMyyyy($experience['EndDate']) ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="br"></div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-2">
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row mgbt-10">
                                                                    <div class="col-sm-4">
                                                                        <p class="mt-6">Cấp bậc</p>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <?php $this->Mconstants->selectConstants('jobLevelId', 'ExLevelId',$experience['LevelId']); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row mgbt-10">
                                                                    <div class="col-sm-4">
                                                                        <p class="mt-6">Phòng ban</p>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" id="exDepartment"
                                                                        class="form-control" value="<?php echo $experience['Department'] ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-2">
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <div class="row mgbt-10">
                                                                    <div class="col-sm-2">
                                                                        <p class="mt-6">Công ty</p>
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" id="exCompanyName" class="form-control"
                                                                        value="<?php echo $experience['CompanyName'] ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-2">
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <p class="mt-6">Lĩnh vực hoạt động</p>
                                                                <textarea type="text" id="exScopeOfActivities" class="form-control"><?php echo $experience['ScopeOfActivities'] ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-2">
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <p class="mt-6">Thành tựu trong thời gian công tác</p>
                                                                <textarea type="text" id="exAchievement" class="form-control"><?php echo $experience['Achievement'] ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Ghi chú</p>
                                </div>
                                <div class="col-sm-10">
                                    <textarea type="text" name="Note" class="form-control"><?php echo $staffEdit['Note'] ?></textarea>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Thẻ tag</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="box-default more-tabs">
                                        <div class="form-group">
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
                            <div class="row mgbt-10">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-10">
                                    <div class="box-default more-tabs cover_wrap_left">
                                        <?php 
                                            $this->load->view('includes/action_logs', 
                                                    array(
                                                        'listActionLogs' =>  $this->Mactionlogs->getList($staffEdit['StaffId'], $itemTypeId, [1,2]),
                                                        'itemId' => $staffEdit['StaffId'],
                                                        'itemTypeId' => $itemTypeId
                                                    )
                                                );
                                        ?>
                                    </div>
                                </div>
                            </div>
                    <ul class="list-inline pull-right margin-right-10">
                        <li><a href="<?php echo base_url('staff'); ?>" class="btn btn-default">Hủy</a></li>
                        <li><a class="btn btn-primary staff_next" href="javascript:void(0)">Tiếp</a></li>
                    </ul>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php $status = $this->Mconstants->itemStaffStatus;
                    $staffRoleId = $this->Mconstants->staffRoleId;
                    $labelCss = $this->Mconstants->labelCss; ?>
                    <div class="cover_wrap_left">
                        <div class="row mgbt-10 d-flex align-items-center">
                            <div class="col-sm-6">
                                <div class="row mgbt-10" style="display:none">
                                    <div class="col-sm-4">
                                        <p>Loại quyền</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="<?php echo $labelCss[$staffEdit['StaffRoleId']]; ?>"><?php echo $staffRoleId[$staffEdit['StaffRoleId']]; ?></span>
                                    </div>
                                </div>
                                <div class="row mgbt-10">
                                    <div class="col-sm-4">
                                        <p>Trạng thái hoạt động</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="<?php echo $labelCss[$staffEdit['StatusId']]; ?>"><?php echo $status[$staffEdit['StatusId']]; ?></span>
                                    </div>
                                </div>
                                <div class="row mgbt-10">
                                    <div class="col-sm-4">
                                        <p>@user name*</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="not-edit">
                                            <input type="text" name="StaffName" class="form-control " value="<?php echo $staffEdit['StaffName'] ?>">

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mgbt-10">
                                    <div class="col-sm-8">
                                        <p>Thời điểm cấp tài khoản để truy cập hệ thống</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-right"><?php echo ddMMyyyy($staffEdit['CrDateTime'],'d-m-y H:i'); ?></span>
                                    </div>
                                </div>
                                <div class="row mgbt-10">
                                    <div class="col-sm-8">
                                        <p>Thời điểm login gần nhất</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="text-right"><?php echo ddMMyyyy($staffEdit['LoginTimes'],'d-m-y H:i'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p><i class="fa fa-check-square-o font20 color-blue" aria-hidden="true"></i> <span> Đổi mật khẩu</span></p>
                        <div class="change-pass">
                            <div class="row mgbt-10">
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-2">
                                    <p>Mật khẩu cũ</p>
                                </div>
                                <div class="col-sm-4">
                                    <input type="password" name="OldPass" value="" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-2">
                                    <p>Mật khẩu mới L1</p>
                                </div>
                                <div class="col-sm-4">
                                    <input type="password" id="newPass" name="NewPass" class="form-control" value=""
                                           data-field="Mật khẩu">
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-2">
                                    <p>Mật khẩu mới L2</p>
                                </div>
                                <div class="col-sm-4">
                                    <input type="password" id="rePass" name="RePass" class="form-control" value=""data-field="Mật khẩu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>Loại tài khoản</p>
                    <div class="row mgbt-10 pointer-none">
                        <div class="col-sm-2">
                                <p class="mt-6"><input type="radio"  class="iCheck Radio" value="1" <?php echo ($staffEdit['StaffRoleId']==1)?'checked':'' ?>> <span>Owner</span></p>
                        </div>
                        <div class="col-sm-2">
                                <p class="mt-6"><input type="radio"  class="iCheck Radio" value="2" <?php echo ($staffEdit['StaffRoleId']==2)?'checked':'' ?>> <span>Admin</span></p>
                        </div>
                        <div class="col-sm-2">
                                <p class="mt-6"><input type="radio"  class="iCheck Radio" value="3" <?php echo ($staffEdit['StaffRoleId']==3)?'checked':'' ?>> <span>Member</span></p>
                        </div>
                    </div>
                    <div class="cover_wrap_left">
                            <?php if(($staffEdit['StaffRoleId'] == 1) || $staffEdit['StaffRoleId'] == 2){ ?>
                                <div class="border_role">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Quyền chức năng hệ thống</p>
                                            <ul>
                                                <?php
                                                foreach($listActions as $action):
                                                    if ($action['ActionLevel'] == 1):
                                                        ?>
                                                        <li>
                                                            <i class="fa blue fa-check" aria-hidden="true"></i>
                                                            <?php echo $action['ActionName']?>
                                                            <ul>

                                                                <?php foreach($listActions as $actionLv2):
                                                                    if ($actionLv2['ActionLevel']==2 && $actionLv2['ParentActionId'] == $action['ActionId']):
                                                                        ?>
                                                                        <li>
                                                                            <i class="fa blue fa-check" aria-hidden="true"></i>
                                                                            <?php echo $actionLv2['ActionName']?>
                                                                            <ul>
                                                                                <?php foreach($listActions as $actionLv3):
                                                                                    if ($actionLv3['ActionLevel']==3 && $actionLv3['ParentActionId'] == $actionLv2['ActionId']):
                                                                                        ?>
                                                                                        <li>
                                                                                            <i class="fa blue fa-check" aria-hidden="true"></i>
                                                                                            <?php echo $actionLv3['ActionName']?>
                                                                                        </li>
                                                                                    <?php
                                                                                    endif;
                                                                                endforeach
                                                                                ?>
                                                                            </ul>
                                                                        </li>
                                                                    <?php
                                                                    endif;
                                                                endforeach
                                                                ?>
                                                            </ul>
                                                        </li>
                                                    <?php
                                                    endif;
                                                endforeach;
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6">
                                            <p>Quyền quản trị người dùng</p>
                                            <ul>
                                                <li><i class="fa <?php echo ($staffEdit['StaffRoleId'] == 1)?'blue fa-check':'red fa-times' ?>" aria-hidden="true"></i>  Quản lý tài khoản Admin</li>
                                                <li><i class="fa blue fa-check" aria-hidden="true"></i>  Quản lý tài khoản member</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <table class="table table-hover table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Thời điểm thêm</th>
                                            <th>Mã vai trò</th>
                                            <th>Tên vai trò</th>
                                        </tr>
                                    </thead>
                                    <tbody  id="tbodyGroupStaff">
                                        <?php
                                        foreach ($listGroupIds as $k => $listGroupId) {
                                            foreach ($listGroups as $listGroup) {
                                                if($listGroup['GroupId'] == $listGroupId['GroupId']){
                                                    ?>
                                                    <tr data-id="<?php echo $listGroup['GroupId'] ?>">
                                                        <td><?php echo $k + 1 ?></td>
                                                        <td><?php echo ddMMyyyy($listGroupId['CrDateTime']); ?></td>
                                                        <td><?php echo $listGroup['GroupName'] ?></td>
                                                        <td><?php echo $listGroup['GroupCode'] ?></td>
                                                    </tr>
                                                <?php }
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    <ul class="list-inline pull-right margin-right-10">
                        <li><a href="<?php echo base_url('staff'); ?>" class="btn btn-default">Đóng</a></li>
                        <li><button class="btn btn-primary submit" data-user="0" type="submit">Cập nhật</button></li>
                        <!-- <li><a href="javascript:void(0)" class="btn btn-default edit-pession-update">Cập nhật</a></li> -->
                    </ul>
                    </div>
                <input type="hidden" name="SchoolReports" id="SchoolReports" class="form-control " value="">
                <input type="hidden" name="JobTitles" id="JobTitles" class="form-control " value="">
                <input type="hidden" name="Experiences" id="Experiences" class="form-control " value="">
                <input type="text" name="StaffId" id="staffId" hidden="hidden" value="<?php echo $staffid ?>">
                <input type="hidden" name="StatusId" class="form-control " value="<?php echo $staffEdit['StatusId'] ?>">
                <input type="hidden" name="StaffRoleId" id="staffRoleId" value="<?php echo $staffEdit['StaffRoleId'] ?>">
                <input type="text" hidden="hidden" id="updateItemTagUrl" value="<?php echo base_url('api/tag/updateItem'); ?>">
                <input type="hidden" id="itemTypeId" value="<?php echo $itemTypeId; ?>">
                
                <a href="<?php echo base_url('user')?>" id="login"></a>
                <?php foreach($tagNames as $tagName){ ?>
                    <input type="text" hidden="hidden" class="tagName" value="<?php echo $tagName; ?>">
                <?php } ?>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?php }?>
</section>
</div>
</div>
<?php $this->load->view('includes/footer'); ?>

