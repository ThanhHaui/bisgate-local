<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('group/update', array('id' => 'groupForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Nhóm quyền</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyGroup">
                            <?php
                            foreach($listGroups as $r){ ?>
                                <tr id="group_<?php echo $r['GroupId']; ?>">
                                    <td id="groupName_<?php echo $r['GroupId']; ?>"><?php echo $r['GroupName']; ?></td>
                                    <td id="comment_<?php echo $r['GroupId']; ?>"><?php echo $r['Comment']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $r['GroupId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $r['GroupId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                        <a href="<?php echo base_url('groupaction/'.$r['GroupId']) ?>" target="_blank" title="Cấp quyền"><i class="fa fa-unlock"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="groupName" name="GroupName" value="" data-field="Nhóm quyền" placeholder="Tên nhóm quyền"></td>
                                <td><input type="text" class="form-control" placeholder="Mô tả" id="comment" name="Comment"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="GroupId" id="groupId" value="0" hidden="hidden">
                                    <input type="text" id="deleteGroupUrl" value="<?php echo base_url('group/delete'); ?>" hidden="hidden">
                                    <input type="text" id="groupActionUrl" value="<?php echo base_url('groupaction'); ?>/" hidden="hidden">
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