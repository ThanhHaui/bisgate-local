<?php $this->load->view('site/includes/header'); ?>
    <section class="section-slider-top">
        <div class="slider-home js-slider-home">
            <?php foreach($listSliders as $s): ?>
                <div class="item-slider" style="background-image: url(<?php echo IMAGE_PATH.$s['SliderImage']; ?>);">
                    <div class="text-inslider">
                        <div class="container">
                            <h2 class="ttl-keyvisual"><?php echo $s['SliderName']; ?></h2>
                            <p><?php echo $s['SliderDesc']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section>
        <?php $this->load->view('site/includes/filter'); ?>
    </section>
    <section class="sec-common sec-gray" style="margin-top: 80px;">
        <div class="container">
            <h2 class="ttl-cmn"><?php echo $configHomes['PROPERTY_HOME_TITLE']; ?></h2>
            <div class="desc-cmn">
                <p><?php echo $configHomes['PROPERTY_HOME_DESC']; ?></p>
            </div>
            <div class="content-tab">
                <div class="body-tab">
                    <div class="tab-content view-gird" id="tab-1">
                        <div class="row">
                            <?php $this->load->view('site/includes/properties', array('listProperties' => $listProperties)); ?>
                        </div>
                        <?php if($countProperty > $limitProperty){ ?>
                            <a class="btn-viewmore" id="aMoreProperty" href="javascript:void(0)">More Properties...</a>
                        <?php } ?>
                        <div style="display: none">
                            <input type="text" hidden="hidden" id="limit" value="<?php echo $limitProperty; ?>">
                            <input type="text" hidden="hidden" id="pageCount" value="<?php echo ceil($countProperty/$limitProperty); ?>">
                            <input type="text" hidden="hidden" id="pageCurrent" value="1">
                            <input type="text" hidden="hidden" id="getPropertyUrl" value="<?php echo base_url('property/getList'); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sec-common sec-gray sec-about-us no-border">
        <div class="container">
            <h2 class="ttl-cmn"><?php echo $configHomes['ABOUT_HOME_TITLE']; ?></h2>
            <div class="row">
                <div class="col-md-6">
                    <?php echo $configHomes['ABOUT_HOME_DESC']; ?>
                </div>
                <div class="col-md-6">
                    <?php $videoId = getVideoYoutubeId($configHomes['ABOUT_HOME_VIDEO']);
                    if(!empty($videoId)){ ?>
                        <iframe width="100%" height="400" src="https://www.youtube.com/embed/<?php echo $videoId; ?>" frameborder="0" allowfullscreen=""></iframe>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <section class="sec-agents sec-common sec-gray">
        <div class="container">
            <h2 class="ttl-cmn"><?php echo $configHomes['AGENT_HOME_TITLE']; ?></h2>
            <div class="desc-cmn">
                <p><?php echo $configHomes['AGENT_HOME_DESC']; ?></p>
            </div>
            <div class="slider-agents js-slider-agents">
                <?php foreach ($listAgents as $agent){
                    $this->load->view('site/includes/agent', array('agent' => $agent));
                } ?>
            </div>
        </div>
    </section>
<?php $this->load->view('site/includes/footer'); ?>