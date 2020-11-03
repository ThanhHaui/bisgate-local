<?php $this->load->view('includes/user/header'); ?>
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo $title; ?></p>
        <?php $this->load->view('includes/notice'); ?>
        <?php if($isWrongToken){ ?>
            <?php echo form_open('user/changePass/'.$token); ?>
            <div class="form-group has-feedback">
                <input type="password" name="StaffPass" class="form-control" value="" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="RePass" class="form-control" value="" placeholder="Nhập lại Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8"></div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Thay đổi</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        <?php } ?>
        <a href="<?php echo base_url('user'); ?>">Đăng nhập</a>
    </div>
<?php $this->load->view('includes/user/footer'); ?>