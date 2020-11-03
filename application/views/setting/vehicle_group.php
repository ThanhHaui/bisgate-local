<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('vehiclegroup/update', array('id' => 'vehicleGroupForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
	                            <tr>
	                                <th>Nhóm xe tự tạo</th>
	                                <th>Mô tả</th>
	                                <th>Hành động</th>
	                            </tr>
                            </thead>
                            <tbody id="tbodyVehicleGroup">
                            <?php
                            	foreach($listVehicleGroups as $bt){  
                            ?>
                                <tr id="vehicleGroup_<?php echo $bt['VehicleGroupId']; ?>">
                                    <td id="vehicleGroupName_<?php echo $bt['VehicleGroupId']; ?>"><?php echo $bt['VehicleGroupName']; ?></td>
                                    <td id="comment_<?php echo $bt['VehicleGroupId']; ?>"><?php echo $bt['Comment']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['VehicleGroupId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['VehicleGroupId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="vehicleGroupName" name="VehicleGroupName" data-field="Nhóm xe tự tạo *"></td>
                                <td><input type="text" class="form-control hmdrequired" id="comment" name="Comment"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="VehicleGroupId" id="vehicleGroupId" value="0" hidden="hidden">
                                    <input type="text" id="deleteVehicleGrouplUrl" value="<?php echo base_url('vehiclegroup/delete'); ?>" hidden="hidden">
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