<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="hero-simple mb-0">
    <div id="hero-particles"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hero-simple-content">
                    <h1>The RSK database, all about plumbing products</h1>
                    <p>
                        Here you will find easy information about plumbing products, such as assembly instructions, product sheets, type approval and pictures, etc.
                    </p>
                    <div class="hero-simple-actions">
                        <?php echo form_open(site_url('Products'), array('method' => 'get')); ?>
                        <form method="post" action="">
                            <div class="row justify-content-sm-center">
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon no-border"><i class="fa fa-search"></i></span>
                                        <input type="text" name="search" class="form-control no-border form-control-xl" placeholder="Search RSK number">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col-* -->
                                <div class="col-sm-2 hidden-xs-up">
                                    <button type="submit" class="btn btn-primary btn-xl">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                                <!-- /.col-* -->
                            </div>
                            <!-- /.row -->
                            <?php echo form_close(); ?>            
                    </div>
                    <!-- /.hero-simple-actions -->
                </div>
                <!-- /.her-simple-content -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</div>
<!-- /.hero-simple -->
<div class="main-wrapper">
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="content">                

                    <?php if (isset($groupsList) and ! empty($groupsList)) { ?>
                        <!-- /.block -->                
                        <div class="block mt-0 mb-4">
                            <div class="block-inner">
                                <div class="page-header">
                                    <h2>Product Groups</h2>                     
                                </div>
                                <div class="categories-wrapper">
                                    <div class="categories">
                                        <div class="row">
                                            <?php foreach ($groupsList as $groupData) { ?>
                                                <div class="col-md-6 col-lg-3">
                                                    <div class="category-column">                             
                                                        <?php
                                                        echo heading($groupData->name, 3);

                                                        if (isset($categories) and isset($categories[$groupData->id])) {
                                                            foreach ($categories[$groupData->id] as $category) {
                                                                $list[] = anchor(site_url('products?cno=' . $category->id), $category->name);
                                                            }

                                                            echo ul($list);
                                                            unset($list);
                                                        }
                                                        ?>                              
                                                    </div>
                                                    <!-- /.category-column -->
                                                </div>
                                                <!-- /.col-* -->  
                                            <?php } ?>                                                

                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.categories -->
                                </div>
                                <!-- /.categories-wrapper -->
                            </div>
                            <!-- /.block-inner -->
                        </div>
                        <!-- /.block -->
                    <?php } ?>

                    <!-- /.features -->


                    <div class="carousel-fullwidth">
                        <div class="page-header mt-3 text-white">
                            <h2>Products</h2>
                            <p class="text-white">Here you will find easy information about plumbing products.</p>
                        </div>
                        <div class="carousel-fullwidth-inner">
                            <div class="listing-boxes">
                                <div class="row mb-30 carousel-items random-products">
                                    <?php
                                    if (isset($productsList) and ! empty($productsList)) {
                                        foreach ($productsList as $product) {
                                            ?>
                                            <div class="col">
                                                <div class="listing-box">
                                                    <div class="listing-box-inner">
                                                        <a href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>" class="listing-box-image">
                                                            <span class="listing-box-image-content" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>')"></span><!-- /.listing-box-image-content -->
                                                        </a>                                                               
                                                        <!-- /.listing-box-image -->
                                                        <div class="listing-box-content">
                                                            <h2><a href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>"><?php echo $product->Name; ?></a></h2>                                
                                                            <div class="actions hide">
                                                                <div class="actions-button">
                                                                    <span></span>
                                                                    <span></span>
                                                                    <span></span>
                                                                </div>
                                                                <!-- /.actions-button -->
                                                                <ul class="actions-list hide">
                                                                    <li><a href="#">Add to compare</a></li>                                    
                                                                    <li><a href="#">Report listing</a></li>
                                                                </ul>
                                                                <!-- /.actions-list -->
                                                            </div>
                                                            <!-- /.actions -->
                                                        </div>
                                                        <!-- /.listing-box-content -->
                                                        <div class="pad-5">
                                                            <span class="listing-box-category tag"><a href="<?php echo site_url('Products?cno=' . $product->CID); ?>"><?php echo $product->CNAME; ?></a></span> 
                                                            <dl>
                                                                <dt>RSK-Nr.</dt>
                                                                <dd><?php echo!empty($product->RSKnummer0) ? $product->RSKnummer0 : '-'; ?></dd>
                                                                <dt>Tillverkare</dt>
                                                                <dd><?php echo!empty($product->MName) ? $product->MName : '-'; ?></dd>
                                                                <dt>Produktnamn</dt>
                                                                <dd><?php echo!empty($product->Produktnamn) ? $product->Produktnamn : '-'; ?></dd>
                                                            </dl>                                                                
                                                        </div>
                                                        <!-- /.listing-box-attributes -->
                                                        <div class="listing-box-attributes-icons hide">
                                                            <ul>
                                                                <li><i class="fa fa-arrows"></i> <span>182sqft</span></li>
                                                                <li><i class="fa fa-shower"></i> <span>2</span></li>
                                                                <li><i class="fa fa-car"></i> <span>1</span></li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.listing-box-attributes -->
                                                    </div>
                                                    <!-- /.listing-box-inner -->
                                                </div>
                                                <!-- /.listing-box -->
                                            </div> 
                                            <?php
                                        }
                                    }
                                    ?>                                               

                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.listing-boxes -->
                        </div>
                        <!-- /.carousel-fullwidth-inner -->
                    </div>
                    <!-- /.carousel-fullwidth -->

                    <?php
                    if (isset($groupsList) and ! empty($groupsList)) {
                        foreach ($groupsList as $groupData) {
                            ?>
                            <!-- category 1 -->
                            <div class="page-header">
                                <h2><?php echo $groupData->name; ?></h2>                  
                            </div>
                            <div class="row">
                                <?php
                                if (isset($groupPdtList[$groupData->id])) {
                                    foreach ($groupPdtList[$groupData->id] as $product) {
                                        ?>
                                        <div class="col-sm-3">
                                            <div class="listing-box">
                                                <div class="listing-box-inner">

                                                    <!-- /.listing-box-info -->
                                                    <a href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>" class="listing-box-image">
                                                        <span class="listing-box-image-content" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>')"></span><!-- /.listing-box-image-content -->                                                  
                                                        <span class="listing-box-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </span>
                                                    </a><!-- /.listing-box-image -->
                                                    <div class="listing-box-content">
                                                        <h2><a href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>"><?php echo $product->Name; ?></a></h2>                                                    
                                                    </div>
                                                    <!-- /.listing-box-content -->
                                                    <div class="pad-5">
                                                        <span class="listing-box-category tag"><a href="<?php echo site_url('Products?cno=' . $product->CID); ?>"><?php echo $product->CNAME; ?></a></span> 
                                                        <dl>
                                                            <dt>RSK-Nr.</dt>
                                                            <dd><?php echo!empty($product->RSKnummer0) ? $product->RSKnummer0 : '-'; ?></dd>
                                                            <dt>Tillverkare</dt>
                                                            <dd><?php echo!empty($product->MName) ? $product->MName : '-'; ?></dd>
                                                            <dt>Produktnamn</dt>
                                                            <dd><?php echo!empty($product->Produktnamn) ? $product->Produktnamn : '-'; ?></dd>
                                                        </dl>
                                                    </div>
                                                    <!-- /.listing-box-attributes -->
                                                    <div class="listing-box-attributes-icons hide">
                                                        <ul>
                                                            <li><i class="fa fa-arrows"></i> <span>182sqft</span></li>
                                                            <li><i class="fa fa-shower"></i> <span>2</span></li>
                                                            <li><i class="fa fa-car"></i> <span>1</span></li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.listing-box-attributes -->
                                                </div>
                                                <!-- /.listing-box-inner -->
                                            </div>
                                            <!-- /.listing-box -->
                                        </div>
                                        <!-- /.col-* -->
                                        <?php
                                    }
                                }
                                ?>

                            </div>
                            <!-- /.category 1-->
                            <?php
                        }
                    }
                    ?>                                                

                    <!-- /.block -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.main-inner -->
    </div>
    <!-- /.main -->
</div>
<!-- /.main-wrapper -->           