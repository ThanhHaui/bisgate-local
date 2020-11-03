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