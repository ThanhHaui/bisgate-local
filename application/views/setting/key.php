<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('key/update', array('id' => 'keyForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
	                            <tr>
	                                <th>Key Code</th>
	                                <th><button type="submit" class="btn btn-primary submit btn-xs">Thêm</button</th>
	                            </tr>
                            </thead>
                            <tbody id="tbodyKey">
                            <?php
                            	foreach($listKeys as $k){  
                            ?>
                                <tr>
                                    <td><?php echo $k['KeyCode']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $k['KeyId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" hidden="hidden" id="deleteKeyUrl" value="<?php echo base_url('key/delete') ?>">
                    <?php echo form_close(); ?>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>