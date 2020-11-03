var panelCustomer = $('#panelCustomer');
var pageIdCustomer = $('input#pageIdCustomer');
var statusSearch = null;
$('#txtSearchCustomer').click(function(e) {
    e.stopPropagation();
    if (panelCustomer.hasClass('active')) {
        panelCustomer.removeClass('active');
        panelCustomer.find('panel-body').css("width", "99%");
    } else {
        panelCustomer.addClass('active');
        setTimeout(function() {
            panelCustomer.find('panel-body').css("width", "100%");
            $('.wrapper').addClass('open-search-customer');
        }, 100);
        pageIdCustomer.val('1');
    }
});

$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true
});

$('#showModalVehicle').click(function() {
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
    $('.boxInfo').hide()
    $('.boxSearch').show()
    $('.btnShơwModal').hide()
    $('.btnHideModal').show()
    $('#btnEditVehicle').hide()
    $('.btnShowAdd').hide()
    $('.btnHideAdd').show()
})


var vehicleId = $("input#vehicleId").val();
var tags = [];
var inputTag = $('input#tags');
inputTag.tagsInput({
    'width': '100%',
    'height': '50px',
    'interactive': true,
    'defaultText': '',
    'onAddTag': function(tag) {
        tags.push(tag);
    },
    'onRemoveTag': function(tag) {
        var index = tags.indexOf(tag);
        if (index >= 0) tags.splice(index, 1);
    },
    'delimiter': [',', ';'],
    'removeWithBackspace': true,
    'minChars': 0,
    'maxChars': 0
});
$('#btnUpdateTag').click(function() {
    if (tags.length > 0) {
        var btn = $(this);
        btn.prop('disabled', true);
        $.ajax({
            type: "POST",
            url: $('input#updateItemTagUrl').val(),
            data: {
                ItemIds: JSON.stringify([vehicleId]),
                TagNames: JSON.stringify(tags),
                ItemTypeId: $("input#itemTypeId").val(),
                ChangeTagTypeId: 1
            },
            success: function(response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                btn.prop('disabled', false);
            },
            error: function(response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                btn.prop('disabled', false);
            }
        });
    } else showNotification('Vui lòng chọn nhãn', 0);
});

$('#btnInsertComment1').click(function() {
    var comment = $('input#comment1').val().trim();
    if (comment != '') {
        var btn = $(this);
        btn.prop('disabled', true);
        $.ajax({
            type: "POST",
            url: $('input#insertCommentUrl').val(),
            data: {
                ItemId: vehicleId,
                Comment: comment,
                ItemTypeId: $("input#itemTypeId").val(),
            },
            success: function(response) {
                var json = $.parseJSON(response);
                if (json.code == 1) {
                    $('div#listComment1').prepend(genItemComment(comment));
                    $('input#comment1').val('');
                }
                showNotification(json.message, json.code);
                btn.prop('disabled', false);
            },
            error: function(response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                btn.prop('disabled', false);
            }
        });
    } else {
        showNotification('Vui lòng nhập ghi chú', 0);
        $('input#comment1').focus();
    }
});


$('#ulListCustomers ').on('click', 'li', function() {
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
    $('.boxInfo').show()
    $('.boxSearch').hide()
    $('.btnShơwModal').show()
    $('.btnHideModal').hide()
    panelCustomer.removeClass('active');
    $('.btnShowAdd').show()
    $('.btnHideAdd').hide()
})

$('#btnDeleteUser').click(function() {
    $('.boxInfo').hide()
    $('.boxSearch').show()
    $('.btnShơwModal').hide()
    $('.btnHideModal').show()
    $('#btnEditVehicle').hide()
    $('.btnShowAdd').hide()
    $('.btnHideAdd').show()
    $('#UserId').val('')
})


$('.btnUpdateVehicle').click(function() {
    var dataId = $(this).attr('data-id') ? $(this).attr('data-id') : 1;
    if (dataId == 1) {
        updateTab1()
    }
    if (dataId == 4) {
        updateTab4()
    }
    if (dataId == 5) {
        updateTab5()
    }
    if (dataId == 7) {
        updateTab7()
    }
})

