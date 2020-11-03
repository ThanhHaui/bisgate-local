var sensorLine = $('#SensorLine').val()
var sensorLineArr = JSON.parse(sensorLine)
var TypeFunctionText = $('#TypeFunctionText').val()
TypeFunctionText = JSON.parse(TypeFunctionText)
var DeviceTypeId = $('#DeviceTypeEditId').val() ?  $('#DeviceTypeEditId').val() : ''
$('#DeviceTypeId').change(function () {
    DeviceTypeId = $(this).val()
    $('.boxCBItem').remove()
    $('#IMEI').val('')
    $('.boxData').hide()
    $('.boxNoData').show()
    AddDeleteSensor()
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
        $.ajax({
            type: "POST",
            url: UrlCheckExist,
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
                //AddDeleteSensor()
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
    }
    //AddDeleteSensor()
})

function AddDeleteSensor() {
    var IMEI = $('#IMEI').val()
    $('.DeviceCodeId').text(IMEI)
    if(IMEI !== '') {
        $('.modalHidden').hide()
        $('.modalShow').show()
    } else {
        $('.modalHidden').show()
        $('.modalShow').hide()
    }
}

$('body').on('click', '.btnShowEdit', function () {
    var textDeviceType = $("#DeviceTypeId option:selected").html()
    var DeviceTypeEditName = $('#DeviceTypeEditName').val() ? $('#DeviceTypeEditName').val() : ''
    $('.textDeviceType').text(textDeviceType)
    if(DeviceTypeEditName !== '') {
        $('.textDeviceType').text(DeviceTypeEditName)
    }
    $('#ModalEditSensor').modal('show')
})

$('body').on('click', '.add-sensors', function (e) {
    var sensorLineDevice = sensorLineArr[DeviceTypeId]
    var check = checkAddNew()
    if(check) {
        showNotification('Bạn chỉ được phép thao tác từng cảm biến. Vui lòng lưu lại trước khi tạo mới cảm biến', 0);
        return false
    }
    e.stopPropagation();
    var ele = ''
    ele += '<div class="row mgbt-10 boxCBItem">\n' +
        '            <div class="col-sm-3">\n' +
        '                <p class="box-name"><span class="boxNameCB"></span> <i class="fa fa-caret-down caret" aria-hidden="true"></i>\n' +
        '                </p>\n' +
        '            </div>\n' +
        '            <div class="col-sm-9">\n' +
        '                <div class="box-search-advance customer">\n' +
        '                    <div class="row mgbt-10 boxEdit">\n' +
        '                        <div class="col-sm-4">\n' +
        '                            <p class="mt-6 d-flex">Dòng cảm biến*</p>\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-8">\n' +
        '                            <select class="form-control sensorList" >\n' +
        '                                <option value="">--Chọn dòng cảm biến --</option>'

    $.each( sensorLineDevice, function( key, value ) {
        ele+='<option value="'+key+'">'+value.text+'</option>'
    });
    ele+=' </select>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    <div class="row boxEdit mgbt-10">\n' +
        '                        <div class="col-sm-4">\n' +
        '                            <p class="mt-6 d-flex">Loại chức năng cảm biến*</p>\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-8"><input type="hidden" value="0" class="checkSave"><input type="hidden" class="SensorId"><input type="hidden" class="FunctionId"><input type="hidden" class="Port"><input type="hidden" class="InputOnOff">\n' +
        '                            <select class="form-control TypeFunctionId">\n' +
        '                                <option value=""> --Chọn chức năng cảm biến --</option>\n' +
        '                            </select>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    <div class="row boxPort boxEdit mgbt-10">\n' +
        '                    </div>\n' +
        '                    <div class="row OnOff boxEdit mgbt-10">\n' +
        '                    </div>\n' +
        '                    <div class="row button">\n' +
        '                       <a href="javascript:void(0)" class="btn btn-danger btnDelete boxEdit">Xóa</a><a href="javascript:void(0)" class="btn btn-primary btnSave boxEdit">Lưu</a>\n' +
        '                    </div>\n' +
        '                    <div class="row boxShow" style="display: none">\n' +
        '                        <div class="col-sm-4">\n' +
        '                            <p class="mt-6 d-flex">Dòng cảm biến*</p>\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-6"><p class="textSensor">Dòng cảm biến a</p>\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-2"><a href="javascript:void(0)" class="btnEdit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                    <div class="row boxShow" style="display: none">\n' +
        '                        <div class="col-sm-4">\n' +
        '                            <p class="mt-6 d-flex">Loại chức năng cảm biến*</p>\n' +
        '                        </div>\n' +
        '                        <div class="col-sm-8"><p class="textFunction">Chức năng A</p>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '            </div>'
    $('.box-append').append(ele)
    updateName()
})

$('body').on('click', '.btnEdit', function() {
    var check = checkAddNew()
    if(check) {
        showNotification('Bạn chỉ được phép thao tác từng cảm biến. Vui lòng lưu lại trước khi sửa cảm biến', 0);
        return false
    }
    var parent = $(this).closest('.boxCBItem')
    $(parent).find('.checkSave').val(0)
    var SensorId = $(parent).find('.SensorId').val()
    var FunctionId = $(parent).find('.FunctionId').val()
    var Port = $(parent).find('.Port').val()
    var ListPort = sensorLineArr[DeviceTypeId][SensorId]['TypeFunctionId'][FunctionId]
    var portItem = ''
    portItem+='<div class="col-sm-4"><p class="mt-6 d-flex">Cách kết nối CB với thiết bị*</p></div>'
    portItem+='<div class="col-sm-8">'
    portItem+='<select class="form-control listPort" id="">'
    var portListEdit = getListPort(Port)
    var checkPort = false
    $.each( ListPort, function( key, value ) {
        if(portListEdit.indexOf(value) < 0) {
            checkPort = true
            if(Port == value) {
                portItem+='<option value="'+value+'" selected>'+value+'</option>'
            } else {
                portItem+='<option value="'+value+'">'+value+'</option>'
            }

        }
    });
    if(!checkPort) {
        portItem+='<option value="">Không còn port nào</option>'
    }
    portItem+='</select>'
    portItem+='</div>'
    $(parent).find('.boxPort').html(portItem)
    $(parent).find('.boxShow').hide()
    $(parent).find('.boxEdit').show()
})

function checkAddNew() {
    var check = false
    $('.boxCBItem').find('.checkSave').each(function() {
        var value = $(this).val()
        if(value == 0) {
            check = true
        }
    })
    return check
}

$('body').on('change', '.sensorList', function() {
    var parent = $(this).closest('.boxCBItem')
    var value = $(this).val()
    if(value == 0) {
        showNotification('Vui lòng chọn dòng cảm biến', 0);
        $(parent).find('.boxPort').html('')
        $(parent).find('.OnOff').html('')
        $(parent).find('.TypeFunctionId').html('<option>--Chọn chức năng cảm biến --</option>')
        return false
    }
    var TypeFunctionId = sensorLineArr[DeviceTypeId][value]['TypeFunctionId']
    var ele = ''
    $.each( TypeFunctionId, function( key, value ) {
        ele+='<option value="'+key+'">'+TypeFunctionText[key]+'</option>'
    });
    $(parent).find('.TypeFunctionId').html(ele)
    var TypeFunctionSelected =  $(parent).find('.TypeFunctionId').val()
    addTypeFunction(parent, TypeFunctionSelected)
})

$('body').on('change', '.TypeFunctionId', function() {
    var TypeFunctionSelected = $(this).val()
    var parent = $(this).closest('.boxCBItem')
    addTypeFunction(parent, TypeFunctionSelected)
})

function addTypeFunction(parent, TypeFunctionSelected) {
    var value = $(parent).find('.sensorList').val()
    var ListPort = sensorLineArr[DeviceTypeId][value]['TypeFunctionId'][TypeFunctionSelected]
    var portItem = ''
    portItem+='<div class="col-sm-4"><p class="mt-6 d-flex">Cách kết nối CB với thiết bị*</p></div>'
    portItem+='<div class="col-sm-8">'
    portItem+='<select class="form-control listPort" id="">'
    var portListEdit = getListPort(0)
    var checkPort = false
    $.each( ListPort, function( key, value ) {
        if(portListEdit.indexOf(value) < 0) {
            checkPort = true
            portItem+='<option value="'+value+'">'+value+'</option>'
        }
    });
    if(!checkPort) {
        portItem+='<option value="">Không còn port nào</option>'
    }
    portItem+='</select>'
    portItem+='</div>'
    $(parent).find('.boxPort').html(portItem)
    $(parent).find('.OnOff').html('')
    if(TypeFunctionSelected == 1 || TypeFunctionSelected == 2 || TypeFunctionSelected == 3) {
        eleCBXe=' <div class="col-sm-4"><p class="mt-6 d-flex">Cách kết nối CB với xe*</p></div>\n' +
            '        <div class="col-sm-8">\n' +
            '            <div class="row">\n' +
            '                <div class="col-sm-6"><p>Default</p>\n' +
            '                    <p>High - Bật; Low - Tắt</p></div>\n' +
            '                <div class="col-sm-6"><p><label class="setting_check"> <input type="checkbox"\n' +
            '                                                                              class="checkBoxItem"> <span\n' +
            '                                    class="checkmark"></span> </label> <span class="ml-40">Đảo</span></p>\n' +
            '                    <p>High - Tắt; Low - Bật</p></div>\n' +
            '            </div>\n' +
            '        </div>'
        $(parent).find('.OnOff').html(eleCBXe)
    } else if(TypeFunctionSelected == 5) {
        eleCBXe = '<div class="col-sm-4"><p class="mt-6 d-flex">Cách kết nối CB với xe*</p></div>'
        eleCBXe+='<div class="col-sm-8">'
        eleCBXe+='<div class="row">'
        eleCBXe+='<p>Bảng thư viện dải cảm biến Điện áp -Dầu của xe</p>'
        eleCBXe+='</div>'
        eleCBXe+='<div class="row">'
        eleCBXe+='<table class="table table-hover table-bordered TBCB">'
        eleCBXe+='<tr><td>Điện áp (Von)</td><td>Dầu (lít)</td><td><i class="fa fa-plus btnAddRow"></i></td></tr>'
        eleCBXe+='<tr class="rowValue" ><td><input type="text" class="form-control voltage"></td><td><input type="text" class="form-control oil"></td><td></td></tr>'
        eleCBXe+='</table>'
        eleCBXe+='</div>'
        eleCBXe+='</div>'
        eleCBXe+='           <div class="row  mgbt-10">\n' +
            '                            <div class="col-sm-4">\n' +
            '                                <p class="mt-6 d-flex">Thể tích thùng NL*</p>\n' +
            '                            </div>\n' +
            '                            <div class="col-sm-8">\n' +
            '                                <input type="number" class="form-control " id="Consumption" placeholder="" required>\n' +
            '                            </div>\n' +
            '                        </div>'
        $(parent).find('.OnOff').html(eleCBXe)
    }
}

function getListPort(port) {
    var portList = []
    $('body').find('.Port').each(function(){
        var value = $(this).val()
        if(value !== port) {
            portList.push(value)
        }
    })
    return portList;
}

function updateName() {
    var count = 1
    $('.boxCBItem').find('.boxNameCB').each(function() {
        $(this).text('Cảm biến '+count)
        count++
    })
}

$('body').on('click', '.btnSave', function() {
    var parent = $(this).closest('.boxCBItem')
    var SensorId = $(parent).find('.sensorList').val()
    var FunctionId = $(parent).find('.TypeFunctionId').val()
    var Port = $(parent).find('.listPort').val()
    if(SensorId == '') {
        showNotification('Vui lòng chọn dòng cảm biến', 0);
        $(parent).find('.sensorList').focus()
        return false
    }
    if(FunctionId == '') {
        showNotification('Loại chức năng cảm biến', 0);
        $(parent).find('.TypeFunctionId').focus()
        return false
    }

    if(Port == '') {
        showNotification('Cách kết nối CB với thiết bị', 0);
        $(parent).find('.listPort').focus()
        return false
    }
    if(FunctionId == 1 || FunctionId == 2 || FunctionId == 3) {
        if ($(parent).find('.checkBoxItem').is(":checked")) {
            $(parent).find('.InputOnOff').val(1)
        } else {
            $(parent).find('.InputOnOff').val(0)
        }
    }
    if(FunctionId == 5) {
        var check = checkValue(parent)
        if(check) {
            showNotification('Thông tin trong bảng thư viện dải cảm biến Điện áp - Dầu của xe không được để trống', 0);
            return false
        }
    }
    var sensorLineDevice = sensorLineArr[DeviceTypeId]
    var textSensor = sensorLineDevice[SensorId].text
    var textFunction = TypeFunctionText[FunctionId]
    $(parent).find('.checkSave').val(1)
    $(parent).find('.SensorId').val(SensorId)
    $(parent).find('.FunctionId').val(FunctionId)
    $(parent).find('.Port').val(Port)
    $(parent).find('.boxShow').show()
    $(parent).find('.boxEdit').hide()
    $(parent).find('.textSensor').text(textSensor)
    $(parent).find('.textFunction').text(textFunction)
    showListDataSensor()
})

function checkValue(parent) {
    var check = false
    $(parent).find('.rowValue').each(function(){
        var voltage = $(this).find('.voltage').val()
        var oil = $(this).find('.oil').val()
        if(voltage == '' || oil == '') {
            check = true
        }
    })
    return check
}

$('body').on('click', '.btnDelete', function() {
    var parent = $(this).closest('.boxCBItem')
    $(parent).remove()
    updateName()
    showListDataSensor()
})

$('body').on('click', '.btnAddRow', function() {
    ele ='<tr class="rowValue"><td><input type="text" class="form-control voltage"></td><td><input type="text" class="form-control oil"></td><td><a href="javascript:void(0)" class="btnDeleteRow"><i class="fa fa-trash"></i></a></td></tr>'
    var parent = $(this).closest('.boxCBItem')
    $(parent).find('.TBCB').append(ele)
})

$('body').on('click', '.btnDeleteRow', function() {
    $(this).closest('tr').remove()
})
showListDataSensor()
function showListDataSensor() {
    var ele = ''
    $('#ModalEditSensor').find('.boxCBItem').each(function () {
        var boxNameCB = $(this).find('.boxNameCB').text()
        var sensorText = $(this).find(".sensorList option:selected").html()
        var TypeFunctionId = $(this).find(".TypeFunctionId option:selected").html()
        ele += '<div class="row mgbt-10">\n' +
            '                        <div class="col-sm-3">\n' +
            '                            <p>'+boxNameCB+'</p>\n' +
            '                        </div>\n' +
            '                        <div class="col-sm-9">\n' +
            '                            <div class="box-search-advance customer">\n' +
            '                                <div class="row mgbt-10">\n' +
            '                                    <div class="col-sm-6">\n' +
            '                                        <p>Dòng cảm biến*</p>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-sm-6">\n' +
            '                                        <p class="text-center">'+sensorText+'</p>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                                <div class="row mgbt-10">\n' +
            '                                    <div class="col-sm-6">\n' +
            '                                        <p>Loại chức năng cảm biến*</p>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-sm-6">\n' +
            '                                        <p class="text-center">'+TypeFunctionId+'</p>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>'
    })
    if(ele !== '') {
        $('.SensorData').html(ele)
        $('.boxData').show()
        $('.boxNoData').hide()
    } else {
        $('.boxData').hide()
        $('.boxNoData').show()
    }
}

$('.tab').click(function () {
    var tabId = $(this).attr('data-id')
    $('.btnUpdateVehicle').attr('data-id', tabId)
})

$('body').on('click', '.btnDeleteCB', function () {
    var DeviceSensorId = $('#DeviceSensorId').val()
    $.ajax({
        type: "POST",
        url: $('#urlDeleteDeviceSensor').val(),
        data: {DeviceSensorId:DeviceSensorId},
        success: function (response) {
            showNotification('Xóa thành công', 0);
            $('.boxEditCB').remove()
            $('.boxCBItem').remove()
            $('.boxAddNewCB').show()
            $('.SensorData').html('')
            $('.boxData').hide()
            $('.boxNoData').show()
            $('#DeviceTypeId').val('')
            $('#select2-DeviceTypeId-container').text('-- Chọn dòng thiết bị --')
            $('#IMEI').val('')
            $('#Comment').val('')
            $('.modalHidden').show()
            $('.modalShow').hide()
            showHistory()
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

})
showHistory()
function showHistory() {
    $.ajax({
        type: "POST",
        url: $('#urlShowHistory').val(),
        data: {VehicleId:$('#VehicleEditId').val()},
        success: function (response) {
            $('.boxShowHistory').html(response)
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

$('body').on('click', '.btnShowDetail', function () {
    var id = $(this).attr('data-id')
    $.ajax({
        type: "POST",
        url: $('#UrlShowDetail').val(),
        data: {DeviceSensorId:id},
        success: function (response) {
            $('#ModalShowDetail .showDetail').html(response)
            $('#ModalShowDetail').modal('show')
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

})