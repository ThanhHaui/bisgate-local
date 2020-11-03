$(document).ready(function(){
    province('resProvinceId','resDistrictId','resWardId');
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    province();
    $('.chooseImage').click(function(){
        $('#inputFileImage').trigger('click');
    });
    chooseFile($('#inputFileImage'), $('#fileProgress'), 2, function(fileUrl){
        $('input#avatar').val(fileUrl);
        $('img#imgAvatar').attr('src', fileUrl);
    });
    $(document).on('submit','#profileForm',function (){
        if(validateEmpty('#profileForm')) {
            if ($('input#newPass').val().length > 0 || $('input#rePass').val().length > 0) {
                if ($('input#newPass').val() != $('input#rePass').val()) {
                    showNotification('Mật khẩu không trùng', 0);
                    return false;
                }
            }
            if($('input#userName').val().trim().indexOf(' ') >= 0){
                showNotification('Tên đăng nhập không được có khoảng trằng', 0);
                $('input#userName').focus();
                return false;
            }
            if($('#roleId').val() == '4') {
                var phoneNumber = $('input#phoneNumber').val().trim();
                if (phoneNumber.indexOf(' ') >= 0) {
                    showNotification('Số điện thoại không được có khoảng trằng', 0);
                    $('input#phoneNumber').focus();
                    return false;
                }
                if (phoneNumber.length == 10 || phoneNumber.length == 11) {
                    var filter = /^[0-9-+]+$/;
                    if (!filter.test(phoneNumber)) {
                        showNotification('Số điện thoại không hợp lệ', 0);
                        $('input#phoneNumber').focus();
                        return false;
                    }
                }
                else {
                    showNotification('Số điện thoại chỉ gồm 10 hoặc 11 số', 0);
                    $('input#phoneNumber').focus();
                    return false;
                }
            }
            var form = $('#profileForm');
            var url = form.attr('action');
            var data = form.serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        $('input#userPass').val('');
                        $('input#newPass').val('');
                        $('input#rePass').val('');
                    }
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        return false;
    });
});