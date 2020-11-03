var appFilter = appFilter || {};
appFilter.initFilter = function (totalColumnTable) {
    appFilter.filter();
};
$(document).ready(function(){
    // setTimeout(function(){
    //     countColumnTable();
    // }, 50000);
//configTable
    $("body").on('click', '#btnShowModalConfigTable', function(){
        var html = '';
        var flagLock = false;
        $('#table-data .dnd-moved th').each(function (k,v) {
            if($(this).attr('is-lock') == 'ON') flagLock = true;
            var value = '';
            value += 'column-name="'+$(this).attr('column-name')+'"';
            value += 'name-user="'+$(this).attr('name-user')+'"';
            value += 'modals-db="'+$(this).attr('modals-db')+'"';
            value += 'status="'+$(this).attr('status')+'"';
            value += 'edit="'+$(this).attr('edit')+'"';
            value += 'id-edit="'+$(this).attr('id-edit')+'"';
            value += 'number="'+$(this).attr('number')+'"';
            value += 'name-relationship="'+$(this).attr('name-relationship')+'"';
            value += 'date-time="'+$(this).attr('date-time')+'"';
            value += 'is-active="'+$(this).attr('is-active')+'"';
            value += 'is-lock="'+$(this).attr('is-lock')+'"';
            var isChecked = '';
            if($(this).attr('is-active') == 'ON ') isChecked = 'checked';
            html += '<tr config-table-id="'+$('.dnd-moved').attr('data-id')+'">';
            html += '<td '+value+' ><i class="fa fa-fw fa-unsorted"></i>'+k+'</td>';
            html += '<td>'+$(this).text()+'</td>';
            html += '<td><input type="checkbox" value="" '+ isChecked +' class="show_and_hide" id="show_and_hide_'+k+'" data-value="'+$(this).attr('is-active')+'" data-id="'+k+'"/></td>';
            html += '<td><input type="checkbox" value="" class="pin" data-value="'+$(this).attr('is-lock')+'" id="pin'+k+'" data-id="'+k+'"/></td>';
            html += '</tr>';
        });
        $("#tbodyConfig").html(html);
        $('#tbodyConfig tr').each(function () {
            var $this = $(this).find('td');
            if($this.eq(3).find('input').attr('data-value') == 'OFF'){
                if(flagLock){
                    $this.eq(3).find('input').bootstrapSwitch({size: 'mini', 'disabled': true});
                    $this.eq(3).find('input').prop('checked', true);
                }
            }else{
                $this.eq(3).find('input').prop('checked', true);
                $this.eq(3).find('input').bootstrapSwitch({size: 'mini', 'disabled': false});
                $this.eq(3).find('input').attr('data-value', 'ON');
            }

            if($this.eq(2).find('input').attr('data-value') == 'ON'){
                $this.eq(2).find('input').prop('checked', true);
            }

        });

        

        $('.show_and_hide').bootstrapSwitch({size: 'mini'}).on('switchChange.bootstrapSwitch', function(event, state) {
            var check = state ? 'ON':'OFF';
            $(this).attr('data-value', check);
        });
        $('.pin').bootstrapSwitch({size: 'mini'}).on('switchChange.bootstrapSwitch', function(event, state) {
            var check = state ? 'ON':'OFF';
            $(this).attr('data-value', check);
            if(state){
                $('#tbodyConfig tr').each(function () {
                    var $this = $(this).find('td');
                    var td_2 = $this.eq(3).find('input').attr('data-id');

                    if($this.eq(3).find('input').attr('data-value') == 'OFF'){
                       $this.eq(3).find('input').bootstrapSwitch('disabled',true);
                    }
                });
            }else{
                $('#tbodyConfig tr').each(function () {
                    var $this = $(this).find('td');
                    if($this.eq(3).find('input').attr('data-value') == 'OFF'){
                       $this.eq(3).find('input').bootstrapSwitch('disabled',false);
                    }
                });
            }
        });
        $("#modalConfigTable").modal('show');
         return false;
    }).on('click', '#bnAddConfigTable', function(){
        saveConfigTable();
        
        $("#modalConfigTable").modal('hide');
        return false;
    });

    $("#tbodyConfig").sortable({
        update: function(evt, ui) {
            if(confirm('Bạn có thực sự di chuyển ?')){
                saveConfigTable();
            }
        }
    }).disableSelection();
});

