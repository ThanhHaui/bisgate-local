var app = app || {};
app.init = function(roleId) {
    app.initLibrary(roleId);
    app.addUserGroup(roleId);
    app.submit(roleId);
    app.commentAndTag(roleId);
};

app.initLibrary = function(roleId) {
    var userId = $('#customerUserId').val();
    province();
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('select#countryId').change(function() {
        changeCountry($(this).val());
    });

    $('input.iCheckCustomerType').on('ifToggled', function(e) {
        resetModalCustomer();
        if (e.currentTarget.checked) customerType(e.currentTarget.value);
    });

    $('input.connectTypeId').on('ifToggled', function(e) {
        var typeId = parseInt(e.currentTarget.value);
        var staffIdBis = $('#staffIdBis').val();
        var html = '';
        $('.select2-container.select2-container--default.select2-container--open').remove();
        if (e.currentTarget.checked) {
            if (typeId == 1) {
                html = `<select class="form-control none-display" name="ManagementUnitId">
                <option value = "` + staffIdBis + `">Bistech</option>
               </select>`;
            } else if (typeId == 2) {
                html = `<select class="form-control managementUnitId" name="ManagementUnitId">
                <option value="0">--- List danh sách đại lý cấp 1* ---</option>
                </select>`;
            } else if (typeId == 3) {
                html = `<select class="form-control managementUnitId" name="ManagementUnitId">
                <option value="0">--- List danh sách đại lý cấp 2* ---</option>
                </select>`;
            }
        }
        $(".agentCheck").html(html);
        if (typeId > 1) {
            agent(typeId);
        }
    });

    $("body").on('click', '#showModalCustomer', function() {
        $(".modal-dialog").css({ "width": "800px" });
        $(".modal-content").css({ "width": "800px" });
        $("#content_left").removeClass('col-sm-8').addClass('col-sm-12');
        $("#content_right").hide();
        $("#customerForm input#customerUserId").val(0);
        if (roleId == 1) {
            $("#label-customer").html('Mã khách hàng');
            $("h4#title").html('Thêm mới khách hàng');
        } else {
            $("#label-customer").html('Mã đại lý');
            $("h4#title").html('Thêm mới đại lý');
        }
        resetModalCustomer();
        $("#modalCustomer").modal('show');
    }).on('click', '.customer_reset', function() {
        var id = parseInt($(this).attr('data-id'));
        if(id > 0) {
            $.ajax({
                type: "POST",
                url: $('input#urlRefreshPass').val(),
                data: {
                    UserId: id,
                },
                success: function(response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    $('.customer_reset').prop('disabled', false);
                },
                error: function(response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.customer_reset').prop('disabled', false);
                }
            });
        } else showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        return false;
    }).on('click', '#btnShowModalChangeStaff', function() {
        $("#modalActiveContract").modal('show');
    }).on('click', '#btnActiveContract', function() {
        var userStatusId = $('input[name="ContractStatusId"]:checked').val()
        changeStatusUser(userStatusId, userId)
        return false;
    }).on('click', '#btnActiveStatusUser', function() {
        $('#btnYesOrNo').html('');
        $('#btnYesOrNo').CeoSlider({
            lable_right: 'OK',
            lable_left: 'CANCEL',
            lable_yes: 'Buông chuột để OK',
            lable_no: 'Buông chuột để CANCEL',
            success: function(data) {
                changeStatusUser(2, userId);
                return false;
            },
            error: function(data) {
                $("#modalActiveOrCancel").modal('hide');
            }
        });
        $("#modalActiveOrCancel").modal('show');

        return false;
    });

};

$(document).ready(function() {
    var roleId = parseInt($("input#roleId").val());
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

    $('#btnUpdateTag').click(function() {
        if (tags.length > 0) {
            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: $('input#updateItemTagUrl').val(),
                data: {
                    ItemIds: JSON.stringify([$("input#customerUserId").val()]),
                    TagNames: JSON.stringify(tags),
                    ItemTypeId: $("input#itemTypeId").val(),
                    ChangeTagTypeId: 1,
                },
                success: function(response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    btn.prop('disabled', false);
                },
                error: function(response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                }
            });
        } else showNotification('Vui lòng chọn nhãn', 0);
    });
    app.init(roleId);
    province();

});

