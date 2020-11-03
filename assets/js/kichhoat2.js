$(document).ready(function () {
    $('input.iCheckTable').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('input.iCheckRadio').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    $('.check-text-hidden').show();
    $('.check-input-hidden').hide();
    $('body').on('ifToggled', 'input.iCheckItem', function (e) {
        if (e.currentTarget.checked) {
            $('.check-input-hidden').show();
            $('.check-text-hidden').hide();
        } else {
            $('.check-input-hidden').hide();
            $('.check-text-hidden').show();
        }
    });
    $('.checkbox-hidden').hide();
    $('input.checkbox-module').click(function(){
        var id =  $(this).data('id');
        if($(this).prop("checked") == true){
        $(id).show();
        }
        else if($(this).prop("checked") == false){
            $(id).hide();
        }
    });

});