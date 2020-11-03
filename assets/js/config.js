$(document).ready(function(){
    if($('input#autoLoad').val() == '1') {
        //province();
        $('#btnUpLogo').click(function () {
            $('#inputFileImage1').trigger('click');
        });
        chooseFile($('#inputFileImage1'), $('#fileProgress1'), 3, function(fileUrl){
            $('#imgLogo').attr('src', fileUrl);
            $('input#logoImage').val(fileUrl);
        });

        $('#btnUpLogo_youtube').click(function () {
            $('#inputFileImage2').trigger('click');
        });
        chooseFile($('#inputFileImage2'), $('#fileProgress2'), 3, function(fileUrl){
            $('#imgLogo_youtube').attr('src', fileUrl);
            $('input#logoImage_youtube').val(fileUrl);
        });
    }
    else {
        CKEDITOR.replace('ABOUT_HOME_DESC', {
            language: 'vi',
            toolbar : 'ShortToolbar',
            height: 200
        });
        /*$('.js-switch').bootstrapSwitch({size: 'mini'}).on('switchChange.bootstrapSwitch', function(event, state) {
            $.ajax({
                type: "POST",
                url: $('input#updateConfigUrl').val(),
                data: {
                    ConfigCode: $(this).val(),
                    ConfigValue: state ? 'ON' : 'OFF'
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code != 1) redirect(true, '');
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    redirect(true, '');
                }
            });
        });*/
    }
    $('.submit').click(function(){
        if(validateEmpty('#configForm')) {
            if($('input#autoLoad').val() == '2') CKEDITOR.instances['ABOUT_HOME_DESC'].updateElement();
            $('.submit').prop('disabled', true);
            var form = $('#configForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    $('.submit').prop('disabled', false);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    $('.submit').prop('disabled', false);
                }
            });
        }
        return false;
    });
});