<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php $this->load->view('includes/breadcrumb'); ?>
        <section class="content">
            <div class="box box-success">
                <?php sectionTitleHtml($title); ?>
                <div class="box-body table-responsive no-padding divTable">
                    <table class="table table-hover table-bordered" id="tblRole">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Menu</th>
                                <th>Menu cha</th>
                                <th>Url</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyRoleMenu">
                            <?php $i = 0;
                            $selectHtml = $this->Mrolemenus->getParentRoleHtml($listActiveRolemenu);
                            $labelCss = $this->Mconstants->labelCss;
                            $status = $this->Mconstants->roleStatusId;
                            foreach($listActiveRolemenu as $act){
                                $i++;
                                $class = '';
                                if($act['RoleLevel'] == 1) $class = ' class="danger"';
                                elseif($act['RoleLevel'] == 2) $class = ' class="warning"'; ?>
                                <tr id="role_<?php echo $act['RoleMenuId']; ?>"<?php echo $class; ?>>
                                    <td><?php echo $i; ?></td>
                                    <td class="role-level-<?php echo $act['RoleLevel']; ?>"><input type="text" class="form-control" id="roleName_<?php echo $act['RoleMenuId'] ?>" value="<?php echo $act['RoleMenuName']; ?>"/></td>
                                    <td><select class="form-control parent" id="parentRoleMenuId_<?php echo $act['RoleMenuId'] ?>" data-id="<?php echo $act['RoleMenuId'] ?>"><?php echo $selectHtml; ?></select></td>
                                    <td><input type="text" class="form-control" id="roleUrl_<?php echo $act['RoleMenuId'] ?>" value="<?php echo $act['RoleMenuUrl']; ?>"/></td>
                                    <td class="roles">
                                        <a href="javascript:void(0)" class="link_update" title="Cập nhật" data-id="<?php echo $act['RoleMenuId'] ?>"><i class="fa fa-save"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" title="Xóa" data-id="<?php echo $act['RoleMenuId'] ?>"><i class="fa fa-times"></i></a>
                                        <input type="text" hidden="hidden" id="parent_<?php echo $act['RoleMenuId'] ?>" value="<?php echo empty($act['RoleMenuChildId']) ? 0 : $act['RoleMenuChildId']; ?>">
                                        <input type="text" hidden="hidden" id="level_<?php echo $act['RoleMenuId'] ?>" value="<?php echo $act['RoleLevel']; ?>">

                                    </td>
                                </tr>
                            <?php } ?>
                            <tr id="role_0">
                                <td><?php echo $i+1; ?></td>
                                <td class="role-level-1"><input type="text" class="form-control" id="roleName_0" value=""/></td>
                                <td><select class="form-control parent" id="parentRoleMenuId_0" data-id="0"><?php echo $selectHtml; ?></select></td>
                                <td><input type="text" class="form-control" id="roleUrl_0" value=""/></td>
                                <td class="roles">
                                    <a href="javascript:void(0)" class="link_update" title="Cập nhật" data-id="0"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" class="link_delete" title="Xóa" data-id="0"><i class="fa fa-times"></i></a>
                                    <input type="text" hidden="hidden" id="parent_0" value="0">
                                    <input type="text" hidden="hidden" id="level_0" value="1">
                                    <input type="text" hidden="hidden" id="updateRoleUrl" value="<?php echo base_url('rolemenu/update'); ?>">
                                    <input type="text" hidden="hidden" id="deleteRoleUrl" value="<?php echo base_url('rolemenu/delete'); ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>