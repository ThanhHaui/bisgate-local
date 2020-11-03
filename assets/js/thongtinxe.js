$(document).ready(function () {
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

    $(".search-data input").keyup(function () {
        var val = $(this).val();
        if (val != '') {
            $('.pCustomerName:not(:contains(' + val + '))').closest('li').hide();
            $('.pCustomerName:contains(' + val + ')').closest('li').show();
        } else {
            $('.pCustomerName').closest('li').show();
        }
    });
    var tags = [];
    var inputTag = $('input#tags');
    inputTag.tagsInput({
        'width': '100%',
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
    $('input.tagName').each(function () {
        inputTag.addTag($(this).val());
    });
    $('#ulTagExist').on('click', 'a', function () {
        var tag = $(this).text();
        if (!inputTag.tagExist(tag)) inputTag.addTag(tag);
    });

    var panelCustomer = $('#panelLXCustomer');
    var pageIdCustomer = $('input#pageIdCustomer');
    var statusSearch = null;
    $(document).on('click','.boxSelect .textbox-advancesearch',function (e) {
        e.stopPropagation();
        if (panelCustomer.hasClass('active')) {
            panelCustomer.removeClass('active');
            panelCustomer.find('panel-body').css("width", "99%");
        } else {
            panelCustomer.addClass('active');
            setTimeout(function () {
                panelCustomer.find('panel-body').css("width", "100%");
                $('.wrapper').addClass('open-search-customer');
            }, 100);
            pageIdCustomer.val('1');
        }
    });
    $(window).click(function (e) {
        var search = $('#panelCustomer');
        var pageIdCustomer = $('input#pageIdCustomer');
        if (search.has(e.target).length == 0 && !search.is(e.target) && pageIdCustomer.has(e.target).length == 0 && !pageIdCustomer.is(e.target)) {
            search.removeClass('active');
            search.find('panel-body').css("width", "99%");
        }
    });
});
$(document).on('click', '.add-sensors', function (e) {
    e.stopPropagation();
    $('.box-append').append('<div class="row mgbt-10">\
                                <div class="col-sm-3">\
                                    <p class="box-name">CẢM BIẾN 1 <i class="fa fa-caret-down caret" aria-hidden="true"></i>\
                                    </p>\
                                </div>\
                                <div class="col-sm-9">\
                                    <div class="box-search-advance customer">\
                                        <div class="row mgbt-10">\
                                            <div class="col-sm-3">\
                                                <p class="mt-6 d-flex">Dòng cảm biến*</p>\
                                            </div>\
                                            <div class="col-sm-9">\
                                                <select class="form-control" id="">\
                                                    <option value="0">--Chọn dòng cảm biến --</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="row">\
                                            <div class="col-sm-3">\
                                                <p class="mt-6 d-flex">Loại chức năng cảm biến*</p>\
                                            </div>\
                                            <div class="col-sm-9">\
                                                <select class="form-control" id="">\
                                                    <option value="0"> --Chọn chức năng cảm biến --</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="row">\
                                            <div class="col-sm-3">\
                                                <p class="mt-6 d-flex">Cách kết nối CB với thiết bị*</p>\
                                            </div>\
                                            <div class="col-sm-9">\
                                                <select class="form-control" id="">\
                                                    <option value="0"> Cổng PORT nào ?</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="row">\
                                            <div class="col-sm-3">\
                                                <p class="mt-6 d-flex">Cách kết nối CB với xe*</p>\
                                            </div>\
                                            <div class="col-sm-9">\
                                                <div class="row">\
                                                    <div class="col-sm-6">\
                                                        <p>Default</p>\
                                                        <p>High - Bật; Low - Tắt</p>\
                                                    </div>\
                                                    <div class="col-sm-6">\
                                                        <p>\
                                                            <label class="setting_check">\
                                                                <input type="checkbox" checked\
                                                                       class="checkBoxItem">\
                                                                <span class="checkmark"></span>\
                                                            </label>\
                                                            <span class="ml-40">Đảo</span>\
                                                            </p>\
                                                        <p>High - Tắt; Low - Bật</p>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>')
})
$(document).on('click', '.add-command', function (e) {
    e.stopPropagation();
    $('.sensor-command').append('  <div class="row mgt-10">\
                                <div class="col-sm-3">\
                                    <p>LỆNH 1 <span><i class="fa fa-caret-up" aria-hidden="true"></i></span></p>\
                                </div>\
                                <div class="col-sm-9">\
                                    <div class="box-search-advance">\
                                        <div class="row">\
                                            <div class="col-sm-4">\
                                                <p class="mt-6 d-flex">Phụ tùng cũ</p>\
                                            </div>\
                                            <div class="col-sm-8">\
                                                <select class="form-control" id="">\
                                                    <option value="0"></option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="row mgt-10">\
                                            <div class="col-sm-4">\
                                                <p class="mt-6 d-flex">Phụ tùng mới</p>\
                                            </div>\
                                            <div class="col-sm-8">\
                                                <select class="form-control" id="">\
                                                    <option value="0"></option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="row mgt-10">\
                                            <div class="col-sm-4">\
                                                <p class="mt-6 d-flex">Lý do thay thế</p>\
                                            </div>\
                                            <div class="col-sm-8">\
                                                <select class="form-control" id="">\
                                                    <option value="0"></option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="row mgt-10">\
                                            <div class="col-sm-4">\
                                                <p class="mt-6 d-flex">Loại dịch vụ</p>\
                                            </div>\
                                            <div class="col-sm-8">\
                                                <select class="form-control" id="">\
                                                    <option value="0"></option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                    <option value="1">CS: 56 TRẦN VĨ</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="row mgt-10">\
                                            <div class="col-sm-4">\
                                                <p class="mt-6 d-flex">Loại trả phí khắc phục</p>\
                                            </div>\
                                            <div class="col-sm-8">\
                                                <input type="text" class="form-control" id="" placeholder="">\
                                            </div>\
                                        </div>\
                                        <div class="row mgt-10">\
                                            <div class="col-sm-4">\
                                                <p class="mt-6 d-flex">Ghi chú</p>\
                                            </div>\
                                            <div class="col-sm-8">\
                                                <input type="text" class="form-control" id="" placeholder="">\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>')
})


