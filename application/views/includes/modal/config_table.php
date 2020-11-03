<div class="modal fade" id="modalListFilter" tabindex="-1" role="dialog" aria-labelledby="modalListFilter">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><i class="fa fa-wrench" aria-hidden="true"></i> Danh sách báo cáo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control" id="itemSearchNameFilter"
                                   placeholder="Nhập thông tin tìm kiếm">
                        </div>
                    </div>
                    <div class="col-sm-3 text-right">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="btnShowModalAddFilter">Thêm mới báo cáo <i
                                        class="fa fa-fw fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-body table-responsive divTable">
                        <table class="table new-style table-hover table-bordered table" id="table-data-filter">
                            <thead>
                            <tr>
                                <th>Mã báo cáo</th>
                                <th>Thời điểm tạo</th>
                                <th>Tên báo cáo</th>
                                <th>Người tạo</th>
                                <th>Mô tả</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyFilter"></tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden="hidden" value="<?php echo base_url('filter/searchByDataFilter'); ?>"
                       id="btn-data-filter">
                <input type="text" hidden="hidden" value="<?php echo base_url('filter/get') ?>" id="urlGetFilter">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddFilter" tabindex="-1" role="dialog" aria-labelledby="modalAddFilter">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title" id="titleAddFilter">Thêm mới báo cáo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Tên báo cáo <span class="red">*</span></label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nameFilter">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Mô tả</label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="text" class="form-control" id="noteFilter">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Bộ lọc <span class="red">*</span></label>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn dropdown-toggle transform" data-toggle="dropdown"
                                        aria-expanded="false">
                                    Chọn loại tiêu chí lọc <span class="fa fa-caret-down"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php $this->load->view($config_filter); ?>
                                </ul>
                            </div>
                        </div>
                            <div class="box-body table-responsive divTable">
                                <label class="control-label">Danh sách các bộ lọc đang chọn</label>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Loại tiêu chí</th>
                                        <th>Giá trị lọc</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="container-filters-add"></tbody>
                                </table>

                            </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="filterId" value="0">
                <button type="button" class="btn btn-danger" id="btn-remove-ilter">
                    Xóa
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-primary" data-href="<?php echo base_url('filter/save'); ?>"
                        id="btn-save-filter-add" display-order="1">Thêm
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalConfigTable" tabindex="-1" role="dialog" aria-labelledby="modalConfigTable">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" style="font-weight: bold;" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title" style="font-weight: bold;"><i class="fa fa-wrench" aria-hidden="true"></i> Cấu hình cột thông tin</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table new-style table-hover table-bordered icon-unsorted-hover" id="table-data-filter">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên cột dữ liệu</th>
                                <th>Hiện/Ẩn cột</th>
                                <th>Ghim cột</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyConfig">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="bnAddConfigTable">Xác nhận</button>
            </div>
        </div>
    </div>
</div>