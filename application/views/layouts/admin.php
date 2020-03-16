<?php

if ($_SERVER['HTTPS'] != "on") {
    $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
        <link href="<?php echo base_url('assets/libraries/slick/slick.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/libraries/slick/slick-theme.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/trackpad-scroll-emulator.css'); ?>" rel="stylesheet" type="text/css">
        <!--<link href="<?php echo base_url('assets/css/chartist.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/jquery.raty.css'); ?>" rel="stylesheet" type="text/css">-->
        <link href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/nouislider.min.css'); ?>" rel="stylesheet" type="text/css">
        <!--<link href="<?php echo base_url('assets/css/explorer.css'); ?>" rel="stylesheet" type="text/css">-->
        <link href="<?php echo base_url('assets/css/explorer-red.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="<?php echo base_url('assets/libraries/easyAutocomplete/easy-autocomplete.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/custom.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/custom/css/custom.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/custom/css/custom_new.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/vendor_data/notifit/css/notifIt.min.css'); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css"> 

        <title>Vvsoffert.se</title>
        <style type="text/css">
            .breadcrumb{
                margin-bottom:0;
            }
            select.form-control{
                margin-bottom:0px;
            }
            .primary-nav-wrapper .nav-link {
    border-radius: 0;
    color: #7f7f7f;
    line-height: 60px;
    font-size: 14px;
    font-weight: 400;
    height: 60px;
    padding: 0 5px;
}
        </style>
    </head>
    <body class="">
        <div class="search_loader noDisplay" id="search_loader">
            <span>Loading...</span>
        </div>
        <div class="search_loader noDisplay" id="form_loader">
            <span>Processing...</span>
        </div>
        <div class="header-wrapper">
            <div class="header">
                <div class="container">
                    <div class="header-inner">
                        <div class="navigation-toggle toggle" id="top-menu-bar"> <span></span> <span></span> <span></span> </div>
                        <!-- /.header-toggle -->
                        <div class="header-logo"> <a href="<?php echo site_url('admin'); ?>" class="header-title">Vvsoffert.se</a> </div>
                        <!-- /.header-logo -->
                        <div class="header-nav float-right">
                            <div class="primary-nav-wrapper">
                                <ul class="nav">
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/dashboard'); ?>" class="nav-link">Dashboard</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/calculator'); ?>" class="nav-link">Calculator</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/users'); ?>" class="nav-link">Users</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/groups'); ?>" class="nav-link">Groups</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/categories'); ?>" class="nav-link">Categories</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/manufacturers'); ?>" class="nav-link">Manufacturers</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/ProductTypes'); ?>" class="nav-link">Product Types</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/products'); ?>" class="nav-link">Products</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/estore'); ?>" class="nav-link">E-Store</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/profile'); ?>" class="nav-link">Profile</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/TermsConditions'); ?>" class="nav-link">Terms & Conditions</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/nyheter'); ?>" class="nav-link">Nyheter</a> </li>
                                    <li class="nav-item"> <a href="<?php echo site_url('admin/logout'); ?>" class="nav-link">Logout</a> </li>
                                </ul>
                            </div>
                            <!-- /.primary-nav-wrapper --> 
                        </div>
                        <!-- /.header-nav --> 
                    </div>
                    <!-- /.header-inner --> 
                </div>
                <!-- /.container --> 
            </div>
            <!-- /.header --> 
        </div>
        <div class="admin-wrapper">
            <!-- /.admin-sidebar -->
            <div class="admin-main"> 

                <!-- /.admin-header -->
                <div class="admin-page-title">
                    <div class="container">
                        <h1><?php page_title() ?> <?php echo!empty($$pageDesc) ? '<small>' . $pageDesc . '</small>' : ''; ?></h1>
                    </div>
                    <!-- /.container --> 
                </div>
                <!-- /.admin-page-title --> 
                <?php echo $content; ?>
                <div class="admin-footer">
                    <div class="container">       
                        <div class="footer-line-left">© 2017 Vvsoffert.se. All rights reserved.  </div>
                        <!-- /.col-* -->         
                    </div>
                    <!-- /.container --> 
                </div>
            </div>
            <!-- /.admin-main --> 
        </div>
        <!-- /.admin-wrapper --> 
        <script>
            var site_url = '<?= site_url('admin/') ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js'); ?>"></script> 
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- <script type="text/javascript" src="<?php //echo base_url('assets/ckeditor/ckeditor.js')?>"></script>
        <script type="text/javascript" src="<?php //echo base_url('assets/ckfinder/ckfinder.js')?>"></script> -->
        <script type="text/javascript" src="<?php echo base_url('assets/libraries/easyAutocomplete/jquery.easy-autocomplete.min.js'); ?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/vendor_data/notifit/js/notifIt.min.js'); ?>"></script> 
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/custom/js/backend-custom.js?v=' . time()); ?>"></script> 
        <script type="text/javascript" src="<?php echo base_url('assets/custom/js/submit_forms.js?v=' . time()); ?>"></script> 
        <!--<script type="text/javascript" src="<?php // echo base_url('assets/js/tether.min.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/bootstrap.min.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/chartist.min.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/jquery.trackpad-scroll-emulator.min.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/jquery.inlinesvg.min.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/jquery.affix.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/jquery.scrollTo.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/libraries/slick/slick.min.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/wNumb.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/particles.min.js');        ?>"></script> 
        <script type="text/javascript" src="<?php // echo base_url('assets/js/explorer.js');        ?>"></script>-->
        <script>
            
            // Category 1
            $(window).resize(function () {
                if ($(window).width() > 991) {
                    $('.header-nav .primary-nav-wrapper').removeAttr("style");
                }
            });
            
            $("#top-menu-bar").click(function () {
                if ($(window).width() < 992) {
                    if ($('.header-nav .primary-nav-wrapper:visible').length > 0) {
                        $('.header-nav .primary-nav-wrapper').css({"display": "none"});
                    } else {
                        $('.header-nav .primary-nav-wrapper').css({"display": "block"});
                    }
                }
            });

            $("#category1").change(function () {
                var category1 = $(this).val();
                $('#category2').find('option').remove().end().append('<option value="">Select</option>').val('');
                $('#category3').find('option').remove().end().append('<option value="">Select</option>').val('');
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('admin/categories/getCategory2'); ?>",
                    data: {category1: category1},
                    success: function (data) {
                        if (data.result)
                        {
                            $.each(data.categories, function (key, data) {
                                console.log(data)
                                $('#category2').append($('<option/>', {
                                    value: key,
                                    text: data
                                }));
                            })
                        }
                    }
                });
            });

            // Category 2
            $("#category2").change(function () {
                var category2 = $(this).val();
                $('#category3').find('option').remove().end().append('<option value="">Select</option>').val('');
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('admin/categories/getCategory3'); ?>",
                    data: {category2: category2},
                    success: function (data) {
                        if (data.result)
                        {
                            $.each(data.categories, function (key, data) {
                                console.log(data)
                                $('#category3').append($('<option/>', {
                                    value: key,
                                    text: data
                                }));
                            })
                        }
                    }
                });
            });

            // Category 3
//        $( "#deleteProduct" ).click(function() {
//          if(confirm("Are you sure that you want to delete this product?"))
//          {
//                  return true;
//          }
//          else
//                return false;
//        });

            // Manufacturer
            var dataSrc = [<?php echo isset($ManuArray) ? $ManuArray : ""; ?>];
            $("#Manufacturer").autocomplete({
                source: dataSrc
            });

            // Product Types
            var dataSrc2 = [<?php echo isset($productTypes) ? $productTypes : ""; ?>];
            $("#ProductType").autocomplete({
                source: dataSrc2
            });
        </script> 
    </body>
</html>