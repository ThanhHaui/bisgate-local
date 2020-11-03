$(document).ready(function(){
    $("#tbodyAgentStar").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#agentStarId').val(id);
        $('input#agentStarName').val($('td#agentStarName_' + id).text());
        $('input#comment').val($('td#comment_' + id).text());
        scrollTo('input#agentStarName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteAgentStarUrl').val(),
                data: {
                    AgentStarId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#agentStar_' + id).remove();
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
        $('#agentStarForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#agentStarForm')) {
            var form = $('#agentStarForm');
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
                            var html = '<tr id="agentStar_' + data.AgentStarId + '">';
                            html += '<td id="agentStarName_' + data.AgentStarId + '">' + data.AgentStarName + '</td>';
                            html += '<td id="comment_' + data.AgentStarId + '">' + data.Comment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.AgentStarId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.AgentStarId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyAgentStar').prepend(html);
                        }
                        else{
                            $('td#agentStarName_' + data.AgentStarId).text(data.AgentStarName);
                            $('td#comment_' + data.AgentStarId).text(data.Comment);
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