// lưu các thông tin lọc khi sử dụng bộ lọc
var data_filter = {
    itemFilters: [],
    filterId: 0,
    tagFilters: []
};
var paginateObject_V2 = null;
//--------------- Thiết kế data chuyển tab bộ lọc -------------------------------//
function loadTabAjaxFilter(itemName) {
    //xóa tab search đi nếu có
    var tab_search = $('#ulFilter').find('li#tab_search');
    if(tab_search.length > 0) $(tab_search).remove();
    $('#itemSearchNameFilter').val('');
    $.ajax({
        type: "POST",
        url: $('input#btn-data-filter').val(),
        //async: false,
        data:{
            filterId: data_filter.filterId
        },
        success: function (response) {
            response = $.parseJSON(response);
            //render  table
            render(response.callBackTable, response.dataTables);

            //render nhãn lọc
            data_filter.itemFilters = response.itemFilters == null ? [] : response.itemFilters;
            data_filter.tagFilters = response.tagFilters == null ? [] : response.tagFilters;
            render(response.callBackTagFilter, data_filter.tagFilters);

            //render paginate
            if(paginateObject_V2 == null){
                paginateObject_V2 = $('#table-data-filter').Paginate1({
                    page: response.page,
                    pageSize: response.pageSize,
                    totalRow: response.totalRow,
                    itemName: itemName,// config.ItemName,
                    totalDataShow: response.totalDataShow
                });
            }
            else{
                paginateObject_V2.Paginate1({
                    page: response.page,
                    pageSize: response.pageSize,
                    totalRow: response.totalRow,
                    registerEvent : false,
                    itemName: itemName,// config.ItemName
                    totalDataShow: response.totalDataShow
                });
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}
function bindFilterAdd(id, itemName){
    data_filter.filterId = id;
    data_filter.tagFilters = [];
    data_filter.itemFilters = [];
    loadTabAjaxFilter(itemName);
}

function actionItemAndSearchFilter(config) {
    $('input.iCheckTable').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('body').on('keydown', 'input.input-number', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.input-number', function () {
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    }).on('ifToggled', 'input#checkAll', function (e) {
        if (e.currentTarget.checked) {
            $('input.iCheckItem').iCheck('check');
            //$('#h3Title').hide();
            $('#selectAction').show();
            $('#selectData').show();
            
        }
        else {
            $('input.iCheckItem').iCheck('uncheck');
            $('#selectAction').hide();
            $('#selectData').hide();
            //$('#h3Title').show();
        }
        var itemIds = [];
        $('input.iCheckItem').each(function () {
            if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) itemIds.push(parseInt($(this).val()));
        });
        $("select#selectData").html('<option value="one">'+itemIds.length+' đã chọn</option><option value="all">Chọn tất cả ('+$("div.total-row").text().split(' ')[0]+')</option>');
    }).on('ifToggled', 'input.iCheckItem', function (e) {
        if (e.currentTarget.checked) {
            //$('#h3Title').hide();
            $('#selectAction').show();
            $('#selectData').show();
            
        } else {
            var iCheckItems = document.querySelectorAll('.checked input.iCheckItem');
            if (iCheckItems.length == 1) {
                $('input#checkAll').iCheck('uncheck');
                //$('#h3Title').show();
                $('#selectAction').hide();
                $('#selectData').hide();
            }
        }
        var itemIds = [];
        $("input.iCheckItem:checked").each(function () {
            itemIds.push(parseInt($(this).val()))
        });
        $("select#selectData").html('<option value="one">'+itemIds.length+' đã chọn</option><option value="all">Chọn tất cả ('+$("div.total-row").text().split(' ')[0]+')</option>');
    });
    var tags = [];
    if ($('input#tags').length > 0) {
        $('input#tags').tagsInput({
            'width': '100%',
            'height': '100px',
            'interactive': true,
            'defaultText': '',
            'onAddTag': function (tag) {
                tags.push(tag);
            },
            'onRemoveTag': function (tag) {
                var index = tags.indexOf(tag);
                if (index >= 0) tags.splice(index, 1);
            },
            'delimiter': [',', ';'],
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 0
        });
    }

    if(typeof(config.IsRenderFirst) != 'undefined'){ //tam thoi
        if(config.IsRenderFirst == 1) searchAjaxFilter();
        else bindFilterAdd(0, config.ItemName);
    }

    /*--------------------------------Thiết kế bộ lọc-------------------------------------------*/
    /*
     *hàm filter
     *input : string,object
     *output : json
     *itemFilters có dạng
     * [
     *      {filed_name : price ,conds : [=,1000]},
     *      {filed_name : name ,conds : [like,thanh]},
     *      {filed_name : name ,conds : [is,thanh]},
     *      {filed_name : create_at ,conds : [between,01-01-2017,31-01-2017]}
     *
     * ]
     */

    function searchAjaxFilter() {
        $.ajax({
            type: "POST",
            url: $('input#btn-data-filter').val(),
            //async: false,
            data: {
                itemFilters : data_filter.itemFilters ,
                searchText :$('#itemSearchNameFilter').val().trim(),
                filterId: data_filter.filterId,
                itemTypeId: $('input#itemTypeId').val()
            },
            success: function (response) {
                response = $.parseJSON(response);
                //render  table
                render(response.callBackTable, response.dataTables);
                // render toan bo id của dữ liệu
                //render nhãn lọc
                data_filter.tagFilters = response.tagFilters == null ? data_filter.tagFilters : response.tagFilters;

                render(response.callBackTagFilter, data_filter.tagFilters);
                //render paginate
                if(paginateObject_V2 == null){
                    paginateObject_V2 = $('#table-data-filter').Paginate1({
                        page: response.page,
                        pageSize: response.pageSize,
                        totalRow: response.totalRow,
                        itemName: config.ItemName,
                        totalDataShow: response.totalDataShow
                    });
                }
                else{
                    paginateObject_V2.Paginate1({
                        page: response.page,
                        pageSize: response.pageSize,
                        totalRow: response.totalRow,
                        registerEvent : false,
                        itemName: config.ItemName,
                        totalDataShow: response.totalDataShow
                    });
                }

            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
    }

    function resetIndex() {
        $('#container-filters').find('.item').each(function (key, val) {
            $(this).attr('data-index', key + 1);
        });
    }

    // Đăng ký sự kiện khi remove nhãn lọc
    $('#container-filters').on('click', '.item  button.remove', function () {
        //lấy đối tượng li
        var parent_item = $(this).parents('.item');
        var index = $(parent_item).attr('data-index');
        data_filter.itemFilters.splice(index - 1, 1);
        data_filter.tagFilters.splice(index - 1, 1);
        resetIndex();
        searchAjaxFilter();

    });
    if($('input.datepicker').length > 0){
        $('input.datepicker').datepicker({
            format: 'dd/mm/yyyy'
            //autoclose: true
        }).on('changeDate', function(ev){
            $(this).datepicker('hide');
            setTimeout(function(){
                $('#searchGroup').addClass('open');
            }, 10);
        });
    }
    // sự kiện thay đổi field select ẩn tất cả các trường không tương ứng đi và show các trường tương úng lên
    $('#field_select').change(function () {
        var field = $(this).val();
        $('input.'+field).val('');
        $(this).find('option').each(function (keyO, valO) {
            var elementClass = '.' + $(valO).val();
            if (elementClass != '.') {
                $(elementClass).removeClass('block-display').removeClass('none-display').addClass('none-display');
            }
        });
        $('.' + field).removeClass('none-display').addClass('block-display');
    });

   
    

    //--------------------------------- Thiết kế xóa bộ lọc --------------------------//

  
    // --------------------------- Thiết kế search ------------------------------- //
    var statusSearch = null;
    $('#itemSearchNameFilter').keydown(function () {
        var tab_search = $('#ulFilter').find('li#tab_search');
        //thêm tab search khi thực hiện việc search nếu chưa có thì thêm mới vào
        if(tab_search.length == 0){
            $('#ulFilter').find('li.active').removeClass('active');
            data_filter.itemFilters = [];
            data_filter.tagFilters = [];
            // var html= '<li id="tab_search" class="active"><a href="javascript:;" data-id="-1" data-toggle="tab" aria-expanded="true">Tùy chọn</li>';
            // $('#ulFilter').append(html);
        }

        if (statusSearch != null) {
            clearTimeout(statusSearch);
            statusSearch = null;
        }

    });

    $('#itemSearchNameFilter').keyup(function () {
        if (statusSearch == null) {
            statusSearch = setTimeout(function () {
                searchAjaxFilter();
            }, 500);
        }
    });


//vì mỗi table lại có kiểu gen html khác nhau nên không thể gôp chung lại được
//call_back là 1 tên của funtion thực hiện việc render html cho table bằng dữ liệu data_table
//call_back được gửi xuống từ server khi thực hiện ajax nên call_back phải được định nghĩa global bên js trước khi server trả xuống
    
}
//data table paginate
$.fn.Paginate1 = function (opt) {
    var root = this;
    var conf = $.extend({pageShow: 3, page: 1, pageSize: 1, totalRow: 3,registerEvent: true,limit: 10,totalDataShow: 10}, opt);
    var actions = {
        init: function () {},
        render: function () {},
        event: function () {}
    };

    actions.init = function () {
        conf.page = parseInt(conf.page);
        conf.pageShow = parseInt(conf.pageShow);
        conf.pageSize = parseInt(conf.pageSize);
        conf.totalRow = parseInt(conf.totalRow);
    };

    actions.render = function () {
        if(conf.pageSize == 1) {
            html = '<div class="up-n-pager"><div class="total-row">' + conf.totalDataShow +'/'+ conf.totalRow + ' ' + conf.itemName + '</div></div>';
            $(root).find('.paginate_table').html(html);
            return false;
        }
        var html = "<ul>{first_page}{prev_page}{pages}{next_page}{last_page}</ul>";
        var first_page = '<li><a class="{option} first-page" data-page="1" href="javascript:;">Trang đầu</a></li>';
        var last_page = '<li><a class="{option} last-page" data-page="' + conf.pageSize + '" href="javascript:;">Trang cuối</a></li>';
        var prev_page = '<li><a class="{option}" data-page="' + (conf.page - 1 > 0 ? conf.page - 1 : 1 ) + '" href="javascript:;"><<</a></li>';
        var next_page = '<li><a class="{option}" data-page="' + (conf.page + 1 < conf.pageSize ? conf.page + 1 : conf.pageSize ) + '" href="javascript:;">>></a></li>';
        var start_page = 1;
        var end_page = 1;
        var offset = Math.floor(conf.pageShow / 2);
        if (conf.pageSize <= conf.pageShow) {
            start_page = 1;
            end_page = conf.pageSize;
            html = html.replace(/\{[a-z_]{6,}\}|/img, '');
        }
        else {
            // page ở khoảng giữa
            if (conf.page > offset && conf.pageSize > conf.page + offset) {
                start_page = conf.page - offset;
                end_page = conf.page + offset;
                // page ở cuối
            }
            else if (conf.page == conf.pageSize) {
                start_page = conf.pageSize - conf.pageShow + 1;
                end_page = conf.pageSize;
                next_page = next_page.replace('{option}', ' disable');
                last_page = last_page.replace('{option}', ' disable');
                //page ở đầu
            }
            else if (conf.page === 1) {
                start_page = 1;
                end_page = conf.pageShow;
                first_page = first_page.replace('{option}', ' disable');
                prev_page = prev_page.replace('{option}', ' disable');

                //page nhỏ hơn số hiển thị
            }
            else if (conf.page <= conf.pageShow) {
                start_page = 1;
                end_page = conf.pageShow;

                //page lớn hơn số hiển thị conf.page > conf.pageShow
            }
            else {
                start_page = conf.pageSize - conf.pageShow + 1;
                end_page = conf.pageSize;
            }
            next_page = next_page.replace('{option}', '');
            last_page = last_page.replace('{option}', '');
            prev_page = prev_page.replace('{option}', '');
            first_page = first_page.replace('{option}', '');
        }
        var pages = "";
        for (var page = start_page; page <= end_page; page++) {
            var row = '<li>';
            row += '<a class="{option}" data-page="' + page + '" href="javascript:;">' + page + '</a>';
            row += '</li>';
            if (page == conf.page)
                row = row.replace('{option}', 'active disable none-event');
            else
                row = row.replace('{option}', '');
            pages += row;
        }
      
        html = '<div class="total-row">'+ conf.totalDataShow +'/'+ ' <span class="countx"> '+ conf.totalRow +' </span>'  + conf.itemName  + '</div>' + html;
        html = '<div class="up-n-pager">' + html;
        html = html.replace('{pages}', pages).replace('{first_page}', first_page).replace('{prev_page}', prev_page).replace('{next_page}', next_page).replace('{last_page}', last_page);
        html += '</div>';
        $(root).find('.modal_paginate_table').html(html);
    };
    actions.event = function () {
        // bắt sự kiện chuyển trang của table khi phân trang
        $(root).on('click', '.paginate_table a', function (e) {
            //var active_event = $(this).attr('class').indexOf('disable') > -1 ? false : true;
            //if (active_event) {
            if(!$(this).hasClass('disable')){
                data_filter.page = $(this).attr('data-page');
                var data = {
                    itemFilters : data_filter.itemFilters,
                    page : data_filter.page,
                    searchText : $('#itemSearchNameFilter').val().trim(),
                    itemTypeId: $('input#itemTypeId').val()
                };
                $.ajax({
                    type: "POST",
                    url: $('input#btn-data-filter').val(),
                    //async: false,
                    data: data,
                    success: function (response) {
                        response = $.parseJSON(response);
                        //render  table
                        render(response.callBackTable, response.dataTables);

                        //render paginate table
                        conf.page = parseInt(response.page);
                        conf.pageSize = parseInt(response.pageSize);
                        conf.totalRow = parseInt(response.totalRow);
                        conf.totalDataShow = parseInt(response.totalDataShow);
                        actions.render();
                    },
                    error: function (response) {
                        showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    }
                });
            }
            return false;
        });

    };
    actions.init();
    actions.render();
    if(conf.registerEvent)
        actions.event();

    return root;
};
function renderTagFilter(data) {
    var html = '';
    for (var i = 0; i < data.length; i++) {
        html += '<li class="item" data-index="' + (i + 1) + '">'
            + '<button class="btn btn-field">' + data[i] + '</button>'
            + '<button class="btn remove">'
            + '<i class="fa fa-times font-size-12px type-subdued "></i>'
            + '</button >'
            + '</li>';
    }
    $('#container-filters').html(html);

}
function render(call_back, data) {
    window[call_back](data);
}