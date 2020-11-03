$('#userDriverList ').on('click', 'li', function() {
    var FullName = $(this).find('#FullName').text()
    var PhoneNumber = $(this).find('#PhoneNumber').text()
    var GPLX = $(this).find('#GPLX').text()
    var UserCode = $(this).find('#UserCode').text()
    var UserId = $(this).attr('data-id')
    $('.boxShowInfo .FullName').text(FullName)
    $('.boxShowInfo .PhoneNumber').text(PhoneNumber)
    $('.boxShowInfo .GPLX').text(GPLX)
    $('.boxShowInfo #DriverId').val(UserId)
    $('#userDriverList').removeClass('active');
    $('.boxShowInfo').show()
    $('.boxSelect').hide()
})

$('.btnDelete').click(function () {
    var UserVehicleId = $('#UserVehicleId').val();
    $('.boxShowInfo').hide()
    // $('#userDriverList').hide()
    $('.boxSelect').show()
    $('#DriverId').val(0)
    if(UserVehicleId > 0) {
        $.ajax({
            type: "POST",
            url: $('#deleteUserVehicle').val(),
            data: {
                UserVehicleId:UserVehicleId
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                $('#UserVehicleId').val(0);
                showHistoryDriver()
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
    }
})

showHistoryDriver()
function showHistoryDriver() {
    var VehicleId = $('#VehicleEditId').val()
    $.ajax({
        type: "POST",
        url: $('#getListHistoryUrl').val(),
        data: {
            VehicleId:VehicleId
        },
        success: function (response) {
            $('.boxShowHistoryDriver').html(response)
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}