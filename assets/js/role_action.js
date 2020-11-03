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
    var selectRole = $('select#roleId');
    var selectPart = $('select#partId');
    getActions(parseInt(selectRole.val()), parseInt(selectPart.val()));
    selectRole.change(function(){
        $('input.iCheck').iCheck('uncheck');
        getActions(parseInt($(this).val()), parseInt(selectPart.val()));
    });
    selectPart.change(function(){
        $('input.iCheck').iCheck('uncheck');
        getActions(parseInt(selectRole.val()), parseInt($(this).val()));
    });
    $('#btnUpdate').click(function(){
        var roleId = parseInt(selectRole.val());
        if(roleId > 0){
            var btn = $(this);
            btn.prop('disabled', true);
            var actionIds = [];
            $('.icheckbox_square-blue').each(function(){
                if($(this).hasClass('checked')) actionIds.push($(this).find('input.iCheck').val());
            });
            $.ajax({
                type: "POST",
                url: $('input#updateRoleActionUrl').val(),
                data: {
                    RoleId: roleId,
                    PartId: parseInt(selectPart.val()),
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
    })
});

function getActions(roleId, partId){
    if(roleId > 0){
        $('#checkAll, #unCheckAll, #btnUpdate').show();
        $.ajax({
            type: "POST",
            url: $('input#getActionUrl').val(),
            data: {
                RoleId: roleId,
                PartId: partId
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