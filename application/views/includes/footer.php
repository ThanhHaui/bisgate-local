<?php $siteName = 'Bistech';
$email = 'contact@bistech.vn';
$configs = $this->session->userdata('configs');
if($configs){
    if(isset($configs['SITE_NAME'])) $siteName = $configs['SITE_NAME'];
    if(isset($configs['EMAIL_COMPANY'])) $email = $configs['EMAIL_COMPANY'];
} ?>
<?php $this->load->view('includes/modal/modal_logs'); ?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Bản quyền của <a href="<?php echo base_url(); ?>">Bistech</a>.</strong> Phát triển bởi Bistech
    - <strong>Email: <a id="aSysEmail" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></strong>.
</footer>
</div>
<input type="text" hidden="hidden" id="rootPath" value="<?php echo ROOT_PATH; ?>">
<input type="text" hidden="hidden" id="siteName" value="<?php echo $siteName; ?>">
<input type="text" hidden="hidden" id="userImagePath" value="<?php echo USER_PATH; ?>">
<input type="text" hidden="hidden" id="errorCommonMessage" value="<?php echo ERROR_COMMON_MESSAGE; ?>">
<input type="text" hidden="hidden" id="urlDrapDropTable" value="<?php echo base_url('configtable/updateDrapDrop') ?>">
<input type="text" hidden="hidden" id="urlActiveAndLock" value="<?php echo base_url('configtable/updateActiveAndLock') ?>">
<?php if(!$user) $user = $this->session->userdata('user');
if($user){ ?>
    <input type="text" hidden="hidden" id="userLoginId" value="<?php echo isset($user['StaffId'])?$user['StaffId']:$user['UserId']; ?>">
    <input type="text" hidden="hidden" id="fullNameLoginId" value="<?php echo $user['FullName'] ?>">
    <input type="text" hidden="hidden" id="avatarLoginId" value="<?php echo empty($user['Avatar']) ? NO_IMAGE : $user['Avatar']; ?>">
<?php } else { ?>
    <input type="text" hidden="hidden" id="userLoginId" value="0">
    <input type="text" hidden="hidden" id="fullNameLoginId" value="">
    <input type="text" hidden="hidden" id="avatarLoginId" value="<?php echo NO_IMAGE; ?>">
<?php } ?>
<input type="text" hidden="hidden" id="urlGetListProvince" value="<?php echo base_url('staff/getListProvince'); ?>">
<input type="text" hidden="hidden" id="urlGetListDistrict" value="<?php echo base_url('staff/getListDistrict'); ?>">
<input type="text" hidden="hidden" id="urlGetListWard" value="<?php echo base_url('staff/getListWard'); ?>">
<input type="text" hidden="hidden" id="getListWardUrl" value="<?php echo base_url('api/config/getListWard'); ?>">
<noscript><meta http-equiv="refresh" content="0; url=<?php echo base_url('user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/plugins/fastclick/fastclick.js"></script>
<script src="assets/vendor/dist/js/app.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.min.js"></script>
<script src="assets/vendor/plugins/select2/select2.full.min.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/common.js?20191023"></script>
<?php if(isset($scriptFooter)) outputScript($scriptFooter); ?>
</body>
</html>