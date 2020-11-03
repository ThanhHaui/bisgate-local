<div class="box-body border-box p-0 tab1 tab">
    <?php echo form_open('', array('id' => '')); ?>
    <h2 class="box-title">Bước 1 Lắp đặt thiết bị</h2>
    <div class="row mgbt-10">
        <div class="col-sm-3">
            <p class="box-name">Thông tin khách hàng</p>
        </div>
        <div class="col-sm-9">
            <div class="box-search-advance customer">
                <div class="row">
                    <div class="col-sm-2">
                        <p class="mt-6">Khách hàng *</p>
                    </div>
                    <div class="col-sm-10">
                        <div>
                            <div class="possition-relative choose-customer" <?= !empty($VehicleDeviceItem) ? 'style="display:none"' : ''?>>
                                <input type="text" class="form-control textbox-advancesearch boxSearch"
                                id="txtSearchCustomer" placeholder="--Chọn khách hàng--">
                            </div>
                            <div class="row boxInfo"   <?= empty($VehicleDeviceItem) ? 'style="display:none"' : ''?>>
                                <div class="col-sm-10">
                                    <p class="fullName"><?=isset($VehicleDeviceItem['FullName']) ? $VehicleDeviceItem['FullName'] : ''?></p>
                                    <p>ID : <span class="userCode"><?=isset($VehicleDeviceItem['UserId']) ? $VehicleDeviceItem['UserId'] + 10000 : ''?></span></p>
                                    <p>SĐT : <span class="phoneNumber"><?=isset($VehicleDeviceItem['PhoneNumber']) ? $VehicleDeviceItem['PhoneNumber'] : ''?></span></p>
                                    <p>Địa chỉ : <span class="address"><?=isset($VehicleDeviceItem['Address']) ? $VehicleDeviceItem['Address'] : ''?></span></p>
                                    <input type="hidden" id="userId" value="<?=isset($VehicleDeviceItem['UserId']) ? $VehicleDeviceItem['UserId'] : ''?>">
                                </div>
                                <div class="col-sm-2">
                                    <?php if($checkDetail == 0) { ?>
                                    <a href="javascript:void(0)" id="btnDeleteUser">x</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelCustomer" >
                            <div class="search-data">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                <input type="text" class="form-control " id="seachText" placeholder="Tìm kiếm khách hàng">
                            </div>
                            <div id="listUser">
                            <?php $this->load->view('includes/customer/_search_customer'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mgbt-10">
        <div class="col-sm-3">
            <p class="box-name">Lắp trên xe nào</p>
        </div>
        <div class="col-sm-9">
            <div class="box-search-advance customer">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mt-6 d-flex">Biển số xe * <a href="javascript:void(0)"   class="btnShơwModal btnAddVehicle" <?= isset($VehicleDeviceItem['VehicleId']) && $checkDetail == 0 ? '' : 'style="display: none"' ?>><i style="color: #3c8dbc" class="fa fa-plus-circle"
                                                                                                                                                       aria-hidden="true"></i></a>
                            <a href="javascript:void(0)" class="btnHideModal" <?= isset($VehicleDeviceItem['VehicleId']) || $checkDetail == 1 ? 'style="display: none"' : '' ?>><i class="fa fa-plus-circle "></i></a>
                        </p>
                    </div>
                    <div class="col-sm-9">
                        <select class="select2 form-control  edit-license" id="VehicleId" <?= isset($VehicleDeviceItem['VehicleId']) && $checkDetail == 0 ? '' : 'disabled' ?>>
                            <option value="">--Chọn từ danh sách xe đang có --</option>
                           
                        </select>
                    </div>
                    <a href="javascript:void(0)" id="btnEditVehicle" style="position: absolute;right: 25px;top: 30px;<?= isset($VehicleDeviceItem['VehicleId']) && $checkDetail == 0 ? '' : 'display: none' ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mgbt-10">
        <div class="col-sm-3">
            <p class="box-name">Thông tin thiết bị</p>
        </div>
        <div class="col-sm-9">
            <div class="box-search-advance customer">
                <div class="row mgbt-10">
                    <div class="col-sm-3">
                        <p class="mt-6">Dòng thiết bị *</p>
                    </div>
                    <div class="col-sm-9">
                        <select class="select2 form-control" id="DeviceTypeId" <?=$checkDetail == 1 ? 'disabled' : ''?>>
                            <option value="">-- Chọn dòng thiết bị --</option>
                            <?php foreach ($Devicetypes as $item) { ?>
                                <option value="<?= $item['DeviceTypeId']?>" <?=$checkDetail == 1 ? 'disabled' : ''?> <?= isset($VehicleDeviceItem['DeviceTypeId']) && $VehicleDeviceItem['DeviceTypeId'] == $item['DeviceTypeId'] ? 'selected' : ''?>><?= $item['DeviceTypeName']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mgbt-10">
                    <div class="col-sm-3">
                        <p class="mt-6">ID thiết bị *</p>
                    </div>
                    <input type="hidden" id="DeviceId" <?=$checkDetail == 1 ? 'disabled' : ''?> value="<?= isset($VehicleDeviceItem['DeviceId']) ? $VehicleDeviceItem['DeviceId'] : '0'?>">
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="IMEI" <?=$checkDetail == 1 ? 'disabled' : ''?> placeholder="Check list - điền khớp 100%" value="<?= isset($VehicleDeviceItem['IMEI']) ? $VehicleDeviceItem['IMEI'] : ''?>">
                    </div>
                </div>
                <div class="row mgbt-10">
                    <div class="col-sm-3">
                        <p class="mt-6">Số sim khai báo LĐ *</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control " id="SeriSim" <?=$checkDetail == 1 ? 'disabled' : ''?> value="<?= isset($VehicleDeviceItem['SeriSim']) ? $VehicleDeviceItem['SeriSim'] : ''?>" placeholder="Check list - điền khớp 100%">
                        <input type="hidden" id="SimId" value="<?= isset($VehicleDeviceItem['SimId']) ? $VehicleDeviceItem['SimId'] : '0'?>">
                    </div>
                </div>
                <div class="row mgbt-10">
                    <div class="col-sm-3">
                        <p class="mt-6">Ghi chú lắp đặt thiết bị</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="Comment" <?=$checkDetail == 1 ? 'disabled' : ''?> placeholder="text" value="<?= isset($VehicleDeviceItem['Comment']) ? $VehicleDeviceItem['Comment'] : ''?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="close-box">
        <?php if($checkDetail == 0) { ?>
            <button type="button" class="button-can">Hủy</button>
        <?php } ?>
        <button type="button" class="button-next blue-bg btnActive" <?= isset($VehicleDeviceItem['VehicleId']) ? '' : 'style="display: none;"'?> >Tiếp theo</button>
        <button type="button" class="button-next btnNone"  <?= isset($VehicleDeviceItem['VehicleId']) ? 'style="display: none;"' : ''?>>Tiếp theo</button>
    </div>
    <input type="hidden" id="VehicleDeviceId" value="<?= isset($VehicleDeviceItem['VehicleDeviceId']) ? $VehicleDeviceItem['VehicleDeviceId'] : 0 ?>">
    <input type="hidden" id="UrlCheckCode" value="<?=base_url('api/setting/checkCode')?>">
    <input type="hidden" id="UrlGetListSSL" value="<?=base_url('api/setting/getListSSL')?>">
    <input type="hidden" id="UrlUpdateVehicleDevice" value="<?=base_url('api/setting/UpdateVehicleDevice')?>">
    <input type="hidden" id="urlSaveVehicleDevice" value="<?=base_url('api/setting/SaveVehicleDevice')?>">
    <input type="hidden" id="UrlCheckExist" value="<?= base_url('api/setting/checkExist')?>">
   
    <?php echo form_close(); ?>
</div>