var app = app || {};
app.init = function(simManufacturerId) {
    app.add();
    app.submit(simManufacturerId);
    app.comment(simManufacturerId);
};
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true
});
$(document).ready(function() {
    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('input.iCheckTable').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    var simManufacturerId = $("input#simManufacturerId").val()
    app.init(simManufacturerId);
    var tags = [];
    var inputTag = $('input#tags');
    inputTag.tagsInput({
        'width': '100%',
        'height': '50px',
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
                    ItemIds: JSON.stringify([simManufacturerId]),
                    TagNames: JSON.stringify(tags),
                    ItemTypeId: $("input#itemTypeId").val(),
                    ChangeTagTypeId: 1
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
});


app.add = function() {
    $("body").on('click', '#showModalSimManuFacturer', function() {
        resetModalSimManuFacturer();
        $("#modalSimManuFacturer").modal('show');
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
}

app.submit = function(simManufacturerId) {
    $("body").on('click', '.submit', function() {
        if (validateEmpty('#simManuFacturerForm')) {
            if (($("input#simManufacturerName").val()).length == 0) {
                showNotification("Vui lòng nhập tên.", 0);
                return false;
            }
            if (checkPhoneNumber() == false) {
                showNotification('Số điện thoại không hợp lệ', 0);
                return false;
            }
            if (parseInt($("select#provinceId").val()) == 0) {
                showNotification("Vui lòng chọn tỉnh/thành.", 0);
                return false;
            }
            var form = $('#simManuFacturerForm');
            $('.submit').prop('disabled', true);
            var datas = form.serializeArray();
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
                success: function(response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        if (parseInt(simManufacturerId) == 0) {
                            resetTable();
                            resetModalSimManuFacturer();
                            $("#modalSimManuFacturer").modal('hide');
                        }
                        else{
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

app.comment = function(simManufacturerId) {
    $('#btnInsertComment1').click(function() {
        var comment = $('input#comment1').val().trim();
        if (comment != '') {
            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: $('input#insertCommentUrl').val(),
                data: {
                    ItemId: simManufacturerId,
                    Comment: comment,
                    ItemTypeId: $("input#itemTypeId").val(),
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


function resetModalSimManuFacturer() {
    $("#simManuFacturerForm input#simManufacturerId").val(0);
    $("#simManuFacturerForm .inputReset").val('');
    $("#simManuFacturerForm select#ProvinceId").val(0).trigger('change');
    $("#simManuFacturerForm #divHtmlUserGroup").html('');
    $('.submit').prop('disabled', false);
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