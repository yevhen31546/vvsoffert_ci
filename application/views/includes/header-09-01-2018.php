<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Vvsoffert.se</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
        <link href="<?php echo base_url('assets/libraries/slick/slick.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/libraries/slick/slick-theme.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/trackpad-scroll-emulator.css'); ?>" rel="stylesheet" type="text/css">
        <!--<link href="<?php echo base_url('assets/css/chartist.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/jquery.raty.css'); ?>" rel="stylesheet" type="text/css">-->
        <link href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/nouislider.min.css'); ?>" rel="stylesheet" type="text/css">
        <!--<link href="<?php echo base_url('assets/css/explorer.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/explorer-red.css'); ?>" rel="stylesheet" type="text/css">-->
        <!--<link href="<?php // echo base_url('assets/css/custom.css');  ?>" rel="stylesheet" type="text/css">-->

        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
        <!--<link rel="stylesheet" href="css/custom.css">-->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>">
        <!--<link href="<?php echo base_url('assets/custom/css/custom_infoway.css'); ?>" rel="stylesheet" type="text/css">-->
       
        <link href="<?php echo base_url('assets/vendor_data/notifit/css/notifIt.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css"/> 
 <link href="<?php echo base_url('assets/custom/css/custom_infoway_30_11_2017.css'); ?>" rel="stylesheet" type="text/css">
        <style>
            ul.ui-autocomplete li.ui-menu-item a .media .media-body {
                width: 350px;
                vertical-align: middle;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid header_bg">
            <div class="container header nopad-hd-lft-rgt">
                <div class="navigation">
                    <a href="<?= site_url()?>"><div class="pull-left"><img src="<?= site_url() ?>assets/img/logo.png" class="img-responsive"></div></a>
                    <div class="pull-right">
                        <a id="menu-toggle" class="fa fa-bars btn-menu toggle pointer dropdown-toggle pull-right"></a>
                        <div class="dropdown-menu sidebar-navigation pull-right" id="myNavbar"> <a class="pointer close-sidebar">&times;</a>
                            <nav class="navbar" id="sidebar-wrapper" role="navigation">
                                <ul class="nav sidebar-nav">

                                    <li><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i> Hem</a></li>
                                    <li><a href="<?php echo site_url('Products'); ?>"><i class="fa fa-product-hunt"></i> Produkter</a></li>
                                    <?php if (!$this->session->userdata('user_id')) { ?>
                                        <li><a href="<?php echo site_url('login'); ?>"><i class="fa fa-sign-in"></i> Logga in</a></li>
                                        <li><a href="<?php echo site_url('home/signup'); ?>"><i class="fa fa-user-plus"></i> Registrera</a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-tachometer"></i> kontrollpanel</a></li>
                                        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="fa fa-sign-out"></i> Logga ut</a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo site_url('home/contactus'); ?>"><i class="fa fa-envelope-o"></i> Kontakta oss</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- /Sidebar Navigation -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
                if ($this->router->fetch_class() == 'home' && $this->router->fetch_method() == 'index') {
                    ?>
                    <div class="header_caption">
                        <h2>Här kan du jämföra vvsartiklar, pris, lagersaldo från grossister.</h2>
                        <?php // echo form_open(site_url('Products'), array('method' => 'get'));  ?>
                        <form action="<?= site_url('Products') ?>" method="get" accept-charset="utf-8">
                            <div class="header_search_bar">
                                <div class="search_left_icon"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Sök Rsk-nummer, artiklar eller tillverkare" autocomplete="off" onkeyup="searchProduct(this)">
                                <div class="search_right_icon"><i class="fa fa-times"></i></span>
                                </div>
                            </div>
<!--                           --- searchContainer---->
<div class="searchContainer active" style="display:none;" id="searchContainer">
                                <div class="left-side" id="left_side">
    </div>

    <div class="right-side" id="right_side">
       
        
    </div>
</div>
                            <!-- --- searchContainer end---->
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script>
            var site_url = '<?= site_url() ?>';
        </script>
        