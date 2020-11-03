<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <?php if($vehicleId): ?>
                        <li><a class="btn btn-primary btnUpdateVehicle btnShowAdd" data-id="1">Cập nhật</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo base_url('vehicle'); ?>" class="btn btn-default">Đóng</a></li>
                </ul>
            </section>
            <section class="content">
                <?php if($vehicleId): ?>
                    <?php echo form_open('vehicle/update', array('id' => 'vehicleForm')); ?>
                    <div class="row">
                        <div class="box box-default padding15">
                            <ul class="nav nav-tabs mgbt-20 tab-vehicle ul-log-actions">
                                <li class="active" action-type-ids="<?php echo json_encode(array(ID_CREATE,ID_UPDATE)); ?>"><a href="javascript:void(0)" data-id="#tab_1">Thông tin Xe</a></li>
                                <li><a href="javascript:void(0)" data-id="#tab_2">Đăng kiểm</a></li>
                                <li><a href="javascript:void(0)" data-id="#tab_3">Lịch sử bảo dưỡng, sửa chữa</a></li>
                                <li><a href="javascript:void(0)" data-id="#tab_4">Lái xe</a></li>
                                <li><a href="javascript:void(0)" data-id="#tab_5">Thiết bị - cảm biến</a></li>
                                <li action-type-ids="<?php echo json_encode(array(ID_UNASSIGN, ID_ASSIGN)); ?>"><a href="javascript:void(0)" data-id="#tab_6">Dịch vụ SSL</a></li>
                                <li action-type-ids="<?php echo json_encode(array(ID_TAB_CONFIG_IN_VEHICLE)); ?>"><a href="javascript:void(0)" data-id="#tab_7">Cấu hình tổng hợp xe</a></li>
                                <li><a href="javascript:void(0)" data-id="#tab_8">Phân quyền Bislog xe</a></li>
                            </ul>
                            <div class="tab-content tab-vehicle-content">
                                <?php $this->load->view('vehicle/tab_1'); ?>
                                <div class="tab-pane" id="tab_2">
                                </div>
                                <div class="tab-pane" id="tab_3">
                                </div>
                                <div class="tab-pane" id="tab_4">
                                    <?php $this->load->view('vehicle/tab_4'); ?>
                                </div>
                                <div class="tab-pane" id="tab_5">
                                    <?php $this->load->view('vehicle/tab_5'); ?>
                                </div>
                                <div class="tab-pane" id="tab_6">
                                    <?php $this->load->view('vehicle/tab_6'); ?>
                                </div>
                                <div class="tab-pane" id="tab_7">
                                    <?php $this->load->view('vehicle/tab_7'); ?>
                                </div>
                                <div class="tab-pane" id="tab_8">
                                    <?php $this->load->view('vehicle/tab_8'); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" id="VehicleEditId" value="<?php echo $vehicle['VehicleId'] ?>">
                    <input type="hidden" id="urlDeviceSensor" value="<?=base_url('api/DeviceSensor/SaveDeviceSensor') ?>">
                    <input type="hidden" id="urlGetVehicle" value="<?= base_url('api/Vehicle/getVehicle')?>">
                    <input type="hidden" id="urlSaveVehicle" value="<?= base_url('api/Vehicle/save')?>">
                    <ul class="list-inline pull-right margin-right-10">
                        <li><a class="btn btn-primary btnUpdateVehicle btnShowAdd" data-id="1">Cập nhật</a></li>
                        <li><a class="btn btn-primary btnHideAdd" disabled="" style="display: none">Cập nhật</a></li>
                        <li><a href="<?php echo base_url('vehicle'); ?>" id="vehicleListUrl" class="btn btn-default">Đóng</a></li>
                    </ul>
                    <?php echo form_close(); ?>
                    <input type="text" hidden="hidden" id="urlEditVehicle" value="<?php echo base_url('vehicle/edit') ?>">
                <?php else: ?>
                    <?php $this->load->view('includes/error/not_found'); ?>
                <?php endif; ?>
            </section>
        </div>
    </div>
    <div class="modal fade" id="ModalEditSensor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="box-search-advance customer">
                    <div class="row boxInfo">
                        <div class="col-sm-2">
                            <p class="mt-6">Khách hàng</p>
                        </div>
                        <div class="col-sm-10">
                            <p class="FullName"><?=isset($UserInfo['FullName']) ? $UserInfo['FullName'] : ''?></p>
                            <p>ID : <span class="UserCode"><?=isset($UserInfo['UserId']) ? $UserInfo['UserId'] + 10000 : ''?></span></p>
                            <p>SĐT : <span class="PhoneNumber"><?=isset($UserInfo['PhoneNumber']) ? $UserInfo['PhoneNumber'] : ''?></span></p>
                            <p>Địa chỉ : <span class="Address"><?=isset($UserInfo['Address']) ? $UserInfo['Address'] : ''?></span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <p class="mt-6">Xe</p>
                        </div>
                        <div class="col-sm-10">
                            <p class="textXe"><?=isset($vehicle['LicensePlate']) ? $vehicle['LicensePlate'] : ''?></p>
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
                    <input type="hidden" id="SensorLine" value='<?= json_encode($SensorLine)?>'>
                    <input type="hidden" id="TypeFunctionText" value='<?= json_encode($TypeFunctionId)?>'>
                    <div class="box-append">
                        <?php if(!empty($VehicleDeviceSensor)) { $listPort = []; foreach ($VehicleDeviceSensor as $key => $itemSensor) { ?>
                            <div class="row mgbt-10 boxCBItem">
                                <div class="col-sm-3">
                                    <p class="box-name"><span class="boxNameCB">Cảm biến <?= $key + 1?></span> <i class="fa fa-caret-down caret" aria-hidden="true" ></i></p>
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
                                                    <?php foreach ($SensorLine[$DeviceSensorItem['DeviceTypeId']] as $item) { ?>
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
                                                    <?php foreach ($SensorLine[$DeviceSensorItem['DeviceTypeId']][$itemSensor['SensorId']]['TypeFunctionId'] as $k => $value) {  ?>
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
                                                    <?php foreach ($SensorLine[$DeviceSensorItem['DeviceTypeId']][$itemSensor['SensorId']]['TypeFunctionId'][$itemSensor['SensorFunctionId']] as $k => $value) {
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
                                            <div class="col-sm-6"><p class="textSensor"><?=$SensorLine[$DeviceSensorItem['DeviceTypeId']][$itemSensor['SensorId']]['text']?></p>
                                            </div>
                                            <div class="col-sm-2">
                                                <a href="javascript:void(0)" class="btnEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
                        <p class="box-name blue-color"><i class="fa fa-plus-circle blue-color add-sensors" aria-hidden="true"></i> Thêm cảm biến</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalShowDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content showDetail">

            </div>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>