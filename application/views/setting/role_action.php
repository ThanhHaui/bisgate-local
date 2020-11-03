<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-default">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-role">
                                    <?php $this->Mconstants->selectObject($listRoles, 'RoleId', 'RoleName', 'RoleId', $roleId, true, 'Chọn Nhóm quyền', ' select2'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-role">
                                    <?php $this->Mconstants->selectObject($listParts, 'PartId', 'PartName', 'PartId', $partId, true, 'Tất cả phòng ban', ' select2'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="box box-success">
                    <?php sectionTitleHtml($title); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered" id="tblAction">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">STT</th>
                                <th class="text-center">Chọn</th>
                                <th>Trang</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0;
                            foreach($listActiveActions as $act){
                                $i++; ?>
                                <tr<?php if($act['ActionLevel'] == 1) echo ' class="success"'; ?>>
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="text-center"><input type="checkbox" class="iCheck" id="cbAction_<?php echo $act['ActionId']; ?>" value="<?php echo $act['ActionId']; ?>"/></td>
                                    <td class="action-level-<?php echo $act['ActionLevel']; ?>"><?php echo $act['ActionName']; ?></td>
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
                        <input type="text" hidden="hidden" id="getActionUrl" value="<?php echo base_url('roleaction/getAction'); ?>">
                        <input type="text" hidden="hidden" id="updateRoleActionUrl" value="<?php echo base_url('roleaction/update'); ?>">
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>