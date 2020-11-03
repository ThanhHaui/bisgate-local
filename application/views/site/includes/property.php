<?php $url = $this->Mconstants->getUrl($p['PropertySlug'], $p['PropertyId'], 3); ?>
<div class="thumb">
    <a href="<?php echo $url; ?>">
        <img width="350" height="350" src="<?php echo IMAGE_PATH.$p['PropertyImage']; ?>" alt="<?php echo $p['PropertyName']; ?>" />
    </a>
</div>
<div class="content">
    <h3 class="ttl-item item-matchheight">
        <a href="<?php echo $url; ?>"><?php echo $p['PropertyName']; ?></a>
    </h3>
    <div class="infor dis-flex justify-content-between">
        <div class="num-id"><span>ID:</span><strong><?php echo $p['PropertyCode'] ?></strong></div>
        <div class="mun-price">
            <?php if($p['PriceMonth'] > 0){ ?>
                <span> $</span>
                <strong><?php echo priceFormat($p['PriceMonth']); ?></strong>
                <span>/month</span>
            <?php } elseif($p['PriceDay'] > 0){ ?>
                <span> $</span>
                <strong><?php echo priceFormat($p['PriceDay']); ?></strong>
                <span>/day</span>
            <?php } else{ ?>
                <strong>Call</strong>
            <?php } ?>
        </div>
    </div>
    <?php if($p['PriceWeekend'] > 0){ ?>
        <div class="infor dis-flex justify-content-between">
            <div class="num-id">Weekend</div>
            <div class="mun-price">
                <span> $</span>
                <strong><?php echo priceFormat($p['PriceMonth']); ?></strong>
                <span>/day</span>
            </div>
        </div>
    <?php } ?>
    <hr>
    <div class="row utilities dis-flex justify-content-between">
        <div class="col-8 list-utilities">
            <span><i class="fa fa-bed" aria-hidden="true" title="Bedroom"></i><?php echo $p['BedRoom']; ?></span>
            <span><i class="fa fa-bath" aria-hidden="true" title="Bathroom"></i><?php echo $p['BathRoom']; ?></span>
            <span><i class="fa fa-area-chart" aria-hidden="true" title="Living Area"></i><?php echo $p['LivingArea']; ?>m<sup>2</sup></span>
        </div>
        <div class="col-4 text-center"><a class="view-more" href="<?php echo $url; ?>">Full info</a></div>
    </div>
</div>