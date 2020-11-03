<div class="box-body">
    <div class="box-search-advance customer">
        <?php if (isset($ssls)) { ?>
            <?php $arrActive = array();
                                    foreach($listMenuactive as $menuId){
                                        $sSLStatusId = isset($menuId['SSLStatusId'])?$menuId['SSLStatusId']:'';
                                        $sSLDetailStatusId = isset($menuId['SSLDetailStatusId'])?$menuId['SSLDetailStatusId']:'';
                                        array_push($arrActive,$menuId['RoleMenuId'],$sSLStatusId,$sSLDetailStatusId);
                                    } $arrActive = array_unique($arrActive)?>

        <div class="row mgbt-10">
            <div class="col-sm-6">
                <p class="mt-6">Chức năng trong bislog của xe (<?php echo count($arrActive) ?>/<?php echo count($listMenuCustomer) ?>)</p>
            </div>
            <div class="col-sm-6">
                Mã thuê bao SSL : <?php echo $ssls['SSLCode'] ?> <span class="<?php echo $labelCss[$ssls['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$ssls['SSLStatusId']]; ?></span>
            </div>
        </div>
        <div class="box-function">
            <?php if (in_array($ssls['SSLStatusId'], [2, 3, 4])){ ?>
                <div class="customer_border box box-default box-padding">
                    <ul>
                    <li><span>Chức năng trong bislog</span> <a href="javascript:void(0)"><span>Trạng thái xe - Bislog</span></a></li>
                        <?php $listMenuCustomer1 = $listMenuCustomer2 = $listMenuCustomer3 = array();
                        foreach($listMenuCustomer as $act){
                            if($act['RoleLevel'] == 1) $listMenuCustomer1[] = $act;
                            elseif($act['RoleLevel'] == 2) $listMenuCustomer2[] = $act;
                            elseif($act['RoleLevel'] == 3) $listMenuCustomer3[] = $act;
                        }
                        foreach($listMenuCustomer1 as $act1) {
                            $listActionLv2 = array();
                            foreach($listMenuCustomer2 as $act2){
                                if($act2['RoleMenuChildId'] == $act1['RoleMenuId']) $listActionLv2[] = $act2;
                            }
                            if(!empty($listActionLv2)){ ?>
                                <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act1['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act1['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act1['RoleMenuName']; ?></span>
                                   <?php foreach($listMenuactive as $arrActivelist){
                                        if($act1['RoleMenuId'] == $arrActivelist['RoleMenuId']){
                                       ?>
                                       <?php if(isset($arrActivelist['SSLStatusId'])){?>
                                            <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLStatusId']]; ?></span></a>
                                        <?php } if(isset($arrActivelist['SSLDetailStatusId'])) {?>
                                            <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLDetailStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLDetailStatusId']]; ?></span></a>
                                        <?php }
                                        }
                                    }?>
                                    <ul class="mgt-10">
                                        <?php foreach($listActionLv2 as $act2){
                                            $listActionLv3 = array();
                                            foreach($listMenuCustomer3 as $act3){
                                                if($act3['RoleMenuChildId'] == $act2['RoleMenuId']) $listActionLv3[] = $act3;
                                            }
                                            if(!empty($listActionLv3)){ ?>
                                                <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act2['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act2['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act2['RoleMenuName']; ?></span>
                                                <?php foreach($listMenuactive as $arrActivelist){
                                                    if($act2['RoleMenuId'] == $arrActivelist['RoleMenuId']){
                                                ?>
                                                <?php if(isset($arrActivelist['SSLStatusId'])){?>
                                                        <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLStatusId']]; ?></span></a>
                                                    <?php } if(isset($arrActivelist['SSLDetailStatusId'])) {?>
                                                        <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLDetailStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLDetailStatusId']]; ?></span></a>
                                                    <?php }
                                                    }
                                                }?>
                                                    <ul>
                                                        <?php foreach($listActionLv3 as $act3){ ?>
                                                            <li class="mgbt-10">
                                                            <input type="checkbox" class="checktran iCheck icheckitem" value="<?php echo $act3['RoleMenuId']; ?>" <?php echo in_array($act3['RoleMenuId'], $arrActive) ?'checked':'' ?>> 
                                                            <span><?php echo $act3['RoleMenuName']; ?></span>
                                                            <?php foreach($listMenuactive as $arrActivelist){
                                                                if($act3['RoleMenuId'] == $arrActivelist['RoleMenuId']){
                                                            ?>
                                                            <?php if(isset($arrActivelist['SSLStatusId'])){?>
                                                                    <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLStatusId']]; ?></span></a>
                                                                <?php } if(isset($arrActivelist['SSLDetailStatusId'])) {?>
                                                                    <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLDetailStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLDetailStatusId']]; ?></span></a>
                                                                <?php }
                                                                }
                                                            }?>
                                                        </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } else{ ?>
                                                <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act2['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act2['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act2['RoleMenuName']; ?></span>
                                                <?php foreach($listMenuactive as $arrActivelist){
                                                    if($act2['RoleMenuId'] == $arrActivelist['RoleMenuId']){
                                                ?>
                                                <?php if(isset($arrActivelist['SSLStatusId'])){?>
                                                        <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLStatusId']]; ?></span></a>
                                                    <?php } if(isset($arrActivelist['SSLDetailStatusId'])) {?>
                                                        <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLDetailStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLDetailStatusId']]; ?></span></a>
                                                    <?php }
                                                    }
                                                }?>
                                                </li>
                                                <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } else{ ?>
                            <li class="mgbt-10"><input type="checkbox" class="checktran iCheck icheckitem" name="" value="<?php echo $act1['RoleMenuId']; ?>" placeholder="" <?php echo in_array($act1['RoleMenuId'], $arrActive)?'checked':'' ?>> <span><?php echo $act1['RoleMenuName']; ?></span>
                            <?php foreach($listMenuactive as $arrActivelist){
                                        if($act1['RoleMenuId'] == $arrActivelist['RoleMenuId']){
                                       ?>
                                       <?php if(isset($arrActivelist['SSLStatusId'])){?>
                                            <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLStatusId']]; ?></span></a>
                                        <?php } if(isset($arrActivelist['SSLDetailStatusId'])) {?>
                                            <a href="<?php echo base_url('/package/edit/'.$arrActivelist['PackageId'])?>"  target="_blank"><span class="<?php echo $labelCss[$arrActivelist['SSLDetailStatusId']] ?>"><?php echo $this->Mconstants->sslStatus[$arrActivelist['SSLDetailStatusId']]; ?></span></a>
                                        <?php }
                                        }
                                    }?>
                            </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
                <?php }
            else { ?>
                <p class="text-center">Không có quyền</p>
            <?php } ?>
        </div>
        <?php  } else {?>
            <div class="row mgbt-10">
                <div class="col-sm-6">
                    <p class="mt-6">Chức năng trong bislog của xe (<span>0</span>/<span>0</span>)</p>
                </div>
                <div class="col-sm-6">
                    Mã thuê bao SSL :Trống            
                </div>
            </div>
            <div class="box-function">
                <p class="text-center">Không có quyền</p>
                <div class="not-ssl">xe không có SSL</div>
            </div>
        <?php }?>
    </div>
</div>

<style>
#tab_8 .box-function .customer_border ul li input{
   pointer-events: none;
}
#tab_8 .box-function .customer_border>ul {
    width: 70%;
}
#tab_8 .box-function .customer_border ul li a{
    float: right;
    margin-left: 20px;
}
#tab_8 .box-function .customer_border ul li {
    border-bottom:1px solid #e4e4e4;
}
</style>