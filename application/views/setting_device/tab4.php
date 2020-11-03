<div class="box-body border-box p-0 tab tab4" style="display: none">
    <?php echo form_open('', array('id' => '')); ?>
    <h2 class="box-title"> BƯỚC CUỐI:  KCS</h2>

    <div class="box-search-advance customer">
        <div class="row boxInfo">
            <div class="col-sm-2">
                <p class="mt-6">Khách hàng</p>
            </div>
            <div class="col-sm-10">
                <p class="FullName "><?=isset($VehicleDeviceItem['FullName']) ? $VehicleDeviceItem['FullName'] : ''?></p>
                <p>ID : <span class="UserCode"><?=isset($VehicleDeviceItem['UserId']) ? $VehicleDeviceItem['UserId'] + 10000 : ''?></span></p>
                <p>SĐT : <span class="PhoneNumber"><?=isset($VehicleDeviceItem['PhoneNumber']) ? $VehicleDeviceItem['PhoneNumber'] : ''?></span></p>
                <p>Địa chỉ : <span class="Address"><?=isset($VehicleDeviceItem['Address']) ? $VehicleDeviceItem['Address'] : ''?></span></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p class="mt-6">Xe</p>
            </div>
            <div class="col-sm-10">
                <p class="textXe"><?=isset($VehicleDeviceItem['LicensePlate']) ? $VehicleDeviceItem['LicensePlate'] : ''?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p class="mt-6">Dòng thiết bị</p>
            </div>
            <div class="col-sm-10">
                <p class="textDeviceType"><?=isset($VehicleDeviceItem['DeviceTypeName']) ? $VehicleDeviceItem['DeviceTypeName'] : ''?></p>
            </div>
        </div>
    </div>
    <div class="box-search-advance">
        <div class="row mgbt-10" style="text-align: center;">
            <p>Lắp đặt thành công !</p>
        </div>
        <div class="justify-content-between close-box">
            <div class="">
                <button type="button" class="button-back btnBack3">Back</button>
            </div>
        </div>
        <input type="hidden" id="urlSettingList" value="<?= base_url('setting')?>">
        <?php echo form_close(); ?>
    </div>
</div>