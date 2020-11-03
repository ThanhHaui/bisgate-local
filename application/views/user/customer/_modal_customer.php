<div class="modal fade" role="dialog" id="modalCustomer">
	<div class="modal-dialog">
		<div class="modal-content" style="width: 800px;margin: 0px auto">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="title">Thêm mới khách hàng</h4>
			</div>
			<?php echo form_open('customer/update', array('id' => 'customerForm')); ?>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12"  id="content_left">
						<div class="row">
							<div class="col-sm-4">
								<label >@Username ( Tên đăng nhập ) <span class="required">*</span></label>
							</div>
							<div class="col-sm-8">
								<div class="form-group">
									<input type="text" class="form-control hmdrequired inputReset" name="UserName" value="" id="userName" data-field="@Username">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">Thông tin chung</label>
						</div>
						<div class="with-border">
							<div class="form-group">
								<div class="radio-group">
									<span class="item"><input type="radio" name="CustomerTypeId" class="iCheck iCheckCustomerType" value="1" checked> Cá nhân</span>
									<span class="item"><input type="radio" name="CustomerTypeId" class="iCheck iCheckCustomerType" value="2"> Công ty</span>
								</div>
							</div>
						</div>
						<div class="box-body row">
							<div class="personalType">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label">Tên <span class="required">*</span></label>
											<input type="text" id="personalName" class="form-control hmdrequired inputReset" value="" data-field="Tên *">
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
												<span class="item"><input type="radio" name="GenderId" class="iCheck genderId" value="1" checked> Nam</span>
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
							</div>
							<div class="companyType" style="display: none">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label">Tên công ty <span class="required">*</span></label>
											<input type="text" id="companyName" class="form-control inputReset" value="" data-field="Tên công ty *">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label">Tên viết gọn</label>
											<input type="text" id="shortName" name="ShortName" class="form-control inputReset" value=""/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label">Mã số thuế</label>
											<input type="text" id="taxCode" name="TaxCode" class="form-control inputReset" value="">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label">Lĩnh vực vận tải </label>
											<?php $this->Mconstants->selectObject($listTransportTypes, 'TransportTypeId', 'TransportTypeName', 'TransportTypeId', 0, true, '--Lĩnh vực vận tải--', ' select2'); ?>
										</div>
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
										<input type="text" id="address" class="form-control" name="Address" value="">
									</div>
								</div>
							</div>
							<div class="row companyType"  style="display: none">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="control-label">Đầu mối liên hệ</label>
										<div class="box box-default htmlUserGroup">
											<div class="box-header with-border">
												<h3 class="box-title title">Đầu mối liên hệ 1</h3>
											</div>
											<div class="box-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="control-label">Tên</label>
															<input type="text" class="form-control inputReset contactFullName" value=""/>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label class="control-label">Chức vụ</label>
															<input type="text" class="form-control inputReset contactPosition" value="">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label class="control-label">SĐT</label>
															<input type="text" class="form-control inputReset contactPhone" value=""/>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label class="control-label">Email</label>
															<input type="text" class="form-control inputReset contactEmail" value="">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id="divHtmlUserGroup">

										</div>
										<div class="text-right">
											<button type="button" class="btn btn-primary" id="addUserGroup">Thêm đầu mối liên hệ</button>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-12 form-group">
										<label class="control-label">Đơn vị quản lý <span class="required">*</span></label>
										<div class="radio-group">
											<span class="item"><input type="radio" name="AgentLevelId" class="iCheck connectTypeId" value="1" checked> Bistech</span>
											<span class="item"><input type="radio" name="AgentLevelId" class="iCheck connectTypeId" value="2"> Đại lý cấp 1</span>
											<span class="item"><input type="radio" name="AgentLevelId" class="iCheck connectTypeId" value="3"> Đại lý cấp 2</span>
										</div>
									</div>
									<div class="col-sm-6 agentCheck">
										<select class="form-control none-display" name="ManagementUnitId">
											<option value = "<?php echo $staffIdBis ?>">Bistech</option>
										</select>
									</div>
								</div>
							</div>
							<div id="genHtml"></div>
						</div>
					</div>
				</div>
			</div>
			<input type="text" hidden="hidden" value="0" name="UserId" id="customerUserId">
			<?php echo form_close(); ?>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-toggle="modal" data-dismiss="modal">Đóng</button>
				<button type="submit" class="btn btn-primary submit">Thêm</button>
				<input type="text" hidden="hidden" id="urlEditCusstomer" value="<?php echo base_url('customer/edit') ?>" name="">
				<input type="text" hidden="hidden" id="insertCommentUrl" value="<?php echo base_url('customer/insertComment'); ?>">
				<input type="text" hidden="hidden" id="updateItemTagUrl" value="<?php echo base_url('api/tag/updateItem'); ?>">
				<input type="text" hidden="hidden" id="ajaxListAgentHtml" value="<?php echo base_url('customer/listAgentAjax'); ?>">
				<input type="text" hidden="hidden" value="<?php echo $staffIdBis ?>" name="" id="staffIdBis">
				<input type="text" hidden="hidden" value="0" name="UserId" id="customerUserId">

			</div>

		</div>
	</div>
</div>