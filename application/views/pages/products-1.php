<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .mst5{height:145px;}
    .mst6{color:red;}
</style>
<div class="search_listing_screen"><!--start search listing screen--->
    <div class="container"> <!--start search listing screen container--->
        <div class="row"><!--start search listing screen row--->
            <div class="col-md-3 col-sm-4">
                <div class="left_panel_wrapper">
                    <div class="sidebar hidden-lg hidden-md hidden-sm">
                        <h4>Produktlista</h4>
                        <div class="over_view">
                            <h5>Antal produkter <span class="pull-right"><span class="pull-right"><?php echo $total_rows; ?></span></h5>
                        </div>
                        <hr>
                        <div class="overview category-column mb-3 hide" id="pdt-compare-wrap">                         
                            <strong class="mrg-nw-cst-grd">Produkter att jämföra</strong>
                            <ul class="mb-0 cst-nw-ul" id="pdt-compare">                           
                            </ul>
                            <button type="button" class="btn btn-primary btn-block mt-2" id="goToCompare">Jämföra</button>
                            <hr>
                        </div>

                        <div class="form_area">
                            <?php echo form_open('', array('method' => 'get')); ?>
                            <div class="form-group">
                                <input type="text" class="search-query mb-2" name="search" placeholder="Sök på RSK ..." value="<?php echo isset($text) ? $text : ''; ?>">          
