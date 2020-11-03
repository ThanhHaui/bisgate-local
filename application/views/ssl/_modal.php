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
                <button type="button" class="btn btn-primary" id="btnAddPackage" data-id="0">Thêm</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="modalActiveContract">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Cắt hợp đồng thuê bao tạm thời hay vĩnh viễn</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="radio-group">
                            <span class="item"><input type="radio" name="ContractStatusId" class="iCheck" value="3" checked> Cắt dịch vụ tạm thời</span> 
                            <br><br>
                            <span class="item"><input type="radio" name="ContractStatusId" class="iCheck" value="5"> Dừng hẳn luôn</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="btnActiveContract">Cắt</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="modalActiveService">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Cắt hợp đồng thuê bao tạm thời hay vĩnh viễn</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="radio-group">
                            <span class="item"><input type="radio" name="ServiceStatusId" class="iCheck" value="3" checked> Cắt dịch vụ tạm thời</span>
                            <br><br>
                            <span class="item"><input type="radio" name="ServiceStatusId" class="iCheck" value="5"> Dừng hẳn luôn</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="btnActiveService">Cắt</button>
                <input type="hidden" id="ServiceId" value="0">
                <input type="hidden" id="ServiceisCheck" value="">
                <input type="hidden" id="ServicepackageCode" value="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalActiveService2">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Bật lại gói phần mềm</h4>
            </div>
            <div class="modal-body">
                <div class="row contentActiveService2">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="btnActiveService2">OK</button>
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