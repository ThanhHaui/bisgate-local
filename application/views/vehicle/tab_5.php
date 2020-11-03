<div class="box-search-advance customer">
    <div class="row row25 mgbt-10 boxAddNewCB" <?= !empty($DeviceSensorItem) ? 'style="display:none"' : '';?>>
        <div class="col-sm-5 col25 possition-relative">
            <img src="assets/img/idtb.jpg" alt="" class="imgdevice">
            <p>Thiết bị đang gắn trên xe hiện tại</p>
            <p><span class="red">Hiện chưa có TB được lắp trên xe</span>
            </p>
            <div class="box-search-advance possition-relative height200">
                <div class="row mgbt-10">
                    <div class="col-sm-6">
                        <p>Dòng thiết bị*</p>
                    </div>
                    <div class="col-sm-6">
                        <select class="select2 form-control" id="DeviceTypeId">
                            <option value="">-- Chọn dòng thiết bị --</option>
                            <?php foreach ($listDeviceTypes as $item) { ?>
                                <option value="<?= $item['DeviceTypeId']?>"><?= $item['DeviceTypeName']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mgbt-10">
                    <div class="col-sm-6">
                        <p>ID THIẾT BỊ*</p>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="IMEI"  placeholder="Check list - điền khớp 100%" value="">
                    </div>
                    <input type="hidden" id="DeviceId"  value="<?=isset($DeviceSensorItem['DeviceId']) ? $DeviceSensorItem['DeviceId'] : ''?>">
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <p>Ghi chú lắp đặt thiết bị</p>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="Comment"  placeholder="text" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7 col25">
            <p>Cảm biến đang lắp đặt hiện tại trên xe và thiết bị</p>
            <p><span>ID TB:</span> <span
                    class="ml-20 blue-color DeviceCodeId"></span>
                <img src="assets/img/idtb.jpg" alt="" class="imgdevoce-icon">
                <span>BIỂN SỐ XE:</span> <span
                    class="ml-20 blue-color"><?= $vehicle['LicensePlate']?></span>
            </p>
            <div class="box-search-advance height200 d-flex alignend boxNoData">
                <p class="absolute-center">Chưa có cảm biến nào được kết nối với Xe và thiết bị</p>
                <a data-toggle="modal" data-target="#view-details-configuration" class="modal-hidden modalHidden">Xem chi
                    tiết và cấu hình</a>
                <a data-toggle="modal" data-target="" class="modalShow btnShowEdit" style="display: none;">Xem chi
                    tiết và cấu hình</a>
            </div>
            <div class="box-search-advance boxData" style="display:none;">
                <div class="device-scroll SensorData">
                    <div class="row mgbt-10">
                        <div class="col-sm-3">
                            <p>CẢM BIẾN 1</p>
                        </div>
                        <div class="col-sm-9">
                            <div class="box-search-advance customer">
                                <div class="row mgbt-10">
                                    <div class="col-sm-6">
                                        <p>Dòng cảm biến*</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-center">Cable IO T5 ACC V1</p>
                                    </div>
                                </div>
                                <div class="row mgbt-10">
                                    <div class="col-sm-6">
                                        <p>Loại chức năng cảm biến*</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-center">Cảm biến bật tắt động
                                            cơ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a data-toggle="modal" data-target="" class="modalShow btnShowEdit" style="display: none;">Xem chi
                    tiết và cấu hình</a>
            </div>
        </div>
    </div>
    <?php if(!empty($DeviceSensorItem)) { ?>
    <div class="boxDeviceShowInsert">
        <div class="row row25 mgbt-10 boxEditCB">
            <div class="col-sm-5 col25 possition-relative">
                <p>Thiết bị đang gắn trên xe hiện tại</p>
                <p><span class="blue-color"><?=$DeviceSensorItem['DeviceCodeId']?></span> <span class="ml-20">Giai đoạn <?= date('d/m/Y H:i', strtotime($DeviceSensorItem['BeginDate']))?> - Nay</span>
                </p>
            </div>
            <div class="col-sm-7 col25">
                <p>Cảm biến đang lắp đặt hiện tại trên xe và thiết bị</p>
                <p><span>ID TB:</span> <span
                        class="ml-20 blue-color"><?=$DeviceSensorItem['DeviceCodeId']?></span>
                    <img src="assets/img/idtb.jpg" alt="" class="imgdevoce-icon">
                    <span>BIỂN SỐ XE:</span> <span
                        class="ml-20 blue-color"><?=$DeviceSensorItem['LicensePlate']?></span>
                </p>
            </div>
        </div>
        <div class="row row25 mgbt-10 boxEditCB d-flex">
            <div class="col-sm-5 col25 possition-relative d-flex">
                <img src="assets/img/idtb.jpg" alt="" class="imgdevice">
                <div class="box-search-advance possition-relative ">
                                            <span class="close-id"><i class="fa fa-times btnDeleteCB"
                                                                      aria-hidden="true"></i></span>
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
                    <input type="hidden" id="DeviceSensorId" value="<?=$DeviceSensorItem['DeviceSensorId']?>">
                    <input type="hidden" id="DeviceTypeEditId" value="<?=$DeviceSensorItem['DeviceTypeId']?>">
                    <input type="hidden" id="DeviceTypeEditName" value="<?=$DeviceSensorItem['DeviceTypeName']?>">
                </div>
            </div>
            <div class="col-sm-7 col25 d-flex">
                <div class="box-search-advance ">
                    <div class="device-scroll SensorData">

                    </div>
                    <a data-toggle="modal" class="modalShow btnShowEdit">Xem chi
                        tiết và cấu hình</a>
                </div>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <div class="boxDeviceShowInsert">

        </div>
    <?php } ?>
    <div class="boxShowHistory"></div>
</div>
<input type="hidden" id="UrlCheckExist" value="<?= base_url('api/setting/checkExist')?>">
<input type="hidden" id="urlShowHistory" value="<?= base_url('api/DeviceSensor/getListHistory')?>">
<input type="hidden" id="UrlShowDetail" value="<?= base_url('api/DeviceSensor/viewDetailSensor')?>">
<input type="hidden" id="urlDeleteDeviceSensor" value="<?= base_url('api/DeviceSensor/DeleteDeviceSensor')?>">
<input type="hidden" id="urlShowInfoInsert" value="<?= base_url('api/DeviceSensor/showItem')?>">