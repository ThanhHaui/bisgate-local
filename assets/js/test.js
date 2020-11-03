var panelCustomer = $('#panelCustomer');
var pageIdCustomer = $('input#pageIdCustomer');
var statusSearch = null;
$('#txtSearchCustomer').click(function () {
    if (panelCustomer.hasClass('active')) {
        panelCustomer.removeClass('active');
        panelCustomer.find('panel-body').css("width", "99%");
    } else {
        panelCustomer.addClass('active');
        setTimeout(function () {
            panelCustomer.find('panel-body').css("width", "100%");
            $('.wrapper').addClass('open-search-customer');
        }, 100);
        pageIdCustomer.val('1');
    }
});
$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
});


