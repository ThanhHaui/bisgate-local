<div class="modal fade" id="modalEditTags" tabindex="-1" role="dialog" aria-labelledby="modalEditTags">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thêm nhãn những <span class="spanItemName"></span> đã chọn</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label label-nomal">Tag nhãn <span class="spanItemName"></span> với các từ khóa để dễ dàng sắp xếp.</label>
                    <input type="text" class="form-control" id="tags">
                </div>
                <img src="assets/vendor/dist/img/loading.gif" class="imgLoading imgCenter" style="display: none;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btnChangeTags">Thay đỏi</button>
                <input type="text" hidden="hidden" id="changeTagTypeId" value="1">
                <input type="text" hidden="hidden" id="itemTagIds" value="">
                <input type="text" hidden="hidden" id="itemTagAllIds" value="">
                <input type="text" hidden="hidden" id="updateItemTagUrl" value="<?php echo base_url('api/tag/updateItem'); ?>">
            </div>
        </div>
    </div>
</div>