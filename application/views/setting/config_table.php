<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Tên Controller</th>
                                <th style="width:150px">Hành động <a href="javascript:void(0)" id="btnShowModal">Thêm</a></th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <?php
                            foreach($listConfigTables as $p){ ?>
                                <tr id="config_table_<?php echo $p['ConfigTableId']; ?>">
                                    <td id="tableName_<?php echo $p['ConfigTableId']; ?>"><?php echo $p['TableName']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $p['ConfigTableId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $p['ConfigTableId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <input type="hidden" value="<?php echo base_url('configtable/edit') ?>" id="urlEdit">
                    </div>
                </div>
                <div class="modal fade" id="modalConfigTable" tabindex="-1" role="dialog" aria-labelledby="modalConfigTable">
                    <div class="modal-dialog" style="width:1224px!important">
                        <div class="modal-content" style="width:1224px!important">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="box-title"><i class="fa fa-comments-o"></i> Config</h4>
                            </div>
                            <div class="modal-body">
                                <?php echo form_open('configtable/update', array('id' => 'configTableForm')); ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Tên Controller *</label>
                                            <input class="form-control hmdrequired" name="TableName" id="tableName" data-field="Tên Controller *">
                                        </div>
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Tên cột db</th>
                                                <th>Tên cột hiển thị</th>
                                                <th>Tên Model</th>
                                                <th>Tên Model Relationship</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>IdEdit</th>
                                                <th>Number</th>
                                                <th>Date Time</th>
                                                <th>Ẩn/Hiện</th>
                                                <th>Ghim cột</th>
                                                <th><a href="javascript:void(0)" id="btnAddData">Thêm</a></th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyConfigTable">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" id="configTableId" name="ConfigTableId" value="0">
                                <?php echo form_close(); ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary submit">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>