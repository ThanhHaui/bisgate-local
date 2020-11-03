<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php $this->load->view('includes/breadcrumb'); ?>
        <?php echo form_open('group/update', array('id' => 'groupForm')); ?>
        <section class="content">
            <div class="box-default">
                <div class="box-body">
                    <div class="row mgbt-10">
                        <div class="col-sm-3">
                            <p class="mt-6">Mã vai trò</p>
                        </div>
                        <div class="col-sm-9">
                            <strong><?php echo $listGroupView['GroupCode'] ?></strong>
                        </div>
                    </div>
                    <div class="row mgbt-10">
                        <div class="col-sm-3">
                            <p class="mt-6">Tên vai trò <span class="red" style="color: #ff0000;">*</span></p>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control hmdrequired" name="GroupName" id="groupName"
                                placeholder="Nhập tên vai trò" data-field="Tên vai trò"
                                value="<?php echo $listGroupView['GroupName'] ?>">
                        </div>
                    </div>
                    <div class="row mgbt-10">
                        <div class="col-sm-3">
                            <p class="mt-6">Mô tả</p>
                        </div>
                        <div class="col-sm-9">
                            <textarea type="text" rows="3" class="form-control" name="Comment"
                                id="comment"><?php echo $listGroupView['Comment'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row mgbt-20">
                <div class="col-sm-3">Thời điểm tạo: <?php echo ddMMyyyy($listGroupView['CrDateTime'], 'd/m/Y H:i'); ?></div>
                <?php 
                $nameStaff = $this->Mstaffs->getFieldValue(array('StaffId' => $listGroupView['CrStaffId']),'FullName','');
                $avataStaff = $this->Mstaffs->getFieldValue(array('StaffId' => $listGroupView['CrStaffId']),'Avatar','');
                ?>
                <div class="col-sm-6">Người tạo: <img class="img-table width30" src="<?php echo USER_PATH.$avataStaff?>" alt=""> <?php echo  $nameStaff?></div>
            </div>
            <div class="box box-success">
                <?php sectionTitleHtml($title); ?>
                <style>
                .fa-angle-down {
                    cursor: pointer;
                }
                </style>
                <ul class="nav nav-tabs mgbt-20 tab-add-pession">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Cấu hình phân quyền</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Danh sách tài khoản đang dùng</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box-body table-responsive padding30  divTable">


                        <?php $listRoles1 = $listRoles2 = $listRoles3 = array();
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
                            <div class="packageRole">
                                <label>
                                    <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role1['ActionId']?>" <?php echo in_array($role1['ActionId'], $listGroupId)?'checked':'' ?>>
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
                                        <div class="packageRole" style="position: relative; left: 20px;">
                                        <label>
                                            <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role2['ActionId'] ?>" <?php echo in_array($role2['ActionId'], $listGroupId)?'checked':'' ?>>
                                            <?php echo $role2['ActionName']; ?>
                                        </label>
                                        <?php foreach($listRolesLv3 as $role3){ ?>
                                            <div class="packageRole" style="position: relative; left: 40px;">
                                                <label>
                                                    <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role3['ActionId'] ?>" <?php echo in_array($role3['ActionId'], $listGroupId)?'checked':'' ?>>
                                                    <?php echo $role3['ActionName']; ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                        </div>
                                        <?php }  else { ?>
                                            <div class="packageRole" style="position: relative; left: 20px;">
                                        <label>
                                            <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role2['ActionId'] ?>" <?php echo in_array($role2['ActionId'], $listGroupId)?'checked':'' ?>>
                                            <?php echo $role2['ActionName']; ?>
                                        </label>
                                    </div>
                                <?php } }?>
                            </div>
                            <?php } else { ?>
                                <div class="packageRole">
                                    <label>
                                        <input type="checkbox" class="iCheck" name="ActionId" value="<?php echo $role1['ActionId'] ?>" <?php echo in_array($role1['ActionId'], $listGroupId)?'checked':'' ?>>
                                        <?php echo $role1['ActionName']; ?>
                                    </label>
                                </div>
                                <?php }
                            }?>




   
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <table class="table table-hover table-bordered text-center" id="table-group">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tài khoản người dùng</th>
                                    <th>Thời điểm gán quyền</th>
                                    <th>Người gán</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbodyGroup">
                                <?php foreach($listGroupAction as $i => $ga){
                                    $avataCr = $this->Mstaffs->getFieldValue(array('StaffId' => $ga['CrStaffId']),'Avatar','');
                                    $fullNameCr = $this->Mstaffs->getFieldValue(array('StaffId' => $ga['CrStaffId']),'FullName','');
                                    ?>
                                <tr data-id="<?php echo $ga['StaffId'] ?>">
                                    <td><?php echo $i + 1 ?></td>
                                    <td>
                                    <img class="img-table width30" src="<?php echo USER_PATH.$ga['Avatar']?>" alt="">
                                    <span><?php echo $ga['FullName'] ?></span>
                                    </td>
                                    <td><?php echo ddMMyyyy($ga['CrDateTime'],'d/m/Y H:i'); ?></td>
                                    <td>
                                    <img class="img-table width30" src="<?php echo USER_PATH.$avataCr?>" alt="">
                                    <span><?php echo $fullNameCr ?></span>
                                    </td>
                                    <td><a href="javascript:void(0)" class="link_delete_group" title="Xóa"><i class="fa fa-trash-o"></i></a></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-6 ">
                            <a class="delete_group remove_group" href="javascript:void(0)">Xóa</a>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-end">
                            <ul class="list-inline">
                                <li><a class="remove_group" href="<?php echo base_url('group')?>">Đóng</a></li>
                                <li><button class="btn btn-primary submit" type="submit">Cập nhật</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-default more-tabs cover_wrap_left" style="padding: 20px;border: 1px solid #ccc;border-radius: 10px;background:#fff">
                    <?php 
                        $this->load->view('includes/action_logs', 
                                array(
                                    'listActionLogs' =>  $this->Mactionlogs->getList($listGroupView['GroupId'], $itemTypeId, [1]),
                                    'itemId' => $listGroupView['GroupId'],
                                    'itemTypeId' => $itemTypeId
                                )
                            );
                    ?>
            </div>
        </section>
        <input type="hidden" id="groupId" name="GroupId" value="<?php echo $listGroupView['GroupId'] ?>">
        <?php echo form_close(); ?>
    </div>
</div>
<a href="<?php echo base_url('group/view/'. $groupId)?>" id="customerListUrl"></a>
<input type="text" hidden="hidden" id="urlListGroup" value="<?php echo base_url('group'); ?>">
<input type="text" hidden="hidden" id="urlChangeStatus" value="<?php echo base_url('group/delete'); ?>">
<a id="groupListUrl" href="<?php echo base_url('group/view/' . $groupId ); ?>"></a>
<ul class="ul-log-actions">
    <li class="active" action-type-ids="<?php echo json_encode(array(ID_CREATE)); ?>">
    </li>
</ul>
<?php $this->load->view('group/_modal'); ?>
<?php $this->load->view('includes/footer'); ?>