$(document).ready(function() {
    $("body").on('click', '.btnShowModalGroup', function() {
        $("#btnShowModalGroups").modal('show');
    });
    $('body').on('click', '#btnAddGroup', function() {
        var countId = parseInt($(this).val());
        var arrGroup = [];
        var d = new Date(Date.now());
        var formatted = ('0' + d.getDate()).slice(-2) + '/' + ('0' + (d.getMonth() + 1)).slice(-2) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes();
        $('#table-group input.iCheck').each(function() {
            if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) {
                arrGroup.push({
                    GroupId: $(this).val(),
                    GroupTime: formatted,
                    GroupCode: $(this).parent().parent().parent().find('td').eq(1).text().trim(),
                    GroupName: $(this).parent().parent().parent().find('td').eq(2).text().trim(),
                });
                $(this).parent().parent().parent().hide();
                $(this).parent().removeClass('checked');
                $(this).parent().attr('aria-checked', 'false');
            }
        });
        if (arrGroup.length == 0) {
            showNotification('Vui lòng chọn phân quyền cho người dùng.', 0);
            return false;
        }
        var html = '';
        $.each(arrGroup, function(i, item) {
            html += `<tr data-id="${item.GroupId}">
            <td>${i + 1}</td>
            <td>${item.GroupTime}</td>
            <td>${item.GroupCode}</td>
            <td><a href="javascript:void(0)">${item.GroupName}</a></td>
            <td><a href="javascript:void(0)" class="link_delete_group" title="Xóa" count-id="${countId}"><i class="fa fa-trash-o"></i></a></td>
            </tr>
            `;
        });
        $("#tbodyGroupUser").append(html);
        $("#btnShowModalGroups").modal('hide');
        return false;
    }).on('click', '.link_delete_group', function() {
        var id = $(this).parent().parent().attr('data-id');
        var code = $(this).parent().parent().find('td').eq(2).text();
        var name = $(this).parent().parent().find('td').eq(3).text();
        $(this).parent().parent().remove();
        $('#tbodyGroup').find('tr#group_' + id).show();

    }).on('change', '#agentForm select', function() {
        if ($(this).find('#provinceIds1').val() != '') {
            var zone = '';
            $('.select2-selection__choice').each(function(i, v) {
                if (i == 0) {
                    zone += $(this).attr('title');
                } else {
                    zone += ', ' + $(this).attr('title');
                }
            });
            $('.resAddress').text(zone);
        }
        $('span.show-data-info.' + $(this).attr('name')).text($(this).children('option:selected').text());

    }).on('ifToggled', 'input.iCheckCustomerType', function(e) {
        resetModalCustomer();
        if (e.currentTarget.checked) customerType(e.currentTarget.value);
    });
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });

    var tags = [];
    var inputTag = $('input#tags');
    inputTag.tagsInput({
        'width': '100%',
        'height': '90px',
        'interactive': true,
        'defaultText': '',
        'onAddTag': function(tag) {
            tags.push(tag);
        },
        'onRemoveTag': function(tag) {
            var index = tags.indexOf(tag);
            if (index >= 0) tags.splice(index, 1);
        },
        'delimiter': [',', ';'],
        'removeWithBackspace': true,
        'minChars': 0,
        'maxChars': 0
    });

    $('input.tagName').each(function() {
        inputTag.addTag($(this).val());
    });
    $('#ulTagExist').on('click', 'a', function() {
        var tag = $(this).text();
        if (!inputTag.tagExist(tag)) inputTag.addTag(tag);
    });
    $("body").on('click', '#addUserGroup', function() {
        var count = $(".htmlUserGroup").length;
        genUserGroup(count);
    }).on('click', '.removeUserGroup', function() {
        $(this).parent().parent().parent().remove();
        var count = 0;
        $('.htmlUserGroup').each(function() {
            count++;
            $(this).find('.title').html('Đầu mối liên hệ ' + count + '');
        });
    });

    $('input.agentLevelId').on('ifToggled', function(e) {
        var agentLevelId = parseInt(e.currentTarget.value);
        var html = '';
        if (e.currentTarget.checked) {
            if (agentLevelId == 2) {
                $('.select2-container.select2-container--default.select2-container--open').remove();
                html = `<select class="form-control" name="ManagementUnitId" disabled>
                            <option value="1">Bistech</option>
                        </select>`;
                $('span.ManagementUnitId').text('Bistech');
            } else if (agentLevelId = 3) {
                html = `<select class="form-control managementUnitId" name="ManagementUnitId">
                        <option>--Đơn vị quản lý--</option>
                    </select>`;
            }
        }
        $(".unit_manage").html(html);
        if (agentLevelId == 3) callSelectManagementUnit();
    });

    $("body").on('click', '.submit', function() {
        if (validateEmpty('#agentForm')) {
            if (!checkInput()) {
                return false;
            }
            if (parseInt($("select#provinceId").val()) == 0) {
                showNotification("Vui lòng chọn tỉnh/thành.", 0);
                return false;
            }
            var form = $('#agentForm');
            var datas = form.serializeArray();
            var staffTypeId = parseInt($('input[name="StaffTypeId"]:checked').val());
            if (staffTypeId == 1) {
                datas.push({ name: "FullName", value: $("input#personalName").val() });
            } else {
                // if($("input#taxCode").val().trim() == ''){
                //     showNotification("Vui lòng thêm Mã số thuế.", 0);
                //     return false;
                // }
                datas.push({ name: "FullName", value: $("input#companyName").val() });
            }
            datas.push({ name: "ContactUsers", value: JSON.stringify(getDataContactUser()) });
            datas.push({ name: "AgentLevelId", value: $('input[name="AgentLevelId"]:checked').val() });
            datas.push({ name: "Tags", value: JSON.stringify(tags) })
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
                success: function(response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        var staffId = parseInt($("input#staffId").val());
                        $('.id_account').text(json.staffCode);
                        if ($('.tab_modal_user3').length > 0) {
                            $('.nav.nav-tabs li').removeClass('active');
                            $('.tab_modal_user3').addClass('active');
                            $('.tab-pane').removeClass('active');
                            $('.tab-pane#tab_3').addClass('active');
                        }

                        if(staffId > 0) {
                            redirect(true, "");
                        }
                    }
                },
                error: function(response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.submit').prop('disabled', false);
                }
            });
        }
        return false;
    });
});
$('.button_next').click(function() {
    var flag = 0;
    $('#' + $(this).closest('.tab-pane').attr('id') + ' .hmdrequired').each(function() {
        if ($(this).val().trim() == '') {
            showNotification($(this).attr('data-field') + ' không được bỏ trống', 0);
            $(this).focus();
            flag++;
            return false;
        }
    });
    if (flag == 0) {
        if (checkInput() == false) return false;
        $('.nav.nav-tabs li').removeClass('active');
        $('.nav.nav-tabs li.tab_modal_user' + $(this).attr('data-id')).addClass('active');
        $('.tab-pane').removeClass('active');
        $('.tab-pane#tab_' + $(this).attr('data-id')).addClass('active');
        $('body,html').animate({
			scrollTop: 0
		}, 500);
    }
});
$('.button_back').click(function() {
    $('.nav.nav-tabs li').removeClass('active');
    $('.nav.nav-tabs li.tab_modal_user' + $(this).attr('data-id')).addClass('active');
    $('.tab-pane').removeClass('active');
    $('.tab-pane#tab_' + $(this).attr('data-id')).addClass('active');
});
$('#agentForm input[type=text],textarea').on('keyup change', function() {
    $('span.show-data-info.' + $(this).attr('name')).text($(this).val());
});

