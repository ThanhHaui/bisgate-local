$(document).ready(function(){
    $("#tbodyDeviceManuFacturer").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#deviceManufacturerId').val(id);
        $('input#deviceManufacturerName').val($('td#deviceManufacturerName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#deviceManufacturerName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteDeviceManuFacturerUrl').val(),
                data: {
                    DeviceManufacturerId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#deviceManufacturerName_' + id).remove();
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
        $('#deviceManuFacturerForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#deviceManuFacturerForm')) {
            var form = $('#deviceManuFacturerForm');
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
                            var html = '<tr id="deviceManufacturerName_' + data.DeviceManufacturerId + '">';
                            html += '<td id="deviceManufacturerName_' + data.DeviceManufacturerId + '">' + data.DeviceManufacturerName + '</td>';
                            html += '<td id="comment_' + data.DeviceManufacturerId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.DeviceManufacturerId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.DeviceManufacturerId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyDeviceManuFacturer').prepend(html);
                        }
                        else{
                            $('td#deviceManufacturerName_' + data.DeviceManufacturerId).text(data.DeviceManufacturerName);
                            $('td#comment_' + data.DeviceManufacturerId).text(data.Comment);
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