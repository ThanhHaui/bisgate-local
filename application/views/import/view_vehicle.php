<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li>
                        <a href="javascript:void(0);" id="btnImportExcel" class="btn btn-primary">Nhập từ Excel</a>
                    </li>
                </ul>
            </section>
        </div>
    </div>
    <div class="modal fade" id="modalImportExcel" tabindex="-1" role="dialog" aria-labelledby="modalImportExcel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">File Excel</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="fileExcelUrl" placeholder="File Excel" disabled>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" id="btnUploadExcel">Tải lên</button>
                            </span>
                        </div>
                    </div>
                    <div class="progress" id="fileProgress" style="display: none;">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <input type="file" style="display: none;" id="inputFileExcel">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="btnImportCloneExcel">Import</button>
                    <input type="text" hidden="hidden" id="importExcelVehicleUrl" value="<?php echo base_url('import/importExcelVehicle'); ?>">
                    <input type="text" hidden="hidden" id="uploadFileNormalUrl" value="<?php echo base_url('file/uploadNormal'); ?>">
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('includes/footer'); ?>
<script>
    $(document).ready(function(){
        // import excel
        $('#btnImportExcel').click(function (e) {
            $('input#fileExcelUrl').val('');
            $('input#inputFileExcel').val('');
            $('#modalImportExcel').modal('show');
        });

        $("body").on('click', '#btnUploadExcel', function(e){
            e.preventDefault();
            $('#inputFileExcel').trigger('click');
        });

        $("body").on('change', '#inputFileExcel', function(e){
            var file = this.files[0];
            var typeFile = file.name.split(".").pop();
            var whiteList = ['xlsx', 'xls'];
            if (whiteList.indexOf(typeFile) === -1) {
                showNotification('Tệp tin phải là file excel có định dạng xlsx/xls', 0);
                return;
            }
            var data = new FormData();
            data.append('File', file);
            $.ajax({
                type: 'POST',
                url: $('input#uploadFileNormalUrl').val(),
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        $('input#fileExcelUrl').val(json.data);
                        $('#btnImportExcel').prop('disabled', false);
                    }
                
                    else showNotification(json.message, json.code);
                    data.reset();
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
            return false;
        });

        $('#btnImportCloneExcel').click(function () {
            var fileUrl = $('input#fileExcelUrl').val();
            if (fileUrl != '') {
                $.ajax({
                    type: "POST",
                    url: $('input#importExcelVehicleUrl').val(),
                    data: {
                        FileUrl: fileUrl
                    },
                    success: function (response) {
                        console.log(response)
                        var json = $.parseJSON(response);
                    
                    },
                    error: function (response) {
                        showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    }
                });
            }
            else showNotification('Vui lòng chọn file Excel');
        });
    })
</script>