app.addUserGroup = function(roleId) {
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
}

app.commentAndTag = function(roleId) {
    $('#btnInsertComment1').click(function() {
        var comment = $('input#comment1').val().trim();
        if (comment != '') {
            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: $('input#insertCommentUrl').val(),
                data: {
                    UserId: $("input#customerUserId").val(),
                    Comment: comment,
                    CommentTypeId: $("input#itemTypeId").val()
                },
                success: function(response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) {
                        $('div#listComment1').prepend(genItemComment(comment));
                        $('input#comment1').val('');
                    }
                    showNotification(json.message, json.code);
                    btn.prop('disabled', false);
                },
                error: function(response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                }
            });
        } else {
            showNotification('Vui lòng nhập ghi chú', 0);
            $('input#comment1').focus();
        }
    });
}

app.submit = function(roleId) {
    $("body").on('click', '.submit', function() {
        if (validateEmpty('#customerForm')) {
            if ($(''))
                var username = $.trim($('#username').val());
            var CheckPhoneNumber = /((09|03|07|08|05)+([0-9]{8})\b)/g;
            if (!CheckPhoneNumber.test($('#phoneNumber').val())) {
                showNotification("Số điện thoại không đúng", 0);
                return false;
            }
            var connectTypeId = parseInt($('input.connectTypeId:checked').val());
            if ($('input.connectTypeId:checked').length == 0) {
                showNotification("Vui lòng chọn đơn vị quản lý.", 0);
                return false;
            }
            if (parseInt($("select#provinceId").val()) == 0) {
                showNotification("Vui lòng chọn tỉnh/thành.", 0);
                return false;
            }
            if (connectTypeId == 0) {
                showNotification("Vui lòng chọn Liên kết.", 0);
                return false;
            } else if (connectTypeId != 1){
                var managementUnitId = $("select.managementUnitId").val();
                if(managementUnitId == null || parseInt(managementUnitId) == 0) {
                    showNotification("Vui lòng chọn đơn vị quản lý.", 0);
                return false;
                }
            };
            
            var form = $('#customerForm');
            var datas = form.serializeArray();
            var customerTypeId = parseInt($('input[name="CustomerTypeId"]:checked').val());
            if (customerTypeId == 1) {
                datas.push({ name: "FullName", value: $("input#personalName").val() });
            } else {
                datas.push({ name: "FullName", value: $("input#companyName").val() });
            } 
            datas.push({ name: "AgentLevelId", value: $('input[name="AgentLevelId"]:checked').val() });
            datas.push({ name: "ContactUsers", value: JSON.stringify(getDataContactUser()) });
            datas.push({ name: "RoleId", value: $("input#roleId").val() });
            // $('.submit').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
                success: function(response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        if (parseInt($("input#customerUserId").val()) == 0) {
                            resetTable();
                            resetModalCustomer();
                            $("#modalCustomer").modal('hide');
                        } else {
                            redirect(true, "");
                        }
                    }
                    $('.submit').prop('disabled', false);
                },
                error: function(response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.submit').prop('disabled', false);
                }
            });
        }
        return false;
    });
}

function changeCountry(countryId = 0) {
    if (countryId != '232') {
        $('.VNon').hide();
        $('.VNoff').fadeIn();
    } else {
        $('.VNoff').hide();
        $('.VNon').fadeIn();
    }
}

function customerType(typeId) {

    if (typeId == '2') {
        $('.companyType').show();
        $('.personalType').hide();
        $("input#companyName").addClass('hmdrequired');
        $("input#personalName").removeClass('hmdrequired');
    } else {
        $('.companyType').hide();
        $('.personalType').show();
        $("input#companyName").removeClass('hmdrequired');
        $("input#personalName").addClass('hmdrequired');
    }
}

