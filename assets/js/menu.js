$(document).ready(function() {
    $("#tbodyMenu").on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')){
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#changeStatusUrl').val(),
                data: {
                    MenuId: id,
                    StatusId: 0
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#trItem_' + id).remove();
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        return false;
    }).on("click", "a.link_status", function(){
        var id = $(this).attr('data-id');
        var statusId = $(this).attr('data-status');
        if(statusId != $('input#statusId_' + id).val()) {
            $.ajax({
                type: "POST",
                url: $('input#changeStatusUrl').val(),
                data: {
                    MenuId: id,
                    StatusId: statusId
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1){
                        $('td#statusName_' + id).html(json.data);
                        $('input#statusId_' + id).val(statusId);
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        $('#btnGroup_' + id).removeClass('open');
        return false;
    });
});