$('input[type=radio]').on('ifToggled click', function() {
    $('span.show-data-info.' + $(this).attr('name')).html($(this).attr('data-val'));
});
$('.save-comment').click(function() {
    datas = [];
    datas.push({ name: "Comment", value: $('.input_comment').val() });
    datas.push({ name: "ItemId", value: $('#staffId').val() });
    datas.push({ name: "ItemTypeId", value: $('#itemTypeId').val() });
    datas.push({ name: "Avatar", value: $('#avatarLoginId').val() });
    $.ajax({
        type: "POST",
        url: $(this).attr('data-link'),
        data: datas,
        success: function(response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            // location.reload();
            if (json.code == 1) {
                $('.list_comment').prepend(Comment());
                $('.input_comment').val(null);

            }
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            $('.submit').prop('disabled', false);
        }
    });
});

function Comment() {
    var html = '<div class="row item_comment"> \n' +
        '           <div class="col-sm-4 ">\n' +
        '               <img src="' + $('#userImagePath').val() + $('#avatarLoginId').val() + '" alt="">\n' +
        '                <div class="user_comment">\n' +
        '                   <p class="name_coment">' + $('#fullNameLoginId').val() + '</p>\n' +
        '                   <p>' + $('#jobLevel').val() + '</p>' +
        '                </div>\n' +
        '           </div>\n' +
        '           <div class="col-sm-8">\n' +
        '                <p class="content_comment">' + ($('.input_comment').val()) + '</p>\n' +
        '                <p class="text-right time">' + getCurrentDateTime(6) + '</p>\n' +
        '            </div>\n' +
        '         </div>';
    return html;
}


