<div class="modal fade" role="dialog" id="modalShowListPackages">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Danh sách gói phần mềm base</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group form-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="packageName" placeholder="Search">
                        </div>
                        <div class="maxheight10">
                            <table class="table table-hover table-bordered" id="table-package">
                                <thead>
                                    <tr>
                                        <th style="width:60px"></th>
                                        <th>Mã gói phần mềm</th>
                                        <th>Tên gói phần mềm</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyPackages"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span style="float:left">Đang chọn <span id="count_data_package">0</span>/<span id="total_package">0</span> gói</span>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="btnAddPackage" data-id="0" count-id="0">Thêm</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="modalShowListSSL">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Thêm mã thuê bao SSL vào nhóm gia hạn</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group form-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="SSLCode" placeholder="Search mã SSL hoặc biển số xe">
                        </div>
                        <div class="maxheight10">
                            <table class="table table-hover table-bordered" id="table-ssl">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>SSL</th>
                                        <th>Xe</th>
                                        <th>Trạng thái thuê bao SSL</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodySSL"></tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span style="float:left">Đang chọn <span id="count_data_ssl">0</span>/<span id="total_ssl">0</span> gói</span>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="btnAddSSL" count-id="0">Thêm</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalActiveOrCancel">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Áp dụng vào hệ thống</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ceo_slider" id="btnYesOrNo"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .maxheight10{
        max-height: 438px;
        overflow: auto;
    }
</style>