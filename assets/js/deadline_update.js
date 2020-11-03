var app = app || {};

app.init = function (deadlineId) {
    app.customer(deadlineId);
    app.deadline(deadlineId);
    app.ssls(deadlineId);
    app.submit(deadlineId);
};

app.customer = function(deadlineId){
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

    $('#ulListCustomers ').on('click', 'li', function() {
        var fullName = $(this).find('#FullName').text();
        var phoneNumber = $(this).find('#PhoneNumber').text();
        var address = $(this).find('#Address').text();
        var userCode = $(this).find('#UserCode').text();
        var userId = parseInt($(this).attr('data-id'));
        $('.boxInfo .fullName').text(fullName);
        $('.boxInfo .phoneNumber').text(phoneNumber);
        $('.boxInfo .address').text(address);
        $('.boxInfo .userCode').text(userCode);
        $('.boxInfo #userId').val(userId);
        $('.boxInfo').show();
        $('.boxSearch').hide();
        $('.btnShơwModal').show();
        $('.btnHideModal').hide();
        panelCustomer.removeClass('active');
        $('.btnShowAdd').show();
        $('.btnHideAdd').hide();
        checkExitSSL(userId);
    });

    $('#btnDeleteUser').click(function() {
        $('.boxInfo').hide()
        $('.boxSearch').show()
        $('.btnShơwModal').hide()
        $('.btnHideModal').show()
        $('#btnEditVehicle').hide()
        $('.btnShowAdd').hide()
        $('.btnHideAdd').show()
        $('#userId').val(0);
        $('select#vehicleId').val(0).trigger('change');
        $("div.htmlGroupExtension").html('');
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

app.deadline = function(deadlineId){
    if( $('#tbodyBase_1 tr').length>0){
        $('.check-show-base').prop( "checked", true );
    }

    $("input.check-show-base").change(function(){
        if ( $(this).is(":checked") ){
            var html = `<tr data-id="1">
            <td>1</td>
            <td class="packageName">Gói base GSHT tiêu chuẩn</td>
        <td><input class=" cost packagePriceBase" value="0"> đ/tháng</td>
            <td><input class=" cost expiryDateBase" value="0"> tháng</td>
            <td class="packageTotalPrice">0</td>
            <td><a href="javascript:void(0)" class="link_delete_base" title="Xóa" count-id="1"><i class="fa fa-trash-o"></i></a></td>
        </tr>
              `;
            $("#tbodyBase_1").html(html);
        }
        else{
            $('#tbodyBase_1').empty();
        }
    });

    $("body").on('click', '#tbodyBase_1 .link_delete_base', function(){
        $('.check-show-base').prop( "checked", false );
    });
    $("body").on('click', '.btnShowModalBase', function(){
        $("span#count_data_package").text(0);
        $("input#packageName").val('');
        var userId = parseInt($("input#userId").val());
        // if(userId > 0){
            var isCheck = parseInt($(this).attr('data-id'));
            var countId = parseInt($(this).attr('count-id'));
            $("#btnAddPackage").attr({'data-id':isCheck, 'count-id':countId});
            var packageIds = [];
            var packageTypeId = 0;
            if(isCheck == 1){
                packageTypeId = 1;
                $("#modalShowListPackages .modal-title").html('Danh sách gói phần mềm base');
                $("#tbodyBase_"+countId+" tr").each(function(){
                    packageIds.push($(this).attr('data-id'));
                });
            } else if(isCheck == 2){
                packageTypeId = 2;
                $("#modalShowListPackages .modal-title").html('Danh sách gói phần mềm mở rộng');
                $("#tbodySslDetails_"+countId+" tr").each(function(){
                    packageIds.push($(this).attr('data-id'));
                });
            }
            loadDataPackages(packageIds, '', userId, isCheck, packageTypeId);
        // } else {
        //     showNotification('Vui lòng chọn khách hàng.', 0);
        // }
        return false;
    }).on('keyup', '#packageName', function(){
        var isCheck = parseInt($('.btnShowModalBase').attr('data-id'));
        var searchText = $(this).val();
        var packageIds = [];
        var packageTypeId = 0;
        var userId = parseInt($("input#userId").val());
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
            loadDataPackages(packageIds, searchText, userId, isCheck, packageTypeId);
        }, 500);
        return false;
    }).on('click', '#btnAddPackage', function(){
       
        var isCheck = parseInt($(this).attr('data-id'));
        var countId = parseInt($(this).attr('count-id'));
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
            showPackageBaseOrSslDetail(arrPackages, isCheck, countId);
        } else if(isCheck == 2){
            showPackageBaseOrSslDetail(arrPackages, isCheck, countId);
        }
       
        return false;
    }).on('click', '.link_delete_base', function(){
        var countId = parseInt($(this).attr('count-id'));
        $("#totalBase_"+countId).text(0);
        $(this).parent().parent().remove();
    }).on('keyup', '.packagePriceBase', function(){
        var $this = $(this).parent().parent().find('td');
        var packagePrice = replaceCost($(this).val(), true);
        var expiryDate = replaceCost($this.eq(3).find('input').val(), true);

        var total = packagePrice * expiryDate;
        $this.eq(4).text(formatDecimal(total.toString()));
    }).on('keyup', '.expiryDateBase', function(){
        var $this = $(this).parent().parent().find('td');
        var expiryDate = replaceCost($(this).val(), true);
        var packagePrice = replaceCost($this.eq(2).find('input').val(), true);

        var total = packagePrice * expiryDate;
        $this.eq(4).text(formatDecimal(total.toString()));
    }).on('click', '.link_delete_ssldetail', function(){
        var countId = parseInt($(this).attr('count-id'));
        var count = parseInt($("#totalSslDetail_"+countId).text());
        $("#totalSslDetail_"+countId).text(count - 1);
        $(this).parent().parent().remove();
        numericalOrderPackages(countId);
    }).on('keyup', '.packagePriceSslDetails', function(){
        var $this = $(this).parent().parent().find('td');
        var packagePrice = replaceCost($(this).val(), true);
        var expiryDate = replaceCost($this.eq(3).find('input').val(), true);

        var total = packagePrice * expiryDate;
        $this.eq(4).text(formatDecimal(total.toString()));
    }).on('keyup', '.expiryDateSslDetails', function(){
        var $this = $(this).parent().parent().find('td');
        var expiryDate = replaceCost($(this).val(), true);
        var packagePrice =  replaceCost($this.eq(2).find('input').val(), true);

        var total = packagePrice * expiryDate;
        $this.eq(4).text(formatDecimal(total.toString()));
    });

    if(deadlineId > 0){
        $("body").on('click', '#btnCancelDeadline', function(){
            var url = $(this).attr('data-url');
            $('#btnYesOrNo').html('');
            $('#btnYesOrNo').CeoSlider({
                lable_right : 'DUYỆT',
                lable_left : 'KHÔNG DUYỆT',
                lable_yes : 'Buông chuột để DUYỆT',
                lable_no : 'Buông chuột để KHÔNG DUYỆT',
                success : function (data) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            DeadlineId: deadlineId,
                        },
                        success: function (response) {
                            var json = $.parseJSON(response);
                            if(json.code == 1){
                                redirect(true, '');
                            }
                            showNotification(json.message, json.code);
                        },
                        error: function (response) {
                            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                        }
                    });
                    return false;
                },
                error : function (data) {
                    // xử lý KHÔNG DUYỆT
                }
            });
            $("#modalActiveOrCancel").modal('show');
            
            return false;
        });
    }

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

