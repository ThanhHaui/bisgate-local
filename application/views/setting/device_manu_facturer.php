<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('devicemanufacturer/update', array('id' => 'deviceManuFacturerForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
	                            <tr>
	                                <th>Nhà sản xuất</th>
	                                <th>Mô tả</th>
	                                <th>Hành động</th>
	                            </tr>
                            </thead>
                            <tbody id="tbodyDeviceManuFacturer">
                            <?php
                            	foreach($listDeviceManuFfacturers as $bt){  
                            ?>
                                <tr id="deviceManuFacturer_<?php echo $bt['DeviceManufacturerId']; ?>">
                                    <td id="deviceManufacturerName_<?php echo $bt['DeviceManufacturerId']; ?>"><?php echo $bt['DeviceManufacturerName']; ?></td>
                                    <td id="comment_<?php echo $bt['DeviceManufacturerId']; ?>"><?php echo $bt['Comment']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['DeviceManufacturerId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['DeviceManufacturerId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="deviceManufacturerName" name="DeviceManufacturerName" data-field="Nhà sản xuất *"></td>
                                <td><input type="text" class="form-control hmdrequired" id="comment" name="Comment"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="DeviceManufacturerId" id="deviceManufacturerId" value="0" hidden="hidden">
                                    <input type="text" id="deleteDeviceManuFacturerUrl" value="<?php echo base_url('devicemanufacturer/delete'); ?>" hidden="hidden">
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