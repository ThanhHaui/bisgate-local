<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('vehiclekind/update', array('id' => 'vehicleKindForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
	                            <tr>
	                                <th>Dòng xe</th>
	                                <th>Mô tả</th>
	                                <th>Hành động</th>
	                            </tr>
                            </thead>
                            <tbody id="tbodyVehicleKind">
                            <?php
                            	foreach($listVehicleKinds as $bt){  
                            ?>
                                <tr id="vehicleKind_<?php echo $bt['VehicleKindId']; ?>">
                                    <td id="vehicleKindName_<?php echo $bt['VehicleKindId']; ?>"><?php echo $bt['VehicleKindName']; ?></td>
                                    <td id="comment_<?php echo $bt['VehicleKindId']; ?>"><?php echo $bt['Comment']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['VehicleKindId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['VehicleKindId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="vehicleKindName" name="VehicleKindName" data-field="Dòng xe *"></td>
                                <td><input type="text" class="form-control" id="comment" name="Comment"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="VehicleKindId" id="vehicleKindId" value="0" hidden="hidden">
                                    <input type="text" id="deleteVehicleKindUrl" value="<?php echo base_url('vehiclekind/delete'); ?>" hidden="hidden">
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