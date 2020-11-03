$(document).ready(function () {
	province('resProvinceId','resDistrictId','resWardId');
	province('hTProvinceId','hTDistrictId','hTWardId');
	hideGroupPageEdit();
	$('.button_back').click(function() {
		$('.nav.nav-tabs li').removeClass('active');
		$('.nav.nav-tabs li.tab_modal_user' + $(this).attr('data-id')).addClass('active');
		$('.tab-pane').removeClass('active');
		$('.tab-pane#tab_' + $(this).attr('data-id')).addClass('active');
	});
	$('input.iCheck').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%'
	});
	$('input.iCheckRadio').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue'
	});
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true
	});
	$("body").on('click', '.btnShowModalGroup', function () {
		$("#btnShowModalGroups").modal('show');
	});

	$('#showModalUser').click(function () {
		$('#showModalUsers').modal('show')
	});
	$('.show_info_user').click(function () {
		var modal = $(this).attr('data-modal');
		$(modal).modal('show')
	});
	$('input.staffRoleId').on('ifToggled', function(e){
		if($(this).val()==2){
			$('.show_hide_role1').show();
			$('.show_hide_role2').hide();
		}
		else{
			$('.show_hide_role2').show();
			$('.show_hide_role1').hide();
			$('#tbodyGroupStaff tr').remove();
			hideGroupPageEdit();
		}
	});
	$('#staffForm input[type=text],input[type=number],textarea').on('keyup change', function () {
		$('span.show-data-info.' + $(this).attr('name')).text($(this).val());
	});
	$('.chooseImage').click(function () {
		$('#inputFileImage').trigger('click');
	});
	chooseFile($('#inputFileImage'), $('#fileProgress'), 2, function (fileUrl) {
		$('input#avatar').val(fileUrl);
		$('img#imgAvatar').attr('src', fileUrl);
	});
	$('.chooseImage1').click(function () {
		$('#inputFileImage1').trigger('click');
	});
	chooseFile($('#inputFileImage1'), $('#fileProgress1'), 2, function (fileUrl) {
		$('input#avatarBegin').val(fileUrl);
		$('img#imgAvatarBegin').attr('src', fileUrl);
	});
	$('.chooseImage2').click(function () {
		$('#inputFileImage2').trigger('click');
	});
	chooseFile($('#inputFileImage2'), $('#fileProgress2'), 2, function (fileUrl) {
		$('input#avatarBehind').val(fileUrl);
		$('img#imgAvatarBehind').attr('src', fileUrl);
	});
	$('.staff_next').click(function () {
		if (!checkInputTab1()){
			return false;
		}
		$('#tab_1,.tab_modal_user1').removeClass('in active');
		$('#tab_2,.tab_modal_user2').addClass('in active');
		$('body,html').animate({
			scrollTop: 0
		}, 500);
	});
	var staffId = parseInt($('input#staffId').val());
	$("body").on('click','.refresh-pass',function(){
		var id = $(this).attr('data-id');

		$.ajax({
			type: "POST",
			url: $('input#urlRefreshPass').val(),
			data: {
				StaffId: id,
			},
			success: function (response) {
				var json = $.parseJSON(response);
				showNotification(json.message, json.code);
				$('.refresh-pass').prop('disabled', false);
			},
			error: function (response) {
				showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
				$('.refresh-pass').prop('disabled', false);
			}
		});
	}).on('click', '#btnShowModalChangeStaff', function(){
		$("#modalActiveContract").modal('show');
	}).on('click', '#btnActiveContract', function(){
		var staffStatusId = $('input[name="ContractStatusId"]:checked').val()
		changeStatusStaff(staffStatusId, staffId)
		return false;
	}).on('click', '#btnActiveStatusStaff', function(){
		$('#btnYesOrNo').html('');
		$('#btnYesOrNo').CeoSlider({
			lable_right : 'OK',
			lable_left : 'CANCEL',
			lable_yes : 'Buông chuột để OK',
			lable_no : 'Buông chuột để CANCEL',
			success : function (data) {
				changeStatusStaff(2, staffId);
				return false;
			},
			error : function (data) {
				$("#modalActiveOrCancel").modal('hide');          
			}
		});
		$("#modalActiveOrCancel").modal('show');

		return false;
	}).on('ifToggled', '.check_tab_show input.iCheckRadio', function (e) {
		$('.tab-hide').removeClass('active');
		if (e.currentTarget.checked) {
			var tab = $(this).parent().parent().attr('data-tab');
			$(tab).addClass('active');
		} else {
		}
	}).on('click','.show_hide_group_item',function(){
		$(this).closest('.show_hide').find('.show_hide_group').toggle(10);
		$(this).toggleClass('fa-plus-circle');
		$(this).toggleClass('fa-minus-circle');
	}).on('click', '.btnAddHb', function (e) {
		$('.arr-hb').append('<div class="border-hb mgbt-10">\n' +
			'           <div class="row mgbt-10">\n' +
			'                <div class="col-sm-6">\n' +
			'                    <div class="row mgbt-10">\n' +
			'                        <div class="col-sm-4">\n' +
			'                            <p>Tên bằng cấp</p>\n' +
			'                        </div>\n' +
			'                        <div class="col-sm-8">\n' +
			'                            <input type="text" id= "diploma" class="form-control "\n' +
			'                                   value="">\n' +
			'                       </div>\n' +
			'                    </div>\n' +
			'                </div>\n' +
			'                <div class="col-sm-6">\n' +
			'                    <div class="row mgbt-10">\n' +
			'                        <div class="col-sm-4">\n' +
			'                            <p>Loại bằng</p>\n' +
			'                        </div>\n' +
			'                        <div class="col-sm-8">\n' +
			'                            <select class="form-control" id="diplomaTypeId">\n' +
			'                                <option value="1">Trung cấp</option>\n' +
			'                                <option value="2">Cao đẳng</option>\n' +
			'                                <option value="3">Cử nhân</option>\n' +
			'                                <option value="4">Kỹ sư</option>\n' +
			'                                <option value="5">Thạc sỹ</option>\n' +
			'                                <option value="6">P. Giáo sư</option>\n' +
			'                                <option value="7">Tiến sỹ</option>\n' +
			'                            </select>\n' +
			'                        </div>\n' +
			'                    </div>\n' +
			'                </div>\n' +
			'            </div>\n' +
			'            <div class="row mgbt-10">\n' +
			'                <div class="col-sm-6">\n' +
			'                    <div class="row mgbt-10">\n' +
			'                        <div class="col-sm-4">\n' +
			'                            <p>Tên trường</p>\n' +
			'                        </div>\n' +
			'                        <div class="col-sm-8">\n' +
			'                            <input type="text" id="schoolName" class="form-control "\n' +
			'                                   value="">\n' +
			'                        </div>\n' +
			'                    </div>\n' +
			'                </div>\n' +
			'                <div class="col-sm-6">\n' +
			'                    <div class="row mgbt-10">\n' +
			'                        <div class="col-sm-4">\n' +
			'                            <p>Tên ngành</p>\n' +
			'                        </div>\n' +
			'                        <div class="col-sm-8">\n' +
			'                            <input type="text" id="industryName" class="form-control "\n' +
			'                                   value="">\n' +
			'                        </div>\n' +
			'                    </div>\n' +
			'                </div>\n' +
			'            </div>\n' +
			'           <div class="row mgbt-10">\n' +
			'                <div class="col-sm-6">\n' +
			'                    <div class="row mgbt-10">\n' +
			'                        <div class="col-sm-4">\n' +
			'                            <p>Khóa học từ</p>\n' +
			'                       </div>\n' +
			'                        <div class="col-sm-8">\n' +
			'                            <input type="text" id="startDate" class="form-control datepicker"\n' +
			'                                  value="">\n' +
			'                        </div>\n' +
			'                    </div>\n' +
			'               </div>\n' +
			'                <div class="col-sm-6">\n' +
			'                    <div class="row mgbt-10">\n' +
			'                        <div class="col-sm-4">\n' +
			'                            <p>đến</p>\n' +
			'                        </div>\n' +
			'                       <div class="col-sm-8">\n' +
			'                           <input type="text" id="endDate" class="form-control datepicker" value="">\n' +
			'                        </div>\n' +
			'                    </div>\n' +
			'                </div>\n' +
			'           </div>\n' +
			'        </div>\n' +
			'    </div>');
		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true
		});
	}).on('click', '.btnAddCDKN', function (e) {
		var html = '<div class="row mgbt-10 item-cdkn">\n' +
		'                    <div class="col-sm-2">\n' +
		'                    </div>\n' +
		'                   <div class="col-sm-5">\n' +
		'                        <div class="row mgbt-10">\n' +
		'                            <div class="col-sm-4">\n' +
		'                                <p class="mt-6">Cấp bậc</p>\n' +
		'                            </div>\n' +
		'                            <div class="col-sm-8">\n' +
		'                                <select class="form-control" name="JobLevelIdOther" id="jobLevelIdOther">\n' +
		'                                   <option value="1">Bậc 1</option>\n' +
		'                                   <option value="2">Bậc 2</option>\n' +
		'                                   <option value="3">Bậc 3</option>\n' +
		'                                   <option value="4">Bậc 4</option>\n' +
		'                                   <option value="5">Bậc 5</option>\n' +
		'                                  </select>\n' +
		'                            </div>\n' +
		'                        </div>\n' +
		'                    </div>\n' +
		'                    <div class="col-sm-5">\n' +
		'                       <div class="row mgbt-10">\n' +
		'                            <div class="col-sm-4">\n' +
		'                                <p class="mt-6">Phòng ban</p>\n' +
		'                            </div>\n' +
		'                           <div class="col-sm-8">\n' +
		'                                <input type="text" id="jobDepartmentOther" class="form-control " value="">\n' +
		'                            </div>\n' +
		'                        </div>\n' +
		'                    </div>\n' +
		'                </div>'
		$('.arr-cdkn').append(html);
		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true
		});
	}).on('click', '.btnAddKMCT', function (e) {

		$('.arr-knct').append('     <div class="border-hb mgbt-10">\n' +
			'                                                <div class="row mgbt-10">\n' +
			'                                                    <div class="col-sm-2">\n' +
			'                                                        Giai đoạn\n' +
			'                                                    </div>\n' +
			'                                                    <div class="col-sm-5">\n' +
			'                                                        <div class="row mgbt-10">\n' +
			'                                                            <div class="col-sm-4">\n' +
			'                                                                <p class="mt-6">từ</p>\n' +
			'                                                            </div>\n' +
			'                                                            <div class="col-sm-8">\n' +
			'                                                                <input type="text" id="exStartDate"\n' +
			'                                                                       class="form-control datepicker" value="">\n' +
			'                                                            </div>\n' +
			'                                                        </div>\n' +
			'                                                    </div>\n' +
			'                                                    <div class="col-sm-5">\n' +
			'                                                        <div class="row mgbt-10">\n' +
			'                                                            <div class="col-sm-4">\n' +
			'                                                                <p class="mt-6">đến</p>\n' +
			'                                                            </div>\n' +
			'                                                            <div class="col-sm-8">\n' +
			'                                                                <input type="text" id="exEndDate"\n' +
			'                                                                       class="form-control datepicker" value="">\n' +
			'                                                            </div>\n' +
			'                                                        </div>\n' +
			'                                                    </div>\n' +
			'                                                </div>\n' +
			'                                                <div class="br"></div>\n' +
			'                                                <div class="row mgbt-10">\n' +
			'                                                    <div class="col-sm-2">\n' +
			'                                                    </div>\n' +
			'                                                    <div class="col-sm-5">\n' +
			'                                                        <div class="row mgbt-10">\n' +
			'                                                            <div class="col-sm-4">\n' +
			'                                                                <p class="mt-6">Cấp bậc</p>\n' +
			'                                                            </div>\n' +
			'                                                            <div class="col-sm-8">\n' +
			'                                                                  <select class="form-control" name="ExLevelId" id="exLevelId">\n' +
			'                                                                  <option value="1">Bậc 1</option>\n' +
			'                                                                  <option value="2">Bậc 2</option>\n' +
			'                                                                  <option value="3">Bậc 3</option>\n' +
			'                                                                  <option value="4">Bậc 4</option>\n' +
			'                                                                  <option value="5">Bậc 5</option>\n' +
			'                                                                 </select>\n' +
			'                                                            </div>\n' +
			'                                                        </div>\n' +
			'                                                    </div>\n' +
			'                                                    <div class="col-sm-5">\n' +
			'                                                        <div class="row mgbt-10">\n' +
			'                                                            <div class="col-sm-4">\n' +
			'                                                                <p class="mt-6">phòng ban</p>\n' +
			'                                                            </div>\n' +
			'                                                            <div class="col-sm-8">\n' +
			'                                                                <input type="text" id="exDepartment"\n' +
			'                                                                       class="form-control" value="">\n' +
			'                                                            </div>\n' +
			'                                                        </div>\n' +
			'                                                    </div>\n' +
			'                                                </div>\n' +
			'                                                <div class="row mgbt-10">\n' +
			'                                                    <div class="col-sm-2">\n' +
			'                                                    </div>\n' +
			'                                                    <div class="col-sm-10">\n' +
			'                                                        <div class="row mgbt-10">\n' +
			'                                                            <div class="col-sm-2">\n' +
			'                                                                <p class="mt-6">Công ty</p>\n' +
			'                                                            </div>\n' +
			'                                                            <div class="col-sm-10">\n' +
			'                                                                <input type="text" id="exCompanyName" class="form-control"\n' +
			'                                                                       value="">\n' +
			'                                                            </div>\n' +
			'                                                        </div>\n' +
			'                                                    </div>\n' +
			'                                                </div>\n' +
			'                                                <div class="row mgbt-10">\n' +
			'                                                    <div class="col-sm-2">\n' +
			'                                                    </div>\n' +
			'                                                    <div class="col-sm-10">\n' +
			'                                                        <p class="mt-6">Lĩnh vực hoạt động</p>\n' +
			'                                                        <textarea type="text" id="exScopeOfActivities" class="form-control"></textarea>\n' +
			'                                                    </div>\n' +
			'                                                </div>\n' +
			'                                            <div class="row mgbt-10">\n' +
			'                                                <div class="col-sm-2">\n' +
			'                                                </div>\n' +
			'                                                <div class="col-sm-10">\n' +
			'                                                    <p class="mt-6">Thành tựu trong thời gian công tác</p>\n' +
			'                                                    <textarea type="text" id="exAchievement" class="form-control"></textarea>\n' +
			'                                                </div>\n' +
			'                                            </div>\n' +
			'                                          </div>');
			$('.datepicker').datepicker({
				format: 'dd/mm/yyyy',
				autoclose: true
			});
	}).on('click', '#btnAddGroup', function () {
		var countId = parseInt($(this).val());
		var d = new Date(Date.now());
		var formatted = ('0'+d.getDate()).slice(-2) + '/' + ('0'+(d.getMonth()+1)).slice(-2) + '/' + d.getFullYear() + ' ' + ('0'+(d.getHours()+1)).slice(-2) + ':' + ('0'+(d.getMinutes()+1)).slice(-2);
		var arrGroup = [];
		$('#table-group input.iCheck').each(function () {
			if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) {
				arrGroup.push({
					GroupId: $(this).val(),
					GroupTime: formatted,
					GroupCode: $(this).parent().parent().parent().find('td').eq(1).text().trim(),
					GroupName: $(this).parent().parent().parent().find('td').eq(2).text().trim(),
				});
				$(this).parent().parent().parent().hide();
				$(this).parent().removeClass('checked');
				$(this).parent().attr('aria-checked','false');
			}
		});
		if (arrGroup.length == 0) {
			showNotification('Vui lòng chọn phân quyền cho người dùng.', 0);
			return false;
		}
		var num = $('.show_hide_role2 #tbodyGroupStaff tr').length;
		var html = '';
		$.each( arrGroup, function( i, item ) {
			html += `<tr data-id="${item.GroupId}">
			<td>${num+1}</td>
			<td>${item.GroupTime}</td>
			<td>${item.GroupCode}</td>
			<td>${item.GroupName}</td>
			<td><a href="javascript:void(0)" class="link_delete_group" title="Xóa" count-id="${countId}"><i class="fa fa-trash-o"></i></a></td>
			</tr>
			`;
			num+=1;
		});
		$("#tbodyGroupStaff").append(html);
		$("#btnShowModalGroups").modal('hide');
		return false;
	}).on('click', '.link_delete_group', function(){
		var id = $(this).parent().parent().attr('data-id');
		var code = $(this).parent().parent().find('td').eq(2).text();
		var name = $(this).parent().parent().find('td').eq(3).text();
		$(this).parent().parent().remove();
		$('#tbodyGroup').find('tr#group_'+id).show();
		$("#tbodyGroupStaff tr").each(function(i){
			$(this).find('td:nth-child(1)').text(i+1);
		});

	});

	
});

