<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php $this->load->view('includes/breadcrumb'); ?>
        <section class="content">
            <div class="box box-success">
                <div class="breacrumb">
                    <ul>
                        <li class="active"><a title="" class="smooth">Lắp đặt thiết bị</a></li>
                        <li><a title="" class="smooth">Lắp đặt cảm biến</a></li>
                        <li><a title="" class="smooth">Cấu hình dịch vụ</a></li>
                        <li><a title="" class="smooth">KCS - Kết thúc</a></li>
                    </ul>
                </div>
                <?php $this->load->view('setting_device/tab1'); ?>
                <?php $this->load->view('setting_device/tab2'); ?>
                <?php $this->load->view('setting_device/tab3'); ?>
                <?php $this->load->view('setting_device/tab4'); ?>
            </div>
        </section>
    </div>
</div>
<input type="hidden" id="SettingListUrl" value="<?=base_url('setting')?>">
<input type="hidden" id="urlVehicleInUser" value="<?php echo base_url('vehicle/getVehicleInUser') ?>">
<?php $this->load->view('includes/modal/setting_device'); ?>
<?php $this->load->view('includes/footer'); ?>
