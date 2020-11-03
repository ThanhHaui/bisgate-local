$(document).ready(function() {
    resetTable();
    $(document).on('click','.btnHideAdd',function(){
        showNotification('Vui lòng chọn khách hàng', 0);
    })
});

function resetTable() {
    actionItemAndSearch({
        ItemName: 'Xe của tôi',
        IsRenderFirst: true,
        extendFunction: function(itemIds, actionCode) {}
    });
}

function renderContentVehicles(dataAll) {
    var data = dataAll.dataTables;
    var countIsLock = parseInt(dataAll.countIsLock);
    $("#html-thead").html(dataAll.htmlTableTh)
    var html = '';
    if (data != null) {
        var htmlPaginate = '';

        // if(html != '') htmlPaginate += '<tr><td colspan="8"></td><td class="text-right">' + formatDecimal(sumCODCost.toString()) + '</td><td></td></tr>';
        htmlPaginate += '<div class="row box-tools ">';
        htmlPaginate += '<div class="col-md-2 total-data"></div>';
        htmlPaginate += '<div class="col-md-2">';
        htmlPaginate += '<span>Số dòng mỗi trang</span>';
        htmlPaginate += '<input id="changeLimit" value="20">';
        htmlPaginate += '</div>';
        htmlPaginate += '<div class="col-sm-8 paginate_table pull-right"></div>';
        htmlPaginate += '</div>';
        $('#tbodyVehicle').html(data);
        $(".box-footer").html(htmlPaginate);

        $('#table-data').dragableColumns();
        $("#table-data").tableHeadFixer({ "left": countIsLock });
        if ($("select#selectData").val() == 'all') {
            $('input#checkAll').iCheck('check');
            $('input.iCheckItem').iCheck('check');
            setTimeout(function() {
                $("select#selectData").val('all').trigger('change');
            }, 500);
        }
        countColumnTable();
    }
    $('input.iCheckTable').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });

}

$('body').on('keyup', 'input#LicensePlate', function (e) {
    if(checkKeyCodeNumberText(e)) e.preventDefault();
    locdau(this);
})