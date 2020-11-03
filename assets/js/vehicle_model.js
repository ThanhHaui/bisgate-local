$(document).ready(function(){
    $("#tbodyVehicleModel").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#vehicleModelId').val(id);
        $('input#vehicleModelName').val($('td#vehicleModelName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#vehicleModelName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteVehicleModelUrl').val(),
                data: {
                    VehicleModelId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#vehicleModel_' + id).remove();
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
        $('#vehicleModelForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#vehicleModelForm')) {
            var form = $('#vehicleModelForm');
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
                            var html = '<tr id="vehicleModel_' + data.VehicleModelId + '">';
                            html += '<td id="vehicleModelName_' + data.VehicleModelId + '">' + data.VehicleModelName + '</td>';
                            html += '<td id="comment_' + data.VehicleModelId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.VehicleModelId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.VehicleModelId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyVehicleModel').prepend(html);
                        }
                        else{
                            $('td#vehicleModelName_' + data.VehicleModelId).text(data.VehicleModelName);
                            $('td#comment_' + data.VehicleModelId).text(data.Comment);
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