function hideGroupPageEdit(){
	$('#tbodyGroupStaff tr').each(function(){
		var id = $(this).data('id');
		$('#tbodyGroup').find('tr#group_'+id).hide();

	});
}
function checkInputTab1() {
	var username    = $.trim($('#fullName').val());
	var phonenumber = $.trim($('#phoneNumber').val());
	if (username == '' || username.length < 4){
		showNotification('Họ tên phải nhiều hơn 4 kí tự', 0);
		$('input#fullName').focus();
		return false;
	}
	if (phonenumber == '' || phonenumber.length < 9){
		showNotification('Số điện thoại không đúng định dạng', 0);
		$('input#phoneNumber').focus();
		return false;
	}

	return true;
}
function changeStatusStaff(staffStatusId, staffId){
	$.ajax({
		type: "POST",
		url: $("input#urlChangeStatus").val(),
		data: {
			StatusId: staffStatusId,
			StaffId: staffId
		},
		success: function (response) {
			var json = $.parseJSON(response);
			showNotification(json.message, json.code);
			if(json.code == 1){
				if(staffId == 0) redirect(false, $("#staffListUrl").attr('href'));
				else redirect(true, '');
			}
		},
		error: function (response) {
			showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
		}
	});

}

$(document).ready(function(){
	var staffTag = $('#staffId').val();
	var tags = [];
	var inputTag = $('input#tags');
	inputTag.tagsInput({
		'width': '100%',
		'height': '50px',
		'interactive': true,
		'defaultText': '',
		'onAddTag': function(tag){
			tags.push(tag);
		},
		'onRemoveTag': function(tag){
			var index = tags.indexOf(tag);
			if(index >= 0) tags.splice(index, 1);
		},
		'delimiter': [',', ';'],
		'removeWithBackspace': true,
		'minChars': 0,
		'maxChars': 0
	});
	$('input.tagName').each(function(){
		inputTag.addTag($(this).val());
	});
	$('#ulTagExist').on('click', 'a', function(){
		var tag = $(this).text();
		if(!inputTag.tagExist(tag)) inputTag.addTag(tag);
	});

	// cập nhật data
	$("body").on('click','.submit',function () {
		var staffId = $("input#staffId").val();
		if (validateEmpty('#staffForm') && validateNumber('#staffForm', true, ' không được bỏ trống')) {
			if (!checkInputTab1()){
				return false;
			}
			if($('input#staffName').length>0){	
				var namelogin = $('#staffName').val();
				if (namelogin == ''){
					showNotification('UserName không được để trống', 0);
					$('input#staffName').focus();
					return false;
				}
				if($('input#staffName').length > 0 && $('input#staffName').val().trim().indexOf(' ') >= 0){
					showNotification('User name không được có khoảng trắng', 0);
					$('input#staffName').focus();
					return false;
				}
			}
			var groupStaff = [];
			$('#tbodyGroupStaff tr').each(function () {
				groupStaff.push({
					GroupId: $(this).attr('data-id'),
					GroupCode: $(this).find('td').eq(2).text().trim(),
					GroupName: $(this).find('td').eq(3).text().trim(),
				});
			});

			var schoolReports = [];
			$('.arr-hb .border-hb').each(function () {
				schoolReports.push({
					DiplomaTypeId: $(this).find('select#diplomaTypeId').val(),
					Diploma: $(this).find('input#diploma').val(),
					SchoolName: $(this).find('input#schoolName').val(),
					IndustryName: $(this).find('input#industryName').val(),
					StartDate: $(this).find('input#startDate').val(),
					EndDate: $(this).find('input#endDate').val(),
				});
			});

			var jobTitles = [];
			$('.arr-cdkn .item-cdkn').each(function () {
				jobTitles.push({
					LevelId: $(this).find('select#jobLevelIdOther').val(),
					Department: $(this).find('input#jobDepartmentOther').val(),
				});

			});

			var experiences = [];
			$('.arr-knct .border-hb').each(function () {
				experiences.push({
					StartDate: $(this).find('input#exStartDate').val(),
					EndDate: $(this).find('input#exEndDate').val(),
					LevelId: $(this).find('select#exLevelId').val(),
					Department: $(this).find('input#exDepartment').val(),
					CompanyName: $(this).find('input#exCompanyName').val(),
					ScopeOfActivities: $(this).find('input#exScopeOfActivities').val(),
					Achievement: $(this).find('input#exAchievement').val(),
				});
			});

			var form = $('#staffForm');
			var datas = form.serializeArray();
			datas.push({ name: "GroupStaff", value: JSON.stringify(groupStaff) });
			datas.push({ name: "SchoolReports", value: JSON.stringify(schoolReports) });
			datas.push({ name: "JobTitles", value: JSON.stringify(jobTitles) });
			datas.push({ name: "Experiences", value: JSON.stringify(experiences) });
			datas.push({ name: "Tags", value: JSON.stringify(tags) })
			$.ajax({
				type: "POST",
				url: form.attr('action'),
				data: datas,
				success: function (response) {
					var json = $.parseJSON(response);
					showNotification(json.message, json.code);
					if (json.code == 1) {
						$('.tab_modal_user3').removeClass('pointer-none');
						if (staffId == 0){
							var datas = json.data.postData;
							$('.submit').prop('disabled', false);
							$('#tab_2,.tab_modal_user2').removeClass('in active');
							$('#tab_3,.tab_modal_user3').addClass('in active');
							$('span.StaffRoleId').text((datas.StaffRoleId==2)?'Admin':'Member');
							$('span.StaffCode').text(datas.StaffCode);
							$('.show-data-info.staffPass').text($('.form-control.staffPass').val());
							
							if(datas.StaffRoleId == 2){
								$('.profile_role2').show();
								$('.profile_role3').hide();
							}
							else{
								$('.profile_role3').show();
								$('.profile_role2').hide();
								var html = '';
								$.each(json.data.groups, function(k, item){
									html += `
										<tr>
											<td>${k+1}</td>
											<td>${item.GroupCode}</td>
											<td>${item.GroupName}</td>
										</tr>
									`;
								})
								$('.profile_role3 #tbodyGroupStaff').html(html);
							}
						}
						else{
							redirect(true, "");
						}
						if(json.checkPass == 1){
							redirect(false, $('a#login').attr('href'));
						}
						else $('.submit').prop('disabled', false);
					}
					else $('.submit').prop('disabled', false);
				},
				error: function (response) {
					showNotification($('input#errorCommonMessage').val(), 0);
					$('.submit').prop('disabled', false);
				}
			});
		}
		return false;
	})
});
$(document).ready(function () {
	loadSelect2Ajax();
});