app.ssls = function(deadlineId){
    // xử lý thêm mới group ssl
    $("body").on('click', '.btnAddGroupExtension', function(){
        if(deadlineId > 0 && $("div.groupExtension").length == 1){
            showNotification('Chỉ thêm được môt nhóm gia hạn trong quá trình cập nhật.');
            return false;
        }
        var countId = $("div.groupExtension").length + 1;
        addNewGroup(countId);
    }).on('click', '.remove_group', function(){
        var countId = parseInt($(this).attr('count-id'));
        $("div#group_"+countId).remove();
    });

    // xửa lý dữ liệu trong từng group ssl
    $("body").on('click', '.btnShowModalSSL', function(){
        $('#count_data_ssl').text(0);
        var userId = parseInt($("input#userId").val());
        var countId = parseInt($(this).attr('count-id'));
        // var countDataBase = $("#tbodyBase_"+countId+" tr").length;
        if(userId > 0){
            $("#btnAddSSL").attr('count-id', countId);
            var sslsIds = [];
            $("#tbodySsl_"+countId+" tr").each(function(){
                sslsIds.push($(this).attr('data-id'));
            });
            $.ajax({
                type: "POST",
                url: $("input#urlGetSslInUser").val(),
                data: {
                    UserId: userId,
                    SslsIds: JSON.stringify(sslsIds),
                    SearchText: $("input#SSLCode").val().trim()
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        var html = '';
                        var labelCss = json.labelCss;
                        $.each(json.data, function(i, item) {
                            html += `
                                <tr>
                                    <td><input class="checkTran iCheckTableSSL iCheckItem" ssl-id="${item.SSLId}" ssl-code="${item.SSLCode}" extension="${item.Extension}" license-plate="${item.LicensePlate}" type="checkbox" value="${item.SSLId}" package-ids='${JSON.stringify(item.ssldetail)}' data-status="${item.SSLStatusId}"></td>
                                    <td>${item.SSLCode}</td>
                                    <td>${item.LicensePlate}</td>
                                    <td><span class="${labelCss[item.SSLStatusId]}">${item.SSLStatus}</span></td>
                                </tr>
                            `;
                        });
                        $("#tbodySSL").html(html);
                        $('input.iCheckTableSSL').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue',
                            increaseArea: '20%'
                        });
                        $("span#total_ssl").text(json.data.length);
                        $("#modalShowListSSL").modal('show');
                    }
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        } else {
            showNotification('Vui lòng chọn khách hàng hoặc Gói phần mềm chưa được chọn.', 0);
        }
        return false;
    }).on('click', '#btnAddSSL', function(){
        var countId = parseInt($(this).attr('count-id'));
        var packageIds = [];
        var packages = [];
        $("#tbodyBase_"+countId+" tr").each(function(){
            var idx = $.inArray($(this).attr('data-id'), packageIds);
            if (idx == -1) {
                packageIds.push($(this).attr('data-id'));
                packages.push({
                    PackageId: $(this).attr('data-id'),
                    PackageName: $(this).find('td').eq(1).text().trim()
                });
            }
        });
        $("#tbodySslDetails_"+countId+" tr").each(function(){
            var idx = $.inArray($(this).attr('data-id'), packageIds);
            if (idx == -1) {
                packageIds.push($(this).attr('data-id'));
                packages.push({
                    PackageId: $(this).attr('data-id'),
                    PackageName: $(this).find('td').eq(1).text().trim()
                });
            }
        });
        var html = '';   
        var i = 0;     
        $('#tbodySSL input.iCheckTableSSL').each(function () {
            if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')){
                i++;
                var ids = $.parseJSON($(this).attr('package-ids'));
                var content = '';
                $.each(packages, function(i1, v1){
                    var idx2 = $.inArray(v1.PackageId, ids);
                    if (idx2 == -1) {
                        content += v1.PackageName+', ';
                    }
                });
                var color = "";
                if(content != ''){
                    content = 'Chưa gán gói phần mềm: '+content;
                    color = "color:red";
                } 
                html += `
                    <tr data-id="${$(this).attr('ssl-id')}" vehicle-id="${$(this).attr('vehicle-id')}" style="${color}" status-id="${$(this).attr('data-status')}">
                        <td>${i}</td>
                        <td>${$(this).attr('ssl-code')}</td>
                        <td>${$(this).attr('license-plate')}</td>
                        <td>${$(this).attr('extension')}</td>
                        <td>${content}</td>
                        <td><a href="javascript:void(0)" class="link_delete_ssl" title="Xóa" count-id="${countId}"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                `;
            }
        });
        $("#tbodySsl_"+countId).html(html);
        
        $("#totalSsl_"+countId).text($("#tbodySsl_"+countId+" tr").length);
        $("#modalShowListSSL").modal('hide');
        return false;
    }).on('click', '.link_delete_ssl', function(){
        var countId = parseInt($(this).attr('count-id'));
        var count = parseInt($("#totalSsl_"+countId).text());
        $("#totalSsl_"+countId).text(count - 1);
        $(this).parent().parent().remove();
        numericalOrderSSL(countId);
    });

    $("#table-ssl").on('ifToggled', 'input.iCheckTableSSL', function (e) {
        var itemIds = [];
        if (e.currentTarget.checked) {
            $("input.iCheckTableSSL:checked").each(function () {
                itemIds.push(parseInt($(this).val()))
            });
        }else{
            $("input.iCheckTableSSL:checked").each(function () {
                itemIds.push(parseInt($(this).val()))
            });
        }
        $("span#count_data_ssl").text(itemIds.length);
        
    });
}

