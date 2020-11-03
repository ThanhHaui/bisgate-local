<?php 
$status = $this->Mconstants->itemStaffStatus;
$jobLevelId = $this->Mconstants->jobLevelId;
$staffRoleId = $this->Mconstants->staffRoleId;
$genders = $this->Mconstants->genders;
$labelStaffCss = $this->Mconstants->labelStaffCss;
$labelStaffTypeCss = $this->Mconstants->labelStaffTypeCss;
$staff = $staffInfo[0];
 ?>
<div class="modal fade modal_staff_info" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row mgbt-10">
                    <div class="col-sm-3">
                        <img class="avatar-user" src="<?php echo USER_PATH.$staff['Avatar']; ?>" alt=""
                            onError="this.onerror=null;this.src='assets/vendor/dist/img/no_img.jpg';">
                    </div>
                    <div class="col-sm-9">
                        <div class="row mgbt-20">
                            <div class="col-sm-6">
                                <p class="font18 color-blue">
                                    <?php echo $staff['NickName']?$staff['NickName']:$staff['FullName'] ?>
                                </p>
                                <p><?php echo !empty($staff['JobLevelId'])?$jobLevelId[$staff['JobLevelId']]:''; ?></p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <span
                                    class="<?php echo $labelStaffCss[$staff['StatusId']]; ?> staff label"><?php echo $status[$staff['StatusId']]; ?></span>
                            </div>
                        </div>
                        <p><?= $staff['Note'] ?></p>
                    </div>
                </div>
                <p>Tên đầy đủ : <?php echo $staff['FullName']; ?></p>
                <div class="row mgbt-10">
                    <div class="col-sm-6">
                        <p><i class="fa fa-user" aria-hidden="true"></i>:
                            <?php echo $genders[$staff['GenderId']]??''; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><i class="fa fa-birthday-cake" aria-hidden="true"></i>
                            <?php echo ddMMyyyy($staff['BirthDay']); ?></p>
                    </div>
                </div>
                <div class="row mgbt-10">
                    <div class="col-sm-6">
                        <p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $staff['PhoneNumber']??''; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p>Email: <?php echo $staff['Email']; ?></p>
                    </div>
                </div>
                <div class="row mgbt-10">
                    <div class="col-sm-6">
                        <?php  if($staff['StaffId'] == $staffLogin){ ?>
                        <a href="<?php echo base_url('staff/view/'. $staff['StaffId']); ?>">
                            <i class="fa fa-cog modal_edit_user" data-userid='1' aria-hidden="true"></i>
                        </a>
                        <?php }else if ((($staffLoginRole == 1) && ($staff['StaffRoleId'] != 1)) || (($staffLoginRole == 2) && ($staff['StaffRoleId'] == 3))){
                                    ?>
                        <a href="<?php echo base_url('staff/edit/'. $staff['StaffId']); ?>">
                            <i class="fa fa-cog modal_edit_user" data-userid='1' aria-hidden="true"></i>
                        </a>
                        <?php }?>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>