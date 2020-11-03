$(document).ready(function(){
    $('#checkAll, #unCheckAll, #btnUpdate').hide();
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
    var selectGroup = $('select#groupId');
    getActions(parseInt(selectGroup.val()));
    selectGroup.change(function(){
        $('input.iCheck').iCheck('uncheck');
        getActions(parseInt($(this).val()));
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


    $('#btnClone').click(function(){
        var groupId = parseInt(selectGroup.val());
        if(groupId > 0) $('#modalCloneAction').modal('show');
        else showNotification('Vui lòng chọn nhóm quyền', 0);
    });
    $('#btnUpdateActionClone').click(function(){
        var groupId = parseInt(selectGroup.val());
        var groupName = $('input#groupName').val().trim();
        if(groupId > 0 && groupName != ''){
            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: $('input#cloneGroupActionUrl').val(),
                data: {
                    GroupId: groupId,
                    GroupName: groupName,
                    Comment: $('input#comment').val().trim()
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        $('#modalCloneAction input').val('');
                        $('#modalCloneAction').modal('hide');
                        selectGroup.append('<option value="' + json.data + '" selected>' + groupName + '</option>').trigger('change');
                    }
                    btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    btn.prop('disabled', false);
                }
            });
        }
        else showNotification('Tên nhóm không được bỏ trống', 0);
    });
    $('#btnUpdate').click(function(){
        var groupId = parseInt(selectGroup.val());
        if(groupId > 0){
            var btn = $(this);
            btn.prop('disabled', true);
            var actionIds = [];
            $('.icheckbox_square-blue').each(function(){
                if($(this).hasClass('checked')) actionIds.push($(this).find('input.iCheck').val());
            });
            $.ajax({
                type: "POST",
                url: $('input#updateGroupActionUrl').val(),
                data: {
                    GroupId: groupId,
                    ActionIds: JSON.stringify(actionIds)
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    btn.prop('disabled', false);
                }
            });
        }
        else showNotification('Vui lòng chọn nhóm quyền', 0);
    });
});

function getActions(groupId){
    if(groupId > 0){
        $('#checkAll, #unCheckAll, #btnUpdate').show();
        $.ajax({
            type: "POST",
            url: $('input#getActionUrl').val(),
            data: {
                GroupId: groupId
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if (json.code == 1){
                    var data = json.data;
                    for(var i = 0; i < data.length; i++) $('input#cbAction_' + data[i].ActionId).iCheck('check');
                }
                else showNotification(json.message, json.code);
            },
            error: function (response) {
                showNotification($('input#errorCommonMessage').val(), 0);
            }
        });
    }
    else $('#checkAll, #unCheckAll, #btnUpdate').hide();
}