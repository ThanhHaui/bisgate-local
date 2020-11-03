<div class="modal fade" role="dialog" id="modalSimManuFacturer">
	<div class="modal-dialog">
		<div class="modal-content" style="width: 800px;margin: 0px auto">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="title">Thêm mới Nhà cung cấp Sim</h4>
			</div>
			<?php echo form_open('simmanufacturer/update', array('id' => 'simManuFacturerForm')); ?>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Thông tin chung</label>
						</div>
						<div class="with-border">
							<div class="form-group">
								<div class="radio-group">
									<span class="item"><input type="radio" name="SimManufacturerTypeId" class="iCheck" value="1" checked> Cá nhân</span>
									<span class="item"><input type="radio" name="SimManufacturerTypeId" class="iCheck" value="2"> Công ty</span>
								</div>
							</div>
						</div>
						<div class="box-body row">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Tên <span class="required">*</span></label>
										<input type="text" id="simManufacturerName" name="SimManufacturerName" class="form-control inputReset" value="" data-field="Tên đơn vị cung cấp *">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Ngày sinh </label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<input type="text" class="form-control datepicker inputReset" id="birthDay" name="BirthDay" value="" autocomplete="off">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Giới tính</label>
										<div class="radio-group">
											<span class="item"><input type="radio" name="GenderId" class="iCheck genderId" value="1"> Nam</span>
											<span class="item"><input type="radio" name="GenderId" class="iCheck genderId" value="2"> Nữ</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">CMND </label>
										<input type="text" class="form-control inputReset" id="iDCardNumber" name="IDCardNumber" value="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">SĐT <span class="required">*</span></label>
										<input type="text" id="phoneNumber" name="PhoneNumber" class="form-control inputReset hmdrequired" value="" data-field="SĐT *"/>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Email</label>
										<input type="text" id="email" name="Email" class="form-control inputReset" value="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Quốc gia </label>
										<?php $this->Mconstants->selectObject($listCountries, 'CountryId', 'CountryName', 'CountryId', 232, false, '', ' select2'); ?>
									</div>
								</div>
								<div class="col-sm-6 VNon">
									<div class="form-group">
										<label class="control-label">Tỉnh <span class="required">*</span></label>
										<?php $this->Mconstants->selectObject($listProvinces, 'ProvinceId', 'ProvinceName', 'ProvinceId', 0, true, '--Tỉnh / Thành--', ' select2'); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="control-label">Địa chỉ</label>
										<input type="text" id="address" class="form-control inputReset" name="Address" value="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-12 form-group">
										<label class="control-label">Loại nhà mạng</label>
										<?php $this->Mconstants->selectConstants('telcoIds', 'TelcoId[]',0,true,'',' select2','multiple="multiple"'); ?>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="text" hidden="hidden" value="0" name="SimManufacturerId" id="simManufacturerId">
			<?php echo form_close(); ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-toggle="modal" data-dismiss="modal">Đóng</button>
				<button type="submit" class="btn btn-primary submit">Thêm</button>
				<input type="text" hidden="hidden" id="urlEditSimManuFacturer" value="<?php echo base_url('simmanufacturer/edit') ?>" name="">
			</div>

		</div>
	</div>
</div>