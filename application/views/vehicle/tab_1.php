<div class="tab-pane active" id="tab_1">
    <div class="row">
        <div class="col-sm-8">
            <div class="row mgbt-20">
                <div class="col-sm-3">
                    <p class="box-name v1">Thông tin khách hàng</p>
                </div>
                <div class="col-sm-9">
                    <div class="box-search-advance customer" >
                        <div class="row">
                            <div class="col-sm-2">
                                <p class="mt-6">Khách hàng *</p>
                            </div>
                            <div class="col-sm-10">
                                <div>
                                    <div class="possition-relative choose-customer">
                                        <input type="text" class="form-control textbox-advancesearch boxSearch"  <?= !empty($UserInfo) ? 'style="display:none"' : ''?>
                                               id="txtSearchCustomer" placeholder="--Chọn khách hàng--">
                                    </div>
                                    <div class="row boxInfo"   <?= empty($UserInfo) ? 'style="display:none"' : ''?>>
                                        <div class="col-sm-10">
                                            <p class="FullName"><?=isset($UserInfo['FullName']) ? $UserInfo['FullName'] : ''?></p>
                                            <p>ID : <span class="UserCode"><?=isset($UserInfo['UserId']) ? $UserInfo['UserId'] + 10000 : ''?></span></p>
                                            <p>SĐT : <span class="PhoneNumber"><?=isset($UserInfo['PhoneNumber']) ? $UserInfo['PhoneNumber'] : ''?></span></p>
                                            <p>Địa chỉ : <span class="Address"><?php echo $this->Mprovinces->getFieldValue(array('ProvinceId' => $UserInfo['ProvinceId']),'ProvinceName','') ?></span></p>
                                            <input type="hidden" id="userId" value="<?=isset($UserInfo['UserId']) ? $UserInfo['UserId'] : ''?>">
                                        </div>
                                        <div class="col-sm-2">

                                        </div>
                                    </div>
                                </div>
                               <!--  <div class="panel panel-default" id="panelCustomer">
                                    <div class="panel-body">
                                        <div class="list-search-data">
                                            <div class="search-data">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                                <input type="text" class="form-control " id="" placeholder="Tìm kiếm khách hàng">
                                            </div>
                                            <div class="slimScrollDiv"
                                                 style="position: relative; width: auto; height: 250px;">
                                                <ul id="ulListCustomers"
                                                    style=" width: auto; height: 250px;">
                                                    <?php foreach ($UserList as $user) { ?>
                                                        <li class="row" data-id="<?=$user['UserId']?>">
                                                            <div class="wrap-img inline_block vertical-align-t radius-cycle">
                                                                <img class="thumb-image radius-cycle"
                                                                     src="<?=$user['Avatar'] ? $user['Avatar'] : 'assets/vendor/dist/img/users.png'?>" title="">
                                                            </div>
                                                            <div class="inline_block ml10"><p class="pCustomerName"><span id="FullName"><?=$user['FullName']?></span></p>
                                                                <p>ID: <span id="UserCode"><?=10000 + $user['UserId']?></span></p>
                                                                <p>SĐT:  <span id="PhoneNumber"><?=$user['PhoneNumber']?></span></p>
                                                                <p>Địa chỉ:  <span id="Address"><?=$user['Address']?></span></p>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="btn-group pull-right">
                                            <button type="button" class="btn btn-default" id="btnPrevCustomer"><i
                                                    class="fa fa-chevron-left"></i></button>
                                            <button type="button" class="btn btn-default" id="btnSaveCustomer"><i
                                                    class="fa fa-chevron-right"></i></button>
                                            <input type="text" hidden="hidden" id="pageIdCustomer" value="1">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mgbt-20">
                <div class="col-sm-3">
                    <p class="box-name v1">Thông tin thêm xe</p>
                </div>
                <div class="col-sm-9">
                    <div class="box-search-advance customer" style="    z-index: inherit;">
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
                                <p class="mt-6">Mục đích sử dụng *</p>
                            </div>
                            <div class="col-sm-9">
                                <?php $this->Mconstants->selectConstants('purposeId', 'PurposeId', $PurposeId); ?>
                            </div>
                        </div>
                        <div class="row mgbt-10">
                            <div class="col-sm-3">
                                <p class="mt-6">Sở GTVT quản lý *</p>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="ProvinceId">
                                    <option value="0">--- Chọn tỉnh thành Việt Nam ---</option>
                                    <?php foreach ($listProvinces as $province) { ?>
                                        <option value="<?=$province['ProvinceId']?>"><?=$province['ProvinceName']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mgbt-10">
                            <div class="col-sm-3">
                                <p class="mt-6">Ngày đăng kiểm gần nhất *</p>
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
                                <p class="mt-6">Chủng loại xe</p>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control select2 " id="VehicleTypeId">
                                    <option value="0">--- Chủng loại xe ---</option>
                                    <?php foreach ($listVehicleTypes as $item) { ?>
                                        <option value="<?=$item['VehicleTypeId']?>" <?php echo ($item['VehicleTypeId'] == $vehicle['VehicleTypeId'])?'selected':''?>><?=$item['VehicleTypeName']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mgbt-10">
                            <div class="col-sm-3">

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
                                                <option value="<?=$item['TonnageId']?>  <?php echo ($item['TonnageId'] == $vehicle['TonnageId'])?'selected':''?>" <?php if(($vehicle['TonnageId'] == $item['TonnageId'])) echo ' selected="selected"'; ?> ><?=$item['TonnageName']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mgbt-10">
                            <div class="col-sm-3">
                                <p class="mt-6">Tên hãng xe</p>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="VehicleManufacturerId">
                                    <option value="0">--- hãng xe ---</option>
                                    <?php foreach ($listVehicleManuFacturers as $item) { ?>
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
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-4">
                        <label class="control-label">Ngày thêm</label>
                    </div>
                    <div class="col-sm-8">
                        <span> <?php echo  $vehicle['CrDateTime']; ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-4">
                        <label class="control-label">Người thêm</label>
                    </div>
                    <div class="col-sm-8">
                        <span><i class="fa fa-fw fa-user"></i> <?php echo $vehicle['CrName']; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box box-default classify padding20">
                <label class="light-blue">Ghi chú</label>
                <div class="box-transprt clearfix mb10">
                    <button type="button" class="btn-updaten save" id="btnInsertComment1">
                        Lưu
                    </button>
                    <input type="text" class="add-text" id="comment1" value="" placeholder="Thêm nội dung ghi chú">
                </div>
                <div class="listComment" id="listComment1"  style="<?php echo  count($itemComments)  > 5 ? 'height:300px; overflow:auto': ''; ?>">
                    <?php $i = 0;
                    $now = new DateTime(date('Y-m-d'));
                    foreach($itemComments as $oc){
                        $fullName = $this->Mstaffs->getFieldValue(array('StaffId' => $oc['CrUserId']), 'FullName', '');
                        $avatar = (empty($oc['Avatar']) ? NO_IMAGE : $oc['Avatar']);
                        $i++;
                        ?>
                        <div class="box-customer mb10">
                            <table>
                                <tbody>
                                <tr>
                                    <th rowspan="2" valign="top" style="width: 50px;"><img src="<?php echo USER_PATH.$avatar; ?>" alt=""></th>
                                    <th><a href="javascript:void(0)" class="name"><?php echo $fullName; ?></a></th>
                                    <th class="time">
                                        <?php $dayDiff = getDayDiff($oc['CrDateTime'], $now);
                                        echo getDayDiffText($dayDiff).ddMMyyyy($oc['CrDateTime'], $dayDiff > 2 ? 'd/m/Y H:i' : 'H:i'); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p class="pComment"><?php echo $oc['Comment']; ?></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php }  ?>
                </div>
            </div>
            <div class="box box-default more-tabs padding20">
                <div class="form-group">
                    <label class="control-label" style="width: 100%;line-height: 28px;">Thẻ tag <button class="btn-updaten save btn-sm pull-right" type="button" id="btnUpdateTag">Lưu</button></label>
                    <input type="text" class="form-control" id="tags">
                </div>
                <p class="light-gray">Có thể chọn những thẻ tag đã được sử dụng</p>
                <ul class="list-inline" id="ulTagExist">
                    <?php foreach($listTags as $t){ ?>
                        <li><a href="javascript:void(0)"><?php echo $t['TagName']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="box box-default classify padding20">
                <?php 
                    $this->load->view('includes/action_logs', 
                            array(
                                'listActionLogs' =>  $this->Mactionlogs->getList($vehicle['VehicleId'], $itemTypeId, [ID_CREATE,ID_UPDATE]),
                                'itemId' => $vehicle['VehicleId'],
                                'itemTypeId' => $itemTypeId
                            )
                        );
                ?>
            </div>
        </div>
    </div>
</div>
<?php foreach($tagNames as $tagName){ ?>
    <input type="text" hidden="hidden" class="tagName" value="<?php echo $tagName; ?>">
<?php } ?>
<input type="text" hidden="hidden" id="insertCommentUrl" value="<?php echo base_url('itemcomment/insertComment'); ?>">
<input type="text" hidden="hidden" id="updateItemTagUrl" value="<?php echo base_url('api/tag/updateItem'); ?>">
<input type="hidden" id="vehicleId" value="<?=$vehicleId?>">
<input type="hidden" id="itemTypeId" value="<?php echo $itemTypeId?>">