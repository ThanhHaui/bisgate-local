// var panelCustomer = $('#panelCustomer');
// var pageIdCustomer = $('input#pageIdCustomer');
// var statusSearch = null;
// $('#txtSearchCustomer').click(function (e) {
//     e.stopPropagation();
//     if (panelCustomer.hasClass('active')) {
//         panelCustomer.removeClass('active');
//         panelCustomer.find('panel-body').css("width", "99%");
//     } else {
//         panelCustomer.addClass('active');
//         setTimeout(function () {
//             panelCustomer.find('panel-body').css("width", "100%");
//             $('.wrapper').addClass('open-search-customer');
//         }, 100);
//         pageIdCustomer.val('1');
//     }
// });
// $(window).click(function (e) {
//     var search = $('#panelCustomer');
//     var pageIdCustomer = $('input#pageIdCustomer');
//     if (search.has(e.target).length == 0 && !search.is(e.target) && pageIdCustomer.has(e.target).length == 0 && !pageIdCustomer.is(e.target)) {
//         search.removeClass('active');
//         search.find('panel-body').css("width", "99%");
//     }
// });
$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
});

$(document).ready(function(){
    $("body").on('click', '#ulListCustomers li', function(){
        $('#VehicleId').removeAttr('disabled')
              var FullName = $(this).find('#FullName').text()
        var PhoneNumber = $(this).find('#PhoneNumber').text()
        var Address = $(this).find('#Address').text()
        var UserCode = $(this).find('#UserCode').text()
        var UserId = $(this).attr('data-id')
        $('.boxInfo .FullName').text(FullName)
        $('.boxInfo .PhoneNumber').text(PhoneNumber)
        $('.boxInfo .Address').text(Address)
        $('.boxInfo .UserCode').text(UserCode)
        $('.boxInfo #UserId').val(UserId)
    });

    $("#VehicleId").select2({
        placeholder: "---Danh sách xe--",
        allowClear: true,
        ajax: {
            url: $("input#urlVehicleInUser").val(),
            type: 'POST',
            dataType: 'json',
            delay:250,
            data: function(data) {
                var userId = parseInt($("#userId").val());
                console.log(userId)
                return {
                    UserId: userId,
                    SearchText: data.term,
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.LicensePlate,
                            id: item.VehicleId,
                            data: item
                        };
                        
                    }),
                };
            }
        }
    });
    // $('#ulListCustomers ').on('click', 'li', function() {
    //     console.log("=============")
    // //     var FullName = $(this).find('#FullName').text()
    // //     var PhoneNumber = $(this).find('#PhoneNumber').text()
    // //     var Address = $(this).find('#Address').text()
    // //     var UserCode = $(this).find('#UserCode').text()
    // //     var UserId = $(this).attr('data-id')
    // //     $('.boxInfo .FullName').text(FullName)
    // //     $('.boxInfo .PhoneNumber').text(PhoneNumber)
    // //     $('.boxInfo .Address').text(Address)
    // //     $('.boxInfo .UserCode').text(UserCode)
    // //     $('.boxInfo #UserId').val(UserId)
    // //     $('.boxInfo').show()
    // //     $('.boxSearch').hide()
    // //     $('.btnShơwModal').show()
    // //     $('.btnHideModal').hide()
        
    // //     panelCustomer.removeClass('active');
        
    // })
})

$('.btnAddVehicle').click(function() {
    $('#VehicleEditId').val(0)
    $('#LicensePlate').val('')
    $('#ProvinceId').val('0')
    $('#LastRegistryDate').val('')
    $('#RegistryCycle').val('')
    $('#VIN').val('')
    $('#VehicleTypeId').val('0')
    $('#TonnageId').val('0')
    $('#VehicleManufacturerId').val('0')
    $('#VehicleKindName').val('')
    $('#VehicleModelId').val('0')
    $('#panelLicensePlates').modal('show')
    $('.btnUpdateVehicle').text('Tạo mới xe')
    $('#VehicleTypeId').trigger('change');
    $('#ProvinceId').trigger('change');
    $('#TonnageId').trigger('change');
    $('#VehicleManufacturerId').trigger('change');
    $('#VehicleModelId').trigger('change');
    $('#VehicleKindId').trigger('change');
})

$('#btnDeleteUser').click(function() {
    $('.boxInfo').hide()
    $('.boxSearch').show()
    $('.btnShơwModal').hide()
    $('.btnHideModal').show()
    $('#VehicleId').html('<option value="">--Chọn từ danh sách xe đang có --</option>')
    $('#VehicleId').attr('disabled', true)
    $('#btnEditVehicle').hide()
    checkShowBtnContinue()
})

$('#VehicleId').change(function() {
    var value = $(this).val()
    $('#btnEditVehicle').hide()
    if(value !== '') {
        $('#btnEditVehicle').show()
    }
    checkShowBtnContinue()
})