$('input[type=radio]').on('ifToggled click', function() {
    $('span.show-data-info.' + $(this).attr('name')).html($(this).attr('data-val'));
});

function checkInput() {
    if (!checkPhoneNumber()) {
        showNotification("Số điện thoại không đúng", 0);
        $('#PhoneNumber').focus();
        return false;
    }
    if (!isEmail($('#email').val()) && $('#email').val().trim() != '') {
        showNotification("Email không đúng", 0);
        $('#email').focus();
        return false;
    }

    if (parseInt($("select#hTProvinceId").val()) == 0) {
        showNotification("Vui lòng chọn tỉnh/thành.", 0);
        $('select#hTProvinceId').focus();
        return false;
    }
    if (parseInt($('input#roleId').val()) == 2) {
        if (parseInt($("select#agentTypeId").val()) == 0) {
            showNotification("Vui lòng chọn Loại đại lý.", 0);
            $('select#agentTypeId').focus;
            return false;
        }
    }
    if ($('input.agentLevelId:checked').val() == 3 && ($("select.managementUnitId").val() == '--Đơn vị quản lý--' || $("select.managementUnitId").val() == null)) {
        showNotification("Vui lòng chọn đơn vị quản lý.", 0);
        $('select#hTProvinceId').focus();
        return false;
    }

    return true;
}

function customerType(typeId) {
    if (typeId == '2') {
        $('.companyType').show();
        $('.personalType').hide();
        $("input#companyName").addClass('hmdrequired');
        $("input#TaxCode").addClass('hmdrequired');
        $("input#personalName").removeClass('hmdrequired');
        $('.type_info_user').addClass('active');
        $('.personalType input[type=text]').val('');
    } else {
        $('.companyType').hide();
        $('.personalType').show();
        $("input#companyName").removeClass('hmdrequired');
        $("input#TaxCode").removeClass('hmdrequired');
        $("input#personalName").addClass('hmdrequired');
        $('.type_info_user').addClass('active');
        $('.companyType input[type=text]').val('');
    }
}

function resetModalCustomer() {
    $('div#listComment1').html('');
    $("#customerForm .inputReset").val('');
    $("#customerForm select#transportTypeId").val(0).trigger('change');
    $("#customerForm select#countryId").val(232).trigger('change');
    $("#customerForm #divHtmlUserGroup").html('');
    $('.submit').prop('disabled', false);
}

function genUserGroup(count) {
    var html = '<div class="box box-default htmlUserGroup">';
    html += '<div class="box-header with-border">';
    html += '<h3 class="box-title title">Đầu mối liên hệ ' + (count + 1) + '</h3>';
    html += '<div class="box-tools pull-right"><button type="button" class="removeUserGroup"><i class="fa fa-trash-o"></i></button></div>';
    html += '</div>';
    html += '<div class="box-body">';
    html += '<div class="row">';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">Tên</label>';
    html += '<input type="text" class="form-control contactFullName" value=""/>';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">Chức vụ</label>';
    html += '<input type="text" class="form-control contactPosition" value="">';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">SĐT</label>';
    html += '<input type="text" class="form-control contactPhone" value=""/>';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">Email</label>';
    html += '<input type="text" class="form-control contactEmail" value="">';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    $("#divHtmlUserGroup").append(html);
}

function getDataContactUser() {
    var userContacts = [];
    $('.htmlUserGroup').each(function() {
        var $this = $(this);
        if ($this.find('.contactFullName').val() != undefined) {
            var name = $this.find('.contactFullName').val().trim();
            var phone = $this.find('.contactPhone').val().trim();
            if (name != '' && phone != '') {
                userContacts.push({
                    ContactName: name,
                    PositionName: $this.find('.contactPosition').val(),
                    PhoneNumber: phone,
                    Email: $this.find('.contactEmail').val(),
                });
            }
        }
    });
    return userContacts;
}

function callSelectManagementUnit() {
    var staffId = $('#staffId').val();
    // load select2 ajax lấy đơn vị quản lý
    $("select.managementUnitId").select2({
        placeholder: "---Đơn vị quản lý--",
        allowClear: true,
        ajax: {
            url: $("input#urlGetListManagetUnit").val(),
            type: 'POST',
            dataType: 'json',
            data: function(data) {
                return {
                    SearchText: data.term,
                    StaffId:staffId,
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.FullName,
                            id: item.StaffId,
                            data: item
                        };
                    })
                };
            }
        }
    });
}