// function countColumnTable(){
//     // var totalColumnTable = $('#table-data tr th').length;
//     // var totalColumnTableVisible = $('#table-data tr th:visible').length;
//     // console.log("=======totalColumnTable==============", totalColumnTable)
//     // console.log("=======totalColumnTableVisible==============", totalColumnTableVisible)
//     // if(totalColumnTableVisible == 0) totalColumnTableVisible = 0;
//     // $("input#txtCountColTable").val('Hiển thị '+totalColumnTableVisible+'/'+totalColumnTable);
//     // appFilter.initFilter(totalColumnTable);
// }

appFilter.filter = function(){
    $("body").on('click', '.btnShowModalListFilter', function(){
        resetTableFilter();
        $("#modalListFilter").modal('show');
    }).on('click', '#btnShowModalAddFilter', function(){
        $("#btn-remove-ilter").attr("style","display:none!important");
        $("#titleAddFilter").html('Thêm mới báo cáo');
        $("#btn-save-filter-add").html('Thêm');
        $("#modalAddFilter").modal('show');
    });
    var data_filter_add = {
        itemAddFilters: [],
        filterId: 0,
        tagAddFilters: []
    };
    $('a.btn-filter-data-add').on("click", function(e){
        e.stopPropagation();
        var $this = $(this);
        var id = parseInt($this.attr('value-id'));
        if(id > 0){
            // tạo biến gen code html cho field
            //khởi tạo 1 đối tượng item filer
            var filter_ob = {};
            // lấy nhãn lọc
            var filed_name = $this.attr('field-select');
            var text_field_name = $this.parent().parent().parent().parent().find('a span').eq(0).text();
            // lấy tất cả các điều kiện lọc và giá trị của điều kiện lọc theo nhãn này
            var conds = [];
            //text_opertor  ví dụ : là ,trong khoảng ,trước, sau bằng ,.....
            var text_operator = '';
            var ob_text_operator = $this.attr('text-opertor');
            if (typeof ob_text_operator != 'undefined' && ob_text_operator.length > 0) {
                text_operator = " " + ob_text_operator;
            }
            else{
                ob_text_operator = $('select.' + filed_name);
                if (typeof ob_text_operator != 'undefined' && ob_text_operator.length > 0) {
                  
                    text_operator = " " + $(ob_text_operator).find('option:selected').text();
                }
            }
            //giá trị của value_operator khi có text operator ví dụ : là tương úng với is,= | trong khoảng tương ứng với betweet , in tùy ý rồi sang bên server xử lý sau
            var ob_value_operator = $this.attr('value-operator');
            if (typeof ob_value_operator != 'undefined' && ob_value_operator.length > 0) {
                conds.push(ob_value_operator);
            }
            var text_cond_name = '';
            //push điều kiện lọc và giá trị vào mảng đồng thơi gen html cho nhãn lọc
            if($('.' + filed_name).length > 0 && parseInt($this.attr('check-length')) > 0){
                $('.' + filed_name).each(function (key, val) {
                    if (val.tagName == 'INPUT') {
                        conds.push($(val).val());
                        if($(val).attr('id') == 'timeEnd') text_cond_name += " đến " + $(val).val();
                        else text_cond_name += " " + $(val).val();
                    }
                    else if (val.tagName == 'SELECT') {
                        conds.push($(val).val());
                        text_cond_name += " " + $(val).find('option:selected').text();
                    }

                });
            }else{
                conds.push($this.attr('value-id'));
                text_cond_name += " " + $this.text();
            }
            
            //gắn các thuộc tính vào đối tượng item filter
            filter_ob.field_name = filed_name;
            filter_ob.conds = conds;
            filter_ob.tag = text_field_name + text_operator + text_cond_name;

            var replace = false;
            var matches = true;
            var val;
            var key;
            //kiểm tra item lọc này có trùng nhau không
            if (data_filter_add.itemAddFilters != null) {
                for (var i = 0; i < data_filter_add.itemAddFilters.length; i++) {
                    val = data_filter_add.itemAddFilters[i];
                    //nếu 2 nhãn lọc giống nhau
                    if (filter_ob.field_name == val.field_name) {
                        var cond_matches = 0;
                        for (var cond = 0; cond < val.conds.length; cond++) {
                            if (val.conds[cond] == filter_ob.conds[cond]) cond_matches++;
                            else break;
                        }
                        if (cond_matches == val.conds.length) {
                            //showNotification('Điều kiện lọc đã có', 0);
                            return;
                        }
                        // nếu điều kiện lọc mà giống nhau thì nhãn này sẽ bị thay thế
                        if (val.conds[0] == filter_ob.conds[0]) {
                            replace = true;
                            key = i;
                        }
                    }
                }
                if(replace){
                    for (var i = 1; i < val.conds.length; i++) data_filter_add.itemAddFilters[key].conds[i] = filter_ob.conds[i]; //thay thế đối tượng tronmang itemAddFilters
                    data_filter_add.tagAddFilters[key] = filter_ob.tag;
                renderTagFilterAdd( data_filter_add.tagAddFilters)
                   // updateStatusBtnSaveFilterAdd()
                   // updateStatusBtnRemoFilterAdd()
                }
                else {
                    //thêm 1 đối item filter vào itemAddFilters
                    data_filter_add.itemAddFilters.push(filter_ob);
                    data_filter_add.tagAddFilters.push(filter_ob.tag);
                    renderTagFilterAdd( data_filter_add.tagAddFilters)
                }
            }
        }
    });

    // Đăng ký sự kiện khi remove nhãn lọc
    $('#container-filters-add').on('click', '.item  a.remove', function () {
        //lấy đối tượng li
        var parent_item = $(this).parents('.item');
        var index = $(parent_item).attr('data-index');
        data_filter_add.itemAddFilters.splice(index - 1, 1);
        data_filter_add.tagAddFilters.splice(index - 1, 1);
        resetIndexAdd();
        $(this).parent().parent().remove();

    });

    $("body").on('click', '#btn-save-filter-add', function(){

        var filterId = $("input#filterId").val();
        var filterName = '';
        var displayOrder = 0;
        filterName = $("input#nameFilter").val().trim();
        displayOrder = ($("#ulFilter .liFilter").length) +1;
        if (filterName == '') {
            showNotification('Vui lòng nhập tên báo cáo', 0);
            return false;
        }
        var filterData = data_filter_add.itemAddFilters;
        var tagFilter = data_filter_add.tagAddFilters;
        if(filterData.length <= 0 && tagFilter.length <= 0){
            showNotification('Vui lòng chọn bộ lọc', 0);
            return false;
        }
        var btn = $('#btn-save-filter-add');
        btn.prop('disabled', true);
        $.ajax({
            type: "POST",
            url: btn.attr('data-href'),
            //async: false,
            data: {
                FilterId: filterId,
                FilterName: filterName,
                FilterData: JSON.stringify(filterData),
                TagFilter: JSON.stringify(tagFilter),
                ItemTypeId: $('#itemTypeId').val(),
                DisplayOrder: displayOrder,
                FilterNote : $("input#noteFilter").val(),
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                $("input#nameFilter").val('');
                $("input#filterId").val(0);
                $('#container-filters-add').html('');
                $("input#noteFilter").val('');
                if(json.code == 1){
                   resetTable();
                   resetTableFilter();
                   var listFilters = json.listFilters;
                   var htmlSelect =        '<li class="position-relative btn_add_filter_click" value="0">Danh sách bộ lọc <i class="fa fa-caret-down" aria-hidden="true"></i>';
                   htmlSelect +=            '<ul>';
                   // var ulFilter = '<li class="active" id="liFilter_0"><a href="#tab_0" data-id="0" data-toggle="tab" aria-expanded="true">Tất cả '+$('h1.ttl-list-order').html()+'</a></li>'
                   $.each(listFilters, function(k,v){
                        htmlSelect += '<li class="btn_add_filter_click" value="'+v.FilterId+'">'+v.FilterName+'  &nbsp&nbsp  <i class="fa fa-info-circle" aria-hidden="true"> <span>'+v.FilterNote+'</span>  </i></li>'
                        // ulFilter += '<li id="liFilter_'+v.FilterId+'"><a href="#tab_'+v.FilterId+'" data-id="'+v.FilterId+'" data-toggle="tab" aria-expanded="false">'+v.FilterName+'</a></li>';
                   });
                    htmlSelect +=       '</ul>';
                    htmlSelect +=   '</li>';
                   $("#btn_add_filter").html(htmlSelect);
                   // $("ul#ulFilter").html(ulFilter);
                    $("#modalAddFilter").modal('hide')
                    // $('.input-group-btn ul.dropdown-menu li.dropdown-submenu ul').slideUp();
                }
                btn.prop('disabled', false);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                btn.prop('disabled', false);
            }
        });
        return false;
    }).on('click', 'a.btn-show-modal-edit-filter', function(){
        var data_filter_add = {
            itemAddFilters: [],
            filterId: 0,
            tagAddFilters: []
        };
        $("#btn-remove-ilter").css("display", "block");
        $("#titleAddFilter").html('Cập nhật báo cáo');
        $("#btn-save-filter-add").html('Cập nhật');
        $("input#nameFilter").val('');
        $("input#filterId").val(0);
        $("input#noteFilter").val('');
        $('#container-filters-add').html('');
        var filterId = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: $("input#urlGetFilter").val(),
            //async: false,
            data: {
                FilterId: filterId,
            },
            success: function (response) {
                var json = $.parseJSON(response);
                if(json.code == 1){
                    var data = json.data;
                    $("input#filterId").val(filterId);
                   $("input#nameFilter").val(data.FilterName);
                   var filterDatas = $.parseJSON(data.FilterData);
                   $.each(filterDatas, function(k,v){
                    data_filter_add.itemAddFilters.push(v);
                    data_filter_add.tagAddFilters.push(v.tag);
                   });
                   renderTagFilterAdd($.parseJSON(data.TagFilter));
                   $("input#noteFilter").val(data.FilterNote);
                   $("#modalAddFilter").modal('show')
                }
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                btn.prop('disabled', false);
            }
        });
         return false;
    }).on('click', '#btn-remove-ilter', function(){
        $.ajax({
            type: "POST",
            url: $('#remove-filter').attr('data-href'),
            //async: false,
            data: {
                FilterId: $("input#filterId").val(),
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if(json.code == 1){
                    $('#modalAddFilter').modal("hide");
                    $('.new-style #tbodyFilter #trItem_' + json.filterId).remove();
                    $( "#btn_add_filter .btn_add_filter_click .btn_add_filter_click").each(function() {
                        if( $(this).val() == json.filterId){
                            $(this).remove();
                        }
                    });

                }
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
         return false;
    });

}

function saveConfigTable(){

    $("#table-data").tableHeadFixer({"left": -1});
    arrIdShowAndHideTable = [];
    var tableUserJson1 = [];
    $('#tbodyConfig tr').each(function () {
        var $this = $(this).find('td');
        tableUserJson1.push({
            ColumnName: $this.attr('column-name'),
            ColumnNameUser: $this.attr('name-user'),
            ModelsDb: $this.attr('modals-db'),
            Status: $this.attr('status'),
            Edit: $this.attr('edit'),
            IdEdit: $this.attr('id-edit'),
            Number: $this.attr('number'),
            NameRelationship: $this.attr('name-relationship'),
            DateTime: $this.attr('date-time'),
            IsActive: $this.eq(2).find('input').attr('data-value'),
            IsLock: $this.eq(3).find('input').attr('data-value'),
        });
    });
    $.ajax({
        type: "POST",
        url: $('input#urlActiveAndLock').val(),
        data: {
            ConfigTableId: $('#tbodyConfig tr').attr('config-table-id'),
            TableUserJson: JSON.stringify(tableUserJson1),
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1){
                resetTable();
                resetTableFilter();
                setTimeout(function(){
                    countColumnTable();
                }, 500);
            }
            showNotification(json.message, json.code);
        },
        error: function (response) {
            showNotification($('input#errorCommonMessage').val(), 0);
        }
    });
}

function renderTagFilterAdd(data) {
    var html = '';
    for (var i = 0; i < data.length; i++) {

        var split = data[i].split('là') 
        html += '<tr class="item" data-index="' + (i + 1) + '">';
        html += '<td>' + split[0] + '</td>';
        html += '<td>' + split[1] + '</td>';
        html += '<td><a href="javascript:void(0);" class="remove"><i class="fa fa-fw fa-trash font-size-12px"></i></a ></td>';
        html += '</tr>';
    }
    
    $('#container-filters-add').html(html);

}
function resetIndexAdd() {
    $('#container-filters-add').find('.item').each(function (key, val) {
        $(this).attr('data-index', key + 1);
    });
}

    
function renderContentFilters(data){
    var html = '';
    if(data!=null) {
        for (var item = 0; item < data.length; item++) {
            html += '<tr id="trItem_' + data[item].FilterId + '" class="trItem">';
            html += '<td>'+data[item].Code+'</td>';
            html += '<td>'+ getDayText(data[item].DayDiff) + data[item].CrDateTime +'</td>';
            html += '<td><a href="javascript:void(0);" class="btn-show-modal-edit-filter" data-id="'+ data[item].FilterId +'">' + data[item].FilterName + '</a></td>';
            html += '<td>' + data[item].UserCreate + '</td>';
            html += '<td>' + data[item].FilterNote + '</td>';
            html += '</tr>';
        }

        html += '<tr><td colspan="5" class="paginate_table modal_paginate_table"></td></tr>';

        $('#tbodyFilter').html(html);
    }
   
}

function resetTableFilter(){
    actionItemAndSearchFilter({
        ItemName: 'Báo cáo',
        IsRenderFirst: true,
        extendFunction: function(itemIds, actionCode){

        }
    });

   
}