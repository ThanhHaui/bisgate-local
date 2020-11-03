<div class="modal fade" role="dialog" id="modalActiveContract">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 500px;margin: 0px auto">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Dừng hoạt động tài khoản</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="radio-group">
                            <span class="item"><input type="radio" name="ContractStatusId" class="iCheck" value="1" checked> Tạm cắt - LOCK</span> 
                            <br><br>
                            <span class="item"><input type="radio" name="ContractStatusId" class="iCheck" value="3">Dừng hẳn luôn - STOP</span>
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
<div class="modal fade" role="dialog" id="btnShowModalGroups">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Phân quyền</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-hover table-bordered" id="table-group">
                            <thead>
                                <tr>
                                    <th style="width:60px"></th>
                                    <th>Mã nhóm quyền</th>
                                    <th>Tên nhóm quyền</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyGroup">
                             <?php foreach ($listGroups as $itemGroups) { ?>

                                <tr id="group_<?php echo $itemGroups['GroupId'] ?>" data-id="<?php echo $itemGroups['GroupId'] ?>">
                                    <td>
                                        <input class="checkTran iCheck iCheckItem" type="checkbox"
                                        value="<?php echo $itemGroups['GroupId'] ?>">
                                    </td>
                                    <td><?php echo $itemGroups['GroupCode'] ?></td>
                                    <td><?php echo $itemGroups['GroupName'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-dismiss="modal">Hủy
            </button>
            <button type="button" class="btn btn-primary" id="btnAddGroup" data-id="2">Thêm</button>
        </div>
    </div>
</div>
</div>