<!--                                <input type="text" class="search-query" placeholder="Search">-->
<!--                                <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>     -->
                            </div>
                            <div class="form-group">
                                <h5>Tillverkare</h5>
                                <?php echo isset($manufacturerList) ? form_dropdown('tillverkare', $manufacturerList, $currentManu, 'class="form-control" ', 'placeholder = "Välj tillverkare"') : ''; ?>

                            </div>
                            <div class="row">
                                <div class="btn-wrp-cst clearfix">
                                    <div class="col-md-6 col-sm-12">
                                        <a href="" class="btn btn-primary btn-block nw-btn-cls-3 mrg-bob-1"><i class="fas fa-sync-alt"></i> Återställa</a>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <button type="submit" class="btn btn-primary nw-btn-cls-3 mrg-bob-1"><i class="fa fa-search" aria-hidden="true"></i> Sök</button>
                                    </div>

                                </div>
                            </div>
                            <!-- /.filter -->
                            <?php
                            if (isset($currentCategory) and ! empty($currentCategory)) {
                                echo form_hidden('cno', urlencode($currentCategory));
                            }
                            if (isset($currentCategory2) and ! empty($currentCategory2)) {
                                echo form_hidden('c2no', urlencode($currentCategory2));
                            }
                            if (isset($currentCategory3) and ! empty($currentCategory3)) {
                                echo form_hidden('c3no', urlencode($currentCategory3));
                            }
                            ?>
                            <?php echo form_close(); ?>
                        </div>

                    </div><!---end sidebar--->

                    <div class="sidebar_content">
                        <h3 style="text-align: center;">Kategorier</h3>

                        <div id="treeview12" class="treeview">

                                                                        <?php
                                                                                /*$custom_helper = get_instance()->load->helper('custom');
                                                                                $main_category_list = getListdata(array('pid'=>NULL,'pid2'=>NULL),'categories','name','ASC');   
                                                                                    
                                                                                if(count($main_category_list)>0) {
                                                                                    echo '<ul class="root-product-category list-group">';
                                                                                    foreach($main_category_list as $main_category) {
                                                                                        echo '<li class="list-group-item node-treeview1"><span class="icon expand-icon fa fa-plus"></span></span></i><a class="has-dropdown" href="'.site_url($main_category->slug).'"> '.$main_category->name.' </a>';
                                                                                        
                                                                                        $sub_category1_list = getListdata(array('pid'=>$main_category->id,'pid2'=>NULL),'categories','name','ASC');
                                                                                        if(count($sub_category1_list)>0) {
                                                                                            echo '<ul class="level1-product-category sub-menu">';
                                                                                            foreach($sub_category1_list as $sub_category1) {
                                                                                                echo '<li class="list-group-item"><span class="icon expand-icon fa fa-plus"></span></span><a class="has-dropdown" href="'.site_url($sub_category1->slug).'">'.$sub_category1->name.' </a>';
                                                                                                
                                                                                                $sub_category2_list = getListdata(array('pid2'=>$sub_category1->id),'categories','name','ASC');
                                                                                                if(count($sub_category2_list)>0) {
                                                                                                    echo '<ul class="level2-product-category sub-menu">';
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
                                                                                }*/
                                                                            ?>

                            <?php
                            $custom_helper = get_instance()->load->helper('custom');
                            $main_category_list = getListdata(array('pid'=>NULL,'pid2'=>NULL),'categories','name','ASC');

                            echo '<ul class="list-group">';

                            foreach ($main_category_list as $main_category) {

                                if($main_category->slug != 'GBG-Blandare') {
                            ?>
                            <li class="list-group-item node-treeview1<?php if(isset($activeCategory) && ($activeCategory['slug'] == $main_category->slug || $activeCategory['pid'] == $main_category->id)) { echo ' active'; } ?>" data-nodeid=""><a class="cl2pl" href="#"><?php if(isset($activeCategory) && ($activeCategory['slug'] == $main_category->slug || $activeCategory['pid'] == $main_category->id)) { echo '<i class="icon expand-icon fa fa-minus"></i>'; } else { echo '<i class="icon expand-icon fa fa-plus"></i>'; } ?></a><a href="<?php echo site_url($main_category->slug); ?>" style="color:inherit;"><?php echo $main_category->name; ?></a>
                                <?php
                            

                                $sub_category1_list = getListdata(array('pid'=>$main_category->id,'pid2'=>NULL),'categories','name','ASC');
                                if(count($sub_category1_list)>0) {

                                    echo '<ul class="level1-product-category">';

                                        foreach($sub_category1_list as $sub_category1) {
                                            ?>

                                            <li class="<?php if(isset($activeCategory) && ($activeCategory['slug'] == $sub_category1->slug || $activeCategory['pid2'] == $sub_category1->id)) { echo ' active'; } ?>"><a class="cl3pl" href="#"><?php if(isset($activeCategory) && ($activeCategory['slug'] == $sub_category1->slug || $activeCategory['pid2'] == $sub_category1->id)) { echo '<i class="icon expand-icon fa fa-minus"></i>'; } else { echo '<i class="icon expand-icon fa fa-plus"></i>'; } ?></i></a><a href="<?php echo site_url($sub_category1->slug); ?>"><?php echo $sub_category1->name; ?></a>
                                            <?php

                                            $sub_category2_list = getListdata(array('pid2'=>$sub_category1->id),'categories','name','ASC');
                                            if(count($sub_category2_list)>0) {
                                                echo '<ul class="level2-product-category">';
                                                foreach($sub_category2_list as $sub_category2) {
                                                    $sub2_link = anchor(site_url($sub_category2->slug), $sub_category2->name);
                                                    ?>
                                                    <li class="<?php if(isset($activeCategory) && $activeCategory['slug'] == $sub_category2->slug) { echo ' active'; } ?>"><?php echo $sub2_link; ?></li>;
                                                    <?php
                                                }
                                                echo '</ul>';
                                            }   
                                            echo '</li>';

                                        }
                                        echo '</ul>';

                                }

                                echo '</li>';
                                }

                            }

                            echo '</ul>';
                            ?>
                        </div>

                    </div>
                </div><!---end left panel--->
            </div><!--end col-sm-3--->

            <div class="col-md-9 col-sm-8">
                <div class="row hidden-xs">
                    <div class="col-md-12">
                        <div class="col-md-6"><h4>Produktlista</h4></div>
                            <div class="col-md-6">
                                <h5>Totala produkter <span class="pull-right"><span class="pull-right"><?php echo $total_rows; ?></span></h5>
                            </div>
                    </div>
                    <div class="col-md-12" style="height: 20px;"></div>
                    <div class="col-md-12">
                        <?php echo form_open('', array('method' => 'get')); ?>
                        <div class="col-md-3">
                                <input type="text" class="search-query mb-2 form-control" name="search" placeholder="Sök på RSK ..." value="<?php echo isset($text) ? $text : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <label>Tillverkare</label>
                        </div>
                        <div class="col-md-3">
                            <?php echo isset($manufacturerList) ? form_dropdown('tillverkare', $manufacturerList, $currentManu, 'class="form-control" ', 'placeholder = "Välj tillverkare"') : ''; ?>
                        </div>
                        <div class="col-md-2">
                            <a href="" class="btn btn-primary btn-block nw-btn-cls-3 mrg-bob-1"><i class="fas fa-sync-alt"></i> Återställa</a>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary nw-btn-cls-3 mrg-bob-1"><i class="fa fa-search" aria-hidden="true"></i> Sök</button>
                        </div>
                        <?php
                        if (isset($currentCategory) and ! empty($currentCategory)) {
                            echo form_hidden('cno', urlencode($currentCategory));
                        }
                        if (isset($currentCategory2) and ! empty($currentCategory2)) {
                            echo form_hidden('c2no', urlencode($currentCategory2));
                        }
                        if (isset($currentCategory3) and ! empty($currentCategory3)) {
                            echo form_hidden('c3no', urlencode($currentCategory3));
                        }
                        ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <div class="product_body">
				
					<?php
						if($_SERVER['REQUEST_URI']=='/badrumsutrustning'){ ?>
						<h1>Jämför Badrumsprodukter & Tillbehör Online</h1>
						<p style="text-align: justify;">Vill du organisera ditt badrum på bästa sätt? Här får du chansen att hitta och jämföra badrumsprodukter på nätet, vilket kommer att ge en magisk touch till ditt utrymme. Om du vill göra om ditt badrum på bästa sätt, så är våra tillbehör som är tillgängliga i klassiska och kurviga konstruktioner säkert ett bra intryck. Från tvålfat till dispensrar till inredning, får du allting här. Priserna är faktiskt väldigt fackvänliga och frakten sker med raketfart. Vårt utbud av tillbehör är ganska spännande och du skulle älska att dekorera ditt badområde med dem. Kom och utforska, jämför badrumstillbehör och produkter online och välj de mest lämpliga enligt dina interiörer och budget.</p>
					<?php }
					?>

                    <div class="row first_row">
                        <?php
                        foreach ($productsList as $key => $product) {
                            ?>
                            <div class="col-md-4 col-sm-6 mrg-20">
                                <div class="prdts_listing_content text-center">
                                    <div class="prdts_img_area">

                                        <div class="prdts_img"> 
                                            <a class="vvsoffert-product-url" href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>" id="<?php echo $product->id; ?>" >
                                                <?php if (file_exists($product->ImageName)) { ?>
                                                    <img src="<?php echo $product->ImageName; ?>" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"> 
                                                <?php } else { ?>
                                                    <img src="https://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="prdts_content_area">
                                        <div class="prdts_title">
                                            <h5><a class="vvsoffert-product-url" href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>" id="<?php echo $product->id; ?>"><?php echo $product->Name; ?></a></h5>
                                        </div>
                                        <div class="prdts_type"><a href="<?php echo site_url($product->CSLUG); ?>"><?php echo $product->CNAME; ?></a></div>
                                        <div class="prdts_rsk_number paid_text1 border_bottom1"><b>RSK-No.</b><span class="sub_color"> <?php echo!empty($product->RSKnummer0) ? $product->RSKnummer0 : '-'; ?></span></div>
                                        <div class="prdts_manufacturer paid_text1 border_bottom1"><b>Tillverkare</b> <span class="sub_color"> <?php echo!empty($product->MName) ? $product->MName : '-'; ?></span></div>
                                        <div class="prdts_name paid_text1"><b>Produktnamn </b><span class="sub_color"><?php echo!empty($product->Produktnamn) ? $product->Produktnamn : '-'; ?></span></div>
                                    </div>
                                    <?php if (isset($user_id) && $user_id != 0) { ?>
                                        <div class="add_compare_area add_compare_area-cst">
                                            <!--<a href="javascript:;" onclick="addToList('<?php // $product->id  ?>')">-->
                                            <a href="javascript:;" id="add_to_list_<?= $product->id ?>" data-productId="<?= $product->id ?>" data-rskNo="<?= $product->RSKnummer ?>" onclick="addToList(this)">
                                                <i class="far fa-heart"></i>
                                                <!--<i class="fa fa-heart-o" aria-hidden="true">Lägg till i din Projekt/lista</i>-->
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="add_compare_area add_compare_area-cst">
                                            <a href="<?= site_url('login') ?>">
                                                <i class="far fa-heart"></i>
                                                <!--<i class="fa fa-heart-o" aria-hidden="true">Lägg till i din Projekt/lista</i>-->
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <div class="add_compare_area">
                                        <input type="checkbox"  value="<?php echo $product->id; ?>" class="add-to-compare" name="cc" id="c<?php echo $product->id; ?>"/>
                                        <label for="c<?php echo $product->id; ?>"><span></span>Lägg till för att jämföra</label>
                                    </div>

                                </div>

                            </div>
                            <?php if (($key + 1) % 3 == 0) : ?>
                                <!--                                <div class="clearfix"></div>-->
                            <?php endif; ?>
                        <?php } ?>

                    </div>

                    <div class="row">                    	
                        <div class="col-sm-12">
                            <div class="pagination_area">
                                <div class="pagination_text pull-left">
                                    <h4>Visar <?php echo $start; ?> av <?php echo $end; ?> of <?php echo $total_rows; ?> produkter och</h4>

                                </div>


                                <?php echo $this->pagination->create_links(); ?>   


                            </div>                       
                        </div>                      
                    </div>

                </div>
            </div><!---end row--->
        </div><!--end product body-->
    </div><!---end col-sm-9--->

</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form name="add_to_list_form" id="add_to_list_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Lägg till i Projekt/lista</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <input type="hidden" name="product_rsk" id="product_rsk" value="">
                    <select name="list_id" id="list_id" class="form-control">
                        <option value="0">Välj</option>
                        <?php foreach ($all_list as $k => $v) { ?>
                            <option value="<?= $v->id ?>"><?= $v->name ?></option>   
                        <?php }
                        ?>
                    </select>
                    <div class="help-block error-msg err-list_id mst6"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Stänga</button>
                    <input type="submit" class="btn btn-default" value="Lämna">
                </div>
            </form>
        </div>

    </div>
</div>