<?php $this->load->view('site/includes/header'); ?>
    <div class="block-breadcrumb sec-gray">
        <div class="container">
            <div class="box-breadcrumb">
                <ul>
                    <li><a class="trans" href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a class="trans" href="<?php echo $configSites['pageUrl']; ?>"><?php echo $pageTitle; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section class="sec-head-page">
        <div class="container">
            <h2 class="ttl-title-page"><?php echo $pageTitle; ?></h2>
            <div class="count-item">Found:<strong> <?php echo priceFormat($articlesCount); ?> Items</strong></div>
            <div class="block-product-cat js-list-item view-gird">
                <div class="row">
                    <?php foreach ($listArticles as $a) {
                        $url = $this->Mconstants->getUrl($a['ArticleSlug'], $a['ArticleId'], 4); ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="item-news">
                                <div class="thumb">
                                    <a href="<?php echo $url; ?>">
                                        <?php $image = IMAGE_PATH.(empty($a['ArticleImage']) ? NO_IMAGE : $a['ArticleImage']); ?>
                                        <img src="<?php echo $image; ?>" width="350" height="350" alt="<?php echo $a['ArticleTitle']; ?>">
                                    </a>
                                    <div class="bage">
                                        <div class="date"><?php echo ddMMyyyy($a['PublishDateTime'], 'm/d'); ?></div>
                                        <div class="year"><?php echo ddMMyyyy($a['PublishDateTime'], 'Y'); ?></div>
                                    </div>
                                </div>
                                <div class="text">
                                    <h3 class="ttl-news item-matchheight"><a href="<?php echo $url; ?>"><?php echo $a['ArticleTitle']; ?></a></h3>
                                    <a class="read-more" href="<?php echo $url; ?>">Read more</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php echo getPaggingHtmlFront($pageCurrent, $pageCount, $categoryUrlPage); ?>
            </div>
        </div>
    </section>
<?php $this->load->view('site/includes/footer'); ?>