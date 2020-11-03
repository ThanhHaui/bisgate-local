$('body').on('click','.panel-footer button',function(){
    var searchText = $('#seachText').val();
    var pagination = $(this).attr('data-pagination');
    getListCustomer(searchText,pagination);
}).on('keypress','#seachText' ,function(){
    var searchText = $('#seachText').val();
    getListCustomer(searchText);
}).on('click', '#ulListCustomers li', function() {
    var panelCustomer = $('#panelCustomer');
    $('.submit_hide').addClass('choose-customer');
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
});
$(document).ready(function () {
    var siteName = $('input#siteName').val();
    if (siteName != '') {
        siteName = $('title').text() + ' - ' + siteName;
        $('title').text(siteName);
        $('input#siteName').val(siteName);
    }
    if ($('select.select2').length > 0) $('select.select2').select2();
    if ($('div.divTable').length > 0) {
        if ($(window).width() > 760) $('div.divTable').removeClass('table-responsive');
        else $('div.divTable').addClass('table-responsive');
        $(window).resize(function () {
            if ($(window).width() > 760) $('div.divTable').removeClass('table-responsive');
            else $('div.divTable').addClass('table-responsive');
        });
    }
    $(document).ajaxStart(function () {
        Pace.restart();
    });
    $('#txtSearchCustomer').click(function(){
        
        getListCustomer();
    });
    //admin menu
    if ($('.sidebar-menu').length > 0) {
        var curentPathName = window.location.pathname;
        var rootPath = $('input#rootPath').val();
        curentPathName = curentPathName.replace(rootPath, '');
        var hostname = window.location.hostname;
        $('.sidebar-menu li a').each(function () {
            var pageLink = $(this).attr('href');
            if (pageLink != undefined) {
                pageLink = pageLink.replace('https://', '');
                pageLink = pageLink.replace('http://', '');
                pageLink = pageLink.replace(hostname, '');
                pageLink = pageLink.replace(rootPath, '');
                if (pageLink == curentPathName) {
                    $(this).parent('li').addClass('active');
                    var ul = $(this).parent('li').parent('ul').parent('li').parent('ul');
                    if (ul.length > 0) {
                        $(this).parent('li').parent('ul').css('display', 'block');
                        $(this).parent('li').parent('ul').parent('li').addClass('active');
                        ul.css('display', 'block');
                        ul.parent('li').addClass('active');
                    }
                    else $(this).parent('li').parent('ul').parent('li').addClass('active');
                    return false;
                }
            }
        });
        if(localStorage.getItem('hkrep_menu_collapsed') == '1') $('body').addClass('sidebar-collapse');
        else $('body').removeClass('sidebar-collapse');
        $('.sidebar-toggle').click(function (e) {
            e.preventDefault();
            if(localStorage.getItem('hkrep_menu_collapsed') == '1') localStorage.setItem('hkrep_menu_collapsed', '0');
            else localStorage.setItem('hkrep_menu_collapsed', '1');
        });
        $('section.sidebar').slimScroll({
            height: ($(document).height() - 30) + 'px',
            color : '#2C3B41'
        });
    }

    
    var isBusy = false; // Biến dùng kiểm tra nếu đang gửi ajax thì ko thực hiện gửi thêm
    var logPageId = 1;
    
    // Biến lưu trữ rạng thái phân trang 
    var stopped = false;

    // function load more data log action
    $("body").on('click', '.btnShowLogs', function(){
        $("#scrolActionLog").html('');
        var $this = $(this);
        var itemId = $this.attr('item-id');
        var itemTypeId = $this.attr('item-type-id');
        var actionTypeIds = [];
        if($(".ul-log-actions .active").attr('action-type-ids') != undefined) {
            actionTypeIds = $(".ul-log-actions .active").attr('action-type-ids');
        };
        $.ajax({
            type: 'post',
            url: $this.attr('data-url'),
            data: {
                PageId: 1,
                ItemId: itemId,
                ItemTypeId: itemTypeId,
                ActionTypeIds: actionTypeIds
            },
            success: function (response){
                var json = $.parseJSON(response);
                if(json.code == 1){
                    addHtmlActionLog(json.data);
                } else showNotification(json.message, json.code);
            },
            error: function(response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        })
        $("#modal-logaction").modal('show');
    });

    $("#content-data-log").scroll(function() {
        var itemId = parseInt($('.btnShowLogs').attr('item-id'));
        var itemTypeId = parseInt($('.btnShowLogs').attr('item-type-id'));
        // Element append nội dung
        $element = $('#scrolActionLog');
        // ELement hiển thị chữ loadding
        $loadding = $('#loadding');
        // Nếu màn hình đang ở dưới cuối thẻ thì thực hiện ajax
        if($("#content-data-log").scrollTop() + $("#content-data-log").height() >= $element.height())  {
            // Nếu đang gửi ajax thì ngưng
            if (isBusy == true) return false;
            // Nếu hết dữ liệu thì ngưng
            if (stopped == true) return false;
            // Thiết lập đang gửi ajax
            isBusy = true;
            // Tăng số trang lên 1
            logPageId++;
            // Hiển thị loadding
            $loadding.removeClass('hidden');
            var actionTypeIds = [];
            if($(".ul-log-actions .active").attr('action-type-ids') != undefined) {
                actionTypeIds = $(".ul-log-actions .active").attr('action-type-ids');
            };
            $.ajax({
                type: 'POST',
                url: $('.btnShowLogs').attr('data-url'),
                data: {
                    PageId: logPageId,
                    ItemId: itemId,
                    ItemTypeId: itemTypeId,
                    ActionTypeIds: actionTypeIds
                },
                success: function (response){
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        if(json.data.length <= 20) stopped = true;
                        addHtmlActionLog(json.data);
                    } else showNotification(json.message, json.code);
                },
                error: function(response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            }).always(function(){
                // Sau khi thực hiện xong ajax thì ẩn hidden và cho trạng thái gửi ajax = false
                $loadding.addClass('hidden');
                isBusy = false;
            });
            return false;
        }
    });
});

function addHtmlActionLog(datas){
    var html = '';
    $.each(datas, function(k, item){
        var jobLevel = '';
        if(item.JobLevelId) {
            jobLevel = `<div class="user-position">${item.JobLevelName}</div>`
        }
        html += `
        <div class="item-log">
            <div class="item-user-info">
                <div class="user-avatar">
                    <img src="${item.Avatar}" alt="">
                </div>
                <div class="user-info">
                    <h4 class="user-name">${item.FullName}</h4>
                    ${jobLevel}
                </div>
            </div>
            <div class="item-log-content">${item.Comment}</div>
            <div class="item-log-time">${item.CrDateTime}</div>
        </div>
        `;
    });
    $("#scrolActionLog").append(html);
}

function replaceCost(cost, isInt) {
    cost = cost.replace(/\,/g, '');
    if (cost == '') cost = 0;
    if (isInt) return parseInt(cost);
    else  return parseFloat(cost);
}

function formatDecimal(value) {
    value = value.replace(/\,/g, '');
    while (value.length > 1 && value[0] == '0' && value[1] != '.') value = value.substring(1);
    if (value != '' && value != '0') {
        if (value[value.length - 1] != '.') {
            if (value.indexOf('.00') > 0) value = value.substring(0, value.length - 3);
            value = addCommas(value);
            return value;
        }
        else return value;
    }
    else return 0;
}

function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function checkKeyCodeNumber(e){
    return !((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 ||  e.keyCode == 35 || e.keyCode == 36 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46);
}

/* type = 1 - success
 other - error
 */
function showNotification(msg, type) {
    var typeText = 'error';
    if (type == 1) typeText = 'success';
    var notice = new PNotify({
        title: 'Notification',
        text: msg,
        type: typeText,
        delay: 2000,
        addclass: 'stack-bottomright',
        stack: {"dir1": "up", "dir2": "left", "firstpos1": 15, "firstpos2": 15}
    });
}

function showConfirm(msg, funcOk, funcCancel){
    (new PNotify({
        title: 'Confirm',
        text: msg,
        icon: 'glyphicon glyphicon-question-sign',
        type: 'info',
        hide: false,
        confirm: {
            confirm: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        addclass: 'stack-modal',
        stack: {
            'dir1': 'down',
            'dir2': 'right',
            'modal': true
        }
    })).get().on('pnotify.confirm', function() {
        funcOk();
    }).on('pnotify.cancel', function() {
        funcCancel();
    });
}

function showPrompt(title, msg, fn){
    (new PNotify({
        title: title,
        text: msg,
        icon: 'glyphicon glyphicon-question-sign',
        hide: false,
        confirm: {
            prompt: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        addclass: 'stack-modal',
        stack: {
            'dir1': 'down',
            'dir2': 'right',
            'modal': true
        }
    })).get().on('pnotify.confirm', function(e, notice, val) {
        fn(val);
    }).on('pnotify.cancel', function(e, notice) {

    });
}

function redirect(reload, url) {
    if (reload) {
        window.setTimeout(function () {
            window.location.reload(true);
        }, 2000);
    }
    else {
        window.setTimeout(function () {
            window.location.href = url;
        }, 2000);
    }
}

function scrollTo(eleId) {
    $('html, body').animate({
        scrollTop: $(eleId).offset().top - 200
    }, 1000);
    $(eleId).focus();
}

//validate
function validateEmpty(container) {
    if(typeof(container) == 'undefined') container = 'body';
    var flag = true;
    $(container + ' .hmdrequired').each(function () {
        if ($(this).val().trim() == '') {
            showNotification($(this).attr('data-field') + ' không được bỏ trống', 0);
            $(this).focus();
            flag = false;
            return false;
        }
    });
    return flag;
}

function validateNumber(container, isInt, msg) {
    if(typeof(container) == 'undefined') container = 'body';
    if(typeof(msg) == 'undefined') msg = ' không được bé hơn 0';
    var flag = true;
    var value = 0;
    $(container + ' .hmdrequiredNumber').each(function () {
        value = replaceCost($(this).val(), isInt);
        if (value <= 0) {
            showNotification($(this).attr('data-field') + msg, 0);
            $(this).focus();
            flag = false;
            return false;
        }
    });
    return flag;
}

function checkEmptyEditor(text) {
    text = text.replace(/\&nbsp;/g, '').replace(/\<p>/g, '').replace(/\<\/p>/g, '').trim();
    return text.length > 0;
}

function makeSlug(str) {
    var slug = str.trim().toLowerCase();
    // change vietnam character
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    // remove special character
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    // change space to -
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    return slug;
}

function progressBarUpload(progressBarId) {
    var xhr = new window.XMLHttpRequest();
    xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            var prb = progressBarId.find('.progress-bar');
            prb.text(percentComplete + '%');
            prb.css({
                width: percentComplete + '%'
            });
            if (percentComplete === 100) {
                setTimeout(function () {
                    prb.text('Tải ảnh lên hoàn thành');
                }, 1000);
            }
        }
    }, false);
    return xhr;
}

function validateImage(fileName) {
    var typeFile = getFileExtension(fileName);
    var whiteList = ['jpeg', 'jpg', 'png', 'bmp'];
    if (whiteList.indexOf(typeFile) === -1) {
        showNotification('Tệp tin phải là ảnh có định dạng , jpeg/jpg/png/bmp', 0);
        return false;
    }
    return true;
}

function getFileExtension(fileName) {
    return fileName.split(".").pop().toLowerCase();
}

function getCurrentDateTime(typeId, now){
    if(typeof(now) == 'undefined') now = new Date();
    var date = now.getDate();
    var month = now.getMonth() + 1;
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    if(date < 10) date = '0' + date;
    if(month < 10) month = '0' + month;
    if(hour < 10) hour = '0' + hour;
    if(minute < 10) minute = '0' + minute;
    if(second < 10) second = '0' + second;
    if(typeId == 1) return hour + ":" + minute + ' ' + date + "/" + month + "/" + now.getFullYear();
    else if(typeId == 2) return date + "/" + month + "/" + now.getFullYear() + " " + hour + ":" + minute;
    else if(typeId == 3) return date + "/" + month + "/" + now.getFullYear();
    else if(typeId == 4) return hour + ":" + minute;
    else if(typeId == 5) return now.getFullYear() + "-" + month + "-" + date  + " " + hour + ":" + minute + ":" + second;
    else if(typeId == 6) return 'Hôm nay ' + hour + ":" + minute;
    return date + "/" + month + "/" + now.getFullYear() + " " + hour + ":" + minute + ":" + second;
}

function getDayText(dayDiff){
    var dayText = '';
    if(dayDiff == 0) dayText = 'Hôm nay ';
    else if(dayDiff == 1) dayText = 'Hôm qua ';
    else if(dayDiff == 2) dayText = 'Hôm kia ';
    else if(dayDiff == -1) dayText = 'Ngày mai ';
    else if(dayDiff == -2) dayText = 'Ngày kia ';
    return dayText;
}

function dateRangePicker(fn){
    $(".daterangepicker").daterangepicker({
        forceUpdate: false,
        ranges:{
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Tuần hiện tại': [moment().startOf('isoWeek'),moment().endOf('isoWeek')],
            'Tuần trước': [moment().subtract(1, 'weeks').startOf('weeks'),moment().subtract(1, 'weeks').endOf('weeks')],
            //'7 ngày trước': [moment().subtract(6, 'days'), moment()],
            '30 ngày trước': [moment().subtract(29, 'days'), moment()],
            //'90 ngày trước': [moment().subtract(89, 'days'), moment()],
            'Tháng hiện tại': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Năm trước': [moment().subtract(1, 'year').add(1,'day'), moment()],
            'Năm hiện tại': [moment().startOf('year'), moment().endOf('year')],
            'Quý 1 năm nay':[moment().month(0).startOf('month'),moment().month(2).endOf('month')],
            'Quý 2 năm nay':[moment().month(3).startOf('month'),moment().month(5).endOf('month')],
            'Quý 3 năm nay':[moment().month(6).startOf('month'),moment().month(8).endOf('month')],
            'Quý 4 năm nay':[moment().month(9).startOf('month'),moment().month(11).endOf('month')]
            //'Tất cả': 'all-time',
            //'Tùy chọn': 'custom'
        },
        callback: function(startDate, endDate, period){
            var beginDate = "";
            if(moment().format('DD/MM/YYYY') == startDate.format('DD/MM/YYYY') || moment().add(-1, 'days').format('DD/MM/YYYY') == startDate.format('DD/MM/YYYY')){
                // lấy ngày hôm nay // lấy ngày hôm qua    
                beginDate = startDate.format('DD/MM/YYYY');
            }
            else{
                beginDate = moment(startDate, "DD/MM/YYYY").add(1, 'days').format('DD/MM/YYYY');
            }
            $(this).val(beginDate + ' - ' + endDate.format('DD/MM/YYYY'));
            if(typeof(fn) != 'undefined') fn(beginDate + ' - ' + endDate.format('DD/MM/YYYY'));
        }
    });
}

function genItemComment(comment){
    var html = '<div class="box-customer mb10"><table><tbody><tr><th rowspan="2" class="user-wrapper" valign="top" style="width: 50px;"><div class="user-link"><img class="user-img" width="29" src="' + $('input#userImagePath').val() + $('input#avatarLoginId').val() + '" alt=""></div></th>';
    html +='<th><a href="javascript:void(0)" class="name">' + $('input#fullNameLoginId').val() + '</a></th>';
    html += '<th class="time">' + getCurrentDateTime(6) + '</th></tr><tr><td colspan="2"><p class="pComment">' + comment + '</p></td></tr></tbody></table></div>';
    return html;
}

//pagging
function pagging(pageId) {
    $('input#pageId').val(pageId);
    $('input#submit').trigger('click');
}

function chooseFile(inputFileImage, fileProgress, fileTypeId, fnSuccess) {
    inputFileImage.change(function (e) {
        var file = this.files[0];
        if(!validateImage(file.name)) return;
        var reader = new FileReader();
        reader.addEventListener("load", function () {
            fileProgress.show();
            $.ajax({
                xhr: function () {
                    return progressBarUpload(fileProgress);
                },
                type: 'POST',
                url: $('input#uploadFileUrl').val(),
                data: {
                    FileBase64: reader.result,
                    FileTypeId: fileTypeId
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1) fnSuccess(json.data);
                    else showNotification(json.message, json.code);
                    fileProgress.hide();
                },
                error: function (response) {
                    fileProgress.hide();
                    showNotification($('input#errorCommonMessage').val(), 0);
                }
            });
        }, false);
        if (file) reader.readAsDataURL(file);
    });
}
/*function chooseFile(resourceType, fn){
    var finder = new CKFinder();
    finder.resourceType = resourceType;
    finder.selectActionFunction = function(fileUrl) {
        fn(fileUrl);
    };
    finder.popup();
}*/

