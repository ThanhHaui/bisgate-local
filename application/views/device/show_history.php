<?php if(!empty($ListHistory)) { foreach ($ListHistory as $item) { ?>
    <div class="col-sm-12">
        <div class="col-sm-6">
            <p>Ngày <?= date('d/m/Y H:i', strtotime($item['BeginDate']))?> - Ngày <?= date('d/m/Y H:i', strtotime($item['EndDate']))?> </p>
        </div>
        <div class="col-sm-4">
            <p><?= $item['PhoneNumber']?> - <?= $item['SimTypeId']?></p>
        </div>
    </div>
<?php } } ?>