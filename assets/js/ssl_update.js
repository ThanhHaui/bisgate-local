var app = app || {};

app.init = function (sslId) {
    app.addNewSSL(sslId);
    if(parseInt(sslId) > 0){
        $("#totalBase").text($("#tbodyBase tr").length);
        $("#totalSslDetail").text($("#tbodySslDetails tr").length);
        app.viewSSL(sslId);
    }
    app.submit(sslId);

    $('body').on('keydown', 'input.cost', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.cost', function(){
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    });

};

app.addNewSSL = function(sslId = 0){
    if(parseInt(sslId) == 0){
        var panelCustomer = $('#panelCustomer');
        var pageIdCustomer = $('input#pageIdCustomer');
        $('#txtSearchCustomer').click(function (e) {
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


        $('#btnDeleteUser').click(function() {
            $('.submit_hide').removeClass('choose-customer');
            $('.boxInfo').hide()
            $('.boxSearch').show()
            $('.btnShơwModal').hide()
            $('.btnHideModal').show()
            $('#btnEditVehicle').hide()
            $('.btnShowAdd').hide()
            $('.btnHideAdd').show()
            $('#userId').val(0);
            $('select#vehicleId').val(0).trigger('change');
        });

        $(".search-data input").keyup(function () {
            var val = $(this).val();
            if (val != '') {
                $('.pCustomerName span:not(:contains(' + val + '))').closest('li').hide();
                $('.pCustomerName span:contains(' + val + ')').closest('li').show();
            } else {
                $('.pCustomerName span').closest('li').show();
            }
        });
    }

    $('select#vehicleId').select2({
        placeholder: "---Chọn xe",
        allowClear: true,
        ajax: {
            url: $("input#urlGetVehicleNotInSsl").val(),
            type: 'POST',
            dataType: 'json',
            data: function (data) {
                var userId = parseInt($("input#userId").val());
                return {
                    SearchText: data.term,
                    UserId: userId
                };
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.LicensePlate,
                            id: item.VehicleId,
                            data: item
                        };
                    })
                };
            }
        }
    });


    $("body").on('click', '.btnShowModalBase', function(){
        $('#count_data_package').text(0);
        var isCheck = parseInt($(this).attr('data-id'));
        $("#btnAddPackage").attr('data-id', isCheck);
        var packageIds = [];
        var packageTypeId = 0;
        if(isCheck == 1){
            packageTypeId = 1;
            $("#modalShowListPackages .modal-title").html('Danh sách gói phần mềm base');
            $("#tbodyBase tr").each(function(){
                packageIds.push($(this).attr('data-id'));
            });
            if(parseInt(sslId) > 0){
                $("#tbodyBaseError tr").each(function(){
                    packageIds.push($(this).attr('data-id'));
                });
            }
        } else if(isCheck == 2){
            packageTypeId = 2;
            $("#modalShowListPackages .modal-title").html('Danh sách gói phần mềm mở rộng');
            $("#tbodySslDetails tr").each(function(){
                packageIds.push($(this).attr('data-id'));
            });
            if(parseInt(sslId) > 0){
                $("#tbodySslDetailsError tr").each(function(){
                    packageIds.push($(this).attr('data-id'));
                });
            }
        }
        loadDataPackages(packageIds, '', packageTypeId);

    }).on('keyup', '#packageName', function(){
        var isCheck = parseInt($('.btnShowModalBase').attr('data-id'));
        var searchText = $(this).val();
        var packageIds = [];
        var packageTypeId = 0;
        if(isCheck == 1){
            packageTypeId = 1;
            $("#tbodyBase tr").each(function(){
                packageIds.push($(this).attr('data-id'));
            });
        } else if(isCheck == 2){
            packageTypeId = 2;
            $("#tbodySslDetails tr").each(function(){
                packageIds.push($(this).attr('data-id'));
            });
        }
        setTimeout(function(){
            loadDataPackages(packageIds, searchText, packageTypeId);
        }, 500);
        return false;
    }).on('click', '#btnAddPackage', function(){
        var isCheck = parseInt($(this).attr('data-id'));
        var arrPackages = [];
        $('input.iCheckTable').each(function () {
            if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')){
                arrPackages.push({
                    PackageId: $(this).val(),
                    PackageName:  $(this).parent().parent().parent().find('td').eq(2).text().trim(),
                });
            }
        });
        if(isCheck == 1){
            if(arrPackages.length > 1){
                showNotification('Gói phần mềm base chỉ được chọn 1 gói duy nhất. Vui lòng chọn lại!', 0);
                return false;
            }else if(arrPackages.length == 0){
                showNotification('Vui lòng chọn gói phần mềm base.', 0);
                return false;
            }
            showPackageBaseOrSslDetail(arrPackages, isCheck);
        } else if(isCheck == 2){
            showPackageBaseOrSslDetail(arrPackages, isCheck);
        }
    }).on('click', '#tbodyBase .link_delete', function(){
        $('.submit_hide').removeClass('active');
        $("#totalBase").text(0);
        $(this).parent().parent().remove();
    }).on('keyup', '#tbodyBase .packagePrice', function(){
        var packagePrice = replaceCost($(this).val(), true);
        var expiryDate = replaceCost($("#tbodyBase .expiryDate").val(), true);

        var total = packagePrice * expiryDate;
        $("#tbodyBase .packageTotalPrice").text(formatDecimal(total.toString()));
    }).on('keyup', '#tbodyBase .expiryDate', function(){
        var expiryDate = replaceCost($(this).val(), true);
        var packagePrice = replaceCost($("#tbodyBase .packagePrice").val(), true);

        var total = packagePrice * expiryDate;
        $("#tbodyBase .packageTotalPrice").text(formatDecimal(total.toString()));
    }).on('click', '#tbodySslDetails .link_delete', function(){
        var count = parseInt($("#totalSslDetail").text());
        $("#totalSslDetail").text(count - 1);
        $(this).parent().parent().remove();
    }).on('keyup', '#tbodySslDetails .packagePrice', function(){
        var $this = $(this).parent().parent().find('td');
        var packagePrice = replaceCost($(this).val(), true);
        var expiryDate = replaceCost($this.eq(3).find('input').val(), true);
        var total = packagePrice * expiryDate;
        $this.eq(4).text(formatDecimal(total.toString()));
    }).on('keyup', '#tbodySslDetails .expiryDate', function(){
        var $this = $(this).parent().parent().find('td');
        var expiryDate = replaceCost($(this).val(), true);
        var packagePrice =  replaceCost($this.eq(2).find('input').val(), true);
        var total = packagePrice * expiryDate;
        $this.eq(4).text(formatDecimal(total.toString()));
    });

    $("#table-package").on('ifToggled', 'input.iCheckTable', function (e) {
        var itemIds = [];
        if (e.currentTarget.checked) {
            $("input.iCheckTable:checked").each(function () {
                itemIds.push(parseInt($(this).val()))
            });
        }else{
            $("input.iCheckItem:checked").each(function () {
                itemIds.push(parseInt($(this).val()))
            });
        }
        $("span#count_data_package").text(itemIds.length);

    });
}

