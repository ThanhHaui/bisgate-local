



$(document).ready(function () {
    
    $("body").on('click', '.btnShowModalGroup', function () {
        $("#btnShowModalGroups").modal('show');
    });
    $('body').on('click', '#btnAddGroup', function () {
        var countId = parseInt($(this).val());
        var arrGroup = [];
        $('#table-group input.iCheck').each(function () {
            if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) {
                arrGroup.push({
                    GroupId: $(this).val(),
                    GroupCode: $(this).parent().parent().parent().find('td').eq(1).text().trim(),
                    GroupName: $(this).parent().parent().parent().find('td').eq(2).text().trim(),
                });
                $(this).parent().parent().parent().hide();
                $(this).parent().removeClass('checked');
                $(this).parent().attr('aria-checked', 'false');
            }
        });
        if (arrGroup.length == 0) {
            showNotification('Vui lòng chọn phân quyền cho người dùng.', 0);
            return false;
        }
        var html = '';
        $.each(arrGroup, function (i, item) {
            html += `<tr data-id="${item.GroupId}">
            <td>${i + 1}</td>
            <td>${item.GroupTime}</td>
            <td>${item.GroupCode}</td>
            <td>${item.GroupName}</td>
            <td><a href="javascript:void(0)" class="link_delete_group" title="Xóa" count-id="${countId}"><i class="fa fa-trash-o"></i></a></td>
            </tr>
            `;
        });
        $("#tbodyGroupUser").append(html);
        $("#btnShowModalGroups").modal('hide');
      
        return false;
    }).on('click', '.link_delete_group', function () {
        var id = $(this).parent().parent().attr('data-id');
        var code = $(this).parent().parent().find('td').eq(2).text();
        var name = $(this).parent().parent().find('td').eq(3).text();
        $(this).parent().parent().remove();
        $('#tbodyGroup').find('tr#group_' + id).show();

    });
    

});
$('.button_next').click(function () {
    $('.nav.nav-tabs li').removeClass('active');
    $('.nav.nav-tabs li.tab_modal_user' + $(this).attr('data-id')).addClass('active');
    $('.tab-pane').removeClass('active');
    $('.tab-pane#tab_' + $(this).attr('data-id')).addClass('active');
});
$('#agentForm input[type=text],textarea').on('keyup change', function () {
    $('span.show-data-info.' + $(this).attr('name')).text($(this).val());
});
$(document).on('change', '#agentForm select', function () {
    $('span.show-data-info.' + $(this).attr('name')).text($(this).children('option:selected').text());
});
$('input[type=radio]').on('ifToggled click', function () {
    $('span.show-data-info.' + $(this).attr('name')).html($(this).attr('data-val'));
});






$('.submit_permission').click(function (event) {
    event.preventDefault();
    var form = $('#agentForm');
    var datas = form.serializeArray();
    if (validateEmpty('#agentForm')) {
        var CheckPhoneNumber =/((09|03|07|08|05)+([0-9]{8})\b)/g;
        if (!CheckPhoneNumber.test($('#PhoneNumber').val())){
            showNotification("Số điện thoại không đúng", 0);
            return false;
        }
        var CheckEmail =/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!CheckEmail.test($('#email').val())){
            showNotification("Email không đúng", 0);
            return false;
        }

        if(parseInt($("select#hTProvinceId").val()) == 0){
            showNotification("Vui lòng chọn tỉnh/thành.", 0);
            return false;
        }
        if(parseInt($('input#roleId').val()) == 2){
            if(parseInt($("select#agentTypeId").val()) == 0){
                showNotification("Vui lòng chọn Loại đại lý.", 0);
                return false;
            }

        }
        var customerTypeId = parseInt($('input[name="StaffTypeId"]:checked').val());
        if(customerTypeId == 1){
            console.log($("input#personalName").val());
            datas.push({ name: "FullName", value:  $("input#personalName").val() });
        }else{
            if($("input#taxCode").val().trim() == ''){
                showNotification("Vui lòng thêm Mã số thuế.", 0);
                return false;
            }
            datas.push({ name: "FullName", value:  $("input#companyName").val() });
        }
        datas.push({ name: "listTag", value: JSON.stringify(getDataListTag($('#tags').val())) });
        datas.push({ name: "ContactUsers", value:  JSON.stringify(getDataContactUser()) });
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: datas,
            success: function (response) {
            },
            error: function () {
            }
        });
    }
});
function getDataListTag(tags){
    $arrTags=tags.split(",,;");
    return $arrTags;
}