function agent(typeId) {
    $("select.managementUnitId").select2({
        placeholder: "---Đơn vị quản lý--",
        allowClear: true,
        ajax: {
            url: $("input#ajaxListAgentHtml").val(),
            type: 'POST',
            dataType: 'json',
            data: function(data) {
                return {
                    SearchText: data.term,
                    TypeId: typeId,
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

function genUserGroupEdit(i, itemContact) {
    var html = '<div class="box box-default htmlUserGroup">';
    html += '<div class="box-header with-border">';
    html += '<h3 class="box-title title">Đầu mối liên hệ ' + (i + 1) + '</h3>';
    html += '<div class="box-tools pull-right"><button type="button" class="removeUserGroup"><i class="fa fa-trash-o"></i></button></div>';
    html += '</div>';
    html += '<div class="box-body">';
    html += '<div class="row">';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">Tên</label>';
    html += '<input type="text" class="form-control contactFullName" value="' + itemContact[i].ContactName + '"/>';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">Chức vụ</label>';
    html += '<input type="text" class="form-control contactPosition" value="' + itemContact[i].PositionName + '">';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">SĐT</label>';
    html += '<input type="text" class="form-control contactPhone" value="' + itemContact[i].PhoneNumber + '"/>';
    html += '</div>';
    html += '</div>';
    html += '<div class="col-sm-6">';
    html += '<div class="form-group">';
    html += '<label class="control-label">Email</label>';
    html += '<input type="text" class="form-control contactEmail" value="' + itemContact[i].Email + '">';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    $("#divHtmlUserGroup").append(html);

}

function resetModalCustomer() {
    $('form#customerForm').trigger("reset"); 
    $('div#listComment1').html('');
    $("#customerForm .inputReset").val('');
    $("#customerForm select#provinceId").val(0).trigger('change');
    $("#customerForm select#transportTypeId").val(0).trigger('change');
    $("#customerForm select#countryId").val(232).trigger('change');
    $("#customerForm #divHtmlUserGroup").html('');
    $('.submit').prop('disabled', false);
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

$('body').on('click', '.link_edit_type', function() {
    var MaxSpeed = $(this).closest('tr').find('.maxSpeed').text()
    var VehicleTypeName = $(this).closest('tr').find('.vehicleTypeName').text()
    var VehicleTypeId = $(this).closest('tr').attr('data-id')
    $('#vehicleTypeName').val(VehicleTypeName)
    $('#maxSpeed').val(MaxSpeed)
    $('#vehicleTypeId').val(VehicleTypeId)
})

$('body').on('click', '#link_update_type', function() {
    var MaxSpeed = $('#maxSpeed').val()
    var VehicleTypeId = $('#vehicleTypeId').val()
    var CustomerId = $('#customerUserId').val()
    if (MaxSpeed == '') {
        showNotification('Vui lòng nhập Tốc độ tối đa cấu hình', 0);
        $('#maxSpeed').focus()
        return false
    }
    if (VehicleTypeId == 0) {
        showNotification('Vui lòng chọn chủng loại xe', 0);
        return false
    }
    $.ajax({
        type: "POST",
        url: $('#updateMaxSpeedUrl').val(),
        data: {
            CustomerId: CustomerId,
            VehicleTypeId: VehicleTypeId,
            MaxSpeed: MaxSpeed
        },
        success: function(response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            if (json.code == 1) {
                showNotification('Cập nhật tốc độ tối đa cấu hình thành công', 1);
                $('#vehicleType_' + VehicleTypeId).find('.maxSpeed').text(MaxSpeed)
                $('#vehicleTypeName').val('')
                $('#maxSpeed').val('')
                $('#vehicleTypeId').val(0)
            }
            $('.submit').prop('disabled', false);
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            $('.submit').prop('disabled', false);
        }
    });
})

$('#link_cancel_type').click(function() {
    $('#vehicleTypeName').val('')
    $('#maxSpeed').val('')
    $('#vehicleTypeId').val(0)
})

function changeStatusUser(userStatusId, userId) {
    $.ajax({
        type: "POST",
        url: $("input#urlChangeStatus").val(),
        data: {
            StatusId: userStatusId,
            UserId: userId,
            CheckMember: 0
        },
        success: function(response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            if (json.code == 1) {
                if (userId == 0) redirect(false, $("#userListUrl").attr('href'));
                else redirect(true, '');
            }
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

}
$(document).ready(function() {
    $('body').on('keydown', 'input#maxSpeed,#phoneNumber', function(e) {
        if (checkKeyCodeNumber(e)) e.preventDefault();
    });
    $("input#maxSpeed,#phoneNumber").bind("cut copy paste", function(e) {
        e.preventDefault();
    });

    $("input#maxSpeed,#phoneNumber").on("contextmenu", function(e) {
        return false;
    });
});