app.viewSSL = function(sslId){
    if(parseInt(sslId) > 0){
        $('input.iCheck').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
        $("body").on('click', '#btnShowModalActiveContract', function(){
            $("#modalActiveContract").modal('show');
        }).on('click', '#btnActiveContract', function(){
            var sSLStatusId = $('input[name="ContractStatusId"]:checked').val()
            changeStatusSSL(sSLStatusId, sslId)
            return false;
        }).on('click', '#btnActiveStatusSSL', function(){
            $('#btnYesOrNo').html('');
            $('#btnYesOrNo').CeoSlider({
                lable_right : 'DUYỆT',
                lable_left : 'KHÔNG DUYỆT',
                lable_yes : 'Buông chuột để DUYỆT',
                lable_no : 'Buông chuột để KHÔNG DUYỆT',
                success : function (data) {
                    changeStatusSSL(2, sslId);
                    return false;
                },
                error : function (data) {
                    $("#modalActiveOrCancel").modal('hide');                }
            });
            $("#modalActiveOrCancel").modal('show');

            return false;
        }).on('click', '#btnRemoveStatusSSL', function(){
            if(($('#tbodySslDetailsError tr td').hasClass('out-of-date')) || ($('#tbodySslDetails tr td').hasClass('out-of-date')) || ($('#tbodyBase tr td').hasClass('out-of-date'))){
                showNotification('Còn gói dịch vụ chưa hết hạn nên không thể hủy bỏ thành công, vui lòng kiểm tra lại');
                return false;
            }
            $('#btnYesOrNo').html('');
            $('#btnYesOrNo').CeoSlider({
                lable_right : 'HỦY BỎ',
                lable_left : 'KHÔNG HỦY',
                lable_yes : 'Buông chuột để HỦY',
                lable_no : 'Buông chuột để KHÔNG HỦY',
                success : function (data) {
                    changeStatusSSL(6, sslId);
                    return false;
                },
                error : function (data) {
                    $("#modalActiveOrCancel").modal('hide');                }
            });
            $("#modalActiveOrCancel").modal('show');
            return false;
        }).on('click', '.btnChangeStatus', function(){
            var id = parseInt($(this).attr('data-id'));
            var isCheck = $(this).attr('is-check');
            var packageCode = $(this).attr('package-code');
            var contractStatusId = parseInt($(this).attr('status-id'));
            if($(this).hasClass('cutStatus')){
                $("#modalActiveService").modal('show');
                $('#ServiceId').val(id);
                $('#ServiceisCheck').val(isCheck);
                $('#ServicepackageCode').val(packageCode);
            } else{
                var html = `
                <div class="col-sm-12">
                    <div class="radio-group">
                        <span class="item"><input type="radio" name="ServiceStatusId2" class="iCheck" value="2"> Đang dùng dịch vụ</span>
                        <br><br>
                `;
                if(contractStatusId == 3) {
                    html += `
                        <span class="item"><input type="radio" name="ServiceStatusId2" class="iCheck" value="3" checked> Đang tạm cắt</span>
                        <br><br>
                        <span class="item"><input type="radio" name="ServiceStatusId2" class="iCheck" value="5"> Dừng hẳn dịch vụ</span>
                    `;
                } else if (contractStatusId == 5) {
                    html += `
                        <span class="item"><input type="radio" name="ServiceStatusId2" class="iCheck" value="5" checked> Dừng hẳn luôn</span>
                    `;
                }
                html += `</div></div>`;

                $("div.contentActiveService2").html(html);

                $('input.iCheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });

                $("#btnActiveService2").attr({'data-id': id, 'package-code': packageCode});

                $("#modalActiveService2").modal('show');
                // var StatusId = $(this).attr('status-id');
                // $('#btnYesOrNo').html('');
                // $('#btnYesOrNo').CeoSlider({
                //     lable_right : 'BẬT',
                //     lable_left : 'KHÔNG BẬT',
                //     lable_yes : 'Buông chuột để BẬT',
                //     lable_no : 'Buông chuột để KHÔNG BẬT',
                //     success : function (data) {
                //         changeStatusAddSSL(StatusId, id, isCheck, packageCode);
                //         return false;
                //     },
                //     error : function (data) {
                //         $("#modalActiveOrCancel").modal('hide');                    
                //     }
                // });
                // $("#modalActiveOrCancel").modal('show');

                return false;
            }
        }).on('click', '#btnActiveService', function(){
            var StatusId = $('input[name="ServiceStatusId"]:checked').val();
            var id = $('#ServiceId').val();
            var isCheck = $('#ServiceisCheck').val();
            var PackageCode = $('#ServicepackageCode').val();
            changeStatusAddSSL(StatusId, id, isCheck, PackageCode);
            return false;
        }).on('click', '#btnActiveService2', function() {
            var contractStatusId = $('input[name="ServiceStatusId2"]:checked').val();
            var sslDetailId = parseInt($(this).attr('data-id'));
            var packageCode = $(this).attr('package-code');
            if(sslDetailId > 0 && contractStatusId > 0) {
                changeStatusAddSSL(contractStatusId, sslDetailId, 4, packageCode);
            } else showNotification('Có lỗi xảy ra, vui lòng thử lại');
            return false;
        });
    }
}

app.submit = function(sslId){
    $("body").on('click', '.submit', function(){
        var userId = parseInt($("input#userId").val());
        if(userId == 0){
            showNotification("Vui lòng chọn khách hàng.", 0);
            return false;
        }
        var vehicleId = $("#vehicleId").val();
        var packagePrice = 0;
        var expiryDate = 0;
        if(sslId == 0){
            packagePrice =  replaceCost($("#tbodyBase .packagePrice").val(), true);
            expiryDate = replaceCost($("#tbodyBase .expiryDate").val(), true);
        }

        var form = $('#sslForm');
        var datas = form.serializeArray();
        datas.push({ name: "SSLId", value: sslId });
        datas.push({ name: "UserId", value: userId });
        datas.push({ name: "VehicleId", value: vehicleId });
        datas.push({ name: "PackageId", value: $("#tbodyBase tr").attr('data-id') });
        datas.push({ name: "CheckAdd", value: $("#tbodyBase tr").attr('check-add') });
        datas.push({ name: "PackagePrice", value: packagePrice });
        datas.push({ name: "ExpiryDate", value: expiryDate });
        datas.push({ name: "SSLDetails", value: JSON.stringify(getSSLDetails(sslId)) });
        $('.submit').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: datas,
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if(json.code == 1){
                    if(parseInt(sslId) == 0) redirect(false, $("#sslListUrl").attr('href'));
                    else redirect(true, '');
                }
                $('.submit').prop('disabled', false);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                $('.submit').prop('disabled', false);
            }
        });

        return false;
    });
}

