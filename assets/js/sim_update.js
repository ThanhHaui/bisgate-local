var app = app || {};
app.init = function () {
    app.submit();
    app.add();
};
$(document).ready(function(){
    app.init();
});

app.add = function(){
    $("body").on('click', '#showModalSim', function(){
        resetModalSim();
        $("#modalSim").modal('show');
    });
}

app.submit = function(){
    $("body").on('click', '.submit', function(){
        if(validateEmpty('#simForm')){
            var simManufacturerId = parseInt($('select#simManufacturerId').val());
            var simTypeId = parseInt($('select#simTypeId').val());
            if(simManufacturerId == 0){
                showNotification('Vui lòng chọn Nhà cung cấp', 0);
                return false;
            } 
            if(checkPhoneNumber() == false){
                 showNotification('Số điện thoại không hợp lệ', 0);
                return false;
            }
             if(simTypeId == 0){
                showNotification('Vui lòng chọn loại nhà mạng', 0);
                return false;
            }
    		var form = $('#simForm');
    		$('.submit').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        if(parseInt($("input#simId").val()) == 0){
                            resetTable();
                            resetModalSim();
                            $("#modalSim").modal('hide');
                        }
                    }
                    $('.submit').prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.submit').prop('disabled', false);
                }
            });
    	}
    	return false;
    });
}

function resetModalSim(){
    $('#simForm input').val('');
    $('#simForm select').val(0).trigger('change');
    $('#simForm input#simId').val(0);
}
$(document).ready(function () {
    $('body').on('keydown', 'input#seriSim,#phoneNumber', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    });
    $("input#seriSim,#phoneNumber").bind("cut copy paste", function (e) {
        e.preventDefault();
    });

    $("input#seriSim,#phoneNumber").on("contextmenu",function(e){
        return false;
    });
});