function loadSelect2Ajax(){
	$('.provinceId').select2({
		placeholder: "Tỉnh/Thành phố",
		allowClear: true,
		ajax: {
			url: $("input#urlGetListProvince").val(),
			type: 'POST',
			dataType: 'json',
			data: function (data) {
				var $this = $(this).closest('.parent_address');
				$this.find('.districtId').val(0).trigger('change');
				$this.find('.wardId').val(0).trigger('change');
				return {
					SearchText: data.term,
				};
			},
			processResults: function (data, params) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.ProvinceName,
							id: item.ProvinceId,
							data: item
						};
					})
				};
			}
		}
	});

	$('.districtId').select2({
		placeholder: "Quận/Huyện",
		allowClear: true,
		ajax: {
			url: $("input#urlGetListDistrict").val(),
			type: 'POST',
			dataType: 'json',
			data: function (data) {
				var $this = $(this).closest('.parent_address');
				$this.find('.wardId').val(0).trigger('change');
				var provinceId = $this.find('.provinceId').val()
				return {
					SearchText: data.term,
					ProvinceId: provinceId != null ? provinceId: 0
				};
			},
			processResults: function (data, params) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.DistrictName,
							id: item.DistrictId,
							data: item
						};
					})
				};
			}
		}
	});

	$('.wardId').select2({
		placeholder: "Phường/xã",
		allowClear: true,
		ajax: {
			url: $("input#urlGetListWard").val(),
			type: 'POST',
			dataType: 'json',
			data: function (data) {
				var districtId = $(this).closest('.parent_address').find('.districtId').val() 
				return {
					SearchText: data.term,
					DistrictId: districtId != null ? districtId: '0'
				};
			},
			processResults: function (data, params) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.WardName,
							id: item.WardId,
							data: item
						};
					})
				};
			}
		}
	});
}