function province(provinceIdStr, districtIdStr, wardIdStr) {
    if(typeof(provinceIdStr) == 'undefined'){
        provinceIdStr = 'provinceId';
        districtIdStr = 'districtId';
        wardIdStr = 'wardId';
    }
    var selPro = $('select#' + provinceIdStr);
    if (selPro.length > 0) {
        var selDistrict = $('select#' + districtIdStr);
        var selWard = $('select#' + wardIdStr);
        selDistrict.find('option').hide();
        selDistrict.find('option[value="0"]').show();
        var provinceId = selPro.val();
        if (provinceId != '0') selDistrict.find('option[data-id="' + provinceId + '"]').show();
        selPro.change(function () {
            selDistrict.find('option').hide();
            provinceId = $(this).val();
            if (provinceId != '0') selDistrict.find('option[data-id="' + provinceId + '"]').show();
            selDistrict.val('0');
            //selWard.val('0');
            selWard.html('<option value="0">--Chọn--</option>');
        });
        var districtId = selDistrict.val();
        if (districtId != '0') getListWard(districtId, selWard, selWard.attr('data-id'));
        selDistrict.change(function () {
            districtId = $(this).val();
            if (districtId != '0') getListWard(districtId, selWard, 0);
        });
    }
}

function getListWard(districtId, selWard, wardId){
    $.ajax({
        type: "POST",
        url: $('input#getListWardUrl').val(),
        data: {
            DistrictId: districtId
        },
        success: function (response) {
            var data = $.parseJSON(response);
            var html = '<option value="0">--Chọn--</option>';
            for(var i = 0; i < data.length; i++) html += '<option value="' + data[i].WardId + '">' + data[i].WardName + '</option>';
            selWard.html(html).val(wardId);
        },
        error: function (response) {
            selWard.html('<option value="0">--Chọn--</option>');
        }
    });
}

