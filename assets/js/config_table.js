$(document).ready(function(){
    $("body").on('click', '#btnShowModal', function(){
        $("input#tableName").val('');
        $("input#configTableId").val(0);
        $("#tbodyConfigTable").html('');
        $("#modalConfigTable").modal('show');
    }).on('click', '#btnAddData', function(){
        var html = '<tr>';
        html += '<td><input class="form-control ColumnName"/></td>';
        html += '<td><input class="form-control ColumnNameUser"/></td>'; 
        html += '<td><input class="form-control ModelsDb"/></td>';
        html += '<td><input class="form-control NameRelationship"/></td>';
        html += '<td><input class="form-control Status"/></td>';
        html += '<td><input class="form-control Edit"/></td>';
        html += '<td><input class="form-control IdEdit"/></td>';
        html += '<td><input class="form-control Number"/></td>';
        html += '<td><input class="form-control DateTime"/></td>';
        html += '<td><input class="form-control IsActive" readonly value="ON" /></td>';
        html += '<td><input class="form-control IsLock" readonly value="OFF" /></td>';
        html += '<td><a href="javascript:void(0)" class="link_delete" data-id="0" title="Xóa"><i class="fa fa-trash-o"></i></a></td>';
        html += '</tr>';
        $("#tbodyConfigTable").append(html);
    }).on('click', '.submit', function(){
        if (validateEmpty('#configTableForm')) {
            var form = $('#configTableForm');
            var datas = form.serializeArray();
            datas.push({ name: "ConfigTableJson", value: JSON.stringify(getDataJson()) });
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        redirect(true, '');
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
        
    }).on('click', '.link_edit', function(){
        var id = parseInt($(this).attr('data-id'));
        $("input#tableName").val('');
        $("input#configTableId").val(0);
        $("#tbodyConfigTable").html('');
        if(id > 0){
            $.ajax({
                type: "POST",
                url: $("input#urlEdit").val(),
                data: {
                    ConfigTableId: id,
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        var datas = json.data;
                        $("input#tableName").val(datas.TableName);
                        $("input#configTableId").val(datas.ConfigTableId);
                        var configTableJson = $.parseJSON(datas.ConfigTableJson);
                        if(configTableJson.length > 0){
                            var html = '';
                            for(var i = 0; i < configTableJson.length; i++){
                                html += '<tr>';
                                html += '<td><input class="form-control ColumnName" value="'+configTableJson[i].ColumnName+'" ></td>';
                                html += '<td><input class="form-control ColumnNameUser" value="'+configTableJson[i].ColumnNameUser+'"></td>';
                                html += '<td><input class="form-control ModelsDb" value="'+configTableJson[i].ModelsDb+'"></td>';
                                html += '<td><input class="form-control NameRelationship" value="'+configTableJson[i].NameRelationship+'"></td>';
                                html += '<td><input class="form-control Status" value="'+configTableJson[i].Status+'"></td>';
                                html += '<td><input class="form-control Edit" value="'+configTableJson[i].Edit+'"></td>';
                                html += '<td><input class="form-control IdEdit" value="'+configTableJson[i].IdEdit+'"></td>';
                                html += '<td><input class="form-control Number" value="'+configTableJson[i].Number+'"></td>';
                                html += '<td><input class="form-control DateTime" value="'+configTableJson[i].DateTime+'"></td>';
                                html += '<td><input class="form-control IsActive" readonly value="'+configTableJson[i].IsActive+'"/></td>';
                                html += '<td><input class="form-control IsLock" readonly value="'+configTableJson[i].IsLock+'"/></td>';
                                html += '<td><a href="javascript:void(0)" class="link_delete" data-id="'+configTableJson[i].ConfigTableId+'" title="Xóa"><i class="fa fa-trash-o"></i></a></td>';
                                html += '</tr>';
                            }
                            $("#tbodyConfigTable").append(html);
                        }
                        $("#modalConfigTable").modal('show');
                        
                    }
                    else showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }else showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
    });

});

function getDataJson(){
    var dataArr = [];
    $('#tbodyConfigTable tr').each(function () {
        var $this = $(this).find('td');
        dataArr.push({
            'ColumnName' : $this.eq(0).find('input').val(),
            'ColumnNameUser' : $this.eq(1).find('input').val(),
            'ModelsDb' : $this.eq(2).find('input').val(),
            'NameRelationship': $this.eq(3).find('input').val(),
            'Status': $this.eq(4).find('input').val(),
            'Edit': $this.eq(5).find('input').val(),
            'IdEdit': $this.eq(6).find('input').val(),
            'Number': $this.eq(7).find('input').val(),
            'DateTime': $this.eq(8).find('input').val(),
            'IsActive': 'ON',
            'IsLock': 'OFF',
        });
    });
    return dataArr;
}