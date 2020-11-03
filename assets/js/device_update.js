var app = app || {};
app.init = function (deviceId) {
    app.submit(deviceId);
    app.comment(deviceId);
    app.add();
};
$(document).ready(function(){
    var deviceId = $('#DeviceId').val()
    app.init(deviceId);
    var tags = [];
    var inputTag = $('input#tags');
    inputTag.tagsInput({
          'width': '100%',
          'height': '50px',
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

    $('#btnUpdateTag').click(function(){
          if(tags.length > 0){
              var btn = $(this);
              btn.prop('disabled', true);
              $.ajax({
                  type: "POST",
                  url: $('input#updateItemTagUrl').val(),
                  data: {
                      ItemIds: JSON.stringify([deviceId]),
                      TagNames: JSON.stringify(tags),
                      ItemTypeId: $("input#itemTypeId").val(),
                      ChangeTagTypeId: 1
                  },
                  success: function (response) {
                      var json = $.parseJSON(response);
                      showNotification(json.message, json.code);
                      btn.prop('disabled', false);
                  },
                  error: function (response) {
                      showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                      btn.prop('disabled', false);
                  }
              });
          }
          else showNotification('Vui lòng chọn nhãn', 0);
    });
    $("#SimId").select2({
        placeholder: "---Chọn sim--",
        allowClear: true,
        ajax: {
            url: $("input#getListSims").val(),
            type: 'POST',
            dataType: 'json',
            delay:250,
            data: function(data) {
                return {
                    SearchText: data.term,
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.PhoneNumber,
                            id: item.SimId,
                            data: item
                        };
                        
                    }),
                };
            }
        }
    });
});

app.add = function(){
    $("body").on('click', '#showModalDevice', function(){
        resetModalDevice();
        $("#title").html('Thêm mới thiết bị');
        $(".submit").html('Thêm');
        $("#modalDevice").modal('show');
    });
}

app.comment = function(deviceId){
    $('#btnInsertComment1').click(function(){
       var comment = $('input#comment1').val().trim();
       if(comment != ''){
           var btn = $(this);
           btn.prop('disabled', true);
           $.ajax({
               type: "POST",
               url: $('input#insertCommentUrl').val(),
               data: {
                    ItemId: deviceId,
                    Comment: comment,
                    ItemTypeId: $("input#itemTypeId").val(),
               },
               success: function (response) {
                   var json = $.parseJSON(response);
                   if(json.code == 1) {
                       $('div#listComment1').prepend(genItemComment(comment));
                       $('input#comment1').val('');
                   }
                   showNotification(json.message, json.code);
                   btn.prop('disabled', false);
               },
               error: function (response) {
                   showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                   btn.prop('disabled', false);
               }
           });
       }
       else{
           showNotification('Vui lòng nhập ghi chú', 0);
           $('input#comment1').focus();
       }
   });
}

app.submit = function(deviceId){
    $("body").on('click', '.submit', function(){
        if(validateEmpty('#deviceForm')){
    		var form = $('#deviceForm');
    		$('.submit').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        if(parseInt(deviceId) == 0){
                            resetTable();
                            resetModalDevice();
                            $("#modalDevice").modal('hide');
                        }
                    }
                    $('.submit').prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.submit').prop('disabled', false);
                }
            });
    	}
    	return false;
    });
}

$('#SimId').change(function () {
    var SimId = $('#SimId').val();
    
    $.ajax({
        type: "POST",
        url: $('#getBySimId').val(),
        data: {
            SimId: SimId
        },
        success: function (response) {
            var json = $.parseJSON(response);
            $('.boxShow').find('.phone').text(json.PhoneNumber)
            $('.boxShow').find('.telco').text(json.SimType)
            $('.boxShow').find('.Serisim').text(json.SeriSim)
            $('.boxShow').show()
            $('.boxSelect').hide()
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            $('.submit').prop('disabled', false);
        }
    });
    
})

$('.btnDelete').click(function () {
    var DeviceSimId = $('#DeviceSimId').val();
    $('.boxShow').hide()
    $('.boxSelect').show()
    $('.boxShow').find('#SimIdEdit').val(0)
    $('#SimId').val('')
    $('.select2-selection__rendered').text('--Chọn sim--')
    if(DeviceSimId > 0) {
        $.ajax({
            type: "POST",
            url: $('#deleteDeviceSim').val(),
            data: {
                DeviceSimId:DeviceSimId
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                showHistory()
                $('#DeviceSimId').val(0);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
    }
})
showHistory()
function showHistory() {
    var DeviceId = $('#DeviceId').val()
    $.ajax({
        type: "POST",
        url: $('#getListHistoryUrl').val(),
        data: {
            DeviceId:DeviceId
        },
        success: function (response) {
            $('.boxShowHistory').html(response)
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

$('.btnUpdate').click(function () {
    var DeviceId = $('#DeviceId').val()
    var SimId = $('#SimId').val()
    if(SimId <= 0) {
        showNotification('Vui lòng chọn Sim', 0);
        $('#SimId').focus()
        return false
    }
    $.ajax({
        type: "POST",
        url: $('#updateDeviceSim').val(),
        data: {
            DeviceId:DeviceId,
            SimId:SimId
        },
        success: function (response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            $('#DeviceSimId').val(json.DeviceSimId)
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
})

$('.btnSubmit').click(function () {
    var form = $('#deviceForm');
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        success: function (response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            if(json.code == 1){
                resetTable();
                resetModalDevice();
                $("#modalDevice").modal('hide');
            } else {
                $('#'+json.field).focus()
            }
            $('.submit').prop('disabled', false);
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            $('.submit').prop('disabled', false);
        }
    });
})

function resetModalDevice(){
    $("#deviceForm input").val('');
    $("#deviceForm select").val(0).trigger('change');
    $("#deviceForm input#deviceId").val(0);
    $("div.dev-reset").html('');

}
$(document).ready(function(){
    $('.btnUpdate').hide()
});
$('.ul-log-actions li').click(function(){
    if($(this).hasClass('tab_active_save')){
        $('.btnUpdate').show()
    }
else{
    $('.btnUpdate').hide()
}})