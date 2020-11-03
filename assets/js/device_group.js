$(document).ready(function(){
    $("#tbodyDeviceGroup").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#deviceGroupId').val(id);
        $('input#deviceGroupName').val($('td#deviceGroupName_' + id).text());
        scrollTo('input#deviceGroupName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteDeviceGroupUrl').val(),
                data: {
                    DeviceGroupId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#deviceGroup_' + id).remove();
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
    });
    $('a#link_cancel').click(function(){
        $('#deviceGroupForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#deviceGroupForm')) {
            var form = $('#deviceGroupForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        form.trigger("reset");
                        var data = json.data;
                        if(data.IsAdd == 1){
                            var html = '<tr id="deviceGroup_' + data.DeviceGroupId + '">';
                            html += '<td id="deviceGroupName_' + data.DeviceGroupId + '">' + data.DeviceGroupName + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.DeviceGroupId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.DeviceGroupId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyDeviceGroup').prepend(html);
                        }
                        else{
                            $('td#deviceGroupName_' + data.DeviceGroupId).text(data.DeviceGroupName);
                        }
                    }
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
    });
});