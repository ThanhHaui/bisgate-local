<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('vehiclemanufacturer/update', array('id' => 'vehicleManuFacturerForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
	                            <tr>
	                                <th>Hãng xe</th>
	                                <th>Mô tả</th>
	                                <th>Hành động</th>
	                            </tr>
                            </thead>
                            <tbody id="tbodyVehicleManuFacturer">
                            <?php
                            	foreach($listVehiclemanufacturers as $bt){  
                            ?>
                                <tr id="vehicleManuFacturer_<?php echo $bt['VehicleManufacturerId']; ?>">
                                    <td id="vehicleManufacturerName_<?php echo $bt['VehicleManufacturerId']; ?>"><?php echo $bt['VehicleManufacturerId'].'. '.$bt['VehicleManufacturerName']; ?></td>
                                    <td id="comment_<?php echo $bt['VehicleManufacturerId']; ?>"><?php echo $bt['Comment']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['VehicleManufacturerId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['VehicleManufacturerId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="vehicleManufacturerName" name="VehicleManufacturerName" data-field="Hãng xe *"></td>
                                <td><input type="text" class="form-control" id="comment" name="Comment"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="VehicleManufacturerId" id="vehicleManufacturerId" value="0" hidden="hidden">
                                    <input type="text" id="deleteVehicleManuFacturerUrl" value="<?php echo base_url('vehiclemanufacturer/delete'); ?>" hidden="hidden">
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