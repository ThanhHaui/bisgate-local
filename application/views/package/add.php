<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit" type="button">Lưu</button></li>
                    <li><a href="<?php echo base_url('package'); ?>" class="btn btn-default">Đóng</a></li>
                </ul>
            </section>
            <section class="content new-box-stl ft-seogeo">
            <?php echo form_open('package/update', array('id' => 'packagesForm')); ?>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="box box-default padding20">
                            <div class="form-group"> 
                                <label class="control-label">Nhập tên gói mở rộng <span class="required">*</span></label>
                                <input type="text" data-field="Tên gói mở rộng"  class="form-control hmdrequired" name="PackageName" placeholder="Nhập tên gói mở rộng">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="box box-default padding20">
                            <div class="box-header with-border">
                                <h3 class="box-title">Phân quyền</h3>
                            </div>
                            <div class="box-body">
                            <?php 
                                $listRoles1 = $listRoles2 = $listRoles3 = array();
                                foreach($listRoles as $role){
                                    if($role['RoleLevel'] == 1) $listRoles1[] = $role;
                                    elseif($role['RoleLevel'] == 2) $listRoles2[] = $role;
                                    elseif($role['RoleLevel'] == 3) $listRoles3[] = $role;
                                }

                                foreach($listRoles1 as $role1) {
                                    $listRolesLv2 = array();
                                    foreach($listRoles2 as $role2){
                                        if( $role2['RoleMenuChildId'] == $role1['RoleMenuId']) $listRolesLv2[] = $role2;

                                        $disabled = in_array($role1['RoleMenuId'], $listRoleMenuExits) ? 'disabled': '';
                                    }
                                    if(!empty($listRolesLv2)){
                            ?>
                                        <div class="packageRole">
                                            <label>
                                                <input type="checkbox" class="checkbox" name="RoleMenuId" <?php echo $disabled; ?> value="<?php echo $role1['RoleMenuId'].'-'.$role1['RoleMenuChildId']; ?>">
                                                <?php echo $role1['RoleMenuName']; ?>
                                            </label>
                                            <?php 
                                                foreach ($listRolesLv2 as $role2) { 
                                                    $listRolesLv3 = array();
                                                    foreach($listRoles3 as $role3){
                                                        if($role3['RoleMenuChildId'] == $role2['RoleMenuId']) $listRolesLv3[] = $role3;
                                                    }
                                                    $disabled2 = in_array($role2['RoleMenuId'], $listRoleMenuExits) ? 'disabled': '';
                                                    if(!empty($listRolesLv3)){
                                            ?>
                                                    <div class="packageRole" style="position: relative; left: 20px;">
                                                        <label>
                                                            <input type="checkbox" class="checkbox" name="RoleMenuId" <?php echo $disabled2; ?> value="<?php echo $role2['RoleMenuId'].'-'.$role2['RoleMenuChildId']; ?>">
                                                            <?php echo $role2['RoleMenuName']; ?>
                                                        </label>
                                                    
                                                    <?php 
                                                        foreach($listRolesLv3 as $role3){ 
                                                            $disabled3 = in_array($role3['RoleMenuId'], $listRoleMenuExits) ? 'disabled': '';
                                                    ?>
                                                        <div class="packageRole" style="position: relative; left: 40px;">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="RoleMenuId" <?php echo $disabled3; ?> value="<?php echo $role3['RoleMenuId'].'-'.$role3['RoleMenuChildId']; ?>">
                                                                <?php echo $role3['RoleMenuName']; ?>
                                                            </label>
                                                        </div>
                                                    <?php } ?>
                                                    </div>
                                            <?php }  else { ?>
                                                <div class="packageRole" style="position: relative; left: 20px;">
                                                    <label>
                                                        <input type="checkbox" class="checkbox" name="RoleMenuId" <?php echo $disabled2; ?> value="<?php echo $role2['RoleMenuId'].'-'.$role2['RoleMenuChildId']; ?>">
                                                        <?php echo $role2['RoleMenuName']; ?>
                                                    </label>
                                                </div>
                                            <?php } }?>
                                        </div>
                            <?php } else { ?>
                                <div class="packageRole">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="RoleMenuId" <?php echo $disabled; ?> value="<?php echo $role1['RoleMenuId'].'-'.$role1['RoleMenuChildId'] ?>">
                                        <?php echo $role1['RoleMenuName']; ?>
                                    </label>
                                </div>
                            <?php
                                    }
                                }
                            ?>
                            
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right">
                    <li><button class="btn btn-primary submit" type="button">Lưu</button></li>
                    <li><a href="<?php echo base_url('package'); ?>" class="btn btn-default">Đóng</a></li>
                    <input type="hidden" hidden="hidden" value="0" id="packageId">
                </ul>
                <?php echo form_close(); ?>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>