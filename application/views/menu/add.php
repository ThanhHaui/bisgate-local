<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Lưu</button></li>
                    <li><a href="<?php echo base_url('menu'); ?>" class="btn btn-default">Đóng</a></li>
                </ul>
            </section>
            <section class="content">
                <div class="box box-default padding15">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin cơ bản</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Tên menu <span class="required">*</span></label>
                                    <input type="text" id="menuName" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Vị trí</label>
                                    <?php $this->Mconstants->selectConstants('menuPositions', 'MenuPositionId'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Trạng thái</label>
                                    <?php $this->Mconstants->selectConstants('status', 'StatusId'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><input class="btn btn-primary submit" type="submit" name="submit" value="Lưu"></li>
                    <li><a href="<?php echo base_url('menu'); ?>" id="menuListUrl" class="btn btn-default">Đóng</a></li>
                    <input type="text" hidden="hidden" id="menuId" value="0">
                    <input type="text" hidden="hidden" id="updateMenuUrl" value="<?php echo base_url('menu/update'); ?>">
                    <input type="text" hidden="hidden" id="editMenuUrl" value="<?php echo base_url('menu/edit'); ?>/">
                </ul>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>