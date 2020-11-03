<div class="box-search-advance customer">
    <div class="row">
        <div class="col-sm-3">
            <p class="mt-6">Giao lái xe quản lý xe này</p>
        </div>
        <div class="col-sm-8 boxSelect" style="<?= !empty($UserVehicle) ? 'display:none;' : ''?>">
            <div>
                <input type="text" class="form-control userDriverShowList"
                       id="" placeholder="Chọn lái xe">
            </div>
            <div id="userDriverList" style="border: 1px solid #ccc;">
            </div>
        </div>
        <div class="col-sm-4 form-group boxShowInfo" style="border: 1px solid;padding: 5px;<?= !empty($UserVehicle) ? '' : 'display:none;'?>">
            <div class="row">
                <a href="javascript:void(0)" class="btnDelete" style="z-index: 99999;position: absolute;right: 25px;font-size: 30px;">x</a>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-4 control-label ">Tên lái xe : </label>
                        <div class="col-sm-8 form-group FullName">
                            <?= !empty($UserVehicle) ? $UserVehicle['FullName'] : ''?>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="SimIdEdit" value="0">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">GPLX : </label>
                        <div class="col-sm-8 form-group GPLX">
                            <?= !empty($UserVehicle) ? $UserVehicle['DriverLicence'] : ''?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">SDT : </label>
                        <div class="col-sm-8 form-group PhoneNumber">
                            <?= !empty($UserVehicle) ? $UserVehicle['PhoneNumber'] : ''?>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="DriverId" value="0">
            <input type="hidden" id="UserVehicleId" value="<?= !empty($UserVehicle) ? $UserVehicle['UserVehicleId'] : 0?>">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="col-sm-12">
                <p>Lịch sử thay đổi lái xe</p>
            </div>
            <div class="boxShowHistoryDriver">

            </div>
        </div>
    </div>
</div>
<input type="text" hidden="hidden" id="updateUserVehicle" value="<?php echo base_url('api/UserVehicle/update'); ?>">
<input type="text" hidden="hidden" id="deleteUserVehicle" value="<?php echo base_url('api/UserVehicle/delete'); ?>">
<input type="text" hidden="hidden" id="getListHistoryUrl" value="<?php echo base_url('api/UserVehicle/getListHistory'); ?>">
<input type="text" hidden="hidden" id="getListUserDrivers" value="<?php echo base_url('customer/getListUserDrivers'); ?>">