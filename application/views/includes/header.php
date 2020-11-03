<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $title; ?></title>
    <base href="<?php echo base_url(); ?>" id="baseUrl"/>
    <?php $this->load->view('includes/favicon'); ?>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pnotify/pnotify.custom.min.css"/>
    <link rel="stylesheet" href="assets/vendor/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="assets/vendor/plugins/iCheck/all.css">
    <?php if (isset($scriptHeader)) outputScript($scriptHeader); ?>
    <link rel="stylesheet" href="assets/vendor/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/style.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/common.css">
    <link rel="stylesheet" href="assets/css/log_action.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php $textLogoHeader = 'Bistech';
    $textLogoMenu = 'Bistech';
    $logoImage = NO_IMAGE;
    $configs = $this->session->userdata('configs');
    if($configs){
        if(isset($configs['TEXT_LOGO_HEADER'])) $textLogoHeader = $configs['TEXT_LOGO_HEADER'];
        if(isset($configs['TEXT_LOGO_MENU'])) $textLogoMenu = $configs['TEXT_LOGO_MENU'];
        if(isset($configs['LOGO_IMAGE'])) $logoImage = $configs['LOGO_IMAGE'];
    } ?>
    <header class="main-header">
        <a href="<?php echo base_url(); ?>" class="logo">
            <img src="assets/img/logo.png" width="140px" class="mgr-5">
        </a>
        <nav class="navbar navbar-static-top">
            <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="dropup user-toggle-account">
                <div class="treeview next-menu-left-account">
                    <div class="media user-media menu-login" style="cursor: pointer;">
                        <div class="user-media-toggleHover" style="display:none">
                            <span class="fa fa-user"></span>
                        </div>
                        <div class="user-wrapper clearfix">
                            <div class="user-link">
                                <?php $avatar = empty($user['Avatar']) ? $logoImage : $user['Avatar']; ?>
                                <img width="29" class="user-img" src="<?php echo USER_PATH.$avatar; ?>" alt="<?php echo $user['FullName']; ?>" />
                            </div>
                            <div class="media-body next-nav-text">
                                <h5 id="sys_storename" class="media-heading">Tài khoản đăng nhập</h5>
                                <p class="list-unstyled user-info">
                                    <span class="media-heading"><?php echo $user['FullName']; ?></span>
                                    <!-- <i class="fa fa-angle-up"></i> -->
                                </p>
                            </div>
                        </div>
                    </div>
                    <ul class="dropdown-menu">
                        <li><a target="_blank" href="<?php echo base_url(); ?>">Website của bạn</a></li>
                        <?php if(isset($user['StaffId'])){?>
                        <li><a href="<?php echo base_url('staff/view/'.$user['StaffId']); ?>">Tài khoản của tôi</a></li>
                        <?php }else if(isset($user['UserId'])){?>
                        <li><a href="<?php echo base_url('customer/viewMember/'.$user['UserId']); ?>">Tài khoản của tôi</a></li>
                        <?php }?>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('user/logout'); ?>">Thoát tài khoản</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <?php if(isset($user['StaffId'])){ ?>
                <?php $listActions1 = $listActions2 = $listActions3 = array();
                foreach($listActions as $act){
                    if($act['DisplayOrder'] > 0){
                        if($act['ActionLevel'] == 1) $listActions1[] = $act;
                        elseif($act['ActionLevel'] == 2) $listActions2[] = $act;
                        elseif($act['ActionLevel'] == 3) $listActions3[] = $act;
                    }
                }
                foreach($listActions1 as $act1) {
                    $listActionLv2 = array();
                    foreach($listActions2 as $act2){
                        if($act2['ParentActionId'] == $act1['ActionId']) $listActionLv2[] = $act2;
                    }
                    if(!empty($listActionLv2)){ ?>
                        <li class="treeview">
                            <a href="javascript:void(0)">
                                <i class="fa <?php echo empty($act1['FontAwesome']) ? 'fa-circle-o' : $act1['FontAwesome']; ?>"></i> <span><?php echo $act1['ActionName']; ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php foreach($listActionLv2 as $act2){
                                    if($act2['DisplayOrder'] > 0){
                                        $listActionLv3 = array();
                                        foreach($listActions3 as $act3){
                                            if($act3['ParentActionId'] == $act2['ActionId']) $listActionLv3[] = $act3;
                                        }
                                        if(!empty($listActionLv3)){ ?>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <i class="fa <?php echo empty($act2['FontAwesome']) ? 'fa-circle-o' : $act2['FontAwesome']; ?>"></i> <?php echo $act2['ActionName']; ?>
                                                    <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php foreach($listActionLv3 as $act3){ ?>
                                                        <li><a href="<?php echo empty($act3['ActionUrl']) ? 'javascript:void(0)' : base_url($act3['ActionUrl']); ?>"><i class="fa <?php echo empty($act3['FontAwesome']) ? 'fa-circle-o' : $act3['FontAwesome']; ?>"></i> <?php echo $act3['ActionName']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } else{ ?>
                                            <li><a href="<?php echo empty($act2['ActionUrl']) ? 'javascript:void(0)' : base_url($act2['ActionUrl']); ?>"><i class="fa <?php echo empty($act2['FontAwesome']) ? 'fa-circle-o' : $act2['FontAwesome']; ?>"></i> <?php echo $act2['ActionName']; ?></a></li>
                                        <?php } ?>
                                    <?php }
                                } ?>
                            </ul>
                        </li>
                    <?php } else{ ?>
                        <li><a href="<?php echo empty($act1['ActionUrl']) ? 'javascript:void(0)' : base_url($act1['ActionUrl']); ?>"><i class="fa <?php echo empty($act1['FontAwesome']) ? 'fa-circle-o' : $act1['FontAwesome']; ?>"></i> <span><?php echo $act1['ActionName']; ?></span></a></li>
                    <?php }
                } ?>
                <?php }else if(isset($user['UserId'])){ ?>
                <?php } ?>
            </ul>
        </section>
    </aside>
    <style>
        .user-toggle-account{
            padding: 8px 5px 8px 9px;
            min-height: 40px;
            display: inline-block;
            float: right;
            margin-right: 15px;
        }
        .dropup .dropdown-menu {
    top: 100%;
    bottom: auto;
}
    </style>