<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
        </section>
        <?php if ($staff){?>
            <section class="content agent agent_edit">
                <div class=" box-success">
                    <?php echo form_open('agent/update', array('id' => 'agentForm')); ?>
                        <div class="row">
                                <div class="col-sm-8">
                                    <div class="tab-content height80vh box panel-body">
                                        <ul class="nav nav-tabs mgbt-20 tab-add-pession ul-log-actions">
                                            <li class="tab_modal_user1 title active edit" action-type-ids="<?php echo json_encode(array(ID_CREATE,ID_UPDATE)); ?>">
                                                <a data-toggle="tab" href="#tab_1" class="tab" data-id="1">Thông tin </a>
                                            </li>
                                            <li class="tab_modal_user2 title edit">
                                                <a data-toggle="tab" href="#tab_2" class="tab" data-id="2">Tài khoản </a>
                                            </li>
                                        </ul>
                                        <div class="tab-pane fade in active" id="tab_1">
                                            <div class="row mgbt-30">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Mã đại lý </label>
                                                        <input type="text" class="form-control" value="<?php echo $staff['StaffCode']?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mgbt-30">
                                                <div class="col-sm-12" >
                                                    <label class="control-label">Mã đại lý </label>
                                                    <div class="with-border">
                                                        <div class="form-group">
                                                            <div class="radio-group">
                                                                <span class="item"><input type="radio" name="StaffTypeId" class="iCheck iCheckCustomerType" value="1" <?php echo $staff['StaffTypeId'] == 1?'checked':''; ?>> Cá nhân</span>
                                                                <span class="item"><input type="radio" name="StaffTypeId" class="iCheck iCheckCustomerType" value="2" <?php echo $staff['StaffTypeId'] == 2?'checked':''; ?> > Công ty</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-body row">
                                                        <div class="personalType"
                                                                style="display: <?php echo $staff['StaffTypeId'] == 1?'block':'none';?>">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Tên <span class="required">*</span></label>
                                                                        <input type="text" id="personalName" name="personalName" class="form-control hmdrequired inputReset" value="<?php echo $staff['FullName'] ?>" data-field="Tên *">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Ngày sinh </label>
                                                                        <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                            <input type="text" class="form-control datepicker inputReset" id="birthDay" name="BirthDay" value="<?php echo ddMMyyyy($staff['BirthDay']) ?>" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Giới tính</label>
                                                                        <div class="radio-group">
                                                                            <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" data-val="Nam" value="1" <?php if ($staff['GenderId'] == 1) echo 'checked' ?> > Nam</span>
                                                                            <span class="item"><input type="radio" name="GenderId" class="iCheck genderId" data-val="Nữ" value="2" <?php if ($staff['GenderId'] == 2) echo 'checked' ?> > Nữ</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">CMND </label>
                                                                        <input type="text" class="form-control inputReset"
                                                                                id="iDCardNumber" name="CardId"
                                                                                value="<?php echo $staff['CardId']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="companyType"
                                                                style="display: <?php echo $staff['StaffTypeId'] == 2?'block':'none';?>">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Tên công ty <span class="required">*</span></label>
                                                                        <input type="text" id="companyName" name="companyName" class="form-control inputReset" value="<?php echo $staff['FullName'] ?>" data-field="Tên công ty *">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Tên viết gọn</label>
                                                                        <input type="text" id="shortName" name="ShortName" class="form-control inputReset" value="<?php echo $staff['ShortName'] ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Mã số thuế</label>
                                                                    <input type="text" id="taxCode" name="TaxCode" class="form-control inputReset " value="<?php echo $staff['TaxCode'] ?>" data-field="Mã số thuế *">
                                                                </div>
                                                            </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Lĩnh vực vận tải </label>
                                                                        <?php $this->Mconstants->selectObject($listTransportTypes, 'TransportTypeId', 'TransportTypeName', 'TransportTypeId', $staff['TransportTypeId'], true, '--Lĩnh vực vận tải--', ' select2'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">SĐT <span class="required">*</span></label>
                                                                    <input type="text" id="phoneNumber" name="PhoneNumber" class="form-control inputReset hmdrequired" value="<?php echo $staff['PhoneNumber'] ?>" data-field="SĐT *"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">Email</label>
                                                                    <input type="text" id="email" name="Email" class="form-control inputReset" value="<?php echo $staff['Email'] ?>">
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
                                                            <div class="col-sm-6 VNon">
                                                                <div class="form-group">
                                                                    <label class="control-label">Tỉnh <span class="required">*</span></label>
                                                                    <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'HTProvinceId', $staff['HTProvinceId'], true, '--Tỉnh / Thành--', ' select2'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">Địa chỉ</label>
                                                                    <input type="text" id="address" class="form-control" name="HTAddress" value="<?php echo $staff['HTAddress'] ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row companyType"
                                                                style="display: <?php echo $staff['StaffTypeId'] == 2?'block':'none'?>">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">Đầu mối liên hệ</label>

                                                                    <div class="" id="divHtmlUserGroup">
                                                                        <?php if ($listItemContact) {
                                                                            $i = 1;
                                                                            ?>
                                                                            <?php foreach ($listItemContact as $itemContact) { ?>
                                                                                <div class="box box-default htmlUserGroup">
                                                                                    <div class="box-header with-border">
                                                                                        <h3 class="box-title title">Đầu mối
                                                                                            liên hệ <?php echo $i; ?></h3>
                                                                                        <div class="box-tools pull-right">
                                                                                            <button type="button"
                                                                                                    class="removeUserGroup">
                                                                                                <i class="fa fa-trash-o"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Tên</label>
                                                                                                    <input type="text" class="form-control inputReset contactFullName" value="<?php echo $itemContact['ContactName'] ?>"/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Chức vụ</label>
                                                                                                    <input type="text" class="form-control inputReset contactPosition" value="<?php echo $itemContact['PositionName'] ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">SĐT</label>
                                                                                                    <input type="text" class="form-control inputReset contactPhone" value="<?php echo $itemContact['PhoneNumber'] ?>"/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Email</label>
                                                                                                    <input type="text" class="form-control inputReset contactEmail" value="<?php echo $itemContact['Email'] ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                                $i++;
                                                                            }
                                                                            ?>
                                                                        <?php } else { ?>
                                                                            <div class="box box-default htmlUserGroup">
                                                                                <div class="box-header with-border ">
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

                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <button type="button" class="btn btn-primary"
                                                                                id="addUserGroup">Thêm đầu mối liên hệ
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="control-label">Thông tin đại lý <span class="required">*</span></label>
                                            <div class="row mgbt-30">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label class="control-label">Loại đại lý </label>
                                                                <?php $this->Mconstants->selectObject($listAgentTypes, 'AgentTypeId', 'AgentTypeName', 'AgentTypeId', $staff['AgentTypeId'], true, '--Chọn loại đại lý--', ' select2'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <label class="control-label">Khu vực phụ trách </label>
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ProvinceIds1[]', $listAgentProvinces, true, '--Tỉnh / Thành--', ' select2', ' multiple'); ?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mgbt-30">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <?php $labelCss = $this->Mconstants->labelCss;?>
                                                        <div class="row">
                                                            <div class="col-sm-7">
                                                                <p>Ngày thêm: </p>
                                                                <p>Người thêm: </p>
                                                                <p>Trạng thái:  </p>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p class=""><?php echo ddMMyyyy($staff['CrDateTime']) ?></p>
                                                                <p class=""><i class="fa fa-user" aria-hidden="true"></i> <?php echo $this->Mstaffs->getFieldValue(array('StaffId'=>$staff['CrStaffId']),'FullName','')?></p>
                                                                <p class="<?php echo $labelCss[$staff['StatusId']]; ?> "><?php echo $this->Mconstants->status[$staff['StatusId']]?></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-6 ">
                                                    <div class="cover_form_dm">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <p>Cấp độ đại lý*</p>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <span class="cover_level_agency">
                                                                        <input type="radio" class="iCheck agentLevelId" name="AgentLevelId" value="2" data-val="Đại lý cấp 1" <?php if ($staff['AgentLevelId'] == 2) echo 'checked'; ?>>Đại lý cấp 1
                                                                    </span>
                                                                    <span class="cover_level_agency">
                                                                        <input type="radio" class="iCheck agentLevelId" name="AgentLevelId" value="3" data-val="Đại lý cấp 2" <?php if ($staff['AgentLevelId'] == 3) echo 'checked'; ?>>Đại lý cấp 2
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <p>Đơn vị quản lý*</p>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="form-group unit_manage">
                                                                        <?php $managementUnitId = '' ?>
                                                                        <?php if ($staff['AgentLevelId'] == 2) { ?>
                                                                            <select class="form-control" name="ManagementUnitId" disabled>
                                                                                <option value="1">Bistech</option>
                                                                            </select>
                                                                        <?php } else { ?>
                                                                            <?php $this->Mconstants->selectObject($listStaffs, 'StaffId', 'StaffName', 'ManagementUnitId', $staff['ManagementUnitId'], true, '--Đơn vị quản lý--', ' managementUnitId select2'); ?>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane  fade" id="tab_2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 ">
                                    <div class="cover_info_user box panel-body">
                                        <div class="form-group info_user ">
                                            <label class="control-label">Thông tin khác hàng </label>
                                            <p class="name"><img src="<?php echo USER_PATH.$staff['Avatar'];?>" alt=""><span class="name"><?php echo $staff['FullName']?></span></p>
                                            <p class="phone"><i class="fa fa-phone" aria-hidden="true"></i> <span><?php echo $staff['PhoneNumber']?></span> </p>
                                            <p class="email"><i class="fa fa-envelope" aria-hidden="true"></i> <span><?php echo $staff['Email']?></span> </p>
                                            <p class="maker"><i class="fa fa-map-marker" aria-hidden="true"></i> <span><?php echo $this->Mprovinces->getFieldValue(array('ProvinceId'=>$staff['HTProvinceId']),'ProvinceName','')?></span> </p>
                                            <p class="card"><i class="fa fa-id-card" aria-hidden="true"></i> <span><span><?php echo $this->Mcountries->getFieldValue(array('CountryId'=>$staff['CountryId']),'CountryName','')?></span> </p>
                                        </div>
                                        <div class="form-group info_user">
                                            <label class="control-label">Ghi chú </label>
                                            <input name="comment" class="input_comment form-control" id="" cols="30" rows="10" placeholder="Thêm nội dung ghi chú">
                                            <input class="btn btn-primary  save-comment" data-link="<?php echo base_url('itemcomment/insertcomment');?>" type="button" value="Lưu">
                                            <?php
                                            $listComment1 = array_slice($listComment,0,3);
                                            $listComment2 = array_slice($listComment,0,20);
                                            ?>
                                            <div class="list_comment">
                                                <?php foreach ($listComment1 as $comment){
                                                    $level =  $this->Mstaffs->getFieldValue(array('StaffId' => $comment['CrUserId']), 'JobLevelId', '')
                                                    ?>
                                                    <div class="row item_comment">
                                                        <div class="col-sm-4 pd-r">
                                                            <img src="<?php echo USER_PATH.$comment['Avatar'];?>" alt="">
                                                            <div class="user_comment">
                                                                <p class="name_coment"><?php echo $this->Mstaffs->getFieldValue(array('StaffId'=>$comment['CrUserId']),'FullName','')?></p>
                                                                <p><?php echo ($level && $level >0)?$this->Mconstants->jobLevelId[$level]:'' ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <p class="content_comment"><?php echo $comment['Comment']?></p>
                                                            <p class="text-right time"><?php echo ddMMyyyy($comment['CrDateTime'],'d/m/Y H:m')?></p>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </div>
                                            <div class="view_more text-right">
                                                <a  data-toggle="modal" data-target="#myModal">
                                                    Xem thêm
                                                </a>
                                            </div>

                                            <div class="modal fade modal_comment" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php foreach ($listComment2 as $comment){?>
                                                                <?php $level =  $this->Mstaffs->getFieldValue(array('StaffId' => $comment['CrUserId']), 'JobLevelId', '') ?>
                                                                <div class="row item_comment">
                                                                    <div class="col-sm-4 ">
                                                                        <img src="<?php echo USER_PATH.$comment['Avatar'];?>" alt="">
                                                                        <div class="user_comment">
                                                                            <p class="name_coment"><?php echo $this->Mstaffs->getFieldValue(array('StaffId'=>$comment['CrUserId']),'FullName','')?></p>
                                                                            <p><?php echo ($level && $level >0)?$this->Mconstants->jobLevelId[$level]:'' ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <p class="content_comment"><?php echo $comment['Comment']?></p>
                                                                        <p class="text-right time"><?php echo ddMMyyyy($comment['CrDateTime'],'d/m/Y H:m')?></p>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group info_user">
                                            <div class="box-default more-tabs">
                                                <div class="form-group">
                                                    <label class="control-label" style="width: 100%;line-height: 28px;">Thẻ tag</label>
                                                    <input type="text" class="form-control" name="TagId" id="tags" value="">
                                                    <input class="btn btn-primary submit save-tag" type="submit" value="Lưu">
                                                </div>
                                                <p class="light-gray">Có thể chọn những thẻ tag đã được sử dụng</p>
                                                <ul class="list-inline" id="ulTagExist">
                                                    <?php foreach ($listTags as $tag) { ?>
                                                        <li>
                                                            <a href="javascript:void(0)"><?php echo $tag['TagName'] ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="box box-default classify padding20">
                                        <?php 
                                            $this->load->view('includes/action_logs', 
                                                    array(
                                                        'listActionLogs' =>  $this->Mactionlogs->getList($staff['StaffId'], $itemTypeId, [1,2]),
                                                        'itemId' => $staff['StaffId'],
                                                        'itemTypeId' => $itemTypeId
                                                    )
                                                );
                                        ?>
                                    </div>
                                </div>
                                <ul class="list-inline pull-right margin-right-10">
                                    <?php foreach ($listTagName as $tagName) { ?>
                                        <input type="text" hidden="hidden" class="tagName" value="<?php echo $tagName; ?>">
                                    <?php } ?>
                                    <li><a href="<?php echo base_url('agent') ?>" class="btn btn-default">Hủy</a></li>
                                    <li><input class="btn btn-primary submit" type="submit" value="Cập nhật"></li>
                                </ul>
                        </div>
                        <input type="hidden" id="staffId" name="StaffId"  value="<?php echo $staff['StaffId'];?>" >
                        <input type="hidden"  id="staffName" name="StaffName"  value="<?php echo $staff['StaffName'];?>" >
                        <input type="hidden" id="itemTypeId" name="ItemTypeId"  value="<?php echo $itemTypeId;?>" >
                        <input type="hidden" hidden="hidden" id="urlGetListManagetUnit" value="<?php echo base_url('agent/getListManagerUnit') ?>">
                        <input type="hidden" id="jobLevel" name=""  value="<?php echo $this->Mconstants->jobLevelId[$user['JobLevelId']]; ?>" >
                    <?php echo form_close(); ?>
                </div>
            </section>
        <?php }?>
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
                                    <input class="checktran iCheck icheckitem" type="checkbox" value="1">
                                </td>
                                <td>LX-001</td>
                                <td>Lái xe</td>
                            </tr>
                            <tr id="group_2" data-id="2">
                                <td>
                                    <input class="checktran iCheck icheckitem" type="checkbox" value="2">
                                </td>
                                <td>KH-1</td>
                                <td>Khách hàng</td>
                            </tr>
                            <tr id="group_3" data-id="3">
                                <td>
                                    <input class="checktran iCheck icheckitem" type="checkbox" value="3">
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

