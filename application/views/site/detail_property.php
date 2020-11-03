<?php $this->load->view('site/includes/header'); ?>
    <section class="sec-gray sec-filter-small">
        <?php $this->load->view('site/includes/filter'); ?>
    </section>
    <div class="block-breadcrumb sec-gray">
        <div class="container">
            <div class="box-breadcrumb">
                <ul>
                    <li><a class="trans" href="<?php echo base_url(); ?>">Home</a></li>
                    <li><a class="trans" href="<?php echo base_url(); ?>">Property</a></li>
                    <li><a class="trans" href="<?php echo $propertyUrl; ?>"><?php echo $property['PropertyName']; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <section class="sec-detail-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="ttl-title-detail"><?php echo $property['PropertyName']; ?></h2>
                    <div class="property dis-flex justify-content-between">
                        <div class="price-lang">
                            <select>
                                <option selected="selected" value="0">USD&#x9;</option>
                                <!--<option value="1">VND&#x9;</option>-->
                            </select>
                            <strong class="price">
                                <?php if($property['PriceMonth'] > 0) echo priceFormat($property['PriceMonth']).'/month';
                                elseif($property['PriceDay'] > 0) echo priceFormat($property['PriceDay']).'/day';
                                else echo 'Call'; ?>
                            </strong>
                        </div>
                        <?php if($property['PriceWeekend'] > 0){ ?>
                            <div class="price-lang">
                                <select>
                                    <option selected="selected" value="0">USD&#x9;</option>
                                </select>
                                <strong class="price"><?php echo priceFormat($property['PriceWeekend']); ?>/weekend day</strong>
                            </div>
                        <?php } ?>
                        <div class="id-post">ID: <?php echo $property['PropertyCode']; ?></div>
                    </div>
                    <div class="content-detail">
                        <?php $images = empty($property['PropertyImages']) ? array() : json_decode($property['PropertyImages'], true);
                        if(!empty($property['PropertyImage'])) array_unshift($images, $property['PropertyImage']);
                        if(!empty($images)): ?>
                            <div class="slider-detail">
                                <?php foreach($images as $im): ?>
                                    <div class="item"><img src="<?php echo IMAGE_PATH.$im; ?>" alt="detail"></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="infor-detail">
                            <div class="top-detail dis-flex justify-content-between">
                                <div class="text-left">Property type: <?php implode(', ', $categoryNames); ?></div>
                                <div class="text-right">Location: Ha Noi</div>
                            </div>
                            <div class="top-detail dis-flex justify-content-between">
                                <div class="text-left">Equipment: <?php echo $property['Equipment']; ?></div>
                                <div class="text-right">Furnished: <?php echo $property['Furnished']; ?></div>
                            </div>
                            <?php $i = 0;
                            $extraInfos = array();// getObjectValue($fields, 'extra_info', []);
                            foreach($extraInfos as $ei){
                                $i++;
                                if($i % 2 == 1){
                                    echo '<div class="top-detail dis-flex justify-content-between">';
                                    echo '<div class="text-left">'.$ei['name'].': '.$ei['value'].'</div>';
                                }
                                else{
                                    echo '<div class="text-right">'.$ei['name'].': '.$ei['value'].'</div>';
                                    echo '</div>';
                                }
                            }
                            if($i % 2 == 1) echo '</div>'; ?>
                            <div class="list-utilities-detail">
                                <div class="row">
                                    <div class="col-4 col-sm-4 col-md-2 item">
                                        <div class="icon"><i class="fa fa-bed" aria-hidden="true" title="Bedroom"></i></div>
                                        <div class="text">Bedroom</div>
                                        <div class="num"><strong><?php echo $property['BedRoom']; ?></strong></div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 item">
                                        <div class="icon"><i class="fa fa-bath" aria-hidden="true" title="Bathroom"></i></div>
                                        <div class="text">Bathroom</div>
                                        <div class="num"><strong><?php echo $property['BathRoom']; ?></strong></div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 item">
                                        <div class="icon"><i class="fa fa-area-chart" aria-hidden="true" title="Living Area"></i></div>
                                        <div class="text">Living Area</div>
                                        <div class="num"><strong><?php echo $property['LivingArea']; ?>m</strong><sup>2</sup></div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 item">
                                        <div class="icon"><i class="fa fa-pie-chart" aria-hidden="true" title="Land Area"></i></div>
                                        <div class="text">Land Area</div>
                                        <div class="num"><strong><?php echo $property['LandArea'] ?>m</strong><sup>2</sup></div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 item">
                                        <div class="icon"><i class="fa fa-calendar" aria-hidden="true" title="Built In"></i></div>
                                        <div class="text">Built In</div>
                                        <div class="num"><strong><?php echo $property['BuiltIn']; ?></strong></div>
                                    </div>
                                    <div class="col-4 col-sm-4 col-md-2 item">
                                        <div class="icon"><i class="fa fa-cubes" aria-hidden="true" title="Level Floor"></i></div>
                                        <div class="text">Level Floor</div>
                                        <div class="num"><strong><?php echo $property['LevelFloor']; ?></strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-service">
                                <?php foreach($serviceNames as $serviceTypeId => $arr){ ?>
                                    <div class="box-service">
                                        <h3 class="ttl-service"><?php echo $this->Mconstants->serviceTypes[$serviceTypeId]; ?></h3>
                                        <ul class="list-service row">
                                            <?php foreach($arr as $a): ?>
                                                <li class="col-sm-6 col-md-4">
                                                    <label class="style-radio">
                                                        <!--<input type="checkbox">-->
                                                        <span><?php echo $a; ?></span>
                                                    </label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                <div id="post-<?php echo $property['PropertyId']; ?>" class="box-service news-detail">
                                    <h3 class="ttl-service">Description</h3>
                                    <?php echo $property['PropertyDesc']; ?>
                                </div>
                                <div class="box-service">
                                    <h3 class="ttl-service">Google Maps</h3>
                                    <div class="map-detail"><?php echo htmlspecialchars_decode($property['GoogleMap']); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php if($agent) $this->load->view('site/includes/agent', array('agent' => $agent)); ?>
                    <!--<div class="box-tag-sidebar">
                        <?php //get_template_part('templates/share'); ?>
                    </div>-->
                    <div class="box-inquiry" id="stick-ban">
                        <h2 class="ttl-quiry">inquiry</h2>
                        <form action="<?php echo base_url('feedback/insert'); ?>" method="post" id="feedbackForm">
                            <div class="box-quiry">
                                <input class="style-text hmdrequired" type="text" name="FullName" placeholder="Name *" data-field="Name">
                            </div>
                            <div class="box-quiry">
                                <input class="style-text hmdrequired" type="text" name="PhoneNumber" placeholder="Phone Number *" data-field="Phone Number">
                            </div>
                            <div class="box-quiry">
                                <input class="style-text hmdrequired" type="text" name="Email" placeholder="Email *" data-field="Email">
                            </div>
                            <div class="box-quiry">
                                <textarea class="text-area hmdrequired" name="Content" placeholder="Message *" data-field="Message"></textarea>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LeCVLcUAAAAAM1qNpOi2tzon4M4-xUTkq-iwVNs"></div>
                            <input class="style-btn-submit trans" id="btnAddFeedback" type="button" value="Send">
                        </form>
                    </div>
                </div>
            </div>
            <?php if(!empty($listProperties)){ ?>
                <section class="sec-other">
                    <h2 class="ttl-other">Other similar properties</h2>
                </section>
                <div class="slider-other js-slider-other">
                    <?php foreach ($listProperties as $p){ ?>
                        <div class="item-similer">
                            <div class="item-product">
                                <?php $this->load->view('site/includes/property', array('p' => $p)); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php $this->load->view('site/includes/footer'); ?>