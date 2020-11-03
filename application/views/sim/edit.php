<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
            <ul class="list-inline">
                <?php if($simId): ?>
                    <li><button class="btn btn-primary submit">Cập nhật</button></li>
                <?php endif; ?>
                <li><a href="<?php echo base_url('sim'); ?>" class="btn btn-default">Đóng</a></li>
            </ul>
        </section>
        <section class="content">
            <?php if($simId): ?>
                <?php echo form_open('sim/update', array('id' => 'simForm')); ?>
                <div class="row">
                    <div class="box box-default padding15">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Thông tin Sim</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Nhà cung cấp <span class="required">*</span></label>
                                            <?php $this->Mconstants->selectObject($listSiMmanuFacturers, 'SimManufacturerId', 'SimManufacturerName', 'SimManufacturerId', $sim['SimManufacturerId'], true, '--Nhà cung cấp--', ' select2'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Số điện thoại <span class="required">*</span></label>
                                            <input type="text" id="phoneNumber" name="PhoneNumber" class="form-control hmdrequired" value="<?php echo $sim['PhoneNumber'] ?>" data-field="Số điện thoại *">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Số Seri Sim <span class="required">*</span></label>
                                            <input type="text" id="seriSim" name="SeriSim" class="form-control hmdrequired" value="<?php echo $sim['SeriSim'] ?>" data-field="Số Seri Sim *">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Loại nhà mạng</label>
                                            <?php $this->Mconstants->selectConstants('telcoIds', 'SimTypeId', $sim['SimTypeId'], true, '-- Loại nhà mạng --',' hmdrequired',''); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><button class="btn btn-primary submit" type="submit">Cập nhật</button></li>
                    <li><a href="<?php echo base_url('sim'); ?>" id="simListUrl" class="btn btn-default">Đóng</a></li>
                    <input type="text" hidden="hidden" value="<?php echo $sim['SimId'] ?>" name="SimId" id="simId">
                </ul>
                <?php echo form_close(); ?>
                <input type="text" hidden="hidden" id="urlEditSim" value="<?php echo base_url('sim/edit') ?>">
                <?php else: ?>
                    <?php $this->load->view('includes/error/not_found'); ?>
                <?php endif; ?>
            </section>
        </div>
    </div>
    <?php $this->load->view('includes/footer'); ?>