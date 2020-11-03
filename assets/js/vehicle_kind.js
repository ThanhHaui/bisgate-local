$(document).ready(function(){
    $("#tbodyVehicleKind").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#vehicleKindId').val(id);
        $('input#vehicleKindName').val($('td#vehicleKindName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#vehicleKindName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteVehicleKindUrl').val(),
                data: {
                    VehicleKindId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#vehicleKind_' + id).remove();
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
        $('#vehicleKindForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#vehicleKindForm')) {
            var form = $('#vehicleKindForm');
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
                            var html = '<tr id="vehicleKind_' + data.VehicleKindId + '">';
                            html += '<td id="vehicleKindName_' + data.VehicleKindId + '">' + data.VehicleKindName + '</td>';
                            html += '<td id="comment_' + data.VehicleKindId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.VehicleKindId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.VehicleKindId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyVehicleKind').prepend(html);
                        }
                        else{
                            $('td#vehicleKindName_' + data.VehicleKindId).text(data.VehicleKindName);
                            $('td#comment_' + data.VehicleKindId).text(data.Comment);
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