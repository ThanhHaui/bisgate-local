<div class="modal fade" role="dialog" id="modalDriveMyCar">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 800px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="title">Thêm mới Lái Xe</h4>
            </div>
            <?php echo form_open('drivemycar/update', array('id' => 'driveMyCarForm')); ?>
            <div class="modal-body">
            	<div class="box box-default padding15">
            		<div class="row">
	            		<div class="col-sm-12 form-group">
		            		<h4><strong>Thông tin cá nhân</strong></h4>
		            	</div>
		            </div>
	                <div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Mã số lái xe: <span  id="userName"> <?php echo $genCode; ?></span></label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Tên đầy đủ <span class="required">*</span></label>
							<input type="text" class="form-control inputReset hmdrequired" id="fullName" name="FullName" data-field="Tên đầy đủ">
						</div>
						<div class="col-sm-6 form-group">
							<label class="control-label">Tên thường gọi</label>
							<input type="text" class="form-control inputReset" id="shortName" name="ShortName">
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
						<div class="col-sm-6 form-group">
							<label class="control-label">SĐT <span class="required">*</span></label>
							<input type="text" class="form-control inputReset cost hmdrequired" id="phoneNumber" name="PhoneNumber" data-field="SĐT">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Email</label>
							<input type="text" class="form-control inputReset" id="email" name="Email">
						</div>
						<div class="col-sm-6 form-group">
							<label class="control-label">Ngày sinh</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control datepicker inputReset" name="BirthDay" id="birthDay" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Số CMND</label>
							<input type="text" class="form-control inputReset cost" id="iDCardNumber" name="IDCardNumber">
							
						</div>
						<div class="col-sm-3 form-group">
							<label class="control-label">Ảnh CMND mặt trước</label>
	                        <div class="form-group">
	                            <img src="" class="chooseImageIDCardFront" id="imgIDCardFront" style="width: 50%;display: none;">
	                            <input type="text" hidden="hidden" name="IDCardFront" id="iDCardFront" value="">
	                        <input type="file" style="display: none;" id="inputFileImageIDCardFront">
	                        
	                        <a href="javascript:void(0)" class="chooseImageIDCardFront btn btn-default">Chọn file</a>
							</div>
							<div class="progress" id="fileProgress_1" style="display: none;">
	                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
	                        </div>
						</div>
						<div class="col-sm-3 form-group">
							<label class="control-label">Ảnh CMND mặt sau</label>
	                        <div class="form-group">
	                            <img src="" class="chooseImageIDCardBack" id="imgIDCardBack" style="width: 50%;display: none;">
	                            <input type="text" hidden="hidden" name="IDCardBack" id="iDCardBack" value="">
	                        <input type="file" style="display: none;" id="inputFileImageIDCardBack">
	                        <a href="javascript:void(0)" class="chooseImageIDCardBack btn btn-default">Chọn file</a>
	                        </div>
	                        <div class="progress" id="fileProgress_2" style="display: none;">
	                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
	                        </div>
						</div>
						<input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('file/upload'); ?>">
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Ngày cấp</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control datepicker inputReset" name="IDCardDate" id="iDCardDate" autocomplete="off">
							</div>
						</div>
						<div class="col-sm-6 form-group">
							<label class="control-label">Nơi cấp</label>
							<input type="text" class="form-control inputReset" id="iDCardAddress" name="IDCardAddress">
						</div>
					</div>
				</div>
				<div class="box box-default padding15">
            		<div class="row">
	            		<div class="col-sm-12 form-group">
		            		<h4><strong>Thông tin hành nghề </strong></h4>
		            		<label class="control-label">Giấy phép lái xe</label>
		            	</div>
		            </div>
		            <div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Ngày cấp <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control datepicker inputReset hmdrequired" name="LicenceDate" id="licenceDate" autocomplete="off" data-field="Ngày cấp">
							</div>
						</div>
						<div class="col-sm-6 form-group">
							<label class="control-label">Ngày hết hạn <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control datepicker inputReset hmdrequired" name="LicenceExpDate" id="licenceExpDate" autocomplete="off" data-field="Ngày hết hạn">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Mã GPLX <span class="required">*</span></label>
							<input type="text" class="form-control inputReset hmdrequired" id="driverLicence" name="DriverLicence" data-field="Mã GPLX">
						</div>
						<div class="col-sm-6 form-group">
							<label class="control-label">Loại bằng <span class="required">*</span></label>
							<?php $this->Mconstants->selectConstants('licenceTypes', 'LicenceTypeId', 0, true, '-- Chọn --'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label class="control-label">Mã thẻ RFID <span class="required">*</span></label>
							<input type="text" class="form-control" id="tagsRFID" >
						</div>
					</div>
		        </div>
		        <div class="box box-default padding15">
            		<div class="row">
	            		<div class="col-sm-12 form-group">
		            		<h4><strong>Thông tin nhân sự</strong></h4>
		            	</div>
		            </div>
		            <div class="row">
						<div class="col-sm-6">
							<label class="control-label">Ngày vào làm</label>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control datepicker inputReset" name="WorkDate" id="workDate" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
            </div>
            <input type="text" hidden="hidden" value="0" name="UserId" id="myCarUserId"> 
            <input type="text" hidden="hidden" value="0" name="UserDetailId" id="userDetailId">
			<?php echo form_close(); ?>
			
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary submit">Thêm</button>
                <input type="text" hidden="hidden" id="urlEditDriveMyCar" value="<?php echo base_url('drivemycar/edit') ?>" name="">
            </div>
            
        </div>
    </div>
</div>