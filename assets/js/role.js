$(document).ready(function(){
    $("#tbodyRole").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#roleId').val(id);
        $('input#roleName').val($('td#roleName_' + id).text());
        $('select#partId').val($('input#partId_' + id).val()).trigger('change');
        scrollTo('input#roleName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteRoleUrl').val(),
                data: {
                    RoleId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#role_' + id).remove();
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        return false;
    });
    $('a#link_cancel').click(function(){
        $('#roleForm').trigger("reset");
        $('select#partId').val(0).trigger('change');
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#roleForm')) {
            var form = $('#roleForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        form.trigger("reset");
                        $('select#partId').val(0).trigger('change');
                        var data = json.data;
                        if(data.IsAdd == 1){
                            var html = '<tr id="role_' + data.RoleId + '">'; 
                            html += '<td id="roleName_' + data.RoleId + '">' + data.RoleName + '</td>';
                            html += '<td id="partName_' + data.RoleId + '">' + data.PartName + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.RoleId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.RoleId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '<input type="text" hidden="hidden" id="partId_' + data.RoleId + '" value="' + data.PartId + '">' +
                                //'<a href="' + $('input#roleActionUrl').val() + data.RoleId + '" target="_blank" title="Cấp quyền"><i class="fa fa-unlock"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyRole').prepend(html);
                        }
                        else{
                            $('td#roleName_' + data.RoleId).text(data.RoleName);
                            $('td#partName_' + data.RoleId).text(data.PartName);
                            $('input#partId_' + data.RoleId).val(data.PartId);
                        } 
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        return false;
    });
});