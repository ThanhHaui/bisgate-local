<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
        </section>
        <section class="content agent">
            <div class="box box-success">
                <div class="panel-body">
                    <ul class="nav nav-tabs mgbt-20 tab-add-pession">
                        <li class="tab_modal_user1 title active"><a   class="tab" data-id="1">1, Thông tin profile</a>
                        </li>
                        <li class="tab_modal_user2 title "><a   class="tab" data-id="2">2, Phân quyền sử dụng trong hệ thống</a>
                        </li>
                        <li class="tab_modal_user3 title "><a class="tab" data-id="3">3, Kết thúc</a>
                        </li>
                    </ul>
                    <?php echo form_open('agent/update', array('id' => 'agentForm')); ?>
                    <div class="tab-content height80vh">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row mgbt-30">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Thông tin định danh</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <div class="row">
                                            <div class="col-sm-12" id="content_left">
                                                <div class="with-border">
                                                    <div class="form-group">
                                                        <div class="radio-group">
                                                            <span class="item"><input type="radio" name="StaffTypeId" class="iCheck iCheckCustomerType" value="1" checked> Cá nhân</span>
                                                            <span class="item"><input type="radio" name="StaffTypeId" class="iCheck iCheckCustomerType" value="2"> Công ty</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-body row">
                                                    <div class="personalType">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tên <span class="required">*</span></label>
                                                                    <input type="text" id="personalName" name="personalName" class="form-control hmdrequired inputReset" data-field="Tên *">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Ngày sinh </label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control datepicker inputReset" id="birthDay" name="BirthDay" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Giới tính</label>
                                                                    <div class="radio-group">
                                                                        <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" data-val="Nam" value="1" checked> Nam</span>
                                                                        <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" data-val="Nữ" value="2"> Nữ</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">CMND </label>
                                                                    <input type="text" class="form-control inputReset" id="cardId" name="CardId">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="companyType" style="display: none">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tên công ty <span class="required">*</span></label>
                                                                    <input type="text" id="companyName" name="CompanyName" class="form-control inputReset" data-field="Tên công ty *">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tên viết gọn</label>
                                                                    <input type="text" id="shortName" name="ShortName" class="form-control inputReset"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Mã số thuế</label>
                                                                    <input type="text" id="taxCode" name="TaxCode" class="form-control inputReset">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Lĩnh vực vận tải </label>
                                                                    <?php $this->Mconstants->selectObject($listTransportTypes, 'TransportTypeId', 'TransportTypeName', 'TransportTypeId', 0, true, '--Lĩnh vực vận tải--', ' select2'); ?>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">SĐT <span class="required">*</span></label>
                                                                <input type="text" id="phoneNumber" name="PhoneNumber" class="form-control inputReset hmdrequired" data-field="SĐT *"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Email</label>
                                                                <input type="text" id="email" name="Email" class="form-control inputReset">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Quốc gia </label>
                                                                <?php $this->Mconstants->selectObject($listCountries, 'CountryId', 'CountryName', 'CountryId', 232, false, '', ' select2'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 ">
                                                            <div class="form-group">
                                                                <label class="control-label">Tỉnh <span class="required">*</span></label>
                                                                <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'HTProvinceId', 0, true, '--Tỉnh / Thành--', ' select2'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Địa chỉ</label>
                                                                <input type="text" id="htAddress" class="form-control" name="HTAddress">
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                    <div class="row companyType"  style="display: none">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Đầu mối liên hệ</label>
                                                                <div class="box box-default htmlUserGroup" id="divHtmlUserGroup">
                                                                    <div class="box-header with-border">
                                                                        <h3 class="box-title title">Đầu mối liên hệ 1</h3>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Tên</label>
                                                                                    <input type="text" class="form-control inputReset contactFullName"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Chức vụ</label>
                                                                                    <input type="text" class="form-control inputReset contactPosition">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">SĐT</label>
                                                                                    <input type="text" class="form-control inputReset contactPhone"/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Email</label>
                                                                                    <input type="text" class="form-control inputReset contactEmail">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <button type="button" class="btn btn-primary" id="addUserGroup">Thêm đầu mối liên hệ</button>
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
                            <div class="row mgbt-30">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Thông số đại lý</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p>Cấp độ đại lí*</p>
                                                </div>
                                                <div class="col-sm-9">
                                                <span class="cover_level_agency">
                                                    <input type="radio" class="iCheck agentLevelId" data-val="Đại lí cấp 1" name="AgentLevelId" value="2" checked>
                                                    Đại lý cấp 1
                                                </span>
                                                    <span class="cover_level_agency">
                                                    <input type="radio" class="iCheck agentLevelId" data-val="Đại lí cấp 2" name="AgentLevelId" value="3">
                                                    Đại lí cấp 2
                                                </span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p>Đơn vị quản lí*</p>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group unit_manage">
                                                        <select class="form-control" name="ManagementUnitId" disabled>
                                                            <option value="1" selected="selected">Bistech</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p>Loại đại lý</p>
                                                </div>
                                                <div class="col-sm-5">
                                                    <?php $this->Mconstants->selectObject($listAgentTypes, 'AgentTypeId', 'AgentTypeName', 'AgentTypeId', 0, true, '--Loại đại lí--', ' select2'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p>Khu vực phụ trách</p>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ProvinceIds1[]', 0, true, '--Tỉnh / Thành--', ' select2', ' multiple'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mgbt-30">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Ghi chú</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <textarea class="form-control" name="Note" id="note" cols="30" rows="10" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mgbt-30">
                                <div class="col-sm-2">
                                    <p class="mt-6 bold">Thẻ tag</p>
                                </div>
                                <div class="col-sm-10">
                                    <div class="cover_wrap_left">
                                        <div class="box-default more-tabs">
                                            <div class="form-group">
                                                <label class="control-label" style="width: 100%;line-height: 28px;">Thẻ tag</label>
                                                <input type="text" class="form-control" name="TagId" id="tags">
                                            </div>
                                            <p class="light-gray">Có thể chọn những thẻ tag đã được sử dụng</p>
                                            <ul class="list-inline" id="ulTagExist">
                                                <?php foreach ($listTags as $tag){?>
                                                    <li>
                                                        <a href="javascript:void(0)"><?php echo $tag['TagName']?></a>
                                                    </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <ul class="list-inline pull-right margin-right-10">
                                <li><a href="<?php echo base_url('agent'); ?>" class="btn btn-default">Hủy</a></li>
                                <li><a href="" data-toggle="tab" class="btn btn-primary button_next" data-id="2">Tiếp</a> </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="row mgbt-10">
                                <div class="col-sm-2">
                                    <p class="bold">Phân quyền</p>
                                </div>
                                <div class="col-sm-10 border-permissions cover_wrap_left">
                                    <div class="row mgbt-10">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label">@user name <span class="required">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <input type="text" id="staffName" class="form-control hmdrequired staffName" name="StaffName"
                                                       placeholder="viết liền không dấu, chỉ gồm chữ và số" data-field="@user name*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mgbt-10">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label">Mật khẩu đăng nhập *</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" id="staffPass" class="form-control text-center hmdrequired" name="StaffPass" value="123456"
                                                       placeholder="" data-field="Mật khẩu đăng nhập">
                                            </div>
                                        </div>
                                    </div>
                                    <p style="pointer-events: none;">
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
                                        <tbody id="tbodyGroupUser">
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <hr>
                            <ul class="list-inline pull-right margin-right-10">
                                <li><a href="<?php echo base_url('agent'); ?>" class="btn btn-default">Hủy</a></li>
                                <li><input class="btn btn-primary submit" type="submit" value="Lưu"></li>
                            </ul>
                            <ul class="list-inline pull-left margin-left-10">
                                <span class="button_back" data-id="1"><i class="fa fa-arrow-left " aria-hidden="true"></i> </span>

                            </ul>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="cover_wrap_left">
                                <div class="row mgbt-20">
                                    <div class="col-sm-3">
                                        <p class="bold">+ Thông tin profile</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="bg-gray p-30 address_info_profile" style="background-color: #ededed !important;">
                                            <div class="type_info_user active">
                                                <p>ID tài khoản : <span class="id_account" style="color: #469bce;"></span></p>
                                                <p>Họ tên: <span class="show-data-info personalName" ></span><span class="show-data-info CompanyName" ></span>  </php>
                                                <p>Số điện thoại: <span class="show-data-info PhoneNumber" ></span> </p>
                                                <p>Email: <span class="show-data-info Email" ></span> </p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="bold">+Thông tin khai thác hệ thống</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="bg-gray p-30" style="background-color: #ededed !important;">
                                            <p>Tài khoản đăng nhập ( Một trong các cách bên dưới ):</p>
                                            <ul>
                                                <li>- User name : <span class="show-data-info StaffName" data-name="StaffName"></span></li>
                                                <li>- SĐT : <span class="show-data-info PhoneNumber" data-name="PhoneNumber"></span></li>
                                            </ul>
                                            ------------------------------------
                                            <p class="mgt-10">Mật khẩu lần đầu: <span class="show-data-info StaffPass" >123456</span></p>
                                            ------------------------------------
                                            <p>Quyền được cấp</p>
                                            <p>----- Phân quyền chưa phát triển, version 2 sẽ phát triển----</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <ul class="list-inline pull-right margin-right-10">
                                <li><a href="<?php echo base_url('agent') ?>" class="btn btn-default">Đóng</a></li>
                                <input type="hidden" hidden="hidden" id="urlGetListManagetUnit" value="<?php echo base_url('agent/getListManagerUnit') ?>">
                                <input type="hidden" id="staffId" hidden="hidden" name="StaffId" value="0">
                            </ul>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
        </section>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>

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
                            <tr id="group_1" data-id="1">
                                <td>
                                    <input class="checktran iCheck icheckitem" type="checkbox"
                                           value="1">
                                </td>
                                <td>LX-0011</td>
                                <td>Lái xe</td>
                            </tr>
                            <tr id="group_2" data-id="2">
                                <td>
                                    <input class="checktran iCheck icheckitem" type="checkbox"
                                           value="2">
                                </td>
                                <td>KH-1</td>
                                <td>Khách hàng</td>
                            </tr>
                            <tr id="group_3" data-id="3">
                                <td>
                                    <input class="checktran iCheck icheckitem" type="checkbox"
                                           value="3">
                                </td>
                                <td>AD</td>
                                <td>Admin</td>
                            </tr>
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
