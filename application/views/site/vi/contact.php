<?php $this->load->view('site/includes/header'); ?>
    <div class="block-breadcrumb sec-gray">
        <div class="container">
            <div class="box-breadcrumb">
                <ul>
                    <li><a class="trans" href="<?php echo base_url(); ?>">Trang chủ</a></li>
                    <li><a class="trans" href="<?php echo base_url('contact.html') ?>"><?php echo $pageTitle; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section class="block-map">
        <div class="container">
            <?php echo $configSites['ADDRESS_MAP']; ?>
        </div>
    </section>
    <section class="sec-contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="ttl-contact"><?php echo $pageTitle; ?></h2>
                    <div class="content-detail news-detail"><?php echo $contactContent; ?></div>
                </div>
                <div class="col-md-6 form-page-contact">
                    <form action="<?php echo base_url('feedback/insert'); ?>" method="post" id="feedbackForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box-quiry">
                                    <input class="style-text hmdrequired" type="text" name="FullName" placeholder="Họ tên *" data-field="Họ tên">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box-quiry">
                                    <input class="style-text hmdrequired" type="text" name="Email" placeholder="Email *" data-field="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="box-quiry">
                                    <input class="style-text" type="text" name="Address" placeholder="Địa chỉ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="box-quiry">
                                    <textarea class="text-area hmdrequired" name="Content" placeholder="Nội dung *" data-field="Nội dung"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="g-recaptcha" data-sitekey="6LeCVLcUAAAAAM1qNpOi2tzon4M4-xUTkq-iwVNs"></div>
                            </div>
                            <div class="col-md-3 text-btn">
                                <input class="trans input-send" id="btnAddFeedback" type="button" value="Gửi">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('site/includes/footer'); ?>