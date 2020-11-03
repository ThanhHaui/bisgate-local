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
