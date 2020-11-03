<?php $this->load->view('site/includes/header'); ?>
    <div class="block-breadcrumb sec-gray">
        <div class="container">
            <div class="box-breadcrumb">
                <ul>
                    <li><a class="trans" href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a class="trans" href="<?php echo $articleUrl; ?>"><?php echo $article['ArticleTitle']; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section class="sec-detail-page-news">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="ttl-title-detail"><?php echo $article['ArticleTitle']; ?></h2>
                    <div class="time-view">
                        <span><i class="fa fa-clock-o" aria-hidden="true"></i><?php the_time('m/d/Y h:i:s A'); ?></span>
                        <!--|<span><i class="fa fa-eye" aria-hidden="true"></i>1025</span>-->
                    </div>
                    <div id="post-<?php echo $article['ArticleId']; ?>" class="content-detail news-detail"><?php echo $article['ArticleContent']; ?></div>
                    <?php //get_template_part('templates/share'); ?>
                </div>
                <div class="col-md-4">
                    <?php $this->load->view('site/includes/sidebar'); ?>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('site/includes/footer'); ?>
