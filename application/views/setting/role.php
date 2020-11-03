<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('role/update', array('id' => 'roleForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Chức vụ</th>
                                <th>Phòng ban</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyRole">
                            <?php
                            foreach($listRoles as $r){ ?>
                                <tr id="role_<?php echo $r['RoleId']; ?>">
                                    <td id="roleName_<?php echo $r['RoleId']; ?>"><?php echo $r['RoleName']; ?></td>
                                    <td id="partName_<?php echo $r['RoleId']; ?>"><?php echo $this->Mconstants->getObjectValue($listParts, 'PartId', $r['PartId'], 'PartName'); ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-part-id="<?php echo $r['PartId']; ?>" data-id="<?php echo $r['RoleId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $r['RoleId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                        <input type="text" hidden="hidden" id="partId_<?php echo $r['RoleId']; ?>" value="<?php echo $r['PartId']; ?>">
                                        <!--<a href="<?php //echo base_url('roleaction/'.$r['RoleId']) ?>" target="_blank" title="Cấp quyền"><i class="fa fa-unlock"></i></a>-->
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="roleName" name="RoleName" value="" data-field="Chức vụ"></td>
                                <td><?php echo $this->Mparts->selectHtml(0, 'PartId', $listParts); ?></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="RoleId" id="roleId" value="0" hidden="hidden">
                                    <input type="text" id="deleteRoleUrl" value="<?php echo base_url('role/delete'); ?>" hidden="hidden">
                                    <!--<input type="text" id="roleActionUrl" value="<?php //echo base_url('roleaction'); ?>/" hidden="hidden">-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>