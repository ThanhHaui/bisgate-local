$(document).ready(function(){
    $("#tbodyDeviceCode").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#deviceCodeId').val(id);
        $('input#deviceCodeName').val($('td#deviceCodeName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#deviceCodeName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteDeviceCodeUrl').val(),
                data: {
                    DeviceCodeId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#deviceCode_' + id).remove();
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
        $('#deviceCodeForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#deviceCodeForm')) {
            var form = $('#deviceCodeForm');
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
                            var html = '<tr id="deviceCode_' + data.DeviceCodeId + '">';
                            html += '<td id="deviceCodeName_' + data.DeviceCodeId + '">' + data.DeviceCodeName + '</td>';
                            html += '<td id="comment_' + data.DeviceCodeId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.DeviceCodeId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.DeviceCodeId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyDeviceCode').prepend(html);
                        }
                        else{
                            $('td#deviceCodeName_' + data.DeviceCodeId).text(data.DeviceCodeName);
                            $('td#comment_' + data.DeviceCodeId).text(data.Comment);
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