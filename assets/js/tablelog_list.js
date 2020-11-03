$(document).ready(function(){
    actionItemAndSearch({
        ItemName: 'Lịch sử xóa',
        IsRenderFirst: true,
        extendFunction: function(itemIds, actionCode){}
    });
    $("#tbodyTableLog").on('click','a.link_back', function(){
        if(confirm('Bạn có thực sự muốn phục hổi ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#changeStatusUrl').val(),
                data: {
                    TableLogId: id
                    //IsBack: 2,
                    //StatusIdOld: 0,
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) $('tr#trItem_' + id).remove();
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
    	return false;
    });
});


function renderContentTableLog(data) {
    var html = '';
    if(data!=null) {
        for (var item = 0; item < data.length; item++) {
            html += '<tr id="trItem_'+data[item].TableLogId+'">';
            html += '<td>'+ data[item].CrDateTime +'</td>';
            html += '<td>'+ data[item].Code +'</td>';
            html += '<td>'+ data[item].FullName +'</td>';
            html += '<td>'+ data[item].Comment +'</td>';
            html += '<td class="text-center"><a href="javascript:void(0)" class="link_back" data-id="'+data[item].TableLogId+'"><i class="fa fa-undo"></i></a></td>';
            html += '</tr>';
        }
        html += '<tr><td colspan="5" class="paginate_table"></td></tr>';
        $('#table-data').find('tbody').html(html);
    }
}