function checkPhoneNumber() {
    var flag = false;
    var phone = $('input#phoneNumber').val().trim(); // ID của trường Số điện thoại
    phone = phone.replace('(+84)', '0');
    phone = phone.replace('+84', '0');
    phone = phone.replace('0084', '0');
    phone = phone.replace(/ /g, '');
    if (phone != '') {
        var firstNumber = phone.substring(0, 2);
        if ((firstNumber == '09' || firstNumber == '08' || firstNumber == '03') && phone.length == 10) {
            if (phone.match(/^\d{10}/)) {
                flag = true;
            }
        } else if (firstNumber == '01' && phone.length == 11) {
            if (phone.match(/^\d{11}/)) {
                flag = true;
            }
        }
    }
    return flag;
}

function isEmail(email) {
    var isValid = false;
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(regex.test(email)) {
        isValid = true;
    }
    return isValid;
}
$(document).ready(function () {
    $('body').on('keydown', '#phoneNumber', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    });
    $("#phoneNumber,#staffName").bind("cut copy paste", function (e) {
        e.preventDefault();
    });

    $("#phoneNumber,#staffName").on("contextmenu",function(e){
        return false;
    });
});
function locdau(obj) {
    var str;
    if (eval(obj))
        str = eval(obj).value;
    else
        str = obj;
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    str = str.trim();
    str = str.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,''); 
    eval(obj).value = str;
}
function checkKeyCodeNumberText(e){
    return !((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122 || e.keyCode == 8 ||  e.keyCode == 35 || e.keyCode == 36 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46));
}
$('body').on('keyup', 'input#staffName,input#userName', function (e) {
    if(checkKeyCodeNumberText(e)) e.preventDefault();
    locdau(this);
}).on('click','.menu-login',function(e){
    e.stopPropagation();
    $(this).next('ul').toggle(200);
});
$(window).click(function (e) {
    var menu = $('.navbar-static-top .user-toggle-account');
    if (menu.has(e.target).length == 0 && !menu.is(e.target)) {
        menu.find('ul').slideUp(200);
    }
});
function countColumnTable(){
    var totalColumnTable = $('#table-data tr th').length;
    var totalColumnTableVisible = $('#table-data tr th:visible').length;
    if(totalColumnTableVisible == 0) totalColumnTableVisible = 0;
    $("input#txtCountColTable").val('Hiển thị '+totalColumnTableVisible+'/'+totalColumnTable + ' cột');
}
function getListCustomer(searchText = '',pagination = 0 ){
    $.ajax({
        type: "POST",
        url: $('#getListUsers').val(),
        data: {
            SearchText: searchText,
            Pagination: pagination 
        },
        success: function (response) {
            $('#panelCustomer').addClass(' active');
            $('#listUser').html(response);
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });

}
function replaceLicensePlate(str) {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    str = str.trim();
    str = str.replace(/[ `~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,''); 
    str = str.toUpperCase();
    return str;
}

function checkLicensePlate(vehicleTypeId,licensePlate){
    if((vehicleTypeId == 1) || (vehicleTypeId == 2) || (vehicleTypeId == 3) || (vehicleTypeId == 4) || (vehicleTypeId == 5)){
        value = replaceLicensePlate(licensePlate);
        var check = false
        if (vehicleTypeId == 1) {
            if (value.length == 8 || value.length == 9) {
                if (!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                    if (!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6]) && !isNaN(value[7])) {
                        if (value.length == 8) {
                            var text = value[0] + value[1] + value[2] + value[3] + '-' + value[4] + value[5] + value[6] + value[7]
                            $('#LicensePlate').val(text.toUpperCase())
                            check = true
                        } else if (!isNaN(value[8])) {
                            var text = value[0] + value[1] + value[2] + value[3] + '-' + value[4] + value[5] + value[6] + '.' + value[7] + value[8]
                            $('#LicensePlate').val(text.toUpperCase())
                            check = true
                        }
                        else{
                            $('#LicensePlate').val(licensePlate)
                        }
                    }
                    else{
                        $('#LicensePlate').val(licensePlate)
                    }
                }
                else{
                    $('#LicensePlate').val(licensePlate)
                }
            }
            else{
                $('#LicensePlate').val(licensePlate)
            }
        } else{
            if (value.length == 7 || value.length == 8) {
                if (!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                    if (!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6])) {
                        if (value.length == 7) {
                            var text = value[0] + value[1] + value[2] + '-' + value[3] + value[4] + value[5] + value[6]
                            $('#LicensePlate').val(text.toUpperCase())
                            check = true
                        } else if (!isNaN(value[7])) {
                            var text = value[0] + value[1] + value[2] + '-' + value[3] + value[4] + value[5] + '.' + value[6] + value[7]
                            $('#LicensePlate').val(text.toUpperCase())
                            check = true
                        }
                        else{
                            $('#LicensePlate').val(licensePlate)
                        }
                    }
                    else{
                        $('#LicensePlate').val(licensePlate)
                    }
                }
                else{
                    $('#LicensePlate').val(licensePlate)
                }
            }
            else{
                $('#LicensePlate').val(licensePlate)
            }
        }
        if(check == false){
            $('#LicensePlate').val(licensePlate)
        }
    }
    else{
        $('#LicensePlate').val(licensePlate)
    }
}
function checkFormatLicensePlate() {
    var value = $('#LicensePlate').val()
    var value = value.replace(/[^a-z0-9\s]/gi, '')
    var type = $('#VehicleTypeId').val()
    var check = false
    if (type == 1) {
        if (value.length == 8 || value.length == 9) {
            if (!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                if (!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6]) && !isNaN(value[7])) {
                    if (value.length == 8) {
                        check = true
                    } else if (!isNaN(value[8])) {
                        check = true
                    }
                }
            }
        }
    } else {
        if (value.length == 7 || value.length == 8) {
            if (!isNaN(value[0]) && !isNaN(value[1]) && isNaN(value[2])) {
                if (!isNaN(value[3]) && !isNaN(value[4]) && !isNaN(value[5]) && !isNaN(value[6])) {
                    if (value.length == 7) {
                        check = true
                    } else if (!isNaN(value[7])) {
                        check = true
                    }
                }
            }
        }
    }
    return check
}
//test