
var sensorLine = $('#SensorLine').val()
var sensorLineArr = JSON.parse(sensorLine)
var TypeFunctionText = $('#TypeFunctionText').val()
TypeFunctionText = JSON.parse(TypeFunctionText)
var DeviceTypeId = 2
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
    showHideBtnConinue()
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
    showHideBtnConinue()
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
    }else if(TypeFunctionSelected == 4) {
        eleCBXe=' <div class="col-sm-4"><p class="mt-6 d-flex">Cách kết nối CB với xe*</p></div>\n' +
            '        <div class="col-sm-8">\n' +
            '            <p>"Dòng cảm biến này chỉ có 1 cách kết nối duy nhất với xe, nên không cần khai báo"</p></div>\n' +
            '        </div>'
        $(parent).find('.OnOff').html(eleCBXe)
    }  else if(TypeFunctionSelected == 5) {
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
        eleCBXe+='           <div class="row boxEdit mgbt-10">\n' +
            '                            <div class="col-sm-4">\n' +
            '                                <p class="mt-6 d-flex">Thể tích thùng NL Max*</p>\n' +
            '                            </div>\n' +
            '                            <div class="col-sm-6">\n' +
            '                                <input type="number" class="form-control " id="Consumption" placeholder="">\n' +
            '                            </div>\n' +
            '                           <div class="col-sm-2">\n' +
            '                                ( Lít )\n' +
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
    var camb = $(parent).find('#Consumption').val()
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
        if(camb == '') {
            showNotification('Vui lòng nhập thể tích thùng NL Max', 0);
            $(parent).find('#Consumption').focus()
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
    showHideBtnConinue()
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
    showHideBtnConinue()
})

function showHideBtnConinue() {
    check = checkAddNew()
    if(check) {
        $('.btnNone2').show()
        $('.btnActive2').hide()
    } else {
        $('.btnNone2').hide()
        $('.btnActive2').show()
    }
}

$('.btnActive2').click(function() {
    $('.tab2').hide()
    $('.tab3').show()
    $('.breacrumb ul li').removeClass('active')
    $('.breacrumb ul li:nth-child(3)').addClass('active')
    updateShowHideActive()
})

$('body').on('click', '.btnAddRow', function() {
    ele ='<tr class="rowValue"><td><input type="text" class="form-control voltage"></td><td><input type="text" class="form-control oil"></td><td><a href="javascript:void(0)" class="btnDeleteRow"><i class="fa fa-trash"></i></a></td></tr>'
    var parent = $(this).closest('.boxCBItem')
    $(parent).find('.TBCB').append(ele)
})

$('body').on('click', '.btnDeleteRow', function() {
    $(this).closest('tr').remove()
})

$('#VehicleTypeId').change(function () {
    var VehicleTypeId = $(this).val();
    $('#LicensePlate').val('');
    $.ajax({
        type: "POST",
        url: "Vehicle/showTonage",
        data: {VehicleTypeId:VehicleTypeId} ,
        success: function(response) {
            var json = $.parseJSON(response);
            $('#TonnageId').html(json);
        }
    });
})