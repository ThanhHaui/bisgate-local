$("body").on('click', '#removeSslCart', function () {
    var html = $('.img-html').html();
    var vehicleId = $(this).attr('data-vehicleId');
    var sslvehiclelogId = $(this).attr('data-sslvehiclelog');
    var statuss = $(this).attr('data-statuss');
    var sslId = $(this).data('ssl');
    $('#btnYesOrNo').html('');
    $('#btnYesOrNo').CeoSlider({
        lable_right: 'GỠ',
        lable_left: 'KHÔNG GỠ',
        lable_yes: 'Buông chuột để GỠ',
        lable_no: 'Buông chuột để KHÔNG GỠ',
        success: function (data) {
            removeSSL(sslId, vehicleId, html, sslvehiclelogId);
            return false;
        },
        error: function (data) {
            // xử lý KHÔNG DUYỆT
        }
    });
    $("#modalRemoveSslCart").modal('show');

    return false;
});
$("body").on('click', '.show-sslVehicleLog', function () {
    var id = $(this).attr('data-sslVehicleLogId');
    $(id).addClass('active');
    $('.push-img').not($(id)).removeClass('active');
});
$("body").on('click', '#btnShowModalSSL', function () {
    var userId = $('#userId').val();
    $.ajax({
        type: "POST",
        url: $("input#urlShowModalSSL").val(),
        data:{UserId:userId},
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1) {
                var html = '';
                var labelCss = json.labelCss;
                $.each(json.data, function (i, item) {
                    var text = '';
                    if (item.SSLStatusId == 1) {
                        text = 'Chờ active'
                    } else if (item.SSLStatusId == 2) {
                        text = 'Bình thường'
                    } else if (item.SSLStatusId == 4) {
                        text = 'Đang hết hạn'
                    }
                    else if (item.SSLStatusId == 3) {
                        text = 'Đang tạm cắt'
                    } else if (item.SSLStatusId == 5) {
                        text = 'Đã dừng dịch vụ'
                    }
                    html += `
                    <tr>
                    <td><input class="checkTran iCheckTableSSL iCheckItem" ssl-id="${item.SSLId}" ssl-code="${item.SSLCode}" extension="${item.Extension}" license-plate="${item.LicensePlate}" type="checkbox" value="${item.SSLId}" package-ids='${JSON.stringify(item.ssldetail)}' data-status="${item.SSLStatusId}"></td>
                    <td>${item.SSLCode}</td>
                    <td><span class="${labelCss[item.SSLStatusId]}">${text}</span></td>
                    </tr>
                    `;
                });
                $("#tbodySSL").html(html);
                var arrPackages = [];
                $('input.iCheckTableSSL').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
                $("#modalShowListSSL").modal('show');
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
    return false;
}).on('click', '#btnAddSSL', function () {
    var vehicleId = $(this).attr('data-vehicleId');
    var sslvehiclelogId = $(this).attr('data-sslvehiclelog');
    var statuss = $(this).attr('data-statuss');
    var arrPackages = [];
    $('input.iCheckTableSSL').each(function () {
        if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) {
            arrPackages.push({
                PackageId: $(this).val(),
                PackageName: $(this).parent().parent().parent().find('td').eq(2).text().trim(),
            });
        }
    });
    if (arrPackages.length > 1) {
        showNotification('Mã thuê bao SSL chỉ được chọn 1 gói duy nhất. Vui lòng chọn lại!', 0);
        return false;
    } else if (arrPackages.length == 0) {
        showNotification('Vui lòng chọn mã thuê bao SSL.', 0);
        return false;
    }
    var html = $('.img-html-add').html();
    var id = arrPackages[0].PackageId;
    if (id > 0 && vehicleId > 0) {
        $.ajax({
            type: "POST",
            url: $("input#urlAddSSLVehice").val(),
            data: {
                html: html,
                statuss: statuss,
                sslvehiclelogId: sslvehiclelogId,
                Id: id,
                VehicleId: vehicleId
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if (json.code == 1) {
                    redirect(true, '');
                }
                $(this).prop('disabled', false);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                $('.submit').prop('disabled', false);
            }
        });
    }
}).on('click', '#tabSSL_2', function () {
    var vehicleId = $(this).attr('data-vehicleId');
    var sslvehiclelogId = $(this).attr('data-sslvehiclelog');
    var statuss = $(this).attr('data-statuss');
    var id = $(this).attr('data-sslId');
    var html = $('.img-html-add').html();
    if (id > 0 && vehicleId > 0) {
        $.ajax({
            type: "POST",
            url: $("input#urlAddSSLVehice").val(),
            data: {
                html: html,
                sslvehiclelogId: sslvehiclelogId,
                statuss: statuss,
                Id: id,
                VehicleId: vehicleId
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if (json.code == 1) {
                    redirect(true, '');
                    $('[href="#tab_6"]').click();
                    // browser.tabs.reload({bypassCache: true});
                }
                $(this).prop('disabled', false);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                $('.submit').prop('disabled', false);
            }
        });
    }
}).on('click', '.active_tabssl1', function () {
    $('#tab_6 .tabSSL_1').parent('li').addClass('active');
    $('#tabSSL_1').addClass('active');
    $('#tabSSL_2').removeClass('active');
    $('#tab_6 .tabSSL_2').parent('li').removeClass('active');
});


function removeSSL(sslId, vehicleId, html, sslvehiclelogId, statuss) {
    if (sslId > 0) {
        $.ajax({
            type: "POST",
            url: $("input#urlremoveSslCart").val(),
            data: {
                html: html,
                statuss: statuss,
                sslvehiclelogId: sslvehiclelogId,
                Id: sslId,
                VehicleId: vehicleId,
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if (json.code == 1) {
                    redirect(true, '');
                    $('[href="#tab_6"]').click();

                }
                $(this).prop('disabled', false);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                $('.submit').prop('disabled', false);
            }
        });
    } else showNotification('Có lỗi xảy ra, vui lòng thử lại.', 0);

}
