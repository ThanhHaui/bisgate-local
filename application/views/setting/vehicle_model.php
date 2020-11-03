<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('vehiclemodel/update', array('id' => 'vehicleModelForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
	                            <tr>
	                                <th>Đời xe</th>
	                                <th>Mô tả</th>
	                                <th>Hành động</th>
	                            </tr>
                            </thead>
                            <tbody id="tbodyVehicleModel">
                            <?php
                            	foreach($listVehicleModels as $bt){  
                            ?>
                                <tr id="vehicleModel_<?php echo $bt['VehicleModelId']; ?>">
                                    <td id="vehicleModelName_<?php echo $bt['VehicleModelId']; ?>"><?php echo $bt['VehicleModelName']; ?></td>
                                    <td id="comment_<?php echo $bt['VehicleModelId']; ?>"><?php echo $bt['Comment']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['VehicleModelId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['VehicleModelId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="vehicleModelName" name="VehicleModelName" data-field="Đời xe *"></td>
                                <td><input type="text" class="form-control hmdrequired" id="comment" name="Comment"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="VehicleModelId" id="vehicleModelId" value="0" hidden="hidden">
                                    <input type="text" id="deleteVehicleModelUrl" value="<?php echo base_url('vehiclemodel/delete'); ?>" hidden="hidden">
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