$(document).ready(function(){
    $("#tbodyPackages").on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#packageId').val(id);
        $('input#packageName').val($('td#packageName_' + id).text());
        $('input#packageComment').val($('td#packageComment_' + id).text());
        scrollTo('input#packageName');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm('Bạn có thực sự muốn xóa ?')) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deletePackageUrl').val(),
                data: {
                    PackageId: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code == 1) $('tr#package_' + id).remove();
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
    });
    $('a#link_cancel').click(function(){
        $('#packagesForm').trigger("reset");
        return false;
    });
    $('a#link_update').click(function(){
        if (validateEmpty('#packagesForm')) {
            var form = $('#packagesForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        form.trigger("reset");
                        var data = json.data;
                        if(data.IsAdd == 1){
                            var html = '<tr id="package_' + data.PackageId + '">';
                            html += '<td id="packageName_' + data.PackageId + '">' + data.PackageName + '</td>';
                            html += '<td id="packageComment_' + data.PackageId + '">' + data.PackageComment + '</td>';
                            html += '<td class="actions">' +
                                '<a href="javascript:void(0)" class="link_edit" data-id="' + data.PackageId + '" title="Sửa"><i class="fa fa-pencil"></i></a>' +
                                '<a href="javascript:void(0)" class="link_delete" data-id="' + data.PackageId + '" title="Xóa"><i class="fa fa-trash-o"></i></a>' +
                                '</td>';
                            html += '</tr>';
                            $('#tbodyPackages').prepend(html);
                        }
                        else{
                            $('td#packageName_' + data.PackageId).text(data.PackageName);
                            $('td#packageComment_' + data.PackageId).text(data.PackageComment);
                        }
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
    });
});