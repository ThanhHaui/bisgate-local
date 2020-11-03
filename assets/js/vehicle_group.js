$(document).ready(function(){
    $("#tbodyVehicleGroup").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#vehicleGroupId').val(id);
        $('input#vehicleGroupName').val($('td#vehicleGroupName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#vehicleGroupName_');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteVehicleGrouplUrl').val(),
                data: {
                    VehicleGroupId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#vehicleGroup_' + id).remove();
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
        $('#vehicleGroupForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#vehicleGroupForm')) {
            var form = $('#vehicleGroupForm');
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
                            var html = '<tr id="vehicleGroup_' + data.VehicleGroupId + '">';
                            html += '<td id="vehicleGroupName_' + data.VehicleGroupId + '">' + data.VehicleGroupName + '</td>';
                            html += '<td id="comment_' + data.VehicleGroupId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.VehicleGroupId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.VehicleGroupId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyVehicleGroup').prepend(html);
                        }
                        else{
                            $('td#vehicleGroupName_' + data.VehicleGroupId).text(data.VehicleGroupName);
                            $('td#comment_' + data.VehicleGroupId).text(data.Comment);
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