$(document).ready(function(){
    var sslId = parseInt($("input#sslId").val());
    app.init(sslId);
});

$(window).click(function (e) {
    var search = $('#panelCustomer');
    var pageIdCustomer = $('input#pageIdCustomer');
    if (search.has(e.target).length == 0 && !search.is(e.target) && pageIdCustomer.has(e.target).length == 0 && !pageIdCustomer.is(e.target)) {
        search.removeClass('active');
        search.find('panel-body').css("width", "99%");
    }
});


function loadDataPackages(packageIds, searchText = '', packageTypeId){
    $.ajax({
        type: "POST",
        url: $("input#urlGetPackages").val(),
        data: {
            IsCheck: 0,
            UserId: 0,
            PackageTypeId: packageTypeId,
            PackageIds: JSON.stringify(packageIds),
            SearchText: searchText
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if(json.code == 1){
                $('.submit_hide').addClass('active');
                var html = '';
                $.each(json.data, function(i, item) {
                    html += `
                        <tr>
                            <td><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="${item.PackageId}"></td>
                            <td>${item.PackageCode}</td>
                            <td>${item.PackageName}</td>
                        </tr>
                    `;
                });
                $("#tbodyPackages").html(html);
                $('input.iCheckTable').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
                $("span#total_package").text(json.data.length);
                $("#modalShowListPackages").modal('show');
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

function showPackageBaseOrSslDetail(packages, isCheck){
    var sslId = parseInt($("input#sslId").val());
    if(isCheck == 1){
        var html = '';
        if(sslId == 0){
            html = `
                <tr data-id="${packages[0].PackageId}" check-add="0">
                    <td>1</td>
                    <td class="packageName">${packages[0].PackageName}</td>
                    <td><input class=" cost packagePrice" value="0"> đ/tháng</td>
                    <td><input class=" cost expiryDate" value="0"> tháng</td>
                    <td class="packageTotalPrice">0</td>
                    <td><a href="javascript:void(0)" class="link_delete" title="Xóa"><i class="fa fa-trash-o"></i></a></td>
                </tr>
            `;
        } else {
            html = `
                <tr data-id="${packages[0].PackageId}" check-add="0">
                    <td>1</td>
                    <td class="packageName">${packages[0].PackageName}</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                </tr>
            `;
        }
        $("#tbodyBase").html(html);
    } else if(isCheck == 2){
        var html = '';
        var count  = $("#tbodySslDetails tr").length;
        if(sslId == 0){
            $.each( packages, function( i, item ) {
                count++;
                html += `<tr data-id="${item.PackageId}" check-add="0">
                            <td>${count}</td>
                            <td>${item.PackageName}</td>
                            <td><input class=" cost packagePrice" value="0"> đ/tháng</td>
                            <td><input class=" cost expiryDate" value="0"> tháng</td>
                            <td id="packageTotalPrice">0</td>
                            <td><a href="javascript:void(0)" class="link_delete" title="Xóa"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                    `;
            });
        } else {

            $.each( packages, function( i, item ) {
                count++;
                html += `<tr data-id="${item.PackageId}" check-add="0">
                        <td>${count}</td>
                        <td>${item.PackageName}</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                    </tr>
                `;
            });
        }
        $("#tbodySslDetails").append(html);
    }

    $('body').on('keydown', 'input.cost', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.cost', function(){
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    });
    if(isCheck == 1) $("#totalBase").text(1);
    else if(isCheck == 2) $("#totalSslDetail").text($("#tbodySslDetails tr").length);
    $("#modalShowListPackages").modal('hide');
}
$(document).ready(function () {
    $("input.cost").bind("cut copy paste", function (e) {
        e.preventDefault();
    });
   
    $("input.cost").on("contextmenu",function(e){
        return false;
    });
    

});

function getSSLDetails(sslId){
    var sslDetails = [];
    $("#tbodySslDetails tr").each(function(){
        var $this = $(this).find('td');
        sslDetails.push({
            CheckAdd: $(this).attr('check-add'),
            PackageId: $(this).attr('data-id'),
            PackagePrice: sslId == 0 ? replaceCost($this.eq(2).find('input').val(), true):0,
            ExpiryDate: sslId == 0 ? replaceCost($this.eq(3).find('input').val(), true):0,
        });
    });

    return sslDetails;

}

function changeStatusSSL(sSLStatusId, sslId){
    $.ajax({
        type: "POST",
        url: $("input#urlChangeStatus").val(),
        data: {
            SSLStatusId: sSLStatusId,
            SSLId: sslId
        },
        success: function (response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            if(json.code == 1){
                if(sslId == 0) redirect(false, $("#sslListUrl").attr('href'));
                else redirect(true, '');
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

}
function changeStatusAddSSL(statusId, id, isCheck, packageCode){
    if(id > 0 && packageCode.trim() != '' && statusId > 0){
        $.ajax({
            type: "POST",
            url: $("input#urlChangeStatusPackage").val(),
            data: {
                StatusId: statusId,
                Id: id,
                IsCheck: isCheck,
                PackageCode: packageCode,
                SSLId: $("input#sslId").val(),
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if(json.code == 1){
                    redirect(true, '');
                }
                $(this).prop('disabled', false);
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                $('.submit').prop('disabled', false);
            }
        });
    } else showNotification('Có lỗi xảy ra, vui lòng thử lại.', 0);
    return false;

}

