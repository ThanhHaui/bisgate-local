$(document).ready(function () {
    $('input.iCheckRadio').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
});

$('#SSLtypeId').change(function () {
    var SSLtypeId = $(this).val()
    $('.boxType').hide()
    if (SSLtypeId == 1) {

    } else if (SSLtypeId == 2) {
        $('.boxType2').show()
    } else {
        $('.boxType3').show()
    }
    updateShowHideActive()
})

$('.checkModule').click(function () {
    if ($(this).is(':checked')) {
        $('.moduleList').show()
    } else {
        $('.moduleList').find('.ActionId').prop('checked', false)
        $('.moduleList').hide()
    }
    updateShowHideActive()
})

$('.btnActivedNext').click(function () {
    $('.tab').hide()
    $('.tab4').show()
    $('.breacrumb ul li').removeClass('active')
    $('.breacrumb ul li:nth-child(4)').addClass('active')
})

$('.btnActived').click(function () {
    var userId = parseInt($("input#userId").val());
    var arrDatas = [];
    var countBase = $("#tbodyBase tr").length;
    var countDetail = $("#tbodySslDetails tr").length;
    if(countBase == 0 && countDetail == 0){
        showNotification('Vui lòng thêm Gói phần mềm base bắt buộc hoặc gói mở pm rộng.');
        return false;
    }

    var arrDeadlines = [];
    arrDeadlines.push({
        PackageId:$("#tbodyBase tr").attr('data-id'),
        PackagePrice: 0,
        ExpiryDate: 0,
    });


    var arrDeadlineDetails = [];
    $("#tbodySslDetails tr").each(function(){
        arrDeadlineDetails.push({
            PackageId: $(this).attr('data-id'),
            PackagePrice: 0,
            ExpiryDate: 0,
        });
    });

    var arrDeadlineSsls = [];
    $("#tbodySsl tr").each(function(){
        arrDeadlineSsls.push({
            SSLId: $(this).attr('data-id'),
        });
    });
    arrDatas.push({
        arrDeadlines: arrDeadlines,
        arrDeadlineDetails:arrDeadlineDetails,
        arrDeadlineSsls:arrDeadlineSsls
    });





    var dataSSL = getDataSSL();
    var dataCB = getDataCB();
    var dataDevice = getDataDevice();
    var VehicleDeviceId = $('#VehicleDeviceId').val();
    var data = {
        DeadlineStatusId: 2,
        UserId: userId,
        ArrDatas: JSON.stringify(arrDatas),


        dataSSL: dataSSL,
        dataCB: dataCB,
        dataDevice: dataDevice,
        VehicleDeviceId: VehicleDeviceId,
        SSLTypeId: $('#SSLtypeId').val(),
        IsModule: $('.checkModule').is(':checked') ? 1 : 0,
        SSLId: $('#SSLId').val(),
        IMEI: $('#IMEI').val(),
        SSLCode: $('#SSLCODE').val()
    }

    $.ajax({
        type: "POST",
        url: $('#urlSaveVehicleDevice').val(),
        data: {dataSetting: data,
            // data1:data1
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1) {
                $('.tab').hide()
                $('.tab4').show()
                $('.breacrumb ul li').removeClass('active')
                $('.breacrumb ul li:nth-child(4)').addClass('active')
                $('#VehicleDeviceId').val(json.VehicleDeviceId)
            } else {
                showNotification(json.message, 0);
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
})

$('.btnCheckCode').click(function () {
    var SSLCode = $('#SSLCODE').val()
    $('.messageError').text('')
    if (SSLCode == '') {
        $('.messageError').text('Vui lòng nhập Mã CODE SSL');
        $('#SSLCODE').focus()
        return false
    }
    showDataSSL(SSLCode, '')
    updateShowHideActive()
})

var SSLCode = $('#SSLCODE').val()
var SSLId = $('#SSLOldId').val()
if (SSLCode !== '') {
    showDataSSL(SSLCode, '')
}

if (SSLId > 0) {
    showDataSSL('', SSLId)
}

function showDataSSL(SSLCode, SSLId) {
    $.ajax({
        type: "POST",
        url: $('#UrlCheckCode').val(),
        data: {
            SSLCode: SSLCode,
            SSLId: SSLId
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1) {
                var dataNotModule = json.dataNotModule
                var dataModule = json.dataModule
                var SSLItem = json.SSLItem
                var checked = SSLItem.IsModule == 1 ? 'checked' : ''
                ele = '<div class="row mgbt-20">\n' +
                    '    <div class="col-sm-3">\n' +
                    '        <p class="mt-6 d-flex">Phần mềm GSHT bắt buộc*</p>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-6">\n' +
                    '        <div class="box-search-advance">\n' +
                    '            <div class="row">\n' +
                    '                <div class="col-sm-6">\n' +
                    '                    <p>' + dataNotModule.ItemName + '</p>\n' +
                    '                </div>\n' +
                    '                <div class="col-sm-6">\n' +
                    '                    <p>' + dataNotModule.Month + '</p>\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>'

                // ele += '<div class="row mgt-10">'
                // ele += '<div class="col-sm-3">'
                // ele += '<p><input type="checkbox" class="iCheckTable iCheckItem" ' + checked + ' disabled > Module mở rộng</p>'
                // ele += '</div>'
                // ele += '<div class="col-sm-6">'
                // ele += '<div class="check-input-hidden">'
                // ele += ' <div class="box-search-advance">'
                // if (dataModule.length > 0) {
                //     for (i = 0; i < dataModule.length; i++) {
                //         ele += '<div class="row mgbt-10">'
                //         ele += '<div class="col-sm-6">'
                //         ele += '<p>' + dataModule[i].ItemName + '</p>'
                //         ele += '</div>'
                //         ele += '<div class="col-sm-6">'
                //         ele += '<p>' + dataModule[i].Month + '</p>'
                //         ele += '</div>'
                //         ele += '</div>'
                //     }
                // } else {
                //     ele += '<p>Không có module nào</p>'
                // }
                // ele += '</div>'
                // ele += '</div>'
                // ele += '</div>'
                // ele += '</div>'
                if (SSLId > 0) {
                    $('.boxOld .showData').html(ele)
                } else {
                    $('#checkCode').val(1)
                    $('.boxNew .showData').html(ele)
                }
                updateShowHideActive()
            } else {
                if (SSLId <= 0) {
                    $('.boxNew .showData').html('')
                }
                $('#checkCode').val(0)
                $('.messageError').text(json.message);
                updateShowHideActive()
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}


function getDataDevice() {
    var UserId = $('#userId').val()
    var VehicleId = $('#VehicleId').val()
    var DeviceId = $('#DeviceId').val()
    var SimId = $('#SimId').val()
    var Comment = $('#Comment').val()
    return {
        UserId: UserId,
        VehicleId: VehicleId,
        DeviceId: DeviceId,
        SimId: SimId,
        SSLIsOld: $('#SSLIsOld').val(),
        Comment: Comment
    }
}

function getDataSSL() {
    var dataAll = []
    var item = {
        ItemId: $('.boxSoftWare').find('.ActionId').val(),
        Month: $('.boxSoftWare').find('.Month').val()
    }
    dataAll.push(item)
    if ($('.checkModule').is(':checked')) {
        $('.boxModule .boxItem').each(function () {
            if ($(this).find('.ActionId').is(':checked')) {
                var item = {
                    ItemId: $(this).find('.ActionId').val(),
                    Month: $(this).find('.Month').val(),
                    IsModule: 1
                }
                dataAll.push(item)
            }
        })
    }
    return dataAll
}

function getDataCB() {
    var dataAll = []
    $('.boxCBItem').each(function () {
        var TypeFunctionId = $(this).find('.TypeFunctionId').val()
        var dataTB = []
        if (TypeFunctionId == 5) {
            $(this).find('.TBCB .rowValue').each(function () {
                var item = {
                    voltage: $(this).find('.voltage').val(),
                    oil: $(this).find('.oil').val()
                }
                dataTB.push(item)
            })
        }
        var data = {
            SensorId: $(this).find('.sensorList').val(),
            SensorFunctionId: $(this).find('.TypeFunctionId').val(),
            SensorPort: $(this).find('.listPort').val(),
            IsRevert: $(this).find('.InputOnOff').val() ? $(this).find('.InputOnOff').val() : 0,
            LookupTable: dataTB
        }
        dataAll.push(data)
    })
    return dataAll
}

$("#btnUseSSL").on("ifChanged", function () {
    $('.boxOld').show()
    $('.boxNew').hide()
    $('.boxOld .showData').html('')
    $('#SSLIsOld').val(1)
    getListSSL()
    updateShowHideActive()
})

$("#btnSSLNew").on("ifChanged", function () {
    $('.boxOld').hide()
    $('.boxNew').show()
    $('#SSLIsOld').val(0)
    updateShowHideActive()
});

function getListSSL() {
    var UserId = $('#userId').val()
    $.ajax({
        type: "POST",
        url: $('#UrlGetListSSL').val(),
        data: {
            UserId: UserId
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1) {
                var SSLList = json.SSLList
                var ele = ''
                if (SSLList.length > 0) {
                    ele += '<option value="0">Chọn SSL trống trong danh sách</option>'
                    for (i = 0; i < SSLList.length; i++) {
                        var codeSSL = parseInt(SSLList[i].SSLId) + 10000
                        ele += '<option value="' + SSLList[i].SSLId + '">SSL-' + codeSSL + '</option>'
                    }
                } else {
                    ele += '<option>Không có SSL trống nào</option>'
                }
                $('#SSLId').html(ele)
            } else {
                $('.messageError').text(json.message);
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

$('#SSLId').change(function () {
    var SSLId = $(this).val()
    if (SSLId == 0) {
        showNotification('Vui lòng chọn SLL', 0);
        $('.boxOld .showData').html('')
        updateShowHideActive()
        return false
    }
    showDataSSL('', SSLId)
    updateShowHideActive()
})

$('.btnEnd').click(function () {
    $.ajax({
        type: "POST",
        url: $('#UrlUpdateVehicleDevice').val(),
        data: {
            VehicleDeviceId: $('#VehicleDeviceId').val(),
            StatusId: 2
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1) {
                var url = $('#SettingListUrl').val()
                location.href = url
            } else {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
})

$('.button-can').click(function () {
    $.ajax({
        type: "POST",
        url: $('#UrlUpdateVehicleDevice').val(),
        data: {
            VehicleDeviceId: $('#VehicleDeviceId').val(),
            StatusId: 0
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1) {
                var url = $('#SettingListUrl').val()
                location.href = url
            } else {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
})

function updateShowHideActive() {
    var SSLIsOld = $('#SSLIsOld').val()
    $('.btnNone3').hide()
    $('.btnActived').show()
    if (SSLIsOld == 1) {
        $('.btnActived.submit_update_ssl').text('Kích hoạt dịch vụ')
        var SSLId = $('#SSLId').val()
        if (SSLId <= 0) {
            $('.btnNone3').show()
            $('.btnActived').hide()
        }
    } else {
        $('.btnActived.submit_update_ssl').text('Kích hoạt 24h dịch vụ')
        var SSLtypeId = $('#SSLtypeId').val()
        if (SSLtypeId == 3) {
            var checkCode = $('.boxNew #checkCode').val() ? $('.boxNew #checkCode').val() : 0
            if (checkCode <= 0) {
                $('.btnNone3').show()
                $('.btnActived').hide()
            }
        }
    }
}

$("body").on('click', '.btnShowModalBase', function () {
    var isCheck = parseInt($(this).attr('data-id'));
    $("#btnAddPackage").attr('data-id', isCheck);
    var packageIds = [];
    var packageTypeId = 0;
    if (isCheck == 2) {
        packageTypeId = 2;
        $("#modalShowListPackages .modal-title").html('Danh sách gói phần mềm mở rộng');
        $("#tbodySslDetails tr").each(function () {
            packageIds.push($(this).attr('data-id'));
        });
        if (parseInt(sslId) > 0) {
            $("#tbodySslDetailsError tr").each(function () {
                packageIds.push($(this).attr('data-id'));
            });
        }
    }
    loadDataPackages(packageIds, '', packageTypeId);
}).on('click', '#tbodySslDetails .link_delete', function () {
    $(this).parent().parent().remove();
}).on('click', '#btnAddPackage', function () {
    var isCheck = parseInt($(this).attr('data-id'));
    var arrPackages = [];
    $('input.iCheckTable').each(function () {
        if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) {
            arrPackages.push({
                PackageId: $(this).val(),
                PackageName: $(this).parent().parent().parent().find('td').eq(2).text().trim(),
            });
        }
    });
    if (isCheck == 2) {
        showPackageBaseOrSslDetail(arrPackages, isCheck);
    }
}).on('click', '#tbodyBase .link_delete', function(){
    $('.submit_hide').removeClass('active');
    $("#totalBase").text(0);
    $(this).parent().parent().remove();
}).on('click', '#tbodySslDetails .link_delete', function(){
    var count = parseInt($("#totalSslDetail").text());
    $("#totalSslDetail").text(count - 1);
    $(this).parent().parent().remove();
});

function showPackageBaseOrSslDetail(packages, isCheck) {
    var sslId = parseInt($("input#sslId").val());
    if (isCheck == 1) {
        var html = '';
        if (sslId == 0) {
            html = `
                <tr data-id="${packages[0].PackageId}" check-add="0">
                    <td>1</td>
                    <td class="packageName">${packages[0].PackageName}  (dùng thử miễn phí một ngày)</td>
                    <td><a href="javascript:void(0)" class="link_delete" title="Xóa"><i class="fa fa-trash-o"></i></a></td>
                </tr>
            `;
        } else {
            html = `
                <tr data-id="${packages[0].PackageId}" check-add="0">
                    <td>1</td>
                    <td class="packageName">${packages[0].PackageName}  (dùng thử miễn phí một ngày)</td>
                    <td>---</td>
                </tr>
            `;
        }
        $("#tbodyBase").html(html);
    } else if (isCheck == 2) {
        var html = '';
        var count = $("#tbodySslDetails tr").length;
        if (sslId == 0) {
            $.each(packages, function (i, item) {
                count++;
                html += `<tr data-id="${item.PackageId}" check-add="0">
                            <td>${count}</td>
                            <td>${item.PackageName} (dùng thử miễn phí một ngày)</td>
                            <td><a href="javascript:void(0)" class="link_delete" title="Xóa"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                    `;
            });
        } else {

            $.each(packages, function (i, item) {
                count++;
                html += `<tr data-id="${item.PackageId}" check-add="0">
                        <td>${count}</td>
                        <td>${item.PackageName} (dùng thử miễn phí một ngày)</td>
                        <td>---</td>
                    </tr>
                `;
            });
        }
        $("#tbodySslDetails").append(html);
    }

    $('body').on('keydown', 'input.cost', function (e) {
        if (checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.cost', function () {
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    });
    if (isCheck == 1) $("#totalBase").text(1);
    else if (isCheck == 2) $("#totalSslDetail").text($("#tbodySslDetails tr").length);
    $("#modalShowListPackages").modal('hide');
}

function loadDataPackages(packageIds, searchText = '', packageTypeId) {
    $.ajax({
        type: "POST",
        url: $("input#urlGetPackages").val(),
        data: {
            IsCheck: 0,
            UserId: 0,
            PackageTypeId: packageTypeId,
            PackageIds: JSON.stringify(packageIds),
            SearchText: searchText
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1) {
                $('.submit_hide').addClass('active');
                var html = '';
                $.each(json.data, function (i, item) {
                    html += `
                        <tr>
                            <td><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="${item.PackageId}"></td>
                            <td>${item.PackageCode}</td>
                            <td>${item.PackageName}</td>
                        </tr>
                    `;
                });
                $("#tbodyPackages").html(html);
                $('input.iCheckTable').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
                $("span#total_package").text(json.data.length);
                $("#modalShowListPackages").modal('show');
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}
