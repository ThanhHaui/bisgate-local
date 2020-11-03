$(document).ready(function(){
    $(".submit").on('click', function(){
        var form = $('#keyForm');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if(json.code == 1){
                    redirect(true, '');
                }
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
        return false;
    });
    $("body").on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteKeyUrl').val(),
                data: {
                    KeyId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) redirect(true, '');
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
    });
});