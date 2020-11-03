<div class="modal fade" role="dialog" id="save-filter">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Bạn muốn lưu tìm kiếm này như thế nào?</h4>
            </div>
            <div class="modal-body">
                <div class="form-group mb0">
                    <label for="save-new-search" class="next-label">
                        <input type="radio" name="option_save" checked class="iCheck" value="0">
                        Lưu tìm kiếm mới
                    </label>
                </div>
                <div class="form-group">
                    <label for="overwrite-saved-search" class="next-label">
                        <input type="radio" class="iCheck" name="option_save" value="1">
                        Lưu đè lên tìm kiếm đã tồn tại
                    </label>
                </div>
                <div class="form-group" id="input-name-new">
                    <label class="next-label" for="new-saved-search-name">Tên mới</label>
                    <input id="new-save-name" name="name_new" class="form-control" type="text">
                </div>
                <div class="form-group none-display" id="input-name-exits">
                    <div class="form-group">
                        <label for="new-saved-search-name" class="center-block next-label">Tìm kiếm nào bạn muốn lưu đè?</label>
                        <select class="form-control" id="filter_list_name">
                            <option selected value="0">Chọn bộ lọc</option>
                            <?php foreach ($listFilters as $f): ?>
                                <option value="<?=$f['FilterId']?>"><?=$f['FilterName']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="">
                        <label class="center-block next-label">Tên mới</label>
                        <input type="text" class="form-control" name="FilterName" id="filterName">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-dismiss="modal">Đóng</button>
                <button type="button" data-href="<?php echo base_url('filter/save'); ?>" class="btn btn-primary" id="btn-save-filter" display-order="1">Lưu</button>
                <input type="text" hidden="hidden" id="updateFilterDisplayOrderUrl" value="<?php echo base_url('filter/updateDisplayOrder'); ?>">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="admin-delete">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
                <h4 class="modal-title">Xác nhận xóa</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Mô tả</label>
                        <textarea class="form-control" rows="2" id="commentDelete"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-dismiss="modal">Hủy</button>
                <button type="button" data-href="<?php echo base_url('tablelog/insert'); ?>" class="btn btn-primary" id="btn-save-delete">Xác nhận</button>
            </div>
        </div>
    </div>
</div>