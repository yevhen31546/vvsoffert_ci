<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="<?=site_url()?>assets/img/favicon.ico" type="image/ico" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
        <meta name="google-site-verification" content="m5APWAKxwJ90R-jY-N6PFTBQWJ7EultVu9-PSMypF-A" />
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <?php if(($_SERVER['REQUEST_URI']=='/')||($_SERVER['REQUEST_URI']=='')){ ?>
            <title>vvsoffert.se | VVS kalkyl på nätet, Jämför pris på vvs produkter</title>
            <meta content="Hitta bäst pris på allt du letar efter. Vi jämför tusentals vvsartiklar . Gör egna listor och jämför produkter bästa möjliga info med Sveriges bästa vvs kalkyl tjänst." name="description">
        <?php }elseif($_SERVER['REQUEST_URI']=='/Products'){ ?>
            <title>Vvsoffert.se vvs kalkyl program på nätet</title>
            <meta content="" name="description">
        <?php }elseif($_SERVER['REQUEST_URI']=='/products?cno=3'){ ?>
            <title>Badrumstillbehör på nätet – jämför Badrumstillbehör på nätet- vvsoffert.se</title>
            <meta content="Jämför badrumstillbehör online för att spara pengar ditt badrum hitta bästa pris hos vvsoffert.se." name="description">
        <?php }else{ ?>
            <title>vvsoffert,se | vvs kalkyl på nätet </title>
            <meta content="Hitta bäst pris på allt du letar efter. Vi jämför tusentals vvsartiklar . Gör egna listor och jämför produkter bästa möjliga info med Sveriges bästa vvs kalkyl tjänst." name="description">
        <?php } ?>
        <meta content="Vvs offert | Rörkalkyl | Vvs kalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" name="keywords">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="canonical" href="https://vvsoffert.se<?php echo str_replace("index.php","",$_SERVER['REQUEST_URI']); ?>" />
        
        
        <link rel="preload" href="<?php echo base_url('assets/css/fonts.googleapis.css?family=Lato:300,400,700s'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700"></noscript>
        <link rel="preload" href="<?php echo base_url('assets/libraries/slick/slick.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/libraries/slick/slick.css'); ?>"></noscript>
        <link rel="preload" href="<?php echo base_url('assets/libraries/slick/slick-theme.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/libraries/slick/slick-theme.css'); ?>"></noscript>
        <link rel="preload" href="<?php echo base_url('assets/css/trackpad-scroll-emulator.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/css/trackpad-scroll-emulator.css'); ?>"></noscript>
        <!--<link rel="stylesheet" href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>">-->
        <link href="<?php echo base_url('assets/css/chartist.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/jquery.raty.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="preload" href="<?php echo base_url('assets/css/nouislider.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/css/nouislider.min.css'); ?>"></noscript>
        <link rel="preload" href="<?php echo base_url('assets/css/select2.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/css/select2.css'); ?>"></noscript>
        <!--<link href="<?php echo base_url('assets/css/explorer.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/explorer-red.css'); ?>" rel="stylesheet" type="text/css">-->
        <!--<link href="<?php echo base_url('assets/css/custom.css');  ?>" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
        <!--<link rel="stylesheet" href="css/custom.css">-->
        <!--<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>">-->
        <!--<link href="<?php echo base_url('assets/custom/css/custom_infoway.css'); ?>" rel="stylesheet" type="text/css">-->
        <link rel="preload" href="<?php echo base_url('assets/vendor_data/notifit/css/notifIt.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/vendor_data/notifit/css/notifIt.min.css'); ?>"></noscript>
        <link rel="preload" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css'); ?>"></noscript>
        <link rel="preload" href="<?php echo base_url('assets/css/jquery-confirm.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-confirm.min.css'); ?>"></noscript>
                <link href="<?php echo base_url('assets/custom/css/responsive-nav.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/custom/css/custom_infoway_30_11_2017.css?v=' . time()); ?>" rel="stylesheet" type="text/css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
        <!-- Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-60657115-1"></script>
        <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}; gtag('js', new Date()); gtag('config', 'UA-60657115-1');</script>
        <style>ul.ui-autocomplete li.ui-menu-item a .media .media-body {width: 350px;vertical-align: middle;} .mst9{text-rendering: optimizeLegibility !important;} .mst10{display:none !important;}</style>
        <meta name="msvalidate.01" content="17C7A11136BFCDEA40FEFE73FAB89DE0" />
       

    <body>
        <div class="container-fluid header_bg">
            <div class="container header nopad-hd-lft-rgt">
                <div class="navigation">
                    <div class="pull-left"><a href="<?= site_url()?>"><img src="<?= site_url() ?>assets/img/logo.png" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"></a></div>
                    <div class="pull-right hidden-xs">
                        <div class="pull-right" id="myTopNavbar">
                            <nav class="navbar" id="topbar-wrapper" role="navigation">
                                <ul class="nav topbar-nav">
                                    <li><input type="text" id="search-key" name="search-key" style="width: 100%; height: 40px; padding:  6px 12px; font-size: 16px; color: gray; background: #F4FBFC; border-radius: 5px;" id="search" placeholder="Vad söker du?" autocomplete="off" />
                                    </li>
                                    <li><a href="" id="vvsoffert-se-search"><i class="fa fa-search"></i>Sök</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- /Topbar Navigation -->
                    </div>
                    <div class="pull-right hidden-lg hidden-md hidden-sm">
                        <a id="menu-toggle" class="btn-menu toggle pointer dropdown-toggle pull-right mst9"><i class="fa fa-bars"></i></a>
                        <div class="dropdown-menu sidebar-navigation pull-right" id="myNavbar"> <a class="pointer close-sidebar">&times;</a>
                            <nav class="navbar" id="sidebar-wrapper" role="navigation">
                                <ul class="nav sidebar-nav menu-items">
                                    <li><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i> Hem</a></li>
                                                                        <li class="dropdown">
                                                                            <a class="has-dropdown" href="<?php echo site_url('Products'); ?>"><i class="fab fa-product-hunt"></i> Produkter</a>
                                                                            <?php
                                                                                $custom_helper = get_instance()->load->helper('custom');
                                                                                $main_category_list = getListdata(array('pid'=>NULL,'pid2'=>NULL),'categories','name','ASC');   
                                                                                    
                                                                                if(count($main_category_list)>0) {
                                                                                    echo '<ul class="sub-menu">';
                                                                                    foreach($main_category_list as $main_category) {
                                                                                        echo '<li class="dropdown"><a class="has-dropdown" href="'.site_url($main_category->slug).'"><i class="fa fa-indent"></i> '.$main_category->name.' </a>';
                                                                                        
                                                                                        $sub_category1_list = getListdata(array('pid'=>$main_category->id,'pid2'=>NULL),'categories','name','ASC');
                                                                                        if(count($sub_category1_list)>0) {
                                                                                            echo '<ul class="sub-menu">';
                                                                                            foreach($sub_category1_list as $sub_category1) {
                                                                                                echo '<li class="dropdown"><a class="has-dropdown" href="'.site_url($sub_category1->slug).'"><i class="fa fa-indent"></i> '.$sub_category1->name.' </a>';
                                                                                                
                                                                                                $sub_category2_list = getListdata(array('pid2'=>$sub_category1->id),'categories','name','ASC');
                                                                                                if(count($sub_category2_list)>0) {
                                                                                                    echo '<ul class="sub-menu">';
                                                                                                    foreach($sub_category2_list as $sub_category2) {
                                                                                                        $sub2_link = anchor(site_url($sub_category2->slug), $sub_category2->name);
                                                                                                        echo '<li>'.$sub2_link.'</li>';
                                                                                                    }
                                                                                                    echo '</ul>';
                                                                                                }   
                                                                                                echo '</li>';
                                                                                            }
                                                                                            echo '</ul>';
                                                                                        }   
                                                                                        echo '</li>';
                                                                                    }
                                                                                    echo '</ul>';
                                                                                }
                                                                            ?>
                                                                        </li>
                                    <?php if (!$this->session->userdata('user_id')) { ?>
                                        <li><a href="<?php echo site_url('login'); ?>"><i class="fa fa-sign-in-alt"></i> Logga in</a></li>
                                        <li><a href="<?php echo site_url('home/signup'); ?>"><i class="fa fa-user-plus"></i> Registrera</a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-tachometer-alt"></i> kontrollpanel</a></li>
                                        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logga ut</a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo site_url('home/contactus'); ?>"><i class="fa fa-envelope-open"></i> Kontakta oss</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- /Sidebar Navigation -->
                    </div>
                    <div class="clearfix"></div>
                    <div class="pull-left hidden-xs">
                        <ul class="nav topbar-nav">
                            <li id="product-menu-link"><a id="product-root" href="#"><i class="fab fa-product-hunt"></i> Produkter <b class="caret"></b></a>
<?php
                                                                                $custom_helper = get_instance()->load->helper('custom');
                                                                                $main_category_list = getListdata(array('pid'=>NULL,'pid2'=>NULL),'categories','name','ASC');   
                                                                                    
                                                                                if(count($main_category_list)>0) {
                                                                                    echo '<ul id="product-menu" class="dropdown-menu main-product-category">';
                                                                                    echo '<div class="row"><a id="close-product-menu" href="#"><i class="fa fa-times fa-lg"></i></a></div>';
                                                                                    foreach($main_category_list as $main_category) {
                                                                                        $main_link = anchor(site_url($main_category->slug), $main_category->name);
                                                                                        //echo '<li><a href="#"> '. $main_category->name . ' <b class="caret"></b></a>';
                                                                                        echo '<li><a class="cl2pl" href="#"> '. $main_category->name . ' <b class="caret"></b></a>';
                                                                                        $sub_category1_list = getListdata(array('pid'=>$main_category->id,'pid2'=>NULL),'categories','name','ASC');
                                                                                        if(count($sub_category1_list)>0) {
                                                                                            echo '<ul class="dropdown-menu level1-product-category">';
                                                                                            echo '<li><a class="category-link" href="' . site_url($main_category->slug) . '">VIEW ALL</a></li>';
                                                                                            foreach($sub_category1_list as $sub_category1) {
                                                                                                $sub1_link = anchor(site_url($sub_category1->slug), $sub_category1->name);
                                                                                                //echo '<li>'.$sub1_link;
                                                                                                echo '<li><a class="cl3pl" href="#"> '. $sub_category1->name . ' <b class="caret"></b></a>';
                                                                                                
                                                                                                $sub_category2_list = getListdata(array('pid2'=>$sub_category1->id),'categories','name','ASC');
                                                                                                if(count($sub_category2_list)>0) {
                                                                                                    echo '<ul class="dropdown-menu level2-product-category">';
                                                                                                    echo '<li><a class="category-link" href="' . site_url($sub_category1->slug) . '">VIEW ALL</a></li>';
                                                                                                    foreach($sub_category2_list as $sub_category2) {
                                                                                                        $sub2_link = anchor(site_url($sub_category2->slug), $sub_category2->name);
                                                                                                        echo '<li>'.$sub2_link.'</li>';
                                                                                                    }
                                                                                                    echo '</ul>';
                                                                                                }  
                                                                                                echo '</li>';
                                                                                            }
                                                                                            echo '</ul>';
                                                                                        }  
                                                                                        echo '</li>';
                                                                                    }
                                                                                    echo '</ul>';
                                                                                }   
                                                                            ?>
                            </li>

                        </ul>
                    </div>
                    <div class="pull-right hidden-xs">
                        <div class="pull-right" id="myTopNavbar">
                            <nav class="navbar" id="topbar-wrapper" role="navigation">
                                <ul class="nav topbar-nav">
                                    <li><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i> Hem</a></li>
                                                                        
                                    <?php if (!$this->session->userdata('user_id')) { ?>
                                        <li><a href="<?php echo site_url('login'); ?>"><i class="fa fa-sign-in-alt"></i> Logga in</a></li>
                                        <li><a href="<?php echo site_url('home/signup'); ?>"><i class="fa fa-user-plus"></i> Registrera</a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-tachometer-alt"></i> kontrollpanel</a></li>
                                        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logga ut</a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo site_url('home/contactus'); ?>"><i class="fa fa-envelope-open"></i> Kontakta oss</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- /Topbar Navigation -->
                    </div>
                </div>

            </div>
        </div>
        <script>var site_url = '<?= site_url() ?>';</script>
        