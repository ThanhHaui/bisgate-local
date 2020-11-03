$(document).ready(function(){
    var groupId = $("input#groupId").val();

    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('#checkAll').click(function(){
        $('input.iCheck').iCheck('check');
        $(this).hide();
        $('#unCheckAll').show();
        return false;
    });
    $('#unCheckAll').click(function(){
        $('input.iCheck').iCheck('uncheck');
        $(this).hide();
        $('#checkAll').show();
        return false;
    });
    $('.top-lv.success').click(function(){
        var betweenEl = $(this).nextUntil('tr.success', 'tr.top-lv2');
        var i = $(this).nextUntil('tr.success', 'tr.top-lv2');
        
        if(betweenEl.length > 0){
            if($(betweenEl[0]).is(':visible'))
            {
                $(this).nextUntil('tr.success', 'tr.top-lv3').css('display','none');
                betweenEl.css('display','none');
                $(this).find('i').css('transform','rotate(0deg)');
                
            } 
            else 
            {
                betweenEl.slideDown();
                $(this).find('i').css('transform','rotate(-90deg)');
            }
        }
        $.each(i, function(index, val) {
            $(val).find('i').css('transform','rotate(0deg)');

        });
    });
    $('.top-lv2').click(function(){
        var nextEl = $(this).next();
        var betweenEl = $(this).nextUntil('tr.top-lv2', 'tr.top-lv3');

        if($(nextEl).hasClass('top-lv3')){
           if($(betweenEl[0]).is(':visible'))
           {
               betweenEl.css('display','none');
               $(this).find('i').css('transform','rotate(0deg)');
           } 
           else 
           {
               betweenEl.slideDown();
               $(this).find('i').css('transform','rotate(-90deg)');
           }
        }
    });
    $.each($('.top-lv2'), function(index, val) {
        var nextEl = $(val).next();
        if(!$(nextEl).hasClass('top-lv3'))
        {
            $(val).find('i').remove();
        }
    });

    $(document).on('click','.submit',function(){
        var btn = $(this);
        var groupId = parseInt($("input#groupId").val());
        if(groupId == 0) update(btn);
		else {
            $('#btnYesOrNo').html('');
            $('#btnYesOrNo').CeoSlider({
                lable_right: 'OK',
                lable_left: 'CANCEL',
                lable_yes: 'Buông chuột để OK',
                lable_no: 'Buông chuột để CANCEL',
                success: function(data) {
                    update(btn);
                    return false;
                },
                error: function(data) {
                    $("#modalActiveOrCancel").modal('hide');
                }
            });
            $("#modalActiveOrCancel").modal('show');
        }
		return false;
    }).on('click','.link_delete_group',function(){
        $(this).closest('tr').remove();
    }).on('click', '.delete_group', function() {
        $('#btnYesOrNo').html('');
        $('#btnYesOrNo').CeoSlider({
            lable_right: 'OK',
            lable_left: 'CANCEL',
            lable_yes: 'Buông chuột để OK',
            lable_no: 'Buông chuột để CANCEL',
            success: function(data) {
                deleteGroupAction(groupId);
                return false;
            },
            error: function(data) {
                $("#modalActiveOrCancel").modal('hide');
            }
        });
        $("#modalActiveOrCancel").modal('show');

        return false;
    });;
});

function update(btn){
    if (validateEmpty('#groupForm')) {
        if($('input#groupName').length>0){	
            var namelogin = $('#groupName').val();
            if (namelogin == ''){
                showNotification('Tên vai trò không được để trống', 0);
                $('input#groupName').focus();
                return false;
            }
        }
        
        btn.prop('disabled', true);
        var actionIds = [];
        $('.icheckbox_square-blue').each(function(){
            if($(this).hasClass('checked')) actionIds.push($(this).find('input.iCheck').val());
        });
        var staffgroups = [];
        $('#tbodyGroup tr').each(function () {
            staffgroups.push({
                StaffId: $(this).data('id'),
            });
        });
        var form = $('#groupForm');
        var datas = form.serializeArray();
        datas.push({ name: "ActionId", value: JSON.stringify(actionIds) });
        datas.push({ name: "StaffGroupId", value: JSON.stringify(staffgroups) });
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: datas,
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                btn.prop('disabled', false);
                redirect(false, $('a#customerListUrl').attr('href'));
            },
            error: function (response) {
                showNotification($('input#errorCommonMessage').val(), 0);
                btn.prop('disabled', false);
            }
        });
    }
}

function deleteGroupAction(groupId) {
    $.ajax({
        type: "POST",
        url: $("input#urlChangeStatus").val(),
        data: {
            GroupId: groupId,
        },
        success: function(response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            if (json.code == 1) {
                if (groupId == 0) redirect(false, $("#groupListUrl").attr('href'));
                else setTimeout(function(){window.location.replace($("#urlListGroup").val());}, 2000);
            }
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

}
$("input.iCheck").on("ifChanged", function () {
    if ($(this).prop('checked')==true){
        $(this).parents('.packageRole').children('label').children('.icheckbox_square-blue').children('input.iCheck').prop('checked',true);
        $(this).parents('.packageRole').children('label').children('.icheckbox_square-blue').addClass('checked');
    }else{
        $(this).closest('.packageRole').find('input.iCheck').prop('checked',false);
        $(this).closest('.packageRole').find('.icheckbox_square-blue').removeClass('checked');
    }
});