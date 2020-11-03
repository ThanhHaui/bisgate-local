<?php $this->load->view('includes/user/header'); ?>
    <div class="login-box-body">
        <p class="login-box-msg">Quên mật khẩu</p>
        <?php $this->load->view('includes/notice'); ?>
        <?php echo form_open('user/sendToken'); ?>
        <div class="form-group has-feedback">
            <input type="text" name="Email" class="form-control" value="" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8"></div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Gửi</button>
            </div>
        </div>
        <?php echo form_close(); ?>
        <a href="<?php echo base_url('user'); ?>">Đăng nhập</a><br>
    </div>
<?php $this->load->view('includes/user/footer'); ?>