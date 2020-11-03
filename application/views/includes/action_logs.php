<div class="box-logs">
    <h3 class="box-log-title"><img src="assets/img/log.png" alt=""> Lịch sử thao tác - logs</h4>
    <div class="list-logs">
        <?php 
            $i = 0;
            foreach ($listActionLogs as $key => $al){
                if($key < 3) {
                    $i++; 
                    $crDateTime = ddMMyyyy($al['CrDateTime'], 'd/m/Y H:i');
        ?>
            <div class="item-log">
                <div class="item-user-info">
                    <div class="user-avatar">
                    <?php $avatar = (empty($al['Avatar']) ? NO_IMAGE : $al['Avatar']); ?>
                        <img src="<?php echo USER_PATH.$avatar; ?>" alt="">
                    </div>
                    <div class="user-info">
                        <h4 class="user-name"><?php echo $al['FullName']; ?></h4>
                        <?php if($al['JobLevelId'] > 0): ?>
                        <div class="user-position"><?php echo $this->Mconstants->jobLevelId[$al['JobLevelId']] ?></div> 
                        <?php endif; ?>
                    </div>
                </div>
                <div class="item-log-content">
                    <?php echo $al['Comment']; ?>
                </div>
                <div class="item-log-time"><?php echo $crDateTime; ?></div>
            </div>
        <?php
                }
            }
        ?>
    </div>
    <?php if(count($listActionLogs) > 3): ?>
    <div class="text-right">
        <a href="javascript:void(0)" class="btnShowLogs" item-id="<?php echo $itemId ?>" item-type-id="<?php echo $itemTypeId; ?>" data-url="<?php echo base_url('actionlog/getListData'); ?>">Xem thêm</a>
    </div>
    <?php endif; ?>
</div>

