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
                        <li class="tab_modal_user1 active" action-type-ids="<?php echo json_encode(array(ID_CREATE,ID_UPDATE)); ?>"><a data-toggle="tab" href="#tab_1"  data-id="1" >Thông tin profile</a>
                        </li>
                        <li class="tab_modal_user2"  action-type-ids="<?php echo json_encode(array(ID_STATUS,ID_ROLE,ID_RESET)); ?>"><a  data-toggle="tab" href="#tab_2" data-id="2">Phân quyền sử dụng trong hệ thống</a>
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
                                                                <img src="<?php echo USER_PATH.$avatar; ?>" class="chooseImage" id="imgAvatar" style="width: 150px;display: block;">
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
                                                                            <?php $avatarBehind = (empty($staffEdit['AvatarBehind']) ? NO_IMAGE : $staffEdit['AvatarBehind']); ?>
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
                                                        <input type="radio" name="NationalityId" class="iCheck Radio" value="1" <?php echo ($staffEdit['NationalityId'] == 1)?'checked':'' ?>> Việt nam
                                                    </span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <span class="check_tab_show v2" data-tab="#tab_nkh2">
                                                        <input type="radio" name="NationalityId" class="iCheck Radio" value="2" <?php echo ($staffEdit['NationalityId'] == 2)?'checked':'' ?>> Khác
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
                                        <p class="mt-6 bold" style="pointer-events: none"><i
                                                    class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Học bạ
                                        </p>
                                    </div>
                                    <div class="col-sm-10 show_hide_group">
                                        <div class="arr-hb">
                                            <?php foreach ($schoolreports as $schoolreport) { ?>
                                                <div class="border-hb mgbt-10">
                                                    <div class="row mgbt-10">
                                                        <div class="col-sm-6">
                                                            <div class="row mgbt-10">
                                                                <div class="col-sm-4">
                                                                    <p>Tên bằng cấp</p>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <input type="text" id="diploma"
                                                                           class="form-control "
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
                                                                    <input type="text" id="schoolName"
                                                                           class="form-control "
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
                                                                    <input type="text" id="industryName"
                                                                           class="form-control "
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
                                                                    <input type="text" id="startDate"
                                                                           class="form-control datepicker"
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
                                                                    <input type="text" id="endDate"
                                                                           class="form-control datepicker"
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
                                    <div class="col-sm-3">
                                        <p class="mt-6 bold" style="pointer-events: none"><i
                                                    class="fa fa-fw  fa-plus-circle show_hide_group_item"></i> Công việc
                                        </p>
                                    </div>
                                    <div class="col-sm-9 show_hide_group">
                                        <div class="row mgbt-10">
                                            <div class="col-sm-3">
                                                <p class="mt-6">Ngày bắt đầu làm</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="JobDate" class="form-control datepicker"
                                                       value="<?php echo ddMMyyyy($staffEdit['JobDate']); ?>">
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
                                                                <?php $this->Mconstants->selectConstants('jobLevelId', 'JobLevelId', $staffEdit['JobLevelId']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-4">
                                                                <p class="mt-6">Phòng ban</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="JobDepartment"
                                                                       class="form-control "
                                                                       value="<?php echo $staffEdit['JobDepartment'] ?>">
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
                                                    <?php foreach ($jobtitles as $jobtitle) { ?>
                                                        <div class="row mgbt-10 item-cdkn">
                                                            <div class="col-sm-2">
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row mgbt-10">
                                                                    <div class="col-sm-4">
                                                                        <p class="mt-6">Cấp bậc</p>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <?php $this->Mconstants->selectConstants('jobLevelId', 'JobLevelIdOther', $jobtitle['LevelId']); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row mgbt-10">
                                                                    <div class="col-sm-4">
                                                                        <p class="mt-6">Phòng ban</p>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" id="jobDepartmentOther"
                                                                               class="form-control "
                                                                               value="<?php echo $jobtitle['Department'] ?>">
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
                                                    <?php foreach ($experiences as $experience) { ?>
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
                                                                            <input type="text" id="exStartDate"
                                                                                   class="form-control datepicker"
                                                                                   value="<?php echo ddMMyyyy($experience['StartDate']) ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="row mgbt-10">
                                                                        <div class="col-sm-4">
                                                                            <p class="mt-6">Đến</p>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" id="exEndDate"
                                                                                   class="form-control datepicker"
                                                                                   value="<?php echo ddMMyyyy($experience['EndDate']) ?>">
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
                                                                            <?php $this->Mconstants->selectConstants('jobLevelId', 'ExLevelId', $experience['LevelId']); ?>
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
                                                                                   class="form-control"
                                                                                   value="<?php echo $experience['Department'] ?>">
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
                                                                            <input type="text" id="exCompanyName"
                                                                                   class="form-control"
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
                                                                    <textarea type="text" id="exScopeOfActivities"
                                                                              class="form-control"><?php echo $experience['ScopeOfActivities'] ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mgbt-10">
                                                                <div class="col-sm-2">
                                                                </div>
                                                                <div class="col-sm-10">
                                                                    <p class="mt-6">Thành tựu trong thời gian công
                                                                        tác</p>
                                                                    <textarea type="text" id="exAchievement"
                                                                              class="form-control"><?php echo $experience['Achievement'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
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
                                        <textarea type="text" name="Note"
                                                  class="form-control"><?php echo $staffEdit['Note'] ?></textarea>
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
                                                            'listActionLogs' =>  $this->Mactionlogs->getList($staffEdit['StaffId'], $itemTypeId, [ID_CREATE,ID_UPDATE]),
                                                            'itemId' => $staffEdit['StaffId'],
                                                            'itemTypeId' => $itemTypeId
                                                        )
                                                    );
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <ul class="liitemStatusst-inline pull-right margin-right-10">
                                    <li><a href="<?php echo base_url('staff') ?>" class="btn btn-default">Hủy</a></li>
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
                                        <?php if($staffEdit['StatusId'] == 2): ?>
                                            <div class="row mgbt-10"  style="display:none">
                                                <div class="col-sm-4">
                                                    <p>Loại quyền</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    
                                                    <?php if (!empty($staffEdit['StaffRoleId'])):?>
                                                        <span class="<?php echo $labelCss[$staffEdit['StaffRoleId']]; ?>"><?php echo $staffRoleId[$staffEdit['StaffRoleId']]; ?></span>
                                                    <?php endif?>
                                                    
                                                </div>
                                            </div>
                                            <?php endif ?>
                                            <div class="row mgbt-10">
                                                <div class="col-sm-4">
                                                    <p>Trạng thái hoạt động</p>
                                                </div>
                                                <div class="col-sm-8">
                                                    <span class="<?php echo $labelCss[$staffEdit['StatusId']]; ?>"><?php echo $status[$staffEdit['StatusId']]; ?></span>
                                                    <?php if(($staffEdit['StatusId'] == 1) || ($staffEdit['StatusId'] == 2)){?>
                                                        <a href="javascript:void(0)" id="btnShowModalChangeStaff"><i class="fa fa-fw fa-cog"></i></a>
                                                    <?php } ?>
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
                                    <div class="row mgbt-10">
                                        <div class="col-sm-2">
                                            <p><span><i class="fa fa-refresh font20 color-gray" aria-hidden="true"></i></span> Reset pass về mặc định</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <a href="javascript:void(0)" class="refresh-pass" data-id="<?php echo $staffEdit['StaffId']; ?>"><span class="label label-success">Refresh</span></a>
                                        </div>
                                    </div>
                                </div>

                                <?php if($staffEdit['StatusId'] == 2){?>
                                    <div class="cover_wrap_left">
                                        <p>Loại tài khoản</p>
                                        <div class="col-sm-12">
                                            <div class="row mgbt-10">
                                                <div class="col-sm-2">
                                                    <p class="mt-6"><input type="radio" name="StaffRoleId" class="iCheck Radio staffRoleId " value="2" <?php echo ($staffEdit['StaffRoleId']==2)?'checked':'' ?>> <span>Admin</span></p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="mt-6"><input type="radio" name="StaffRoleId" class="iCheck Radio staffRoleId " value="3" <?php echo ($staffEdit['StaffRoleId']==3)?'checked':'' ?>> <span>Member</span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="show_hide_role1" style="display: <?php echo ($staffEdit['StaffRoleId']==2)?'block':'none' ?>">
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
                                                            <li><i class="fa <?php echo ($staffEdit['StaffRoleId'] == 1)?'blue fa-check':'red fa-times' ?>" aria-hidden="true"></i>  Quản lý tài khoản Admin</li>
                                                            <li><i class="fa blue fa-check" aria-hidden="true"></i>  Quản lý tài khoản member</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="show_hide_role2" style="display: <?php echo ($staffEdit['StaffRoleId']==3)?'block':'none' ?>">
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
                                                <?php
                                                foreach ($listGroupIds as $k=> $listGroupId) {
                                                    foreach ($listGroups as  $listGroup) {
                                                        if($listGroup['GroupId'] == $listGroupId['GroupId']){
                                                            ?>
                                                            <tr data-id="<?php echo $listGroup['GroupId'] ?>">
                                                                <td><?php echo $k + 1 ?></td>
                                                                <td><?php echo ddMMyyyy($listGroupId['CrDateTime'],'d/m/Y H:i'); ?></td>
                                                                <td><?php echo $listGroup['GroupCode'] ?></td>
                                                                <td><?php echo $listGroup['GroupName'] ?></td>
                                                                <td><a href="javascript:void(0)" class="link_delete_group" title="Xóa" count-id="<?php echo $listGroup['GroupId'] ?>"><i class="fa fa-trash-o"></i></a></td>
                                                            </tr>
                                                        <?php }
                                                    }
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php } else{?>
                                        <div class="col-sm-12 text-center">
                                            <button type="button" class="btn btn-primary" id="btnActiveStatusStaff">BẬT LẠI TÀI KHOẢN >> VỀ BÌNH THƯỜNG
                                            </button>
                                        </div>
                                    <?php } ?>

                                <ul class="list-inline pull-left margin-left-10">
                                    <span class="button_back" data-id="1"><i class="fa fa-arrow-left " aria-hidden="true"></i> </span>
                                </ul>
                                <ul class="list-inline pull-right margin-right-10">
                                    <li><a href="<?php echo base_url('staff'); ?>" class="btn btn-default">Đóng</a></li>
                                    <?php if($staffEdit['StatusId'] == 2){?>
                                        <li><button class="btn btn-primary submit" data-user="0" type="submit">Cập nhật</button></li>
                                    <?php } ?>
                                </ul>
                                <div class="col-sm-12 form-group" style="top: 30px;bottom:30px">
                                    <h4><i class="fa fa-fw fa-sticky-note-o"></i> Thông tin cấu hình</h4>
                                    <div class="box-default more-tabs cover_wrap_left">
                                        <?php 
                                            $this->load->view('includes/action_logs', 
                                                    array(
                                                        'listActionLogs' =>  $this->Mactionlogs->getList($staffEdit['StaffId'], $itemTypeId, [ID_STATUS,ID_ROLE, ID_RESET]),
                                                        'itemId' => $staffEdit['StaffId'],
                                                        'itemTypeId' => $itemTypeId
                                                    )
                                                );
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="StaffId" id="staffId" hidden="hidden" value="<?php echo $staffid ?>">
                            <input type="text" hidden="hidden" id="urlRefreshPass" value="<?php echo base_url('staff/refreshPass'); ?>">
                            <input type="text" hidden="hidden" id="staffListUrl" value="<?php echo base_url('staff/edit/' . $staffEdit['StaffRoleId'] ); ?>">
                            <input type="hidden" id="urlChangeStatus" value="<?php echo base_url('staff/changeStatus'); ?>">
                            <input type="hidden" id="itemTypeId" value="<?php echo $itemTypeId; ?>">
                            <input type="hidden" name="StatusId" value="<?php echo $staffEdit['StatusId']; ?>">
                            <?php foreach($tagNames as $tagName){ ?>
                                <input type="text" hidden="hidden" class="tagName" value="<?php echo $tagName; ?>">
                            <?php } ?>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="modal fade" role="dialog" id="btnShowModalGroups">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Phân quyền</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-hover table-bordered" id="table-group">
                                        <thead>
                                            <tr>
                                                <th style="width:60px"></th>
                                                <th>Mã nhóm quyền</th>
                                                <th>Tên nhóm quyền</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyGroup">
                                            <?php foreach ($listGroups as $itemGroups) { ?>
                                                <tr id="group_<?php echo $itemGroups['GroupId'] ?>" data-id="<?php echo $itemGroups['GroupId'] ?>">
                                                    <td>
                                                        <input class="checkTran iCheck iCheckItem" type="checkbox"
                                                        value="<?php echo $itemGroups['GroupId'] ?>">
                                                    </td>
                                                    <td><?php echo $itemGroups['GroupCode'] ?></td>
                                                    <td><?php echo $itemGroups['GroupName'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-dismiss="modal">Hủy
                            </button>
                            <button type="button" class="btn btn-primary" id="btnAddGroup" data-id="2">Thêm</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('staff/_modal'); ?>
            <?php }?>
        </section>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>

