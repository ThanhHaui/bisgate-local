<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('devicegroup/update', array('id' => 'deviceGroupForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
	                            <tr>
	                                <th>Loại thiết bị</th>
	                                <th>Hành động</th>
	                            </tr>
                            </thead>
                            <tbody id="tbodyDeviceGroup">
                            <?php
                            	foreach($listDeviceGroups as $bt){  
                            ?>
                                <tr id="deviceGroup_<?php echo $bt['DeviceGroupId']; ?>">
                                    <td id="deviceGroupName_<?php echo $bt['DeviceGroupId']; ?>"><?php echo $bt['DeviceGroupName']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['DeviceGroupId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['DeviceGroupId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="deviceGroupName" name="DeviceGroupName" data-field="Loại thiết bị *"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="DeviceGroupId" id="deviceGroupId" value="0" hidden="hidden">
                                    <input type="text" id="deleteDeviceGroupUrl" value="<?php echo base_url('devicegroup/delete'); ?>" hidden="hidden">
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