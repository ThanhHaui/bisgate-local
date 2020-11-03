<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?php $this->Mconstants->selectObject($listGroups, 'GroupId', 'GroupName', 'GroupId', $groupId, true, 'Chọn Nhóm quyền', ' select2'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-primary" id="btnClone"><i class="fa fa-clone"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="box box-success">
                    <?php sectionTitleHtml($title); ?>
                    <style>.fa-angle-down{cursor: pointer;}</style>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered" id="tblAction">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">STT</th>
                                <th class="text-center" style="width: 100px;">Chọn</th>
                                <th>Trang</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0;
                            foreach($listActiveActions as $act){ 

                                $i++; ?>
                                <tr<?php if($act['ActionLevel'] == 1) echo ' class="success top-lv"'; elseif($act['ActionLevel'] == 2) echo ' class=" top-lv2 dpn"'; else echo ' class=" top-lv3 dpn"'?>>
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center"><input type="checkbox" class="iCheck" id="cbAction_<?php echo $act['ActionId']; ?>" value="<?php echo $act['ActionId']; ?>"/></td>
                                    <td class="action-level-<?php echo $act['ActionLevel']; ?>"><?php echo $act['ActionName']; ?> <?php if($act['ActionLevel'] == 1 || $act['ActionLevel'] == 2) echo '<i class="fa fa-angle-left mgl-15"></i>' ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <ul class="pull-right list-inline">
                            <li><button class="btn btn-default" id="checkAll">Chọn tất cả</button></li>
                            <li><button class="btn btn-default" id="unCheckAll">Bỏ chọn tất cả</button></li>
                            <li><button class="btn btn-primary" id="btnUpdate">Cập nhật</button></li>
                        </ul>
                        <input type="text" hidden="hidden" id="getActionUrl" value="<?php echo base_url('groupaction/getAction'); ?>">
                        <input type="text" hidden="hidden" id="updateGroupActionUrl" value="<?php echo base_url('groupaction/update'); ?>">
                        <input type="text" hidden="hidden" id="cloneGroupActionUrl" value="<?php echo base_url('group/cloneAction'); ?>">
                    </div>
                </div>
                <div class="modal fade" id="modalCloneAction" tabindex="-1" role="dialog" aria-labelledby="modalCloneAction">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Nhân bản nhóm quyền</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label">Tên nhóm</label>
                                    <input type="text" class="form-control" id="groupName">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Mô tả</label>
                                    <input type="text" class="form-control" id="comment">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Quay lại</button>
                                <button type="button" class="btn btn-primary" id="btnUpdateActionClone">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>