<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><a href="<?= base_url('device')?>">Danh sách thiết bị</a> >>> TB <?=$device['DeviceCodeId'] ?></h1>
                <ul class="list-inline">
                    <?php if($deviceId): ?>
                        <li><button class="btn btn-primary btnUpdate">Cập nhật</button></li>
                    <?php endif; ?>
                    <li><a href="<?php echo base_url('device'); ?>" class="btn btn-default">Đóng</a></li>
                </ul>
            </section>
            <section class="content">
            <?php if($deviceId): ?>
                <?php echo form_open('device/update', array('id' => 'deviceForm')); ?>
                <div class="row">
                    <div class="box box-default padding15">
                        <ul class="nav nav-tabs ul-log-actions">
                            <li class="active" action-type-ids="<?php echo json_encode(array(ID_CREATE,ID_UPDATE)); ?>"><a href="#tab_1" data-toggle="tab">Thông tin thiết bị</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Biển số xe</a></li>
                            <li class="tab_active_save"><a href="#tab_3" data-toggle="tab">Sim số</a></li>
                            <li><a href="#tab_4" data-toggle="tab">Bảo hành</a></li>
                        </ul><br>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="box-search-advance v2">
                                            <div class="row mgbt-10">
                                                <div class="col-sm-12">
                                                    <p class="">Thông tin quản lý thiết bị</p>
                                                </div>
                                                <div class="col-sm-1">
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="box-search-advance customer">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6 d-flex">Dòng thiết bị*</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><?= $device['DeviceTypeName']?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6 d-flex">IMEI thiết bị*</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><?= $device['IMEI']?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6 d-flex">ID thiết bị*</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><?= $device['DeviceCodeId']?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6 d-flex">Ngày thêm thiết bị</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><?= date('d/m/Y H:i', strtotime($device['CrDateTime']))?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6 d-flex">Trạng thái lắp đặt TB</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?= $device['InstallationStatus']?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($device['InstallationStatusId'] == 2) { ?>
                                        <div class="box-search-advance v2">
                                            <div class="row mgbt-10">
                                                <div class="col-sm-12">
                                                    <p class="">Tình trạng hoạt động</p>
                                                </div>
                                                <div class="col-sm-1">
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="box-search-advance customer">
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6 d-flex">Thời gian gói tin gần nhất</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><?= $device['TimeMin']?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row mgbt-10">
                                                            <div class="col-sm-6">
                                                                <p class="mt-6 d-flex">Trạng thái kết nối TB</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <?= $device['ConnectStatusId']?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                   	<div class="col-sm-4">
                                        <div class="box box-default classify padding20">
                                            <label class="light-blue">Ghi chú</label>
                                            <div class="box-transprt clearfix mb10">
                                                <button type="button" class="btn-updaten save" id="btnInsertComment1">
                                                    Lưu
                                                </button>
                                                <input type="text" class="add-text" id="comment1" value="" placeholder="Thêm nội dung ghi chú">
                                            </div>
                                            <div class="listComment" id="listComment1"  style="<?php echo  count($itemComments)  > 5 ? 'height:300px; overflow:auto': ''; ?>">
                                                <?php $i = 0;
                                                $now = new DateTime(date('Y-m-d'));
                                                foreach($itemComments as $oc){
                                                    $fullName = $this->Mstaffs->getFieldValue(array('StaffId' => $oc['CrUserId']), 'FullName', '');
                                                    $avatar = (empty($oc['Avatar']) ? NO_IMAGE : $oc['Avatar']);
                                                    $i++;
                                                    ?>
                                                    <div class="box-customer mb10">
                                                        <table>
                                                            <tbody>
                                                            <tr>
                                                                <th rowspan="2" valign="top" style="width: 50px;"><img src="<?php echo USER_PATH.$avatar; ?>" alt=""></th>
                                                                <th><a href="javascript:void(0)" class="name"><?php echo $fullName; ?></a></th>
                                                                <th class="time">
                                                                    <?php $dayDiff = getDayDiff($oc['CrDateTime'], $now);
                                                                    echo getDayDiffText($dayDiff).ddMMyyyy($oc['CrDateTime'], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'); ?>
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
                                                    <?php }  ?>
                                            </div>
                                        </div>
                                        <div class="box box-default more-tabs padding20">
                                            <div class="form-group">
                                                <label class="control-label" style="width: 100%;line-height: 28px;">Thẻ tag <button class="btn-updaten save btn-sm pull-right" type="button" id="btnUpdateTag">Lưu</button></label>
                                                <input type="text" class="form-control" id="tags">
                                            </div>
                                            <p class="light-gray">Có thể chọn những thẻ tag đã được sử dụng</p>
                                            <ul class="list-inline" id="ulTagExist">
                                                <?php foreach($listTags as $t){ ?>
                                                    <li><a href="javascript:void(0)"><?php echo $t['TagName']; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="box box-default classify padding20">
                                            <?php 
                                                $this->load->view('includes/action_logs', 
                                                        array(
                                                            'listActionLogs' =>  $this->Mactionlogs->getList($device['DeviceId'], $itemTypeId, [ID_CREATE,ID_UPDATE]),
                                                            'itemId' => $device['DeviceId'],
                                                            'itemTypeId' => $itemTypeId
                                                        )
                                                    );
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Sim đang gán trên thiết bị<span class="required">*</span></label>
                                            <div class="col-sm-8 form-group boxSelect" style="<?= !empty($DevivceSim) ? 'display:none;' : ''?>">
                                                <select class="form-control select2 " id="SimId">
                                                </select>
                                            </div>

                                            <div class="col-sm-6 form-group boxShow" style="border: 1px solid;padding: 5px;<?= !empty($DevivceSim) ? '' : 'display:none;'?>">
                                                <div class="row">
                                                    <a href="javascript:void(0)" class="btnDelete" style="z-index: 99999;position: absolute;right: 25px;font-size: 30px;">x</a>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label ">Số : </label>
                                                            <div class="col-sm-8 form-group phone">
                                                                <?= !empty($DevivceSim) ? $DevivceSim['PhoneNumber'] : '';?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="SimIdEdit" value="0">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Serisim : </label>
                                                            <div class="col-sm-8 form-group Serisim">
                                                                <?= !empty($DevivceSim) ? $DevivceSim['SeriSim'] : '';?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Nhà mạng : </label>
                                                            <div class="col-sm-8 form-group telco">
                                                                <?php  echo $DevivceSim['SimTypeId'] > 0 ? $this->Mconstants->telcoIds[$DevivceSim['SimTypeId']]:'';?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="DeviceSimId" value="<?= !empty($DevivceSim) ? $DevivceSim['DeviceSimId'] : '0'?>">
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="col-sm-12">
                                            <p>Lịch sử thay đổi SIM</p>
                                        </div>
                                        <div class="boxShowHistory">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_4">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <ul class="list-inline pull-right">
                    <li><button class="btn btn-primary btnUpdate" type="button">Cập nhật</button></li>
                    <li><a href="<?php echo base_url('device'); ?>" id="deviceListUrl" class="btn btn-default">Đóng</a></li>
                    <input type="text" hidden="hidden" value="<?php echo $device['DeviceId'] ?>" name="DeviceId" id="DeviceId">
                    <input type="text" hidden="hidden" value="<?php echo $itemTypeId ?>" id="itemTypeId">
                    <input type="text" hidden="hidden" id="insertCommentUrl" value="<?php echo base_url('itemcomment/insertComment'); ?>">
                    <input type="text" hidden="hidden" id="updateItemTagUrl" value="<?php echo base_url('api/tag/updateItem'); ?>">
                    <input type="text" hidden="hidden" id="updateDeviceSim" value="<?php echo base_url('api/DeviceSim/update'); ?>">
                    <input type="text" hidden="hidden" id="deleteDeviceSim" value="<?php echo base_url('api/DeviceSim/delete'); ?>">
                    <input type="text" hidden="hidden" id="getListHistoryUrl" value="<?php echo base_url('api/DeviceSim/getListHistory'); ?>">
                </ul>
                <?php foreach($tagNames as $tagName){ ?>
                    <input type="text" hidden="hidden" class="tagName" value="<?php echo $tagName; ?>">
                <?php } ?>
                <?php echo form_close(); ?>
            <?php else: ?>
                <?php $this->load->view('includes/error/not_found'); ?>
            <?php endif; ?>
            </section>
        </div>
    </div>
<input type="hidden" id='getListSims' value="<?php echo base_url('Sim/getListSims')?>">
<input type="hidden" id='getBySimId' value="<?php echo base_url('Sim/getBySimId')?>">
<?php $this->load->view('includes/footer'); ?>