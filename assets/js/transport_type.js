$(document).ready(function(){
    $("#tbodyTransportType").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#transportTypeId').val(id);
        $('input#transportTypeName').val($('td#transportTypeName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#transportTypeName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteTransportTypeUrl').val(),
                data: {
                    TransportTypeId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#transportType_' + id).remove();
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
        $('#transportTypeForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#transportTypeForm')) {
            var form = $('#transportTypeForm');
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
                            var html = '<tr id="transportType_' + data.TransportTypeId + '">';
                            html += '<td id="transportTypeName_' + data.TransportTypeId + '">' + data.TransportTypeName + '</td>';
                            html += '<td id="comment_' + data.TransportTypeId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.TransportTypeId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.TransportTypeId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyTransportType').prepend(html);
                        }
                        else{
                            $('td#transportTypeName_' + data.TransportTypeId).text(data.TransportTypeName);
                            $('td#comment_' + data.TransportTypeId).text(data.Comment);
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