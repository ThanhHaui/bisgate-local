var app = app || {};

app.init = function (myCarUserId) {
    app.initLibrary();
    app.add();
};

$(document).ready(function(){
    var myCarUserId = parseInt($("input#myCarUserId").val());
   
    app.init(myCarUserId);
    var tagsRFID = [];
    var inputTagRFID = $('input#tagsRFID');
   
    inputTagRFID.tagsInput({
        'width': '100%',
        'height': '90px',
        'interactive': true,
        'defaultText': '',
        'onAddTag': function (tag) {
            tagsRFID.push(tag);
        },
        'onRemoveTag': function (tag) {
            var index = tagsRFID.indexOf(tag);
            if (index >= 0) tagsRFID.splice(index, 1);
        },
        'delimiter': [',', ';'],
        'removeWithBackspace': true,
        'minChars': 0,
        'maxChars': 0
    });
    $('input.inputTagRFID').each(function(){
        inputTagRFID.addTag($(this).val());
    });

    $("body").on('click', '.submit', function(){
		if(validateEmpty('#driveMyCarForm')){
            if(parseInt($("select#licenceTypeId").val()) == 0){
                showNotification('Vui lòng thêm Loại bằng.', 0);
                return false;
            }
    		var form = $('#driveMyCarForm');
    		$('.submit').prop('disabled', true);
            var datas = form.serializeArray();
            datas.push({ name: "UserCards", value:  JSON.stringify(tagsRFID) });
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        if(myCarUserId == 0){
                            resetTable();
                            resetModal();
                            $("#modalDriveMyCar").modal('hide');
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

    
});

app.initLibrary = function(){
	$('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    $('body').on('keydown', 'input.cost', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
        
    });
   

    $('.chooseImageIDCardFront').click(function(){
        $('#inputFileImageIDCardFront').trigger('click');
    });
    chooseFile($('#inputFileImageIDCardFront'), $('#fileProgress_1'), 2, function(fileUrl){
        $('input#iDCardFront').val(fileUrl);
        $('img#imgIDCardFront').attr('src', fileUrl).css("display", "block");

    });

    $('.chooseImageIDCardBack').click(function(){
        $('#inputFileImageIDCardBack').trigger('click');
    });
    chooseFile($('#inputFileImageIDCardBack'), $('#fileProgress_2'), 2, function(fileUrl){
        $('input#iDCardBack').val(fileUrl);
        $('img#imgIDCardBack').attr('src', fileUrl).css("display", "block");
    });
}

app.add = function(){
	$("body").on('click', '#showModalDriveMyCar', function(){
        resetModal();
        $("#modalDriveMyCar").modal('show');
    });
}

function resetModal(){
    $("#driveMyCarForm input#userId").val(0);
    $("#driveMyCarForm input#userDetailId").val(0);
	$("#driveMyCarForm .inputReset").val('');
    $("#driveMyCarForm select").val(0).trigger('change'); 
    $("#driveMyCarForm img").attr('src', '').css("display", "none");
    $('.submit').prop('disabled', false);
}
