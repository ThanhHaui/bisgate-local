<div class="box-body border-box p-0 tab tab3" style="display: none">
    <?php echo form_open('', array('id' => '')); ?>
    <h2 class="box-title"> BƯỚC 3: CẤU HÌNH DỊCH VỤ</h2>
    <div class="box-search-advance customer">
        <div class="row boxInfo">
            <div class="col-sm-2">
                <p class="mt-6">Khách hàng</p>
            </div>
            <div class="col-sm-10">
                <p class="FullName"><?= isset($VehicleDeviceItem['FullName']) ? $VehicleDeviceItem['FullName'] : '' ?></p>
                <p>ID : <span
                            class="UserCode"><?= isset($VehicleDeviceItem['UserId']) ? $VehicleDeviceItem['UserId'] + 10000 : '' ?></span>
                </p>
                <p>SĐT : <span
                            class="PhoneNumber"><?= isset($VehicleDeviceItem['PhoneNumber']) ? $VehicleDeviceItem['PhoneNumber'] : '' ?></span>
                </p>
                <p>Địa chỉ : <span
                            class="Address"><?= isset($VehicleDeviceItem['Address']) ? $VehicleDeviceItem['Address'] : '' ?></span>
                </p>
                <!--                <input type="hidden" id="UserId" name="UserId" value="0">-->
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
        <div class="row mgbt-10">
            <div class="col-sm-3">
                <p class="box-name">CHỌN THAO TÁC
                </p>
            </div>
            <div class="col-sm-6">
                <div class="d-flex justify-content-between">
                                    <span class="item"><input type="radio" name="ssl" class="iCheckRadio" value="0"
                                                              id="btnSSLNew"
                                                              <?= !isset($VehicleDeviceItem['SSLIsOld']) || $VehicleDeviceItem['SSLIsOld'] == 0 ? 'checked' : '' ?>
                                                              <?= $checkDetail == 1 ? 'disabled' : '' ?>> Tạo gói dịch vụ SSL mới</span><br/>
                    <span class="item"><input type="radio" id="btnUseSSL" name="ssl" class="iCheckRadio"
                                              <?= isset($VehicleDeviceItem['SSLIsOld']) && $VehicleDeviceItem['SSLIsOld'] == 1 ? 'checked' : '' ?>
                                              value="1"
                                              <?= $checkDetail == 1 ? 'disabled' : '' ?>> Dùng lại SSL cũ</span>
                </div>
            </div>
            <input type="hidden" id="SSLIsOld"
                   value="<?= isset($VehicleDeviceItem['SSLIsOld']) ? $VehicleDeviceItem['SSLIsOld'] : 0 ?>">
        </div>
        <div class="row mgbt-10 boxNew"
             <?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLIsOld'] == 1 ? 'style="display: none"' : '' ?>>
            <div class="col-sm-3">
                <p class="mt-6 d-flex">Kiểu kích hoạt</p>
            </div>
            <div class="col-sm-6">
                <select class="form-control" id="SSLtypeId" <?= $checkDetail == 1 ? 'disabled' : '' ?>>
                <option value= "0">--Chọn kiểu kích hoạt--</option>
                    <?php foreach ($sslType as $key => $value) { ?>
                        <option value="<?= $key ?>"
                                <?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLTypeId'] == $key ? 'selected' : '' ?>><?= $value ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="boxOld"
             <?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLIsOld'] == 1 ? '' : 'style="display: none"' ?>>
            <div class="row mgbt-10 boxOld">
                <div class="col-sm-3">
                    <p class="mt-6 d-flex">CHỌN MÃ SLL</p>
                </div>
                <div class="col-sm-6">
                    <select class="form-control" id="SSLId" <?= $checkDetail == 1 ? 'disabled' : '' ?>>
                        <?php if (isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLIsOld'] == 1) { ?>
                            <option value="0">Chọn SSL trống trong danh sách</option>
                            <?php foreach ($SSLList as $item) { ?>
                                <option value="<?= $item['SSLId'] ?>"
                                        <?= $VehicleDeviceItem['SSLOldId'] == $item['SSLId'] ? 'selected' : ''; ?>>
                                    SSL-<?= $item['SSLId'] + 10000 ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="showData">

            </div>
        </div>
        <div class="boxNew"
             <?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLIsOld'] == 1 ? 'style="display: none"' : '' ?>>
            <div class="row mgbt-20 boxSoftWare boxType2 boxType"
                 <?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLTypeId'] == 2 ? '' : 'style="display: none"' ?>>
                <div class="col-sm-3">
                    <p class="mt-6 d-flex">Phần mềm GSHT bắt buộc*</p>
                </div>
                <div class="col-sm-6">
                    <div class="box-search-advance">
                        <div class="box-default padding15">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <p>Cấu hình gán gói phần mềm cho thuê bao và tạo lệnh gia hạn</p>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <p><i class="fa fa-fw fa-check-square-o"></i> Gói phần mềm base bắt buộc*
                                        (<span id="totalBase">1</span>)</p>
                                    <div class="box-body table-responsive divTable">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width:60px">STT</th>
                                                <th>Tên gói phần mềm</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyBase">
                                            <tr data-id="<?php echo $packageBase['PackageId'] ?>" check-add="0">
                                                <td>1</td>
                                                <td><?php echo $packageBase['PackageName'] ?> (dùng thử miễn phí một ngày)</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <p><a href="javascript:void(0)"
                                          class="base-package btnShowModalBase" data-id="2">
                                            <i class="fa fa-fw fa-plus-circle"></i></a> Gói phần mềm mở
                                        rộng (<span id="totalSslDetail">0</span>)
                                    </p>
                                    <div class="box-body table-responsive divTable">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width:60px">STT</th>
                                                <th>Tên gói phần mềm</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodySslDetails"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right">
                    <input type="hidden" id="urlGetPackages"
                           value="<?php echo base_url('package/getPackages'); ?>">
                    <input type="hidden" id="sslId" name="SSLId" value="0">
                </ul>
            </div>
        </div>
        <!-- thiết kế mới không có đoạn này, ẩn đi -->
        <div style="display: none">
        <div class="row mgt-10 boxModule boxType2 boxType"
             <?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLTypeId'] == 2 ? '' : 'style="display: none"' ?>>
            <div class="col-sm-3">
                <p><input type="checkbox" class="iCheckTable iCheckItem checkModule" id=""
                          <?= isset($VehicleDeviceItem['IsModule']) && $VehicleDeviceItem['IsModule'] == 1 ? 'checked' : '' ?>
                          <?= $checkDetail == 1 ? 'disabled' : '' ?>> Module mở rộng</p>
            </div>
            <div class="col-sm-6 moduleList"
                 <?= isset($VehicleDeviceItem['IsModule']) && $VehicleDeviceItem['IsModule'] == 1 ? '' : 'style="display: none"' ?>>
                <div class="check-input-hidden">
                    <div class="box-search-advance">
                        <?php foreach ($ExpandedList as $Expanded) { ?>
                            <div class="row mgbt-10 boxItem">
                                <div class="col-sm-6">
                                    <p><input <?= $checkDetail == 1 ? 'disabled' : '' ?> type="checkbox"
                                              value="<?= $Expanded['ActionId'] ?>" class="checkbox-module ActionId"
                                              <?= in_array($Expanded['ActionId'], $dataId) ? 'checked' : '' ?>
                                              data-id="#checkbox01"> <?= $Expanded['ActionName'] ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-control checkbox-hidden Month" id="checkbox01"
                                            <?= $checkDetail == 1 ? 'disabled' : '' ?>>
                                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <option value="<?= $i ?>"><?= $i ?> tháng</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row mgbt-10 boxType boxType3"
             <?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLTypeId'] == 3 ? '' : 'style="display: none"' ?>>
            <div class="col-sm-3">
                <p class="mt-6 d-flex">Mã CODE SSL</p>
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="SSLCODE"
                       value="<?= isset($VehicleDeviceItem['SSLCode']) ? $VehicleDeviceItem['SSLCode'] : '' ?>"
                       placeholder="Nhập mã code để active">
                <a href="javascript:void(0)" class="btn btn-primary btnCheckCode"
                   style="position: absolute;right: 15px;top: 0px;">Check Code</a>
                <p class="messageError" style="color: red"></p>
            </div>
            <input type="hidden" id="checkCode"
                   value="<?= isset($VehicleDeviceItem['SSLTypeId']) && $VehicleDeviceItem['SSLTypeId'] == 3 ? '1' : '0' ?>">
        </div>
        <div class="boxType3 showData boxType">

        </div>
    </div>
    <input type="hidden" id="SSLOldId"

           value="<?= isset($VehicleDeviceItem['SSLId']) ? $VehicleDeviceItem['SSLId'] : '' ?>">
    <div class="justify-content-between close-box">
        <?php if ($checkDetail == 0) { ?>
            <button type="button" class="button-can">Hủy</button>
        <?php } ?>
        <div class="">
            <button type="button" class="button-back btnBack2">Back</button>
            <?php if ($checkDetail == 0) { ?>
                <button type="button" class="button-next blue-bg btnActived submit_update_ssl" style="width: 160px">Kích
                    hoạt 24h dịch
                    vụ
                </button>
                <button type="button" class="button-next btnNone3" style="display: none;width: 160px">Kích hoạt dịch
                    vụ
                </button>
            <?php } else { ?>
                <button type="button" class="button-next blue-bg btnActivedNext">Tiếp theo</button>
            <?php } ?>
        </div>
    </div>
    <input type="hidden" id="PackageId" name="PackageId" value="<?php echo $packageBase['PackageId'] ?>">
    <input type="hidden" id="PackagePrice" name="PackagePrice" value="0">
    <input type="hidden" id="ExpiryDate" name="ExpiryDate" value="0">
    <input type="hidden" id="SSLDetails" name="SSLDetails" value="">
    <input type="hidden" id="itemTypeId" name="ItemTypeId" value="8">
    <input type="hidden" id="vehicleDeviceId" name="vehicleDeviceId" value="<?php echo isset($vehicleDeviceId)?$vehicleDeviceId:'0' ?>">

    <?php echo form_close(); ?>
</div>
</div>
<?php $this->load->view('ssl/_modal'); ?>
<input type="hidden" name="ssl_update" value="ssl/update">