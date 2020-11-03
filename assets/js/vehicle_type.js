$(document).ready(function(){
    $("#tbodyVehicleType").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        var tonage = $(this).attr('data-tonage');
        var texts = $('td#tonnage_' + id).data('text');
     var num = $.trim($('td#unitVallues_' + id).text());
        num = num.replace(/\[/g, "");
        $('input#vehicleTypeId').val(id);
        $('input#TonnageId').val(tonage);
        $('input#vehicleTypeName').val($('td#vehicleTypeName_' + id).text());
        $('select#unitName').val(texts);
        $('input#unitVallues').val(num);
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#unitVallues');
        return false;
    })
    $('a#link_cancel').click(function(){
        $('#vehicleTypeForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        var id = $(this).attr('data-id');
        if(id==0){
            showNotification('Bạn không có quyền thêm mới chủng loại xe', 0);
            return false;
        }
        if (validateEmpty('#vehicleTypeForm')) {
            var form = $('#vehicleTypeForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        form.trigger("reset");
                        // location.reload();
                        var data = json.data;
                        var name = json.name;
                        var tona = '';
                        var color = '';
                        if(name.UnitName == 1){
                            tona = 'Tấn';
                        }
                        else if(name.UnitName == 2){
                            tona = 'Người';
                        }
                        if(data.IsAdd == 1){
                            showNotification('Bạn không có quyền thêm mới chủng loại xe', 0);
                           //  var html = '<tr id="vehicleType_' + data.VehicleTypeId + '">';
                           //  html += '<td id="vehicleTypeName_' + data.VehicleTypeId + '">' + data.VehicleTypeName + '</td>';
                           //  html += '<td id="unitVallues_' + data.VehicleTypeId + '">' + name.UnitVallues + '</td>';
                           //  html += '<td id="tonnage_' + data.VehicleTypeId + '" data-text = "' + name.UnitName + '">' + tona + '</td>';
                           // html += '<td id="comment_' + data.VehicleTypeId + '">' + data.Comment + '</td>';
                           //  html += '<td class="actions">' +
                           //      '<a href="javascript:void(0)" class="link_edit" data-id="' + data.VehicleTypeId + '" data-tonage="' + data.TonnageId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                           //      '<a href="javascript:void(0)" class="link_delete" data-id="' + data.VehicleTypeId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                           //      '</td>';
                           //  html += '</tr>';
                           //  $('#tbodyVehicleType').prepend(html);
                        }
                        else{
                            $('td#vehicleTypeName_' + data.VehicleTypeId).text(data.VehicleTypeName);
                            $('td#unitVallues_' + data.VehicleTypeId).text(name.UnitVallues);
                            $('td#tonnage_' + data.VehicleTypeId).text(tona);
                            // $('td#tonnage_' + data.VehicleTypeId).data('text',name.UnitName);
                            $('td#vehicleTypeName_' + data.VehicleTypeId).text(data.VehicleTypeName);
                            $('td#comment_' + data.VehicleTypeId).text(data.Comment);
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
            if($("#unitVallues").length > 0){
            $.fn.numberOnly = function(){
                return this.each(function()
                {
                    $(this).keydown(function(e)
                    {
                        var key = e.charCode || e.keyCode || 0;
                        return (
                            key == 8 ||
                            key == 9 ||
                            key == 13 ||
                            key == 46 ||
                            key == 188 ||
                            // key == 190 ||
                            (key >= 35 && key <= 40) ||
                            (key >= 48 && key <= 57) ||
                            (key >= 96 && key <= 105));
                    });
                });
            };
            $("#unitVallues").numberOnly();
        }
});