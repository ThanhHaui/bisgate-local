<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-ft">
                <h2 class="ttl-ft"><?php echo $configSites['FOOTER_TITLE1']; ?></h2>
                <p>
                    <strong><?php echo $configSites['COMPANY_NAME']; ?></strong>
                    <br><?php echo $configSites['ADDRESS']; ?>
                    <br>Office:  <?php echo $configSites['OFFICE_PHONE']; ?><br>Hotline: <?php echo $configSites['PHONE_NUMBER']; ?>
                    <br>Email: <a href="mailto:<?php echo $configSites['EMAIL_COMPANY']; ?>"><?php echo $configSites['EMAIL_COMPANY']; ?></a>
                    <br>Website: <a href="<?php echo base_url(); ?>"><?php echo base_url(); ?></a>
                </p>
                <div class="btn-scl-ft">
                    <a href="<?php echo $configSites['FACEBOOK_LINK']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="<?php echo $configSites['GOOGLEPLUS_LINK']; ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                    <a href="<?php echo $configSites['YOUTUBE_LINK']; ?>"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                    <a href="<?php echo $configSites['TWITTER_LINK']; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-ft">
                <h2 class="ttl-ft"><?php echo $configSites['FOOTER_TITLE2']; ?></h2>
                <ul class="list-footer">
                    <?php foreach($listMenuItems[2] as $mi){ ?>
                        <li><a href="<?php echo $mi['ItemUrl']; ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $mi['ItemName']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-2 col-md-6 col-ft">
                <h2 class="ttl-ft"><?php echo $configSites['FOOTER_TITLE3']; ?></h2>
                <ul class="list-footer">
                    <?php foreach($listMenuItems[3] as $mi){ ?>
                        <li><a href="<?php echo $mi['ItemUrl']; ?>"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $mi['ItemName']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-ft">
                <h2 class="ttl-ft">FACEBOOK</h2>
                <?php echo $configSites['FACEBOOK_PAGE_CODE']; ?>
            </div>
        </div>
        <div class="coppyright"><?php echo $configSites['COPYRIGHT']; ?></div>
    </div>
    <div class="go-top js-go-top"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
    <div class="more-action">
        <div class="item-action"><a href="mailto:<?php echo $configSites['EMAIL_COMPANY']; ?>" target="_blank"><img src="assets/front/img/common/icon_mail.svg" alt="mail"></a><span>Email</span></div>
        <div class="item-action"><a href="tel:<?php echo str_replace([' ', '.', '-'], '', $configSites['PHONE_NUMBER']); ?>" target="_blank"><img src="assets/front/img/common/icon_call.svg" alt="call"></a><span>Call</span></div>
        <div class="item-action"><a href="https://zalo.me/<?php echo $configSites['ZALO']; ?>" target="_blank"><img src="assets/front/img/common/icon_zalo.svg" alt="zalo"></a><span>Zalo</span></div>
        <div class="item-action"><a href="https://m.me/107968170589592" target="_blank"><img src="assets/front/img/common/icon_mess.svg" alt="messenger"></a><span>Messenger</span></div>
        <?php $hotline = getPhoneFormatVN($configSites['VIBER']); ?>
        <div class="item-action"><a href="<?php echo isMobile() ? 'viber://add?number='.$hotline : 'viber://chat?number='.$hotline; ?>" target="_blank"><img src="assets/front/img/common/icon_viber.svg" alt="Viber"></a><span>Viber</span></div>
        <div class="item-action"><a href="https://wa.me/<?php echo getPhoneFormatVN($configSites['WHATSPAP']); ?>" target="_blank"><img src="assets/front/img/common/icon_whatapp.svg" alt="Whatsapp"></a><span>Whatsapp</span></div>
    </div>
</footer>
</div>
<script src="assets/front/js/jquery-3.3.1.min.js"></script>
<script src="assets/front/js/modernizr.js"></script>
<script src="assets/front/js/jquery.matchHeight.js"></script>
<script src="assets/front/js/sticky-sidebar-scroll.js"></script>
<script src="assets/front/js/slick.js"></script>
<script src="assets/front/js/pure-swipe.js"></script>
<?php if(isset($scriptFooter)) outputScript($scriptFooter); ?>
<script src="assets/front/js/scripts.js"></script>
</body>
</html>