$('#IMEI').change(function() {
    var IMEI = $('#IMEI').val()
    var DeviceTypeId = $('#DeviceTypeId').val()
    var UrlCheckExist = $('#UrlCheckExist').val()
    var data = {
        type:'IMEI',
        IMEI:IMEI,
        DeviceTypeId:DeviceTypeId
    }
    if(IMEI !== '') {
        callApi(data, UrlCheckExist)
    }
    checkShowBtnContinue()
})

$('#SeriSim').change(function() {
    var SeriSim = $('#SeriSim').val()
    var UrlCheckExist = $('#UrlCheckExist').val()
    var data = {
        type:'sim',
        SeriSim:SeriSim
    }
    if(SeriSim !== '') {
        callApi(data, UrlCheckExist)
    }
    checkShowBtnContinue()
})

$('#DeviceTypeId').change(function() {
    $('#IMEI').val('')
    $('.box-append').html('')
    checkShowBtnContinue()
})

function callApi(data, url) {
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 0) {
                $('#'+json.field).focus()
                $('#'+json.field).val('')
                showNotification(json.message, json.code);
            } else if(data.type == 'sim') {
                $('#SimId').val(json.id)
            } else {
                $('#DeviceId').val(json.id)
            }
            checkShowBtnContinue()
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

$('.btnUpdateVehicle').click(function() {
    var UserId = $('#userId').val()
    var PurposeId = $('#purposeId').val()
    var VehicleEditId = $('#VehicleEditId').val()
    var LicensePlate = $('#LicensePlate').val()
    var ProvinceId = $('#ProvinceId').val()
    var LastRegistryDate = $('#LastRegistryDate').val()
    var RegistryCycle = $('#RegistryCycle').val()
    var VIN = $('#VIN').val()
    var VehicleTypeId = $('#VehicleTypeId').val()
    var TonnageId = $('#TonnageId').val()
    var VehicleManufacturerId = $('#VehicleManufacturerId').val()
    var VehicleKindName = $('#VehicleKindName').val()
    var VehicleModelId = $('#VehicleModelId').val()
    if(LicensePlate == '') {
        showNotification('Biển số xe không được để trống', 0);
        $('#LicensePlate').focus()
        return false
    }
    var data = {
        vehicles: {
            UserId:UserId,
            PurposeId:PurposeId,
            LicensePlate:LicensePlate,
            ProvinceId:ProvinceId,
            RegistryCycle:RegistryCycle ? RegistryCycle : 0,
            VIN:VIN,
            TonnageId:TonnageId,
            LastRegistryDate:LastRegistryDate,
            VehicleTypeId:VehicleTypeId,
            VehicleManufacturerId:VehicleManufacturerId,
            VehicleModelId:VehicleModelId,
            VehicleKindName:VehicleKindName,
            VehicleId:VehicleEditId
        }
    }

    $.ajax({
        type: "POST",
        url: $('#urlSaveVehicle').val(),
        data: data,
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 0) {
                $('#'+json.field).focus()
                $('#'+json.field).val('')
                showNotification(json.message, json.code);
            } else {
                showNotification(json.message, json.code);
                var ele = '<option value="'+json.VehicleId+'">'+json.LicensePlate+'</option>'
                if(VehicleEditId > 0) {
                    $('#VehicleId option[value="'+VehicleEditId+'"]').remove()
                }
                $('#VehicleId').append(ele)
                $('#VehicleId').val(json.VehicleId);
                $('#btnEditVehicle').show()
                $('#panelLicensePlates').modal('hide')
                checkShowBtnContinue()
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

})

$('#btnEditVehicle').click(function() {
    var VehicleId = $('#VehicleId').val()
    $('.btnUpdateVehicle').text('Cập nhật')
    $.ajax({
        type: "POST",
        url: $('#urlGetVehicle').val(),
        data: {
            VehicleId:VehicleId
        },
        success: function (response) {
            var json = $.parseJSON(response);
            $('#VehicleEditId').val(VehicleId)
            $('#ProvinceId').val(json.ProvinceId)
            $('#LastRegistryDate').val(json.LastRegistryDate)
            $('#RegistryCycle').val(json.RegistryCycle)
            $('#VIN').val(json.VIN)
            $('#VehicleTypeId').val(json.VehicleTypeId)
            $('#TonnageId').val(json.TonnageId)
            $('#VehicleManufacturerId').val(json.VehicleManufacturerId)
            $('#VehicleKindName').val(json.VehicleKindName)
            $('#VehicleModelId').val(json.VehicleModelId)
            $('#VehicleTypeId').trigger('change');
            $('#ProvinceId').trigger('change');
            $('#TonnageId').trigger('change');
            $('#VehicleManufacturerId').trigger('change');
            $('#VehicleModelId').trigger('change');
            $('#VehicleKindId').trigger('change');
            $('#LicensePlate').val(json.LicensePlate)
            $('#panelLicensePlates').modal('show')
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
})

function checkShowBtnContinue() {
    var VehicleId = $('.tab1 #VehicleId').val()
    var DeviceTypeId = $('.tab1 #DeviceTypeId').val()
    var IMEI = $('.tab1 #IMEI').val()
    var SeriSim = $('.tab1 #SeriSim').val()
    if(VehicleId == '' || DeviceTypeId == '' || IMEI == '' || SeriSim == '') {
        $('.tab1 .btnActive').hide()
        $('.tab1 .btnNone').show()
    } else {
        $('.tab1 .btnActive').show()
        $('.tab1 .btnNone').hide()
        $('.breacrumb ul li').removeClass('active')
        $('.breacrumb ul li:nth-child(1)').addClass('active')
    }
}

$('.btnActive').click(function() {
    $('.tab1').hide()
    $('.tab2').show()
    $('.breacrumb ul li').removeClass('active')
    $('.breacrumb ul li:nth-child(2)').addClass('active')
    var textXe = $("#VehicleId option:selected").html()
    var textDeviceType = $("#DeviceTypeId option:selected").html()
    $('.textXe').text(textXe)
    $('.textDeviceType').text(textDeviceType)
    DeviceTypeId = $('#DeviceTypeId').val() ? $('#DeviceTypeId').val() : 1
})

$('.btnBack1').click(function() {
    $('.tab').hide()
    $('.tab1').show()
    $('.breacrumb ul li').removeClass('active')
    $('.breacrumb ul li:nth-child(1)').addClass('active')
})

$('.btnBack2').click(function() {
    $('.tab').hide()
    $('.tab2').show()
    $('.breacrumb ul li').removeClass('active')
    $('.breacrumb ul li:nth-child(2)').addClass('active')
})

$('.btnBack3').click(function() {
    window.location.href = $('#urlSettingList').val()
})
$(document).ready(function () {
    // $(".search-data input").keyup(function () {
    //     var val = $(this).val();
    //     if (val != '') {
    //         $('.pCustomerName span:not(:contains(' + val + '))').closest('li').hide();
    //         $('.pCustomerName span:contains(' + val + ')').closest('li').show();
    //     } else {
    //         $('.pCustomerName span').closest('li').show();
    //     }
    // });
    var tags = [];
    var inputTag = $('input#tags');
    inputTag.tagsInput({
        'width': '100%',
        'interactive': true,
        'defaultText': '',
        'onAddTag': function(tag){
            tags.push(tag);
        },
        'onRemoveTag': function(tag){
            var index = tags.indexOf(tag);
            if(index >= 0) tags.splice(index, 1);
        },
        'delimiter': [',', ';'],
        'removeWithBackspace': true,
        'minChars': 0,
        'maxChars': 0
    });
    $('input.tagName').each(function(){
        inputTag.addTag($(this).val());
    });
    $('#ulTagExist').on('click', 'a', function(){
        var tag = $(this).text();
        if(!inputTag.tagExist(tag)) inputTag.addTag(tag);
    });
});

$('body').on('change', '#VehicleTypeId', function() {
    var VehicleTypeId = $(this).val()
    $('#LicensePlate').val('')
})

$('body').on('change', '#LicensePlate', function() {
    var value = $(this).val()
    var value = value.replace(/[^a-z0-9\s]/gi, '')
    var type = $('#VehicleTypeId').val()
    if(type == 0) {
        showNotification('Vui lòng chọn chủng loại xe', 0);
        $('#LicensePlate').val('')
        $('#VehicleTypeId').focus()
        return false
    }
    if(type == 1) {
        if(value.length == 8 || value.length == 9) {
            if(!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                if(!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6]) && !isNaN(value[7])) {
                    if(value.length == 8) {
                        var text = value[0] + value[1] + value[2] + value[3] + '-' + value[4] + value[5] + value[6] + value[7]
                        $(this).val(text.toUpperCase())
                    } else if(!isNaN(value[8])) {
                        var text = value[0] + value[1] + value[2] + value[3] + '-' + value[4] + value[5] + value[6] + '.' + value[7] + value[8]
                        $(this).val(text.toUpperCase())
                    }
                }
            }
        }
    } else {
        if(value.length == 7 || value.length == 8) {
            if(!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                if(!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6])) {
                    if(value.length == 7) {
                        var text = value[0] + value[1] + value[2] + '-' + value[3] + value[4] + value[5] + value[6]
                        $(this).val(text.toUpperCase())
                    } else if(!isNaN(value[7])) {
                        var text = value[0] + value[1] + value[2] + '-' + value[3] + value[4] + value[5] + '.' + value[6]  + value[7]
                        $(this).val(text.toUpperCase())
                    }
                }
            }
        }
    }
})