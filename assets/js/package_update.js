
$( document ).ready(function () {
    var packageId = parseInt($("input#packageId").val());
    $('input.checkbox').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $("input.checkbox").on("ifChanged", function () {
        if ($(this).prop('checked')==true){
            $(this).parents('.packageRole').children('label').children('.icheckbox_square-blue').children('input.checkbox').prop('checked',true);
            $(this).parents('.packageRole').children('label').children('.icheckbox_square-blue').addClass('checked');
        }else{
            $(this).closest('.packageRole').find('input.checkbox').prop('checked',false);
            $(this).closest('.packageRole').find('.icheckbox_square-blue').removeClass('checked');
        }
    });
    $("body").on('click', '.submit', function(){
        if(validateEmpty('#packagesForm')){
    		var form = $('#packagesForm');
            $('.submit').prop('disabled', true);
            var datas = form.serializeArray();
            datas.push({ name: "PackageRoles", value: JSON.stringify(getDataRoleMenus(packageId)) });
            datas.push({ name: "PackageId", value: packageId });
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1) redirect(false, $('.list-inline .btn.btn-default').attr('href'));
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

function getDataRoleMenus(packageId = 0) {
    var packageroles = [];
    $("input[name=RoleMenuId]:checked").each(function () {
        var ids = $(this).val();
        ids = ids.split("-");
        packageroles.push({
            RoleMenuId: ids[0],
            RoleMenuChildId: ids[1]
        });
    });

    return packageroles;
}
