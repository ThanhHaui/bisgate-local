<div id="panelLicensePlates" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="panel-body">
                <div class="row mgbt-10">
                    <div class="col-sm-3">
                        <p class="box-name v1">Thông tin khách hàng</p>
                    </div>
                    <div class="col-sm-9">
                        <div class="box-search-advance">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mt-6">Khách hàng *</p>
                                </div>
                                <div class="col-sm-9 boxInfo">
                                    <div class="inline_block ml10">
                                        <p class="fullName">Thái Nguyễn</p>
                                        <p>ID: <span class="userCode"></span></p>
                                        <p>SĐT: <span  class="phoneNumber"></span></p>
                                        <p>Địa chỉ: <span class="address"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mgbt-10">
                    <div class="col-sm-3">
                        <p class="box-name v1">Thông tin thêm xe</p>
                    </div>
                    <div class="col-sm-9">
                        <div class="box-search-advance customer">
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Chủng loại xe</p>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control select2 " id="VehicleTypeId">
                                        <option value="0">--- Chủng loại xe ---</option>
                                        <?php foreach ($Vehicletypes as $item) { ?>
                                            <option value="<?=$item['VehicleTypeId']?>"><?=$item['VehicleTypeName']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6"></p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row mgbt-10 mgt-10">
                                        <div class="col-sm-3">
                                            <p class="mt-6">Trọng tải</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="TonnageId">
                                                <option value="0">--- Trọng tải ---</option>
                                                <?php foreach ($Tonnages as $item) { ?>
                                                    <option value="<?=$item['TonnageId']?>"><?=$item['TonnageName']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Mục đích sử dụng *</p>
                                </div>
                                <div class="col-sm-9">
                                    <?php $this->Mconstants->selectConstants('purposeId', 'PurposeId'); ?>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Biển số xe *</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control " id="LicensePlate" placeholder="">
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Sở GTVT quản lý </p>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control select2" id="ProvinceId">
                                        <option value="0">--- Chọn tỉnh thành Việt Nam ---</option>
                                        <?php foreach ($ProvinceList as $province) { ?>
                                            <option value="<?=$province['ProvinceId']?>"><?=$province['ProvinceName']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Ngày đăng kiểm gần nhất </p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker w-30 d-inline-block" id="LastRegistryDate" >
                                    <span>Chu kì đăng kiểm</span>  <input type="text" class="form-control w-50px d-inline-block" id="RegistryCycle">
                                    <span> tháng</span>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Số Vin xe</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control " id="VIN" placeholder="Nhập text" >
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Tên hãng xe</p>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control select2" id="VehicleManufacturerId">
                                        <option value="0">--- hãng xe ---</option>
                                        <?php foreach ($VehicleManuFacturers as $item) { ?>
                                            <option value="<?=$item['VehicleManufacturerId']?>"><?=$item['VehicleManufacturerName']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Tên dòng xe</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control " id="VehicleKindName" >
                                </div>
                            </div>
                            <div class="row mgbt-10">
                                <div class="col-sm-3">
                                    <p class="mt-6">Đời xe</p>
                                </div>
                                <div class="col-sm-9">
                                    <select class="form-control select2" id="VehicleModelId">
                                        <option value="0">--- Đời xe ---</option>
                                        <?php for ($i = 1990; $i <= 2030; $i++) {?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="VehicleEditId" value="0">
            <input type="hidden" id="urlGetVehicle" value="<?= base_url('api/Vehicle/getVehicle')?>">
            <input type="hidden" id="urlSaveVehicle" value="<?= base_url('api/Vehicle/save')?>">
            <div class="modal-footer">
                <button type="button" class="license-can" data-dismiss="modal">Close</button>
                <button type="submit" class="license-new btnUpdateVehicle" >Tạo xe mới</button>
            </div>
        </div>

    </div>
</div>