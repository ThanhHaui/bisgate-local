<div class="panel-body" style="overflow: auto;">
    <div class="list-search-data">
        <div class="slimScrollDiv"
            style="position: relative; width: auto; height: 250px;">
            <ul id="ulListCustomers"style=" width: auto; height: 250px;">
            <?php foreach ($listUsers as $user) { ?>
                <li class="row" data-id="<?=$user['UserId']?>" style="padding: 10px;border-bottom: 1px dotted #ccc;cursor: pointer;">
                    <div class="wrap-img inline_block vertical-align-t radius-cycle">
                        <img class="thumb-image radius-cycle" src="<?=$user['Avatar'] ? $user['Avatar'] : 'assets/vendor/dist/img/users.png'?>" title="">
                    </div>
                    <div class="inline_block ml10">
                        <p>Tên lái xe: <span id="FullName"><?=$user['FullName']?></span></p>
                        <p>GPLX: <span id="GPLX"><?=$user['DriverLicence']?></span></p>
                        <p>SĐT: <span id="PhoneNumber"><?=$user['PhoneNumber']?></span></p>
                    </div>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="panel-footer">
    <div class="btn-group pull-right">
        <?php if($pagination > 0):?>
        <button type="button" class="btn btn-default" id="btnPrevCustomer" data-pagination='<?php echo $pagination - 1;?>'><i
                class="fa fa-chevron-left"></i></button>
        <?php endif ?>
        <?php if(count($listUsers) >= 10):?>
        <button type="button" class="btn btn-default" id="btnNextCustomer" data-pagination='<?php echo $pagination + 1;?>'><i
                class="fa fa-chevron-right"></i></button>
        <input type="text" hidden="hidden" id="pageIdCustomer" value="1">
        <?php endif?>
    </div>
    <div class="clearfix"></div>
</div>