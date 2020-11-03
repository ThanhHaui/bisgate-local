<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php $this->load->view('includes/breadcrumb'); ?>
        <?php echo form_open('group/update', array('id' => 'groupForm')); ?>
        <section class="content">
            <div class="box-default">
                <div class="box-body">
                    <p class="name_group"><i class="fa fa-fw  fa-plus-circle"
                            style="font-size: 20px;top: 3px;position: relative;"></i> Tạo nhóm quyền mới</p>
                    <div class="row mgbt-10">
                        <div class="col-sm-3">
                            <p class="mt-6">Tên vai trò <span class="red">*</span></p>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control hmdrequired" name="GroupName" id="groupName"
                                placeholder="Nhập tên vai trò" data-field="Tên vai trò">
                        </div>
                    </div>
                    <div class="row mgbt-10">
                        <div class="col-sm-3">
                            <p class="mt-6">Mô tả</p>
                        </div>
                        <div class="col-sm-9">
                            <textarea type="text" rows="3" class="form-control" name="Comment" id="comment"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="box box-success">
                <?php sectionTitleHtml($title); ?>
                <style>
                .fa-angle-down {
                    cursor: pointer;
                }
                </style>
                <div class="box-body table-responsive padding30 divTable">


                    <?php
                    $listRoles1 = $listRoles2 = $listRoles3 = array();
                    foreach($listActiveActions as $role){
                        if($role['ActionLevel'] == 1) $listRoles1[] = $role;
                        elseif($role['ActionLevel'] == 2) $listRoles2[] = $role;
                        elseif($role['ActionLevel'] == 3) $listRoles3[] = $role;
                    }

                    foreach($listRoles1 as $role1) {
                        $listRolesLv2 = array();
                        foreach($listRoles2 as $role2){
                            if( $role2['ParentActionId'] == $role1['ActionId']) $listRolesLv2[] = $role2;
                        }
                        if(!empty($listRolesLv2)){
                            ?>
                            <div class="packageRole" >
                                <label>
                                    <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role1['ActionId'] ?>">
                                    <?php echo $role1['ActionName']; ?>
                                </label>
                                <?php
                                foreach ($listRolesLv2 as $role2) {
                                    $listRolesLv3 = array();
                                    foreach($listRoles3 as $role3){
                                        if($role3['ParentActionId'] == $role2['ActionId']) $listRolesLv3[] = $role3;
                                    }
                                    if(!empty($listRolesLv3)){
                                        ?>
                                        <div class="packageRole mgt-10" style="position: relative; left: 20px;">
                                        <label>
                                            <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role2['ActionId']?>">
                                            <?php echo $role2['ActionName']; ?>
                                        </label>
                                        <?php foreach($listRolesLv3 as $role3){ ?>
                                            <div class="packageRole mgt-10" style="position: relative; left: 40px;">
                                                <label>
                                                    <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role3['ActionId'] ?>">
                                                    <?php echo $role3['ActionName']; ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        </div>
                                        <?php }  else { ?>
                                            <div class="packageRole" style="position: relative; left: 20px;">
                                        <label>
                                            <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role2['ActionId'] ?>">
                                            <?php echo $role2['ActionName']; ?>
                                        </label>
                                    </div>
                                <?php } }?>
                            </div>
                            <?php } else { ?>
                                <div class="packageRole">
                                    <label>
                                        <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role1['ActionId'] ?>">
                                        <?php echo $role1['ActionName']; ?>
                                    </label>
                                </div>
                                <?php }
                            }?>





                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6 ">
                            <a class="remove_group" href="<?php echo base_url('group')?>">Hủy</a>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-end">
                            <ul class="list-inline">
                                <li><button class="btn btn-default" id="checkAll">Chọn tất cả</button></li>
                                <li><button class="btn btn-default" id="unCheckAll">Bỏ chọn tất cả</button></li>
                                <li><button class="btn btn-primary submit" type="submit">Tạo</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" id="groupId" name="GroupId" value="0">
        <?php echo form_close(); ?>
    </div>
</div>
<a href="<?php echo base_url('group')?>" id="customerListUrl"></a>
<?php $this->load->view('includes/footer'); ?>