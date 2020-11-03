$(document).ready(function () {
    $("#tbodyUser").on("click", "a.link_delete", function () {
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#changeStatusUrl').val(),
                data: {
                    UserId: id,
                    StatusId: 0
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#user_' + id).remove();
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        return false;
    }).on("click", "a.link_status", function () {
        var id = $(this).attr('data-id');
        var statusId = $(this).attr('data-status');
        if (statusId != $('input#statusId_' + id).val()) {
            $.ajax({
                type: "POST",
                url: $('input#changeStatusUrl').val(),
                data: {
                    UserId: id,
                    StatusId: statusId
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) {
                        $('td#statusName_' + id).html(json.data.StatusName);
                        $('input#statusId_' + id).val(statusId);
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }
        $('#btnGroup_' + id).removeClass('open');
        return false;
    });
    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('input.iCheckRadio').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    $("body").on('click', '.btnShowModalGroup', function () {
        $("#btnShowModalGroups").modal('show');
    });

    $('#showModalUser').click(function () {
        $('#showModalUsers').modal('show')
    });
      $('.show_info_user').click(function () {
       var modal = $(this).attr('data-modal');
        $(modal).modal('show')
    });

    $('body').on('ifToggled', '.check_tab_show input.iCheckRadio', function (e) {
        $('.tab-hide').removeClass('active');
        if (e.currentTarget.checked) {
            var tab = $(this).parent().parent().attr('data-tab');
            $(tab).addClass('active');
        } else {
        }
    }).on('click', '.btnAddHb', function (e) {
        $('.arr-hb').append('<div class="border-hb mgbt-10">\n' +
                            '           <div class="row mgbt-10">\n' +
                            '                <div class="col-sm-6">\n' +
                            '                    <div class="row mgbt-10">\n' +
                            '                        <div class="col-sm-4">\n' +
                            '                            <p>Tên bằng cấp</p>\n' +
                            '                        </div>\n' +
                            '                        <div class="col-sm-8">\n' +
                            '                            <input type="text" name="NameDegree" class="form-control "\n' +
                            '                                   value="">\n' +
                            '                       </div>\n' +
                            '                    </div>\n' +
                            '                </div>\n' +
                            '                <div class="col-sm-6">\n' +
                            '                    <div class="row mgbt-10">\n' +
                            '                        <div class="col-sm-4">\n' +
                            '                            <p>Loại bằng</p>\n' +
                            '                        </div>\n' +
                            '                        <div class="col-sm-8">\n' +
                            '                            <input type="text" name="TypeDegree" class="form-control "\n' +
                            '                                   value="">\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '            <div class="row mgbt-10">\n' +
                            '                <div class="col-sm-6">\n' +
                            '                    <div class="row mgbt-10">\n' +
                            '                        <div class="col-sm-4">\n' +
                            '                            <p>Tên trường</p>\n' +
                            '                        </div>\n' +
                            '                        <div class="col-sm-8">\n' +
                            '                            <input type="text" name="SchoolDegree" class="form-control "\n' +
                            '                                   value="">\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                </div>\n' +
                            '                <div class="col-sm-6">\n' +
                            '                    <div class="row mgbt-10">\n' +
                            '                        <div class="col-sm-4">\n' +
                            '                            <p>Tên ngành</p>\n' +
                            '                        </div>\n' +
                            '                        <div class="col-sm-8">\n' +
                            '                            <input type="text" name="BranchDegree" class="form-control "\n' +
                            '                                   value="">\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '           <div class="row mgbt-10">\n' +
                            '                <div class="col-sm-6">\n' +
                            '                    <div class="row mgbt-10">\n' +
                            '                        <div class="col-sm-4">\n' +
                            '                            <p>Khóa học từ</p>\n' +
                            '                       </div>\n' +
                            '                        <div class="col-sm-8">\n' +
                            '                            <input type="text" name="FromDateTime" class="form-control "\n' +
                            '                                  value="">\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '               </div>\n' +
                            '                <div class="col-sm-6">\n' +
                            '                    <div class="row mgbt-10">\n' +
                            '                        <div class="col-sm-4">\n' +
                            '                            <p>đến</p>\n' +
                            '                        </div>\n' +
                            '                       <div class="col-sm-8">\n' +
                            '                           <input type="text" name="ComeDateTime" class="form-control " value="">\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                </div>\n' +
                            '           </div>\n' +
                            '        </div>\n' +
                            '    </div>');
    }).on('click', '.btnAddCDKN', function (e) {
        $('.arr-cdkn').append('<div class="row mgbt-10 item-cdkn">\n' +
                            '                    <div class="col-sm-2">\n' +
                            '                    </div>\n' +
                            '                   <div class="col-sm-5">\n' +
                            '                        <div class="row mgbt-10">\n' +
                            '                            <div class="col-sm-4">\n' +
                            '                                <p class="mt-6">Cấp bậc</p>\n' +
                            '                            </div>\n' +
                            '                            <div class="col-sm-8">\n' +
                            '                                <input type="text" id="RankOther" class="form-control " value="">\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                    <div class="col-sm-5">\n' +
                            '                       <div class="row mgbt-10">\n' +
                            '                            <div class="col-sm-4">\n' +
                            '                                <p class="mt-6">Phòng ban</p>\n' +
                            '                            </div>\n' +
                            '                           <div class="col-sm-8">\n' +
                            '                                <input type="text" id="DepartmentOther" class="form-control " value="">\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                </div>');
    }).on('click', '.btnAddKMCT', function (e) {
        $('.arr-knct').append('     <div class="border-hb mgbt-10">\n' +
            '                                                <div class="row mgbt-10">\n' +
            '                                                    <div class="col-sm-2">\n' +
            '                                                        Giai đoạn 1\n' +
            '                                                    </div>\n' +
            '                                                    <div class="col-sm-5">\n' +
            '                                                        <div class="row mgbt-10">\n' +
            '                                                            <div class="col-sm-4">\n' +
            '                                                                <p class="mt-6">từ</p>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="col-sm-8">\n' +
            '                                                                <input type="text" name="ExperienceFrom"\n' +
            '                                                                       class="form-control datepicker" value="">\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                    <div class="col-sm-5">\n' +
            '                                                        <div class="row mgbt-10">\n' +
            '                                                            <div class="col-sm-4">\n' +
            '                                                                <p class="mt-6">đến</p>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="col-sm-8">\n' +
            '                                                                <input type="text" name="ExperienceCome"\n' +
            '                                                                       class="form-control datepicker" value="">\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                                <div class="br"></div>\n' +
            '                                                <div class="row mgbt-10">\n' +
            '                                                    <div class="col-sm-2">\n' +
            '                                                    </div>\n' +
            '                                                    <div class="col-sm-5">\n' +
            '                                                        <div class="row mgbt-10">\n' +
            '                                                            <div class="col-sm-4">\n' +
            '                                                                <p class="mt-6">Cấp bậc</p>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="col-sm-8">\n' +
            '                                                                <input type="text" name="ExperienceRank"\n' +
            '                                                                       class="form-control" value="">\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                    <div class="col-sm-5">\n' +
            '                                                        <div class="row mgbt-10">\n' +
            '                                                            <div class="col-sm-4">\n' +
            '                                                                <p class="mt-6">phòng ban</p>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="col-sm-8">\n' +
            '                                                                <input type="text" name="ExperienceDepartment"\n' +
            '                                                                       class="form-control" value="">\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                                <div class="row mgbt-10">\n' +
            '                                                    <div class="col-sm-2">\n' +
            '                                                    </div>\n' +
            '                                                    <div class="col-sm-10">\n' +
            '                                                        <div class="row mgbt-10">\n' +
            '                                                            <div class="col-sm-2">\n' +
            '                                                                <p class="mt-6">Công ty</p>\n' +
            '                                                            </div>\n' +
            '                                                            <div class="col-sm-10">\n' +
            '                                                                <input type="text" name="ExperienceCompany" class="form-control"\n' +
            '                                                                       value="">\n' +
            '                                                            </div>\n' +
            '                                                        </div>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                                <div class="row mgbt-10">\n' +
            '                                                    <div class="col-sm-2">\n' +
            '                                                    </div>\n' +
            '                                                    <div class="col-sm-10">\n' +
            '                                                        <p class="mt-6">Lĩnh vực hoạt động</p>\n' +
            '                                                        <textarea type="text" name="ExperienceWork" class="form-control"></textarea>\n' +
            '                                                    </div>\n' +
            '                                                </div>\n' +
            '                                            </div>\n' +
            '                                            <div class="row mgbt-10">\n' +
            '                                                <div class="col-sm-2">\n' +
            '                                                </div>\n' +
            '                                                <div class="col-sm-10">\n' +
            '                                                    <p class="mt-6">Thành tựu trong thời gian công tác</p>\n' +
            '                                                    <textarea type="text" name="ExperienceAchievement" class="form-control"></textarea>\n' +
            '                                                </div>\n' +
            '                                            </div>');
    });
});