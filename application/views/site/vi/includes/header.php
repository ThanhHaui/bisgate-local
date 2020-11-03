<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--[if IE]>
    <meta http-equiv="cleartype" content="on">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0" id="viewport">
    <title><?php echo $title; ?></title>
    <base href="<?php echo base_url(); ?>" id="baseUrl"/>
    <?php $this->load->view("includes/favicon"); ?>
    <meta name="description" content="<?php echo strip_tags($configSites['META_DESC']); ?>"/>
    <meta name="keywords" content="<?php echo strip_tags($configSites['META_DESC']); ?>">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&amp;display=swap&amp;subset=vietnamese">
    <link rel="stylesheet" href="assets/front/css/bootstrap.css">
    <link rel="stylesheet" href="assets/front/css/fontawesome.css">
    <link rel="stylesheet" href="assets/front/css/slick.css">
    <?php if (isset($scriptHeader)) outputScript($scriptHeader); ?>
    <link rel="stylesheet" href="assets/front/css/style.css?1">
    <?php echo htmlspecialchars_decode($configSites['GOOGLE_ANALYTICS']); ?>
    <?php echo htmlspecialchars_decode($configSites['FACEBOOK_PIXEL']); ?>
</head>
<body class="<?php echo $isHome ? 'hone-page' : 'another-page'; ?>">
<div class="block-doc">
    <header class="main-header">
        <div class="top-header">
            <div class="container">
                <div class="row justify-content-between align-items-center inner-top-header padding-headder">
                    <a class="logo-mobile" href="<?php echo base_url(); ?>"><img src="<?php echo IMAGE_PATH.$configSites['LOGO_IMAGE']; ?>" alt="<?php echo $configSites['SITE_NAME']; ?>"></a>
                    <div class="langue">
                        <div class="langue-box js-language">
                            <img src="assets/front/img/common/vi.png" alt="vi"/>
                            <span>Việt Nam</span>
                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </div>
                        <div class="langue-drop">
                            <ul>
                                <li class="en"><a href="<?php echo $propertyCategoryRedirect; ?>">English</a></li>
                                <li class="vn"><a href="<?php echo base_url(); ?>">Việt Nam</a></li>
                            </ul>
                        </div>
                    </div>
                    <a class="btn-menu js-btn-menu" href="javascript:void(0)">
                        <i class="fa fa-bars btn-open" aria-hidden="true"></i>
                        <i class="fa fa-times btn-close" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="main-nav js-main-nav">
            <div class="container">
                <div class="row justify-content-between align-items-center padding-headder">
                    <h1 class="logo"><a class="trans" href="<?php echo base_url(); ?>"><img src="<?php echo IMAGE_PATH.$configSites['LOGO_IMAGE']; ?>" alt="<?php echo $configSites['SITE_NAME']; ?>"></a></h1>
                    <div class="right-header dis-flex flex-01">
                        <nav class="flex-01">
                            <ul class="dis-flex">
                                <?php foreach($listMenuItems[1] as $mi1){ ?>
                                    <li>
                                        <a href="<?php echo $mi1['ItemUrl']; ?>"><?php echo $mi1['ItemName']; ?></a>
                                        <?php if(!empty($mi1['Childs'])){ ?>
                                            <ul class="sub-menu">
                                                <?php foreach($mi1['Childs'] as $mi2){ ?>
                                                    <li><a href="<?php echo $mi2['ItemUrl']; ?>"><?php echo $mi2['ItemName']; ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                        <a class="phone-header" href="tel:<?php echo str_replace([' ', '.', '-'], '', $configSites['PHONE_NUMBER']); ?>">
                            <i class="fa fa-phone" aria-hidden="true"></i><span class="text"> <?php echo $configSites['PHONE_NUMBER']; ?></span>
                        </a>
                        <div class="langue">
                            <div class="langue-box js-language">
                                <img src="assets/front/img/common/vi.png" alt="vi"/>
                                <span>Việt Nam</span>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </div>
                            <div class="langue-drop">
                                <ul>
                                    <li class="en"><a href="<?php echo $propertyCategoryRedirect; ?>">English</a></li>
                                    <li class="vn"><a href="<?php echo base_url(); ?>">Việt Nam</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>