<div class="modal fade" role="dialog" id="modalDevice">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="title">Thêm mới thiết bị</h4>
            </div>
            <?php echo form_open('device/update', array('id' => 'deviceForm')); ?>
            <div class="modal-body">
                <div class="row">
                	<div class="col-sm-3">
                        <label class="control-label">Dòng thiết bị <span class="required">*</span></label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <?php $this->Mconstants->selectObject($listDeviceTypes, 'DeviceTypeId', 'DeviceTypeName', 'DeviceTypeId', 0, true, '--Loại thiết bị--', ' select2'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label class="control-label">IMEI thiết bị<span class="required">*</span></label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" id="IMEI" name="IMEI" class="form-control hmdrequired" value="" data-field="IMEI *">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label class="control-label">ID thiết bị <span class="required">*</span></label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" id="DeviceCodeId" name="DeviceCodeId" class="form-control hmdrequired" value="" data-field="DeviceCodeId *">
                        </div>
                    </div>
                </div>
            </div>
            <input type="text" hidden="hidden" value="0" name="DeviceId" id="deviceId">
            <?php echo form_close(); ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default button-close" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary btnSubmit">Thêm thiết bị</button>
            </div>
        </div>
    </div>
</div>