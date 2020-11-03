$(document).ready(function(){
    $('#btnRegister').click(function(){
    	if(validateEmpty('#userForm')){
    		if ($('input#userPass').val() != $('input#rePass').val()) {
                showNotification('Mật khẩu không trùng', 0);
                return false;
            }
            var userName = $('input#userName').val().trim();
            if(userName.indexOf(' ') >= 0){
                showNotification('Tên đăng nhập không được có khoảng trằng', 0);
                $('input#userName').focus();
                return false;
            }
    		var v = grecaptcha.getResponse();
	        if(v.length == 0){
	            showNotification('Chưa veryfy captcha', 0);
	            return false;
	        }
            var form = $('#userForm');
            var btn = $(this);
	        btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: {
                	UserId: 	0,
                	UserName: 	userName,
                	UserPass: 	$('input#userPass').val(),
                	FullName: 	userName,
                	Email: 		$('input#email').val(),
                	GenderId: 	1,
                	StatusId: 	2,
                	ProvinceId: 0,
                	DistrictId: 0,
                	WardId: 	0,
                	Address: 	'',
                	BirthDay: 	0,
                	PhoneNumber: $('input#phoneNumber').val(),
                	DegreeName: '',
                	Facebook: 	'',
                	Avatar: 	'',
                	MaxCost: 	0
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                    	form.trigger('reset');
                        showNotification('Chúc mừng bạn đăng ký thành công', 1);
                    }
                    else showNotification(json.message, json.code);
                    btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    btn.prop('disabled', false);
                }
            });
    	}
        return false;
    });
});