app.submit = function(deadlineId){
    $("body").on('click', '.submit', function(){
        var $this = $(this);
        var price = $('.cost.packagePriceBase').val();
        var price1 = $('.cost.packagePriceSslDetails').val();
        var day = $('.cost.expiryDateBase').val();
        var day1 = $('.cost.expiryDateSslDetails').val();
        if($('.box-search-advance.customer .boxInfo').is(':hidden')){
            showNotification('Vui lòng chọn khách hàng!', 0);
            return false;
        }
        // if(price <= 0 || price1 <= 0){
        //     showNotification('Giá tiền chưa nhập hoặc bằng 0, vui lòng nhập lại!', 0);
        //     return false;
        // }
        var checkCost = 0;
        $('#tbodySslDetails_1 .cost.expiryDateSslDetails').each(function(){
            if($(this).val() > 0){
                checkCost = 1;
            }
        });
        if(day <= 0 && checkCost <= 0){
            showNotification('Số tháng chưa nhập hoặc bằng 0, vui lòng nhập lại!', 0);
            return false;
        }
        if($('#tbodyBase_1 tr').length<=0){
            $fal = 0;
            $false = 0;
            $('#tbodySsl_1 tr').each(function () {
            var status = $(this).attr('status-id');
                if(status ==2){
                    $false = 1;
                }
                if(status !=2){
                    $false = 0;
                    $(this).css({"background-color": "red", "color": "#fff"});
                    $(this).find('td').eq(4).text('SSL này không có gói mở rộng, đang bị cắt hoặc đang dừng hoạt động, vui lòng gia hạn gói base trước');
                }
            })
        }
        if($('#tbodyBase_1 tr').length>0){
            $false = 1;
            $fal = 1;
        }
        if(($('#tbodyBase_1 tr').length<=0) && ( $('#tbodySslDetails_1 tr').length<=0)){
            showNotification('Vui lòng chọn gói phần mềm!', 0);
            return false;
        }
        if(($false == 0) && ($fal == 0)){
            showNotification('Vui lòng chọn thuê bao SSL!', 0);
            return false;
        }
        var deadlineStatusId = parseInt($(this).attr('data-id'));
        if(deadlineStatusId == 1)save(deadlineId, deadlineStatusId, $this);
        else if(deadlineStatusId == 2){
            if($('#tbodySsl_1 tr').length<=0){
                showNotification('Vui lòng chọn gói ssl', 0);
                return false;
            }
            $('#btnYesOrNo').html('');
            $('#btnYesOrNo').CeoSlider({
                lable_right : 'DUYỆT',
                lable_left : 'KHÔNG DUYỆT',
                lable_yes : 'Buông chuột để DUYỆT',
                lable_no : 'Buông chuột để KHÔNG DUYỆT',
                success : function (data) {
                    save(deadlineId, deadlineStatusId, $this);
                    return false;
                },
                error : function (data) {
                    // xử lý KHÔNG DUYỆT
                }
            });
            $("#modalActiveOrCancel").modal('show');
        }
        return false;
    });
}