function updateTab7() {
    var FuelLevel = $('#FuelLevel').val()
    var VehicleId = $('#VehicleEditId').val()
    if (FuelLevel <= 0) {
        showNotification('Vui lòng nhập mức tiêu hao nhiên liệu', 0);
        return false
    }
    $.ajax({
        type: "POST",
        url: $('#updateFuelLevelVehicle').val(),
        data: {
            FuelLevel: FuelLevel,
            VehicleId: VehicleId
        },
        success: function(response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

function updateTab4() {
    var UserId = $('#DriverId').val()
    var VehicleId = $('#VehicleEditId').val()
    if (UserId <= 0) {
        showNotification('Vui lòng chọn lái xe', 0);
        return false
    }
    $.ajax({
        type: "POST",
        url: $('#updateUserVehicle').val(),
        data: {
            UserId: UserId,
            VehicleId: VehicleId
        },
        success: function(response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            $('#UserVehicleId').val(json.UserVehicleId)
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

function updateTab5() {
    var dataCB = getDataCB()
    var DeviceId = $('#DeviceId').val()
    var DeviceSensorId = $('#DeviceSensorId').val() ? $('#DeviceSensorId').val() : 0;
    if (DeviceId == 0 && DeviceSensorId == 0) {
        return false
    }
    var dataDeviceSensor = {
        DeviceId: $('#DeviceId').val(),
        Comment: $('#Comment').val(),
        VehicleId: $('#VehicleEditId').val(),
        DeviceSensorId: $('#DeviceSensorId').val() ? $('#DeviceSensorId').val() : '0',
        dataCB: dataCB
    }
    $.ajax({
        type: "POST",
        url: $('#urlDeviceSensor').val(),
        data: dataDeviceSensor,
        success: function(response) {
            var json = $.parseJSON(response);
            if (json.code == 0) {
                showNotification(json.message, json.code);
            } else {
                showNotification(json.message, json.code);
                showItem()
            }
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

function showItem() {
    $.ajax({
        type: "POST",
        url: $('#urlShowInfoInsert').val(),
        data: {
            VehicleId: $('#VehicleEditId').val()
        },
        success: function(response) {
            $('.boxAddNewCB').hide()
            $('.SensorData').html('')
            $('.boxData').hide()
            $('.boxNoData').show()
            $('.boxDeviceShowInsert').html(response)
            showListDataSensor()
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

function getDataCB() {
    var dataAll = []
    $('.boxCBItem').each(function() {
        var TypeFunctionId = $(this).find('.TypeFunctionId').val()
        var dataTB = []
        if (TypeFunctionId == 5) {
            $(this).find('.TBCB .rowValue').each(function() {
                var item = {
                    voltage: $(this).find('.voltage').val(),
                    oil: $(this).find('.oil').val()
                }
                dataTB.push(item)
            })
            var item1 = $(this).find('#Consumption').val();
        }
        var data = {
            SensorId: $(this).find('.sensorList').val(),
            SensorFunctionId: $(this).find('.TypeFunctionId').val(),
            SensorPort: $(this).find('.listPort').val(),
            IsRevert: $(this).find('.InputOnOff').val() ? $(this).find('.InputOnOff').val() : 0,
            LookupTable: dataTB,
            Consumption: item1
        }
        dataAll.push(data)
    })
    return dataAll
}

function updateTab1() {
    var UserId = $('#userId').val()
    var FuelLevel = $('#FuelLevel').val()
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
    if (LicensePlate == '') {
        showNotification('Biển số xe không được để trống', 0);
        $('#LicensePlate').focus()
        return false
    }
    if((VehicleTypeId == 1) || (VehicleTypeId == 2) || (VehicleTypeId == 3) || (VehicleTypeId == 4) || (VehicleTypeId == 5)){
        LicensePlate = replaceLicensePlate(LicensePlate);
        var check = checkFormatLicensePlate();
        if (!check) {
            showNotification('Định dạng xe chưa đúng, vui lòng nhập lại', 0);
            $('#LicensePlate').focus();
            return false;
        }
    }
    var data = {
        vehicles: {
            UserId: UserId,
            FuelLevel: FuelLevel,
            PurposeId: PurposeId,
            LicensePlate: LicensePlate,
            ProvinceId: ProvinceId,
            RegistryCycle: RegistryCycle ? RegistryCycle : 0,
            VIN: VIN,
            TonnageId: TonnageId,
            LastRegistryDate: LastRegistryDate,
            VehicleTypeId: VehicleTypeId,
            VehicleManufacturerId: VehicleManufacturerId,
            VehicleModelId: VehicleModelId,
            VehicleKindName: VehicleKindName,
            VehicleId: VehicleEditId
        }
    }
    $.ajax({
        type: "POST",
        url: $('#urlSaveVehicle').val(),
        data: data,
        success: function(response) {
            var json = $.parseJSON(response);
            if (json.code == 0) {
                $('#' + json.field).focus()
                $('#' + json.field).val('')
                showNotification(json.message, json.code);
            } else {
                showNotification(json.message, json.code);
                var ele = '<option value="' + json.VehicleId + '">' + json.LicensePlate + '</option>'
                if (VehicleEditId > 0) {
                    $('#VehicleId option[value="' + VehicleEditId + '"]').remove()
                } else {
                    resetTable();
                }
                $('#VehicleId').append(ele)
                $('#VehicleId').val(json.VehicleId);
                $('#btnEditVehicle').show()
                $('#panelLicensePlates').modal('hide')
            }
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

var VehicleId = $('#VehicleEditId').val()
if (VehicleId > 0) {
    $.ajax({
        type: "POST",
        url: $('#urlGetVehicle').val(),
        data: {
            VehicleId: VehicleId
        },
        success: function(response) {
            var json = $.parseJSON(response);
            $('#VehicleEditId').val(VehicleId)
            $('#ProvinceId').val(json.ProvinceId)
            $('#LastRegistryDate').val(json.LastRegistryDate)
            $('#RegistryCycle').val(json.RegistryCycle)
            $('#VIN').val(json.VIN)
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
            $('#VehicleTypeId').val(json.VehicleTypeId)
            checkLicensePlate(json.VehicleTypeId,json.LicensePlate)
            $('#panelLicensePlates').modal('show')
        },
        error: function(response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

$('#VehicleTypeId').change(function() {
    var VehicleTypeId = $(this).val();
    var VehicleId = $('#vehicleId').val();
    $('#LicensePlate').val('');
    $.ajax({
        type: "POST",
        url: "Vehicle/showTonage",
        data: { VehicleTypeId: VehicleTypeId ,
            VehicleId:VehicleId
        },
        success: function(response) {
            var json = $.parseJSON(response);
            $('#TonnageId').html(json);
        }
    });
})

$('body').on('change', '#LicensePlate', function() {
    var value = $(this).val()
    var value = value.replace(/[^a-z0-9\s]/gi, '')
    var type = $('#VehicleTypeId').val()
    if (type == 0) {
        showNotification('Vui lòng chọn chủng loại xe', 0);
        $('#LicensePlate').val('')
        $('#VehicleTypeId').focus()
        return false
    }
    if (type == 1) {
        if (value.length == 8 || value.length == 9) {
            if (!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                if (!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6]) && !isNaN(value[7])) {
                    if (value.length == 8) {
                        var text = value[0] + value[1] + value[2] + value[3] + '-' + value[4] + value[5] + value[6] + value[7]
                        $(this).val(text.toUpperCase())
                    } else if (!isNaN(value[8])) {
                        var text = value[0] + value[1] + value[2] + value[3] + '-' + value[4] + value[5] + value[6] + '.' + value[7] + value[8]
                        $(this).val(text.toUpperCase())
                    }
                }
            }
        }
    } else {
        if (value.length == 7 || value.length == 8) {
            if (!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                if (!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6])) {
                    if (value.length == 7) {
                        var text = value[0] + value[1] + value[2] + '-' + value[3] + value[4] + value[5] + value[6]
                        $(this).val(text.toUpperCase())
                    } else if (!isNaN(value[7])) {
                        var text = value[0] + value[1] + value[2] + '-' + value[3] + value[4] + value[5] + '.' + value[6] + value[7]
                        $(this).val(text.toUpperCase())
                    }
                }
            }
        }
    }
})
$('body').on('click','.userDriverShowList',function(){
    getuserDriverList();
}).on('click','.panel-footer button',function(){
    var searchText = $('#seachText').val();
    var pagination = $(this).attr('data-pagination');
    getuserDriverList(searchText,pagination);
}).on('keypress','#seachText' ,function(){
    var searchText = $('#seachText').val();
    getuserDriverList(searchText);
}).on('click','.tab-vehicle li a',function(){
    var id = $(this).data('id');
    $('.tab-vehicle li').removeClass('active');
    $('.tab-vehicle-content>.tab-pane').removeClass('active');
    $(this).parent().addClass('active');
    $(id).addClass('active');
});
function getuserDriverList(searchText = '',pagination = 0 ){
    $.ajax({
        type: "POST",
        url: $('#getListUserDrivers').val(),
        data: {
            SearchText: searchText,
            Pagination: pagination 
        },
        success: function (response) {
            $('#userDriverList').html(response);
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

}