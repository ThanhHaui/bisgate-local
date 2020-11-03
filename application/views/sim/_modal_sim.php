<div class="modal fade" role="dialog" id="modalSim">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="title">Thêm mới Sim</h4>
            </div>
            <?php echo form_open('sim/update', array('id' => 'simForm')); ?>
            <div class="modal-body">
                <div class="row">
                	<div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nhà cung cấp <span class="required">*</span></label>
                            <?php $this->Mconstants->selectObject($listSiMmanuFacturers, 'SimManufacturerId', 'SimManufacturerName', 'SimManufacturerId', 0, true, '--Nhà cung cấp--', ' select2'); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Số điện thoại <span class="required">*</span></label>
                            <input type="text" id="phoneNumber" name="PhoneNumber" class="form-control hmdrequired" value="" data-field="Số điện thoại *">
                        </div>
                        <div class="form-group"> 
                            <label class="control-label">Số Seri Sim <span class="required">*</span></label>
                            <input type="text" id="seriSim" name="SeriSim" class="form-control hmdrequired" value="" data-field="Số Seri Sim *">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Loại nhà mạng <span class="required">*</span></label>
                            <?php $this->Mconstants->selectConstants('telcoIds', 'SimTypeId', 0, true, '-- Loại nhà mạng --',' hmdrequired',''); ?>
                        </div>
	                </div>
                </div>
            </div>
            <input type="text" hidden="hidden" value="0" name="SimId" id="simId">
            <?php echo form_close(); ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary submit">Thêm</button>
                
            </div>
            
        </div>
    </div>
</div>