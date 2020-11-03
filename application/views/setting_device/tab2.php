<div class="box-body border-box p-0 tab tab2"   style="display: none;">
    <?php echo form_open('', array('id' => '')); ?>
    <h2 class="box-title">BƯỚC 2: LẮP ĐẶT CẢM BIẾN</h2>

    <div class="box-search-advance customer">
        <div class="row boxInfo">
            <div class="col-sm-2">
                <p class="mt-6">Khách hàng</p>
            </div>
            <div class="col-sm-10">
                <p class="FullName"><?=isset($VehicleDeviceItem['FullName']) ? $VehicleDeviceItem['FullName'] : ''?></p>
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
                <p class="textXe"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <p class="mt-6">Dòng thiết bị</p>
            </div>
            <div class="col-sm-10">
                <p class="textDeviceType">BIS T5 PRO</p>
            </div>
        </div>
    </div>
    <div class="box-search-advance">
        <input type="hidden" id="SensorLine" value='<?= json_encode($SensorLine)?>'>
        <input type="hidden" id="TypeFunctionText" value='<?= json_encode($TypeFunctionId)?>'>
        <div class="box-append">
            <?php if(!empty($VehicleDeviceSensor)) { $listPort = []; foreach ($VehicleDeviceSensor as $key => $itemSensor) { ?>
                <div class="row mgbt-10 boxCBItem">
                    <div class="col-sm-3">
                        <p class="box-name"><span class="boxNameCB">Cảm biến <?= $key + 1?></span> <i class="fa fa-caret-down caret" aria-hidden="true" <?=$checkDetail == 1 ? 'style="display:none"' : ''?>></i></p>
                    </div>
                    <div class="col-sm-9">
                        <div class="box-search-advance customer">
                            <div class="row mgbt-10 boxEdit"  style="display: none">
                                <div class="col-sm-4">
                                    <p class="mt-6 d-flex">Dòng cảm biến*</p>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control sensorList">
                                        <option value="">--Chọn dòng cảm biến --</option>
                                        <?php foreach ($SensorLine[$VehicleDeviceItem['DeviceTypeId']] as $item) { ?>
                                            <option value="<?=$item['SensorId']?>" <?= $item['SensorId'] == $itemSensor['SensorId'] ? 'selected' : '';?>><?=$item['text']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row boxEdit mgbt-10"  style="display: none">
                                <div class="col-sm-4">
                                    <p class="mt-6 d-flex">Loại chức năng cảm biến*</p>
                                </div>
                                <div class="col-sm-8">
                                    <input type="hidden" value="1" class="checkSave">
                                    <input type="hidden" class="SensorId" value="<?=$itemSensor['SensorId']?>">
                                    <input type="hidden" class="FunctionId" value="<?=$itemSensor['SensorFunctionId']?>">
                                    <input type="hidden" class="Port" value="<?=$itemSensor['SensorPort']?>">
                                    <input type="hidden" class="InputOnOff" value="<?=$itemSensor['IsRevert']?>">
                                    <select class="form-control TypeFunctionId">
                                        <?php foreach ($SensorLine[$VehicleDeviceItem['DeviceTypeId']][$itemSensor['SensorId']]['TypeFunctionId'] as $k => $value) {  ?>
                                            <option value="<?=$k?>"><?= $TypeFunctionId[$k]?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row boxPort boxEdit mgbt-10"  style="display: none">
                                <div class="col-sm-4">
                                    <p class="mt-6 d-flex">Cách kết nối CB với thiết bị*</p>
                                </div><div class="col-sm-8">
                                    <select class="form-control listPort" id="">
                                        <?php foreach ($SensorLine[$VehicleDeviceItem['DeviceTypeId']][$itemSensor['SensorId']]['TypeFunctionId'][$itemSensor['SensorFunctionId']] as $k => $value) {
                                            if(!in_array($value, $listPort)) {
                                                $listPort[] = $value;
                                                ?>
                                                <option value="<?=$value?>" <?=$itemSensor['SensorPort'] == $value ? 'selected' : '' ?>><?=$value?></option>
                                            <?php }}  ?>
                                    </select>
                                </div>
                            </div>
                            <?php if($itemSensor['SensorFunctionId'] == 5) { ?>
                                <div class="row OnOff boxEdit mgbt-10"  style="display: none">
                                    <div class="col-sm-4">
                                        <p class="mt-6 d-flex">Cách kết nối CB với xe*</p>
                                    </div><div class="col-sm-8">
                                        <div class="row">
                                            <p>Bảng thư viện dải cảm biến Điện áp -Dầu của xe</p>
                                        </div>
                                        <div class="row">
                                            <table class="table table-hover table-bordered TBCB">
                                                <tbody>
                                                <tr>
                                                    <td>Điện áp (Von)</td><td>Dầu (lít)</td>
                                                    <td><i class="fa fa-plus btnAddRow"></i></td>
                                                </tr>
                                                <?php $LookupTable = json_decode($itemSensor['LookupTable'], true);?>
                                                <?php foreach ($LookupTable as $key => $value) { ?>
                                                    <tr class="rowValue">
                                                        <td>
                                                            <input type="text" class="form-control voltage" value="<?=$value['voltage']?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control oil" value="<?=$value['oil']?>">
                                                        </td>
                                                        <td>
                                                            <?php if($key > 0) { ?>
                                                                <a href="javascript:void(0)" class="btnDeleteRow"><i class="fa fa-trash"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($itemSensor['SensorFunctionId'] == 1 || $itemSensor['SensorFunctionId'] == 2 || $itemSensor['SensorFunctionId'] == 3) { ?>
                                <div class="row OnOff boxEdit mgbt-10"  style="display: none"> <div class="col-sm-4"><p class="mt-6 d-flex">Cách kết nối CB với xe*</p></div>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6"><p>Default</p>
                                                <p>High - Bật; Low - Tắt</p></div>
                                            <div class="col-sm-6">
                                                <p>
                                                    <label class="setting_check">
                                                        <input type="checkbox" <?= $itemSensor['IsRevert'] == 1 ? 'checked' : ''?> class="checkBoxItem">
                                                        <span class="checkmark"></span> </label>
                                                    <span class="ml-40">Đảo</span>
                                                </p>
                                                <p>High - Tắt; Low - Bật</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row button" >
                                <a href="javascript:void(0)" class="btn btn-danger btnDelete boxEdit"  style="display: none">Xóa</a>
                                <a href="javascript:void(0)" class="btn btn-primary btnSave boxEdit"  style="display: none">Lưu</a>
                            </div>
                            <div class="row boxShow">
                                <div class="col-sm-4">
                                    <p class="mt-6 d-flex">Dòng cảm biến*</p>
                                </div>
                                <div class="col-sm-6"><p class="textSensor"><?=$SensorLine[$VehicleDeviceItem['DeviceTypeId']][$itemSensor['SensorId']]['text']?></p>
                                </div>
                                <div class="col-sm-2">
                                    <a href="javascript:void(0)" class="btnEdit" <?=$checkDetail == 1 ? 'style="display:none"' : ''?>><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="row boxShow">
                                <div class="col-sm-4">
                                    <p class="mt-6 d-flex">Loại chức năng cảm biến*</p>
                                </div>
                                <div class="col-sm-8"><p class="textFunction"><?=$TypeFunctionId[$itemSensor['SensorFunctionId']]?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } } ?>
        </div>
        <div class="row mgbt-10">
            <p class="box-name blue-color" <?=$checkDetail == 1 ? 'style="display:none"' : ''?>><i class="fa fa-plus-circle blue-color add-sensors"
                                                                                                   aria-hidden="true"></i> Thêm cảm biến</p>
        </div>
    </div>
    <div class="justify-content-between close-box">
        <?php if($checkDetail == 0) { ?>
            <button type="button" class="button-can">Hủy</button>
        <?php } ?>
        <div class="">
            <button type="button" class="button-back btnBack1">Back</button>
            <button type="button" class="button-next blue-bg btnActive2">Tiếp theo</button>
            <button type="button" class="button-next btnNone2" style="display: none;">Tiếp theo</button>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>