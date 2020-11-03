<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('vehicletype/update', array('id' => 'vehicleTypeForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Chủng loại xe</th>
                                <th>Số lượng</th>
                                <th>Đơn vị</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyVehicleType">
                            <?php
                            foreach($listVehicletypes as $bt){
                                ?>
                                <tr id="vehicleType_<?php echo $bt['VehicleTypeId']; ?>">
                                    <td id="vehicleTypeName_<?php echo $bt['VehicleTypeId']; ?>"><?php echo $bt['VehicleTypeName']; ?></td>
                                    <td id="unitVallues_<?php echo $bt['VehicleTypeId']; ?>">
                                        <?php echo $this->Mconstants->getObjectValue($listTonages, 'TonnageId', $bt['TonnageId'], 'UnitVallues'); ?>
                                    </td>
                                    <?php $name = $this->Mconstants->getObjectValue($listTonages, 'TonnageId', $bt['TonnageId'], 'UnitName'); ?>
                                    <td id="tonnage_<?php echo $bt['VehicleTypeId']; ?>" data-text = "<?php echo $name; ?>">
                                        <?php echo ($name == 1)?'Tấn':'Người' ?>
                                    </td>
                                    <td id="comment_<?php echo $bt['VehicleTypeId']; ?>"><?php echo $bt['Comment']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['VehicleTypeId']; ?>" data-tonage="<?php echo $bt['TonnageId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
<!--                                        <a href="javascript:void(0)" class="link_delete" data-id="--><?php //echo $bt['VehicleTypeId']; ?><!--" title="Xóa"><i class="fa fa-trash-o"></i></a>-->
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="pointer-events-none"><input type="" class="form-control" id="vehicleTypeName" name="VehicleTypeName" data-field="Chủng loại xe"></td>
                                <td><input  type="text" class="form-control hmdrequired" id="unitVallues" name="UnitVallues" data-field="Số lượng" placeholder="Nhập số dạng:10,20,30" autofocus ></td>
                                <td> <?php $this->Mconstants->selectConstants('tonnage', 'UnitName', set_value('UnitName'), true, 'Đơn vị'); ?></td>
                                <td><input type="text" class="form-control" id="comment" name="Comment"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="VehicleTypeId" id="vehicleTypeId" value="0" hidden="hidden">
                                    <input type="text" name="TonnageId" id="TonnageId" value="0" hidden="hidden">
                                    <input type="text" id="deleteVehicleTypeUrl" value="<?php echo base_url('vehicletype/delete'); ?>" hidden="hidden">
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