<?php $this->load->view('includes/user/header'); ?>
    <div class="login-box-body">
        <p class="login-box-msg">BISTECH VIỆT NAM</p>
        <?php echo form_open('api/user/checkLogin', array('id' => 'userForm')); ?>
        <div class="form-group has-feedback">
            <span class="fa fa-user form-control-feedback"></span>
            <input type="text" name="StaffName" class="form-control hmdrequired" value="" placeholder="Điện thoại" data-field="Điện thoại">
            <span class="bottom"></span>
        </div>
        <div class="form-group has-feedback">
            <span class="fa fa-lock form-control-feedback"></span>
            <input type="password" name="StaffPass" class="form-control hmdrequired" value="" placeholder="Mật khẩu" data-field="Mật khẩu">
            <span class="bottom"></span>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                <input type="text" hidden="hidden" name="IsGetConfigs" value="1">
            </div>
            <div class="col-xs-6">
                <div class="checkbox icheck color-blu">
                    <label>
                        <input type="checkbox" name="IsRemember" class="iCheck" > Ghi nhớ
                    </label>
                </div>
            </div>
            <div class="col-xs-6 text-right">
                <div class="checkbox icheck color-blu">
                    <a href="javascript:void(0)">Quên mật khẩu</a>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <input type="text" hidden="hidden" id="dashboardUrl" value="<?php echo base_url('user/dashboard'); ?>">
        <input type="text" hidden="hidden" id="siteName" value="Ricky">
    </div>
</div>
<noscript><meta http-equiv="refresh" content="0; url=<?php echo base_url('user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/common.js?20171022"></script>
<script type="text/javascript" src="assets/js/user_login.js"></script>
</body>
</html>
<style>
    a {
    color: #2ab3b7;
}
    div#particles-js:after {
    background: rgb(0 0 0 / 20%);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    content: '';
}
.login-box{
    position: relative;
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 0;
    background-size: 100% 100%!important;
}
.login-logo{
    width: 200px;
    height: 100px;
    top: 20px;
    left: 30px;
    z-index: 10;
    position: absolute;
}
.login-logo img{
    width: 200px;
    object-fit: contain;
}
.login-box-body, .register-box-body {
    background: rgb(4 4 4 / .4);
    position: relative;
    z-index: 10;
    padding: 20px;
    border-top: 0;
    color: #666;
    width: 350px;
    box-shadow: 0px 1px 7px 1px rgb(24 141 171 / 60%);

}
.btn-primary {
    background-color: #2ab3b7;
    border-color: #1c95b0;
}
.login-box-msg, .register-box-msg{
    color: #fdf7d1;
    font-size: 24px;
    font-weight: 700;
}
.form-control-feedback{
    overflow: hidden;
    left:0;
    font-size: 18px;
    width: 20px;
    right:auto;
}
.has-feedback .form-control {
    border-bottom: 1px solid #2ab3b7!important;
    padding-left: 42.5px;
    padding-right:0;
    background-color: transparent;
    color: #2ab3b7;
    border: none;
}
.login-box-body .form-control-feedback, .register-box-body .form-control-feedback {
    color: #2ab3b7;
}
.has-feedback .form-control::-webkit-input-placeholder { /* Edge */
  color: #2ab3b7;
}

.has-feedback .form-control:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #2ab3b7;
}

.has-feedback .form-control::placeholder {
  color: #2ab3b7;
}
.color-blu{
    color: #2ab3b7; 
}
.particles-js-canvas-el{
    z-index:1;
    position: absolute;
}
.has-feedback .bottom {
    position: relative;
    display: block;
    width: 100%;
}
.has-feedback .bottom:before, .has-feedback .bottom:after {
    content: "";
    height: 2px;
    width: 0;
    bottom: 1px;
    position: absolute;
    background: #159b95;
    transition: 0.2s ease;
}
.has-feedback .bottom:after {
    left: 50%;
}
.has-feedback .bottom:before {
    right: 50%;
}
.click_form .bottom:before{
    right:0;
    width: 50%;
}
.click_form .bottom:after{
    left:0;
    width: 50%;
}
.click_form .form-control{
    width:100%;
}
.click_form .form-control-feedback{
    top: -5px;
    font-size:14px;
}
.form-control-feedback{
    transition: 0.2s ease;
}
</style>
<script src="assets/vendor/plugins/particles/particles.js"></script>
<script src="assets/vendor/plugins/particles/app.js"></script>
<script>
$(document).ready(function (){
    $('.form-group.has-feedback').click(function(){
        $('.form-group.has-feedback').removeClass('click_form');
        $(this).addClass('click_form');
    });
    $(window).click(function (e) {
    var menu = $('.form-group.has-feedback');
    if (menu.has(e.target).length == 0 && !menu.is(e.target)) {
        menu.removeClass('click_form');
    }
});
  var count_particles, stats, update;
  stats = new Stats;
  stats.setMode(0);
  stats.domElement.style.position = 'absolute';
  stats.domElement.style.left = '0px';
  stats.domElement.style.top = '0px';
  document.body.appendChild(stats.domElement);
  count_particles = document.querySelector('.banner');
  update = function() {
    stats.begin();
    stats.end();
    if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
      count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
  }
  requestAnimationFrame(update);
};
requestAnimationFrame(update);
});
</script>