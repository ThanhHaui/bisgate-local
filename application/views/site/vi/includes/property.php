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
                <span> VNĐ</span>
                <strong><?php echo priceFormat($p['PriceMonth']); ?></strong>
                <span>/tháng</span>
            <?php } elseif($p['PriceDay'] > 0){ ?>
                <span> VNĐ</span>
                <strong><?php echo priceFormat($p['PriceDay']); ?></strong>
                <span>/ngày</span>
            <?php } else{ ?>
                <strong>Liên hệ</strong>
            <?php } ?>
        </div>
    </div>
    <?php if($p['PriceWeekend'] > 0){ ?>
        <div class="infor dis-flex justify-content-between">
            <div class="num-id">Thứ 6, 7, Lễ</div>
            <div class="mun-price">
                <span> VNĐ</span>
                <strong><?php echo priceFormat($p['PriceWeekend']); ?></strong>
                <span>/ngày</span>
            </div>
        </div>
    <?php } ?>
    <hr>
    <div class="row utilities dis-flex justify-content-between">
        <div class="col-8 list-utilities">
            <span><i class="fa fa-bed" aria-hidden="true" title="Phòng ngủ"></i><?php echo $p['BedRoom']; ?></span>
            <span><i class="fa fa-bath" aria-hidden="true" title="Phòng tắm"></i><?php echo $p['BathRoom']; ?></span>
            <span><i class="fa fa-area-chart" aria-hidden="true" title="Khu vực sống"></i><?php echo $p['LivingArea']; ?>m<sup>2</sup></span>
        </div>
        <div class="col-4 text-center"><a class="view-more" href="<?php echo $url; ?>">Xem thêm</a></div>
    </div>
</div>