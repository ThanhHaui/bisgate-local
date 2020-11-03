<?php if(!empty($ListDeviceSensor)) { foreach ($ListDeviceSensor as $DeviceSensorItem) { ?>
<div class="row row25 mgbt-10">
    <div class="col-sm-5 col25 possition-relative">
        <img src="assets/img/idtb.jpg" alt="" class="imgdevice">
        <p>Thiết bị đang gắn trên xe hiện tại</p>
        <p><span class="blue-color"><?=$DeviceSensorItem['DeviceCodeId']?></span> <span class="ml-20">Giai đoạn <?= date('d/m/Y H:i', strtotime($DeviceSensorItem['BeginDate']))?> - <?= date('d/m/Y H:i', strtotime($DeviceSensorItem['EndDate']))?></span>
        </p>
        <div class="box-search-advance possition-relative height500">
                                            <span class="close-id"></span>
            <div class="row">
                <div class="col-sm-6">
                    <p>Dòng thiết bị*</p>
                </div>
                <div class="col-sm-6">
                    <p><?=$DeviceSensorItem['DeviceTypeName']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p>ID THIẾT BỊ*</p>
                </div>
                <div class="col-sm-6">
                    <p class="blue-color"><?=$DeviceSensorItem['DeviceCodeId']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p>Số sim khai báo LĐ*</p>
                </div>
                <div class="col-sm-6">
                    <p><?=$DeviceSensorItem['SeriSim']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p>Ghi chú lắp đặt thiết bị</p>
                </div>
                <div class="col-sm-6">
                    <p><?=$DeviceSensorItem['Comment']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p>Người thực hiện</p>
                </div>
                <div class="col-sm-6">
                    <p class="blue-color"><?=$DeviceSensorItem['FullName']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <p>Thời điểm thực hiện</p>
                </div>
                <div class="col-sm-6">
                    <p><?= date('d/m/Y H:i', strtotime($DeviceSensorItem['CrDateTime']))?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7 col25">
        <p>Cảm biến đang lắp đặt hiện tại trên xe và thiết bị</p>
        <p><span>ID TB:</span> <span
                class="ml-20 blue-color"><?=$DeviceSensorItem['DeviceCodeId']?></span>
            <img src="assets/img/idtb.jpg" alt="" class="imgdevoce-icon">
            <span>BIỂN SỐ XE:</span> <span
                class="ml-20 blue-color"><?=$DeviceSensorItem['LicensePlate']?></span>
        </p>
        <?php if(!empty($DeviceSensorItem['VehicleDeviceSensor'])) {  ?>
        <div class="box-search-advance height500">
            <div class="device-scroll">
                <?php foreach ($DeviceSensorItem['VehicleDeviceSensor'] as $key => $item) {?>
                    <div class="row mgbt-10">
                        <div class="col-sm-3">
                            <p>Cảm biến <?=$key+1?></p>
                        </div>
                        <div class="col-sm-9">
                            <div class="box-search-advance customer">
                                <div class="row mgbt-10">
                                    <div class="col-sm-6">
                                        <p>Dòng cảm biến*</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-center"><?=$SensorLine[$DeviceSensorItem['DeviceTypeId']][$item['SensorId']]['text']?></p>
                                    </div>
                                </div>
                                <div class="row mgbt-10">
                                    <div class="col-sm-6">
                                        <p>Loại chức năng cảm biến*</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-center"><?=$TypeFunctionId[$item['SensorFunctionId']]?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a class="btnShowDetail" data-id="<?=$DeviceSensorItem['DeviceSensorId']?>">Xem chi tiết</a>
        </div>
        <?php }  else {  ?>
            <div class="box-search-advance d-flex alignend boxNoData height500">
                <p class="absolute-center">Chưa có cảm biến nào được kết nối với Xe và thiết bị</p>
                <a data-toggle="modal" data-target="#view-details-configuration" class="modal-hidden modalHidden">Xem chi
                    tiết và cấu hình</a>
                <a data-toggle="modal" data-target="" class="modalShow btnShowEdit" style="display: none;">Xem chi
                    tiết và cấu hình</a>
            </div>
        <?php } ?>
    </div>
</div>
<?php } } ?>