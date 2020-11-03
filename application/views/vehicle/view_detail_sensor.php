<div class="box-search-advance customer">
    <div class="row boxInfo">
        <div class="col-sm-2">
            <p class="mt-6">Khách hàng</p>
        </div>
        <div class="col-sm-10">
            <p class="FullName"><?=isset($DeviceSensorItem['FullName']) ? $DeviceSensorItem['FullName'] : ''?></p>
            <p>ID : <span class="UserCode"><?=isset($DeviceSensorItem['UserId']) ? $DeviceSensorItem['UserId'] + 10000 : ''?></span></p>
            <p>SĐT : <span class="PhoneNumber"><?=isset($DeviceSensorItem['PhoneNumber']) ? $DeviceSensorItem['PhoneNumber'] : ''?></span></p>
            <p>Địa chỉ : <span class="Address"><?=isset($DeviceSensorItem['Address']) ? $DeviceSensorItem['Address'] : ''?></span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <p class="mt-6">Xe</p>
        </div>
        <div class="col-sm-10">
            <p class="textXe"><?=isset($DeviceSensorItem['LicensePlate']) ? $DeviceSensorItem['LicensePlate'] : ''?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <p class="mt-6">Dòng thiết bị</p>
        </div>
        <div class="col-sm-10">
            <p class="textDeviceType"><?=isset($DeviceSensorItem['DeviceTypeName']) ? $DeviceSensorItem['DeviceTypeName'] : ''?></p>
        </div>
    </div>
</div>
<div class="box-search-advance">
    <div class="">
        <?php if(!empty($DeviceSensorItem['VehicleDeviceSensor'])) {  foreach ($DeviceSensorItem['VehicleDeviceSensor'] as $key => $itemSensor) { ?>
            <div class="row mgbt-10">
                <div class="col-sm-3">
                    <p class="box-name"><span class="boxNameCB">Cảm biến <?= $key + 1?></span> <i class="fa fa-caret-down caret" aria-hidden="true" ></i></p>
                </div>
                <div class="col-sm-9">
                    <div class="box-search-advance customer">
                        <div class="row mgbt-10 boxEdit" >
                            <div class="col-sm-4">
                                <p class="mt-6 d-flex">Dòng cảm biến*</p>
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control sensorList" disabled>
                                    <option value="">--Chọn dòng cảm biến --</option>
                                    <?php foreach ($SensorLine[$DeviceSensorItem['DeviceTypeId']] as $item) { ?>
                                        <option value="<?=$item['SensorId']?>" <?= $item['SensorId'] == $itemSensor['SensorId'] ? 'selected' : '';?>><?=$item['text']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row boxEdit mgbt-10" >
                            <div class="col-sm-4">
                                <p class="mt-6 d-flex">Loại chức năng cảm biến*</p>
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control TypeFunctionId" disabled>
                                    <?php foreach ($SensorLine[$DeviceSensorItem['DeviceTypeId']][$itemSensor['SensorId']]['TypeFunctionId'] as $k => $value) {  ?>
                                        <option value="<?=$k?>" ><?= $TypeFunctionId[$k]?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row boxPort boxEdit mgbt-10" >
                            <div class="col-sm-4">
                                <p class="mt-6 d-flex">Cách kết nối CB với thiết bị*</p>
                            </div><div class="col-sm-8">
                                <select class="form-control listPort" id="" disabled>
                                    <?php foreach ($SensorLine[$DeviceSensorItem['DeviceTypeId']][$itemSensor['SensorId']]['TypeFunctionId'][$itemSensor['SensorFunctionId']] as $k => $value) {
                                        ?>
                                            <option value="<?=$value?>" <?=$itemSensor['SensorPort'] == $value ? 'selected' : '' ?>><?=$value?></option>
                                        <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <?php if($itemSensor['SensorFunctionId'] == 5) { ?>
                            <div class="row OnOff boxEdit mgbt-10" >
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
                                                <td>Điện áp (Von)</td>
                                                <td>Dầu (lít)</td>
                                            </tr>
                                            <?php $LookupTable = json_decode($itemSensor['LookupTable'], true);?>
                                            <?php foreach ($LookupTable as $key => $value) { ?>
                                                <tr class="rowValue">
                                                    <td>
                                                        <input type="text" disabled class="form-control voltage" value="<?=$value['voltage']?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" disabled class="form-control oil" value="<?=$value['oil']?>">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row boxPort boxEdit mgbt-10">
                                <div class="col-sm-4">
                                    <p class="mt-6 d-flex">Thể tích thùng NL*</p>
                                </div>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control " id="Consumption" placeholder="<?php $itemSensor['Consumption']?>" required>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($itemSensor['SensorFunctionId'] == 1 || $itemSensor['SensorFunctionId'] == 2 || $itemSensor['SensorFunctionId'] == 3) { ?>
                            <div class="row OnOff boxEdit mgbt-10" > <div class="col-sm-4"><p class="mt-6 d-flex">Cách kết nối CB với xe*</p></div>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6"><p>Default</p>
                                            <p>High - Bật; Low - Tắt</p></div>
                                        <div class="col-sm-6">
                                            <p>
                                                <label class="setting_check">
                                                    <input type="checkbox" <?= $itemSensor['IsRevert'] == 1 ? 'checked' : ''?> class="checkBoxItem" disabled>
                                                    <span class="checkmark"></span> </label>
                                                <span class="ml-40">Đảo</span>
                                            </p>
                                            <p>High - Tắt; Low - Bật</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } } ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
</div>