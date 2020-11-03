$(document).ready(function(){
    $("#tbodyVehicleManuFacturer").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#vehicleManufacturerId').val(id);
        $('input#vehicleManufacturerName').val($('td#vehicleManufacturerName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#vehicleManufacturerName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteVehicleManuFacturerUrl').val(),
                data: {
                    VehicleManufacturerId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#vehicleManuFacturer_' + id).remove();
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
        $('#vehicleManuFacturerForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#vehicleManuFacturerForm')) {
            var form = $('#vehicleManuFacturerForm');
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
                            redirect(true, '');
                            var html = '<tr id="vehicleManuFacturer_' + data.VehicleManufacturerId + '">';
                            html += '<td id="vehicleManufacturerName_' + data.VehicleManufacturerId + '">' + data.VehicleManufacturerName + '</td>';
                            html += '<td id="comment_' + data.VehicleManufacturerId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.VehicleManufacturerId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.VehicleManufacturerId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyVehicleManuFacturer').prepend(html);
                        }
                        else{
                            $('td#vehicleManufacturerName_' + data.VehicleManufacturerId).text(data.VehicleManufacturerName);
                            $('td#comment_' + data.VehicleManufacturerId).text(data.Comment);
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