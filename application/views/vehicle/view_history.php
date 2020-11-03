<?php if(!empty($ListHistory)) { foreach ($ListHistory as $item) { ?>
    <div class="col-sm-12">
        <div class="col-sm-6">
            <p>Ngày <?php  echo !empty($item['BeginDate']) ? ddMMyyyy($item['BeginDate'], 'd/m/Y H:i'):''; ?> - Ngày <?php  echo !empty($item['EndDate']) ? ddMMyyyy($item['EndDate'], 'd/m/Y H:i'):''; ?></p>
        </div>
        <div class="col-sm-4">
            <p><?= $item['FullName']?> - <?= $item['PhoneNumber']?> - GPLX:<?= $item['DriverLicence']?></p>
        </div>
    </div>
<?php } } ?>