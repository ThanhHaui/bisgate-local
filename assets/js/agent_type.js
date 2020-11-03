$(document).ready(function(){
    $("#tbodyAgentType").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#agentTypeId').val(id);
        $('input#agentTypeName').val($('td#agentTypeName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#agentTypeName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteAgentTypeUrl').val(),
                data: {
                    AgentTypeId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#agentType_' + id).remove();
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
        $('#agentTypeForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#agentTypeForm')) {
            var form = $('#agentTypeForm');
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
                            var html = '<tr id="agentType_' + data.AgentTypeId + '">';
                            html += '<td id="agentTypeName_' + data.AgentTypeId + '">' + data.AgentTypeName + '</td>';
                            html += '<td id="comment_' + data.AgentTypeId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.AgentTypeId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.AgentTypeId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyAgentType').prepend(html);
                        }
                        else{
                            $('td#agentTypeName_' + data.AgentTypeId).text(data.AgentTypeName);
                            $('td#comment_' + data.AgentTypeId).text(data.Comment);
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