$(document).ready(function(){
    var deadlineId = parseInt($("input#deadlineId").val());
    app.init(deadlineId);

    if(deadlineId > 0){
        $('body').on('keydown', 'input.cost', function (e) {
            if(checkKeyCodeNumber(e)) e.preventDefault();
        }).on('keyup', 'input.cost', function(){
            var value = $(this).val();
            $(this).val(formatDecimal(value));
        });
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

function loadDataPackages(packageIds, searchText = '', userId = 0, isCheck = 0, packageTypeId){
    $.ajax({
        type: "POST",
        url: $("input#urlGetPackages").val(),
        data: {
            IsCheck: isCheck,
            UserId: userId,
            PackageTypeId: packageTypeId,
            PackageIds: JSON.stringify(packageIds),
            SearchText: searchText
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if(json.code == 1){
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

function showPackageBaseOrSslDetail(packages, isCheck, countId){
    if(isCheck == 1){
        var html = `
            <tr data-id="${packages[0].PackageId}">
                <td>1</td>
                <td class="packageName">${packages[0].PackageName}</td>
                <td><input class=" cost packagePriceBase" value="0"> đ/tháng</td>
                <td><input class=" cost expiryDateBase" value="0"> tháng</td>
                <td class="packageTotalPrice">0</td>
                <td><a href="javascript:void(0)" class="link_delete_base" title="Xóa" count-id="${countId}"><i class="fa fa-trash-o"></i></a></td>
            </tr>
        `;
        $("#tbodyBase_"+countId).html(html);
    } else if(isCheck == 2){
        var html = '';
        $.each( packages, function( i, item ) {
            html += `<tr data-id="${item.PackageId}">
                        <td>${i+1}</td>
                        <td>${item.PackageName}</td>
                        <td><input class=" cost packagePriceSslDetails" value="0"> đ/tháng</td>
                        <td><input class=" cost expiryDateSslDetails" value="0"> tháng</td>
                        <td class="packageTotalPrice">0</td>
                        <td><a href="javascript:void(0)" class="link_delete_ssldetail" title="Xóa" count-id="${countId}"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                `;
          });
        $("#tbodySslDetails_"+countId).append(html);
    } 

    $('body').on('keydown', 'input.cost', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.cost', function(){
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    });
    if(isCheck == 1) $("#totalBase_"+countId).text(1);
    else if(isCheck == 2) {
        var totalPackageBase = 0;
        $("#tbodySslDetails_"+countId+" tr").each(function(){
            totalPackageBase += 1;
        });
        $("#totalSslDetail_"+countId).text(totalPackageBase);
    } 

    numericalOrderPackages(countId);
    $("#modalShowListPackages").modal('hide');
}

function addNewGroup(countId = 0){
    var html = `
    <div class="col-sm-12 form-group groupExtension" id="group_${countId}" count-id="${countId}">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Nhóm gia hạn chung ${countId}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool remove_group" count-id="${countId}"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <p><a href="javascript:void(0)" class="base-package btnShowModalBase" data-id="1" count-id="${countId}">
                                <i class="fa fa-fw fa-plus-circle"></i></a> Gói phần mềm base bắt buộc* (<span id="totalBase_${countId}">0</span>)
                            </p>
                            <div class="box-body table-responsive divTable">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:60px">STT</th>
                                            <th>Tên gói phần mềm</th>
                                            <th>Giá</th>
                                            <th>Số tháng</th>
                                            <th>Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyBase_${countId}"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <p><a href="javascript:void(0)" class="base-package btnShowModalBase" data-id="2" count-id="${countId}">
                                <i class="fa fa-fw fa-plus-circle"></i></a> Gói phần mềm mở rộng (<span id="totalSslDetail_${countId}">0</span>)
                            </p>
                            <div class="box-body table-responsive divTable">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:60px">STT</th>
                                            <th>Tên gói phần mềm</th>
                                            <th>Giá</th>
                                            <th>Số tháng</th>
                                            <th>Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodySslDetails_${countId}"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="custom-hr">
                <br>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <p><a href="javascript:void(0)" class="base-package btnShowModalSSL" count-id="${countId}">
                                <i class="fa fa-fw fa-plus-circle"></i></a> Danh sách thuê bao SSL (<span id="totalSsl_${countId}">0</span>)
                            </p>
                            <div class="box-body table-responsive divTable">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:60px">STT</th>
                                            <th>Mã thuê bao SSL</th>
                                            <th>Biển số xe</th>
                                            <th>Lần gia hạn gần nhất</th>
                                            <th>Cảnh báo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodySsl_${countId}"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
    $(".htmlGroupExtension").append(html);
}

function save(deadlineId, deadlineStatusId, $this){
    $this.prop('disabled', true);
    var userId = parseInt($("input#userId").val());
    if(userId == 0){
        showNotification("Vui lòng chọn khách hàng.");
        $this.prop('disabled', false);
        return false;
    }
    if($( "div.groupExtension" ).length == 0){
        showNotification("Vui lòng thêm nhóm gia hạn.");
        $this.prop('disabled', false);
        return false;
    }
    
    var arrDatas = [];
    $( "div.groupExtension" ).each(function( index ) {
        var countId = parseInt($(this).attr('count-id'));
        var countBase = $("#tbodyBase_"+countId+" tr").length;
        var countDetail = $("#tbodySslDetails_"+countId+" tr").length;
        if(countBase == 0 && countDetail == 0){
            showNotification('Vui lòng thêm Gói phần mềm base bắt buộc hoặc gói mở pm rộng.');
            $this.prop('disabled', false);
            return false;
        }
      
        if($("#tbodySsl_"+countId+" tr").length > 0){
            $("#tbodySsl_"+countId+" tr").each(function(){
                if($(this).css('color') == "rgb(255, 0, 0)"){
                    showNotification('Thuê bao SSL này chưa được gán phần mềm, vui lòng cập nhật hoặc xóa bỏ.');
                    $this.prop('disabled', false);
                    return false;
                }
            })
        }
        var arrDeadlines = [];
        if($("#tbodyBase_"+countId+" tr").length > 0){
            $("#tbodyBase_"+countId+" tr").each(function(){
                var $this = $(this).find('td');
                arrDeadlines.push({
                    
                    PackageId: $(this).attr('data-id'),
                    
                    PackagePrice: replaceCost($this.eq(2).find('input').val(), true),
                    ExpiryDate: replaceCost($this.eq(3).find('input').val(), true),
                });
            });
        }else{
            arrDeadlines.push({
                PackageId: 0,
                PackagePrice: 0,
                ExpiryDate: 0,
            });
        }
        

        var arrDeadlineDetails = [];
        $("#tbodySslDetails_"+countId+" tr").each(function(){
            var $this = $(this).find('td');
            arrDeadlineDetails.push({
                PackageId: $(this).attr('data-id'),
                PackagePrice: replaceCost($this.eq(2).find('input').val(), true),
                ExpiryDate: replaceCost($this.eq(3).find('input').val(), true),
            });
        });

        var arrDeadlineSsls = [];
        var SSLIds = [];
        $("#tbodySsl_"+countId+" tr").each(function(){
            arrDeadlineSsls.push({
                SSLId: $(this).attr('data-id'),
                // VehicleId: $(this).attr('vehicle-id'),
            });
            SSLIds.push($(this).attr('data-id'));
        });
        arrDatas.push({
            arrDeadlines: arrDeadlines,
            arrDeadlineDetails:arrDeadlineDetails,
            arrDeadlineSsls:arrDeadlineSsls,
            SSLIds:SSLIds
        });
    });
    $this.prop('disabled', true);
    $.ajax({
        type: "POST",
        url: $("input#urlAddMuiltDeadlines").val(),
        data: {
            DeadlineId: deadlineId,
            DeadlineStatusId: deadlineStatusId,
            UserId: userId,
            ArrDatas: JSON.stringify(arrDatas),
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if(json.code == 1){
                if(parseInt(deadlineId) == 0) redirect(false, $("#deadlineListUrl").attr('href'));
                else redirect(true, '');
            }
            $this.prop('disabled', false);
            showNotification(json.message, json.code);
        },
        error: function (response) {
            $this.prop('disabled', false);
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
    return false;
}

function checkExitSSL(userId){
    $.ajax({
        type: "POST",
        url: $("input#urlCheckExitUserToSsl").val(),
        data: {
            UserId: userId,
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if(json.code == 1){
                // if(parseInt(deadlineId) == 0) redirect(false, $("#deadlineListUrl").attr('href'));
                // else redirect(true, '');
            } else {
                showNotification(json.message, json.code);
                $('.boxInfo').hide()
                $('.boxSearch').show()
                $('.btnShơwModal').hide()
                $('.btnHideModal').show()
                $('#btnEditVehicle').hide()
                $('.btnShowAdd').hide()
                $('.btnHideAdd').show()
                $('#userId').val(0);
            }
            
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
    return false;
}

// đếm lại số thứ tự gói phần mềm cơ bản
function numericalOrderPackages(countId = 0){
    var number = 0;
    $("#tbodySslDetails_"+countId+" tr").each(function(){
        number ++;
        $(this).find('td').eq(0).text(number);
    });
}

function numericalOrderSSL(countId = 0){
    var number = 0;
    $("#tbodySsl_"+countId+" tr").each(function(){
        number ++;
        $(this).find('td').eq(0).text(number);
    });
}

$(document).ready(function () {
    $("input.cost").bind("cut copy paste", function (e) {
        e.preventDefault();
    });
   
    $("input.cost").on("contextmenu",function(e){
        return false;
    });
    
    $('#totalSsl_1').text($('.divTable #tbodySsl_1 tr').length);
    $('body').on('keyup', 'input#SSLCode', function (e) {
        var val = $(this).val();
        if (val != '') {
                $(' #table-ssl #tbodySSL tr td:nth-child(2):not(:contains(' + val + '))').parent().hide();
                $(' #table-ssl #tbodySSL tr td:nth-child(3):not(:contains(' + val + '))').parent().hide();
                $(' #table-ssl #tbodySSL tr td:nth-child(2):contains(' + val + ')').parent().show();
                $(' #table-ssl #tbodySSL tr td:nth-child(3):contains(' + val + ')').parent().show();
                
        } else {
            $(' #table-ssl #tbodySSL tr').show();
        }
    });
});