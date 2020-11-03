$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    province();
    province1();
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
        $('input#AvatarBegin').val(fileUrl);
        $('img#imgAvatarBegin').attr('src', fileUrl);
    });
    $('.chooseImage2').click(function () {
        $('#inputFileImage2').trigger('click');
    });
    chooseFile($('#inputFileImage2'), $('#fileProgress2'), 2, function (fileUrl) {
        $('input#AvatarBehind').val(fileUrl);
        $('img#imgAvatarBehind').attr('src', fileUrl);
    });
    var userId = parseInt($('input#userId').val());
    $('.submit').click(function () {
        if (validateEmpty('#userForm') && validateNumber('#userForm', true, ' không được bỏ trống')) {
            var username    = $.trim($('#FullName').val());
            var gender    = $.trim($('#GenderId').val());
            var phonenumber = $.trim($('#PhoneNumber').val());
            if (username == '' || username.length < 4){
                showNotification('Họ tên phải nhiều hơn 4 kí tự', 0);
                $('input#FullName').focus();
                return false;
            }
            if (phonenumber == '' || phonenumber.length < 9){
                showNotification('Số điện thoại không được để trống', 0);
                $('input#PhoneNumber').focus();
                return false;
            }

            // var positionother = [];
            // $('.arr-cdkn .item-cdkn').each(function () {
            //     var departmentother = $(this).find('input#DepartmentOther').val();
            //     var rankother = $(this).find('input#RankOther').val();
            //     alert(rankother);
            //     alert(departmentother);
            //     positionother.push( {
            //         RankOther: rankother,
            //         DepartmentOther: departmentother
            //     } );
            //     alert(positionother);
            // });
            // if (positionother.length > 0) {
            //     $('#PositionOther').val(positionother);
            // }



            // $('.submit').prop('disabled', true);
            var form = $('#userForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        // if (userId == 0){
                             // redirect(false, $('input#userEditUrl').val() + '/' + json.data);
                             $('.submit_permission').attr('data-user',json.data);
                             $('#tab_1,.tab_modal_user1').removeClass('active');
                             $('#tab_2,.tab_modal_user2').addClass('active');
                        // }
                        // else $('.submit').prop('disabled', false);
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
    });
});

$(document).ready(function () {
    var tags = [];
    var inputTag = $('input#tags');
    inputTag.tagsInput({
        'width': '100%',
        'height': '90px',
        'interactive': true,
        'defaultText': '',
        'onAddTag': function (tag) {
            tags.push(tag);
        },
        'onRemoveTag': function (tag) {
            var index = tags.indexOf(tag);
            if (index >= 0) tags.splice(index, 1);
        },
        'delimiter': [',', ';'],
        'removeWithBackspace': true,
        'minChars': 0,
        'maxChars': 0
    });

    $('input.tagName').each(function () {
        // inputTag.addTag($(this).val());
    });
    $('#ulTagExist').on('click', 'a', function () {
        var tag = $(this).text();
        if (!inputTag.tagExist(tag)) inputTag.addTag(tag);
    });

    $('#btnUpdateTag').click(function () {
        if (tags.length > 0) {
            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: $('input#updateItemTagUrl').val(),
                data: {
                    ItemIds: JSON.stringify([$("input#addUserId").val()]),
                    TagNames: JSON.stringify(tags),
                    ItemTypeId: $("input#itemTypeId").val(),
                    ChangeTagTypeId: 1,
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                }
            });
        } else showNotification('Vui lòng chọn nhãn', 0);
    });
    $(document).on('click', '#btnAddGroup', function () {
        var countId = parseInt($(this).val());
        var now = new Date(Date.now());
        var formatted = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
        var arrGroup = [];
        $('input.iCheck').each(function () {
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
        var html = '';
        $.each( arrGroup, function( i, item ) {
            html += `<tr data-id="${item.GroupId}">
            <td>${i+1}</td>
            <td>${item.GroupTime}</td>
            <td>${item.GroupCode}</td>
            <td>${item.GroupName}</td>
            <td><a href="javascript:void(0)" class="link_delete_group" title="Xóa" count-id="${countId}"><i class="fa fa-trash-o"></i></a></td>
            </tr>
            `;
        });
        $("#tbodyGroupUser").append(html);
        $("#btnShowModalGroups").modal('hide');
        return false;
    }).on('click', '.link_delete_group', function(){
        var id = $(this).parent().parent().attr('data-id');
        var code = $(this).parent().parent().find('td').eq(2).text();
        var name = $(this).parent().parent().find('td').eq(3).text();
        $(this).parent().parent().remove();
        $('#tbodyGroup').find('tr#group_'+id).show();

    }).on('click','.submit_permission',function(){
        var id = $(this).data('user');
        var namelogin = $('#NameLogin').val();
        if($('input#NameLogin').length > 0 && $('input#NameLogin').val().trim().indexOf(' ') >= 0){
            showNotification('User name không được có khoảng trằng', 0);
            $('input#NameLogin').focus();
            return false;
        }
        var arrGroup = [];
        $('#tbodyGroupUser tr').each(function () {
            arrGroup.push({
                GroupId: $(this).attr('data-id')
            });
        });

        $.ajax({
            type: "POST",
            url: $('input#updateGroupUser').val(),
            data: {
                group: arrGroup,
                id: id,
                namelogin: namelogin,
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                btn.prop('disabled', false);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                btn.prop('disabled', false);
            }
        });

    });
});

