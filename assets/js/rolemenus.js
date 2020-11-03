$(document).ready(function(){
    $('select.parent').each(function(){
        $(this).val($('input#parent_' + $(this).attr('data-id')).val());
    });
    $('select.parent').change(function(){
        var id = $(this).attr('data-id');
        var value = $(this).val();
        var text = $('select#parentRoleMenuId_' + id + ' option[value="' + value + '"]').text();
        if(text == 'Không có') $('input#level_' + id).val('1');
        else if(text.indexOf('+>') >= 0) $('input#level_' + id).val('3');
        else $('input#level_' + id).val('2');
    });
    $('#tbodyRoleMenu').on('click', '.link_update', function(){
        var id = parseInt($(this).attr('data-id'));
        var roleName = $('input#roleName_' + id).val();
        var roleUrl = $('input#roleUrl_' + id).val().trim();
        if(roleName != '') {
            var roleLevel = parseInt($('input#level_' + id).val());
            $.ajax({
                type: "POST",
                url: $('input#updateRoleUrl').val(),
                data: {
                    RoleMenuId: id,
                    RoleMenuName: roleName,
                    RoleMenuUrl: roleUrl,
                    RoleMenuChildId: $('select#parentRoleMenuId_' + id).val(),
                    RoleLevel: roleLevel
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) redirect(true, '');
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        else{
            showNotification('Tên menu không được bỏ trống', 0);
            $('input#roleName_' + id).focus();
        }
        return false;
    }).on('click', '.link_delete', function() {
        var id = parseInt($(this).attr('data-id'));
        if(id > 0){
            $.ajax({
                type: "POST",
                url: $('input#deleteRoleUrl').val(),
                data: {
                    RoleMenuId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) $('tr#role_' + id).remove();
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        else{
            $('input#roleName_0').val('');
            $('input#roleUrl_0').val('');
            $('input#parentRoleMenuId_0').val('0');
            $('input#level_0').val('1');
        }
        return false;
    });
});
