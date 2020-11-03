<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
        </section>
        <section class="content">
            <div class="box box-success">
                <div class="panel-body">
                    <ul class="nav nav-tabs mgbt-20  tab-add-pession">
                        <li class="tab_modal_user1 active ">
                            <a   class="tab" data-id="1">1, Thông tin profile</a>
                        </li>
                        <li class="tab_modal_user2">
                            <a   class="tab" data-id="2">2, Phân quyền sử dụng trong hệ thống</a>
                        </li>
                        <li class="tab_modal_user3 ">
<!--                            pointer-none-->
                            <a   class="tab" data-id="3">3, Kết thúc</a>
                        </li>
                    </ul>
                    <?php echo form_open('staff/update', array('id' => 'staffForm')); ?>
                        <div class="tab-content height80vh">
                            <div class="tab-pane fade in active" id="tab_1">
                                <div class="row mgbt-10">
                                    <div class="col-sm-2">
                                        <p class="mt-6 bold">Thông tin định danh</p>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="cover_wrap_left">
                                            <div class="row mgbt-10">
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-4">
                                                            <p class="mt-6">Họ tên đầy đủ <span class="red">*</span></p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control hmdrequired" name="FullName" id="fullName" placeholder="Họ và tên" data-field="Họ và tên">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-4">
                                                            <p class="mt-6">Biệt danh hay gọi</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="NickName" id="nickName" placeholder="Biệt danh">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mgbt-10">
                                                <div class="col-sm-2">
                                                    <p class="mt-6">Giới tính <span class="red">*</span></p>
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-2">
                                                            <p class="mt-6"><input type="radio" name="GenderId" class="iCheck Radio"
                                                                value="1" checked> <span>Nam</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mt-6"><input type="radio" name="GenderId"  class="iCheck Radio"
                                                                value="2"> <span>Nữ</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mt-6"><input type="radio" name="GenderId" id="genderId" class="iCheck Radio"
                                                                value="3"> <span>Khác</span>
                                                            </p>
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
                                                                <?php $avatar = (set_value('Avatar')) ? set_value('Avatar') : NO_IMAGE; ?>
                                                                <img src="<?php echo USER_PATH . $avatar; ?>" class="chooseImage"
                                                                id="imgAvatar" style="width: 150px;height:150px">
                                                                <input type="text" hidden="hidden" name="Avatar" id="avatar"
                                                                value="<?php echo $avatar; ?>">
                                                            </div>
                                                            <div class="progress" id="fileProgress" style="display: none;">
                                                                <div class="progress-bar progress-bar-striped active"
                                                                role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                            </div>
                                                            <input type="file" style="display: none;" id="inputFileImage">
                                                            <input type="text" hidden="hidden" id="uploadFileUrl"
                                                            value="<?php echo base_url('file/upload'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="mt-6 mgbt-10">Đôi nét về bản thân</p>
                                                    <textarea type="text" rows="6" class="form-control" name="Description" id="description"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mgbt-10">
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-4">
                                                            <p class="mt-6">SĐT <span class="red">*</span></p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="number" name="PhoneNumber" class="form-control hmdrequired" id="phoneNumber"
                                                            placeholder="Số điện thoại" data-field="Số điện thoại">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-4">
                                                            <p class="mt-6">Email</p>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="Email" id="email">
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
                                                            <input type="text" class="form-control datepicker" name="BirthDay" id="birthDay">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="br"></div>
                                            <div class="extend_user show_hide" style="display:none">
                                                <p><i class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Mở rộng</p>
                                                <div class="extend_user-info show_hide_group">
                                                    <div class="p-30">
                                                        <p class="mgbt-10">Cmnd/thẻ căn cước:</p>
                                                        <div class="row mgbt-20">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6">Số</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="number" class="form-control" name="CardId" id="cardId">
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-20">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6">Ngày cấp</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control datepicker" name="CardDate" id="cardDate">
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-20">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6">Nơi cấp</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'CardPossition', 0, false, '', ' select2'); ?>
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
                                                                            <?php $avatarBegin = (set_value('AvatarBegin')) ? set_value('AvatarBegin') : NO_IMAGE; ?>
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
                                                                            <?php $avatarBehind = (set_value('AvatarBehind')) ? set_value('AvatarBehind') : NO_IMAGE; ?>
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
                                        <p class="mt-6">Nhân khẩu học</p>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="cover_wrap_left">
                                            <div class="row mgbt-10 mgbt-10">
                                                <div class="col-sm-2">
                                                    <p>Quốc tịch</p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <span class="check_tab_show v1" data-tab="#tab_nkh1">
                                                        <input type="radio" name="NationalityId" class="iCheck Radio" value="1" checked="checked">Việt nam
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <span class="check_tab_show v2" data-tab="#tab_nkh2">
                                                        <input type="radio" name="NationalityId" class="iCheck Radio" value="2">Khác
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
                                                            <input type="radio" name="SexStatusId" class="iCheck Radio" value="1" checked> Độc thân
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <p class="mt-6">
                                                            <input type="radio" name="SexStatusId" class="iCheck Radio" value="2"> Đã kết hôn
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="radio" name="SexStatusId" class="iCheck Radio" value="3"> Đã ly hôn
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
                                                                <select class="form-control provinceId" name="ResProvinceId" id="resProvinceId">
                                                                </select>   
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
                                                                <select class="form-control districtId" name="ResDistrictId" id="resDistrictId">
                                                                </select>   
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
                                                                <select class="form-control wardId" name="ResWardId" id="resWardId">
                                                                </select>
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
                                                                <input type="text" name="ResAddress" class="form-control">
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
                                                                <select class="form-control provinceId" name="HTProvinceId" id="hTProvinceId">
                                                                </select>
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
                                                                <select class="form-control districtId" name="HTDistrictId" id="hTDistrictId">
                                                                </select>
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
                                                                <select class="form-control wardId" name="HTWardId" id="hTWardId">
                                                                </select>
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
                                                                <input type="text" name="HTAddress" class="form-control " value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-hide" id="tab_nkh2">
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-3">
                                                        <p class="mt-6">Tình trạng quan hệ</p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="mt-6">
                                                            <input type="radio" name="SexStatusId" class="iCheck Radio" value="1" checked> Độc thân
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="mt-6">
                                                            <input type="radio" name="SexStatusId" class="iCheck Radio" value="2"> Đã kết hôn
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="radio" name="SexStatusId" class="iCheck Radio" value="3"> Đã ly hôn
                                                    </div>
                                                </div>
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-12">
                                                        <p class="mt-6">Nơi đang sống :</p>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="ResProvinceId" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mgbt-10">
                                                    <div class="col-sm-12">
                                                        <p class="mt-6">Quê quán :</p>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="ResAddress" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mgbt-10 show_hide">
                                    <div class="col-sm-2">
                                        <p class="mt-6 bold" style="pointer-events: none">
                                            <i class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Học bạ
                                        </p>
                                    </div>
                                </div>
                                <div class="row mgbt-10 show_hide">
                                    <div class="col-sm-2">
                                        <p class="mt-6 bold" style="pointer-events: none">
                                            <i class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Công việc
                                        </p>
                                    </div>
                                </div>
                                <div class="row mgbt-10">
                                    <div class="col-sm-2">
                                        <p class="mt-6">Ghi chú</p>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea type="text" name="Note" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row mgbt-10">
                                    <div class="col-sm-2">
                                        <p class="mt-6">Thẻ tag</p>
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
                                <ul class="list-inline pull-right margin-right-10">
                                    <li><a href="<?php echo base_url('staff'); ?>" class="btn btn-default">Hủy</a></li>
                                    <li><a class="btn btn-primary staff_next" href="javascript:void(0)">Tiếp</a></li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="tab_2">
                                <div class="row mgbt-10">
                                    <div class="col-sm-2">
                                        <p class="bold">Phân quyền</p>
                                    </div>
                                    <div class="col-sm-10 border-permissions">
                                        <div class="row mgbt-10">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="control-label">@user name <span class="red">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <input type="text" name="StaffName" id="staffName" class="form-control " value=""
                                                    placeholder="viết liền không dấu, chỉ gồm chữ và số">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mgbt-10">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="control-label">Mật khẩu đăng nhập <span class="red">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group" >
                                                    <input type="text" name="StaffPass" class="form-control text-center staffPass"  value="123456"
                                                    placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mgbt-10">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="control-label">Loại tài khoản <span class="red">*</span></label>
                                                </div>
                                            </div>
                                            <?php if(($staffLogin == 1) && ($checkRole == 0)){?>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input type="radio" name="StaffRoleId" class="iCheck Radio staffRoleId"
                                                        value="2"> <span>Admin</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input type="radio" name="StaffRoleId" class="iCheck Radio staffRoleId"
                                                        value="3" checked> <span>Member</span>
                                                    </div>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="col-sm-3">
                                                    <div class="form-group" style="pointer-events: none;">
                                                        <input type="radio" name="StaffRoleId" class="iCheck Radio"
                                                        value="2"> <span>Admin</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input type="radio" name="StaffRoleId" class="iCheck Radio"
                                                        value="3" checked> <span>Member</span>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <div class="show_hide_role1">
                                            <div class="border_role">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p>Quyền chức năng hệ thống</p>
                                                        <ul>

                                                            <?php
                                                            foreach($listActions as $action):
                                                                if ($action['ActionLevel']==1):
                                                            ?>
                                                                <li>
                                                                    <i class="fa blue fa-check" aria-hidden="true"></i>
                                                                    <?php echo $action['ActionName']?>
                                                                    <ul>

                                                                        <?php foreach($listActions as $actionLv2):
                                                                                if ($actionLv2['ActionLevel']==2&&$actionLv2['ParentActionId']==$action['ActionId']):
                                                                            ?>
                                                                            <li>
                                                                                <i class="fa blue fa-check" aria-hidden="true"></i>
                                                                                <?php echo $actionLv2['ActionName']?>
                                                                                <ul>
                                                                                    <?php foreach($listActions as $actionLv3):
                                                                                    if ($actionLv3['ActionLevel']==3&&$actionLv3['ParentActionId']==$actionLv2['ActionId']):
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
                                                        <li><i class="fa red fa-times" aria-hidden="true"></i>  Quản lý tài khoản Admin</li>
                                                        <li><i class="fa blue fa-check" aria-hidden="true"></i>  Quản lý tài khoản member</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="show_hide_role2">
                                        <p>
                                            <a href="javascript:void(0)" class="btnShowModalGroup" data-id="2">
                                                <i class="fa fa-fw fa-plus-circle font20"></i>
                                            </a>
                                            Phân quyền:
                                        </p>
                                        <table class="table table-hover table-bordered text-center" id="table-group">
                                            <thead>
                                                <tr>
                                                    <th>Stt</th>
                                                    <th>Thời điểm thêm</th>
                                                    <th>Mã vai trò</th>
                                                    <th>Tên vai trò</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyGroupStaff">
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <ul class="list-inline pull-right margin-right-10">
                                <li><a href="<?php echo base_url('staff') ?>" class="btn btn-default">Hủy</a></li>
                                <li><input class="btn btn-primary submit" type="button" name="submit" value="Tạo"></li>
                            </ul>
                            <ul class="list-inline pull-left margin-left-10">
                                <a href="#tab_1" data-toggle="tab" class="tab" data-id="1" aria-expanded="true"><i class="fa fa-arrow-left " aria-hidden="true"></i></a>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="tab_3">
                            <div class="row">
                                <div class="col-sm-2">
                                    <p class="bold">+ Thông tin profile</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <p>ID tài khoản : <span class="show-data-info StaffCode"></span></p>
                                        <p>Họ tên :             <span class="show-data-info FullName"></span></p>
                                        <p>Số điện thoại :      <span class="show-data-info PhoneNumber"></span></p>
                                        <p>Email :              <span class="show-data-info Email"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p class="bold">+Thông tin khai thác hệ thống</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <p>Loại quyền: <span class="show-data-info StaffRoleId role_style"></span></p>
                                        <p>Tài khoản đăng nhập ( Một trong các cách bên dưới ):</p>
                                        <ul>
                                            <li>- User name :  <span class="show-data-info StaffName"></span> </li>
                                            <li>- SĐT :        <span class="show-data-info PhoneNumber"></span> </li>
                                        </ul>
                                        ------------------------------------
                                        <p class="mgt-10">Mật khẩu lần đầu: <span class="show-data-info staffPass"></span></p>
                                        ------------------------------------
                                        <p>Quyền được cấp :</p>
                                        <div class="profile_role2">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <p>Quyền chức năng hệ thống</p>
                                                        <ul>

                                                            <?php
                                                            foreach($listActions as $action):
                                                                if ($action['ActionLevel']==1):
                                                                    ?>
                                                                    <li>
                                                                        <i class="fa blue fa-check" aria-hidden="true"></i>
                                                                        <?php echo $action['ActionName']?>
                                                                        <ul>

                                                                            <?php foreach($listActions as $actionLv2):
                                                                                if ($actionLv2['ActionLevel']==2&&$actionLv2['ParentActionId']==$action['ActionId']):
                                                                                    ?>
                                                                                    <li>
                                                                                        <i class="fa blue fa-check" aria-hidden="true"></i>
                                                                                        <?php echo $actionLv2['ActionName']?>
                                                                                        <ul>
                                                                                            <?php foreach($listActions as $actionLv3):
                                                                                                if ($actionLv3['ActionLevel']==3&&$actionLv3['ParentActionId']==$actionLv2['ActionId']):
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
                                                        <li><i class="fa red fa-times" aria-hidden="true"></i>  Quản lý tài khoản Admin</li>
                                                        <li><i class="fa blue fa-check" aria-hidden="true"></i>  Quản lý tài khoản member</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="profile_role3">
                                            <table class="table table-hover table-bordered text-center" id="table-group">
                                                <thead>
                                                    <tr>
                                                        <th>Stt</th>
                                                        <th>Mã vai trò</th>
                                                        <th>Tên vai trò</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyGroupStaff">

                                                </tbody>
                                            </table>
                                        </div>           
                                    </div>
                                </div>
                            </div>
                            <ul class="list-inline pull-right margin-right-10">
                                <li><a href="<?php echo base_url('staff'); ?>" class="btn btn-default">Đóng</a></li>
                            </ul>
                        </div>
                            <input type="text" name="StaffId" id="staffId" hidden="hidden" value="0">
                            <input type="hidden" id="itemTypeId" value="<?php echo $itemTypeId; ?>">
                        <?php echo form_close(); ?>
                </div>
            </div>
        </section>
    </div>
</div>

<?php $this->load->view('staff/_modal'); ?>
<?php $this->load->view('includes/footer'); ?>



