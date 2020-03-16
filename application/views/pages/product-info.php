<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<? //var_dump($categories1);exit;?>
<? //var_dump($productData->url);
//$cat_str = explode("https://www.rskdatabasen.se/kategori/",$productData->url);
//echo $cat_str[1];
//exit;?>
<link href="<?php echo base_url('assets/custom/css/product_info.css'); ?>" rel="stylesheet" type="text/css">
<style>
    .mst4{color:red;}
    
    @media (max-width: 1024px){
        .oversikt_table td {
            display: inline-block !important;    
        }
        
        .price_table td {
            display: table-cell;    
        }
    }
</style>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-3988943093889951",
enable_page_level_ads: true
});
</script>


<div class="listing_details_screen">
    <div class="container">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="listing_details_screen_screen_title">
                    <!--<h5>RSK-Nr: <?php echo $productData->RSKnummer0; ?> <i class="fa fa-check-square" aria-hidden="true"></i> </h5>-->
                    <h5>RSK-Nr: <?php echo $productData->RSKnummer; ?> <i class="fa fa-check-square" aria-hidden="true"></i> </h5>
                    <!-- <p>Inlagd: <?php //echo(strftime('%d. %B %Y', strtotime($productData->CreatedDate))); ?><br>
                        RSK-nr enhet: <?php//echo $productData->Unit; ?></p> -->
                </div>

                <div class="listing_details_breadcrumb_pagination">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url(); ?>">Hem</a> </li>
                        <!--<li><a href="#"><?php //echo $groupData->name; ?></a></li>-->
                        <!--<li> <a href="<?php //echo site_url('products?c=' . urlencode($productData->CNAME) . '&no=' . $productData->CID); ?>"><?php echo $productData->CNAME; ?></a></li>-->
                        <li> <a href="<?php echo site_url($productData->CSLUG); ?>"><?php echo $productData->CNAME; ?></a></li>
                        <li><?php echo $productData->Name; ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="listing_detail_bg">
            <div class="row top_sec clearfix">

                <div class="col-sm-6">
                    <div class="img_background">
                        <div class="bg_img">

                            <?php if (file_exists($productData->ImageName)) { ?>
                                                    <img src="<?php echo site_url($productData->ImageName); ?>" class="img-responsive center-block mst5" style="height: 145px; width: 145px;" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } else if(!empty($productData->ImageName)) {
                                                    ?>
                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/<?php echo explode('/', $productData->ImageName)[1] . '/' . explode('/', explode('.', $productData->ImageName)[0])[2] . '.jpg'; ?>" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } else { 
                                                    ?>
                                                    <img src="https://vvsoffert.se/images/NAPICTURE.jpg" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="tbl_area">
                        <p><?php echo $productData->Name; ?></p>

                    <div>
                        <?php

                            $array = $this->session->flashdata('message');
                            if (!empty($array)) {

                        ?>
                        <div style="padding: 5px;" class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <?php echo $array['content']; ?>
                        </div>
                    </div>
                    <?php

                            $this->session->unset_userdata('message');
                        }

                    ?>
                    <!-- <div class="col-sm-6"> -->
                        <div style="float: right; padding-left: 10px;" class="add_compare_area add_compare_area-cst">
                            <a href="javascript:;" style="display: initial; background-color: #FF9400; color: #ffffff; font-size: 100%;" class="btn btn-sm" id="send_quote_<?= $productData->id ?>" data-productId="<?= $productData->id ?>" data-manufacturer="<?= $productData->MName ?>" data-productName="<?= $productData->Name ?>" data-rskNo="<?= $productData->RSKnummer ?>" onclick="sendQuote(this)">
                                <i class="fa fa-sm fa-envelope"></i>
                                <b>Offertförfrågan</b>
                            </a>
                        </div>
                        <?php if (isset($user_id) && $user_id != 0) { ?>
                            <div style="float: right;" class="add_compare_area add_compare_area-cst">
                                <!--<a href="javascript:;" onclick="addToList('<?php // $product->id  ?>')">-->
                                <a style="display: initial; background-color: #1F543F; color: #ffffff; font-size: 100%;" href="javascript:;" class="btn btn-sm" id="add_to_list_<?= $productData->id ?>" data-productId="<?= $productData->id ?>" data-rskNo="<?= $productData->RSKnummer ?>" onclick="addToList(this)">
                                <i class="fa fa-sm fa-plus"></i>
                                    <b>Till lista</b>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div style="float: right;" class="add_compare_area add_compare_area-cst">
                                <!--<a style="display: initial; background-color: #1F543F; color: #ffffff; font-size: 100%;" class="btn btn-sm" href="<?= site_url('login') ?>">-->
                                <a style="display: initial; background-color: #1F543F; color: #ffffff; font-size: 100%;" class="btn btn-sm" href="<?= site_url('logga-in') ?>">
                                    <i class="fa fa-sm fa-plus"></i>
                                    <b>Till lista</b>
                                </a>
                            </div>
                        <?php } ?>
                        <br><br>
                        <divclass="clearfix"></div>
                        <div class="oversikt table-responsive">
                            <table class="oversikt_table">

                                <tr>
                                    <td>RSK-nummer : </td>
                                    <td><?php echo $productData->RSKnummer; ?></td>
                                </tr>
                                <tr>
                                    <td>Tillverkare</td>
                                    <td><?php echo $productData->MName; ?></td>
                                </tr>
                                <tr>
                                    <td>Tillverkarens artikelnummer</td>
                                    <td><?php echo $productData->Tillverkarensartikelnummer; ?></td>
                                </tr>
                                <tr>
                                    <td>GTIN</td>
                                    <td><?php echo $productData->GTIN; ?></td>
                                </tr>
                                <tr>
                                    <td>Produkt</td>
                                    <td><?php echo $productData->Produkt; ?></td>
                                </tr>
                                <tr>
                                    <td>Produktnamn</td>
                                    <td><?php echo $productData->Produktnamn; ?></td>
                                </tr>
                                <tr>
                                    <td>Dimension</td>
                                    <td><?php echo $productData->Dimension; ?></td>
                                </tr>
                                <tr>
                                    <td>Storlek</td>
                                    <td><?php echo $productData->Storlek; ?></td>
                                </tr>
                                <tr>
                                    <td>Tryck/Flöde/Temp</td>
                                    <td><?php echo $productData->TryckFlodeTemp; ?></td>
                                </tr>
                                <tr>
                                    <td>Effekt/Eldata</td>
                                    <td><?php echo $productData->EffektEldata; ?></td>
                                </tr>
                                <tr>
                                    <td>Funktion</td>
                                    <td><?php echo $productData->Funktion; ?></td>
                                </tr>
                                <tr>
                                    <td>Utförande</td>
                                    <td><?php echo $productData->Utforande; ?></td>
                                </tr>
                                <tr>
                                    <td>Färg</td>
                                    <td><?php echo $productData->Farg; ?></td>
                                </tr>
                                <tr>
                                    <td>Ytbehandling</td>
                                    <td><?php echo $productData->Ytbehandling; ?></td>
                                </tr>
                                <tr>
                                    <td>Material</td>
                                    <td><?php echo $productData->Material; ?></td>
                                </tr>
                                <tr>
                                    <td>Standard</td>
                                    <td><?php echo $productData->Standard; ?></td>
                                </tr>
                                <tr>
                                    <td>Övrig info	</td>
                                    <td><?php echo $productData->Ovriginfo; ?></td>
                                </tr>
                                <tr>
                                    <td>Egen benämning Svensk</td>
                                    <td><?php echo $productData->EgenbenamningSvensk; ?></td>
                                </tr>
                                <tr>
                                    <td>Ersatt av	</td>
                                    <td><?php echo $productData->Ersattav; ?></td>
                                </tr>
                                <tr>
                                    <td>Varumärke</td>
                                    <td><?php echo $productData->Varumarke; ?></td>
                                </tr>
                                <tr>
                                    <td>Tillverkarens produktsida</td>
                                    <td><?php echo $productData->Tillverkarensproduktsida; ?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>

            <div class="last_table_section">
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="price_table_area">
                            <h5>Bästa pris</h5>
                            <div class="price_table table-responsive">
                                <table class="price_table">
                                    <tr>
                                        <th style="width: 20%;">E-Butik</th>
                                        <th style="width: 20%;">Lager<br>status</th>
                                        <!--<th style="width: 5%;"></th>-->
                                        <th style="width: 25%;">Pris</th>
                                        <th style="width: 35%;">Länkar</th>
                                        <!--<th class="hidden-lg hidden-md hidden-sm" style="width: 75%;">Detaljer</th>-->
                                    </tr>
                                    <?php
                                    if (isset($otherStore) && count($otherStore) > 0) : ?>
                                        <?php foreach ($otherStore as $v): 
                                            // var_dump($v);exit;
                                           
                                        ?>
                                            <tr>
                                                <td style="width: 20%;">
                                                    <?php if(file_exists($v->logoImage)){?>
                                                         <a href="<?php echo $v->e_store_link; ?>" target="new"><img title="<?php echo 'Gå till ' . $v->seller . ' för ' . $v->product_name; ?>" src="<?php echo site_url($v->logoImage); ?>" class="img-squared" alt="<?php echo $v->logoImage; ?>" style="width:70px; height: 70px;"></a>
                                                     <?php }else{ ?>
                                                         <a href="<?php echo $v->e_store_link; ?>" target="new"><img title="<?php echo 'Gå till ' . $v->seller . ' för ' . $v->product_name; ?>" src="http://www.vvsoffert.se/scraper/<?php echo $v->logoImage; ?>" class="img-squared" alt="<?php echo $v->logoImage; ?>" style="width:100px; height: 60px;"></a>
                                                         
                                                     <?php }
                                                     ?>

                                                </td>
                                                
                                                <td style="width: 20%;">
                                                    <?php if (strtolower($v->in_stock) == 'j' || $v->in_stock == 1) : ?>
                                                        <span title="I Lager" style="color: #67c61f !important;"><i class="fa fa-lg fa-shopping-cart"></i>   <i class="fa fa-check"></i></span>
                                                    <?php elseif (strtolower($v->in_stock) == 'n' || $v->in_stock == 0) : ?>
                                                        <span title="Ej I Lager" style="color: #cd3208 !important;"><i class="fa fa-lg fa-shopping-cart"></i>   <i class="fa fa-times"></i></span>
                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                </td>
                                                <!--<td style="width:5px">-->
                                                <!--    <a class="" id="update_store_<?= $v->store_id ?>" href="<?php echo site_url('admin/estore/import_product/' . $v->store_id); ?>" title="Upload Product"><i class="fa fa-upload" aria-hidden="true"></i></a>-->
                                                <!--</td>-->
                                                
                                                <?php if (!$this->session->userdata('user_id')) { ?>
                                                <td style="width: 25%;"><b style="font-family: Tahoma, Sans-Serif; font-stretch: expanded; font-size: 110%; color: red;"><?= str_replace(',', '', (int)$v->price) . " kr" ?></b></td>
                                                <?php }else{?>
                                                <td style="width: 25%;"><b style="font-family: Tahoma, Sans-Serif; font-stretch: expanded; font-size: 110%; color: red;"><?= ($v->discountprice != '') ? str_replace(',', '', (int)$v->discountprice) ." kr" : str_replace(',', '', (int)$v->price) ." kr"  ?></b>
                                                </td>
                                                <?php } ?>
                                                
                                                <td style="width: 35%;"><a style="width: 100px;" class="btn btn-sm estore" href="<?= $v->e_store_link; ?>"<?= ($v->e_store_link) ? '' : ' disabled="disabled"'; ?>> <i class="fa fa-external-link-alt"></i> Till butiken</a>
                                                </td>
                                                <!--<td class="hidden-lg hidden-md hidden-sm" style="width: 75%;">-->
                                                <!--    <?php if(!$this->session->userdata('user_id')) { ?>-->
                                                <!--        <b style="font-family: Tahoma, Sans-Serif; font-stretch: condensed; font-size: 80%; color: #333333;"><?= str_replace(',', '', $v->price) . " kr" ?></b>-->
                                                <!--    <?php } else {?>-->
                                                <!--        <b style="font-family: Tahoma, Sans-Serif; font-stretch: condensed; font-size: 80%; color: #333333;"><?= ($v->discountprice != '') ? str_replace(',', '', $v->discountprice) ." kr" : str_replace(',', '', $v->price) ." kr"  ?></b>-->
                                                <!--    <?php } ?>-->
                                                <!--    <br>-->
                                                <!--    <?php if (strtolower($v->in_stock) == 'j' || $v->in_stock == 1) : ?>-->
                                                <!--        <span title="I Lager" style="color: #67c61f !important;"><i class="fa fa-shopping-cart"></i>   <i class="fa fa-sm fa-check"></i></span>-->
                                                <!--    <?php elseif (strtolower($v->in_stock) == 'n' || $v->in_stock == 0) : ?>-->
                                                <!--        <span title="Ej I Lager" style="color: #cd3208 !important;"><i class="fa fa fa-shopping-cart"></i>   <i class="fa fa-sm fa-times"></i></span>-->
                                                <!--    <?php else : ?>-->
                                                <!--    <?php endif; ?>-->
                                                <!--    <br>-->
                                                <!--    <a class="btn btn-xs estore" href="<?= $v->e_store_link; ?>"<?= ($v->e_store_link) ? '' : ' disabled="disabled"'; ?>> <i class="fa fa-external-link-alt"></i> Till butiken</a>-->
                                                <!--</td>-->
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                            <tr><td colspan="4"><p class="text-center text-uppercase">kontakta vvsoffert för pris</p></td></tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row related_prdts clearfix">
                <div class="col-sm-12">
                    <div class="prdts_heading">
                        <h4>Relaterade Produkter</h4>
                    </div>
                    <div class="prdts_box">
                        <div class="row clearfix">
                            <?php
                            if (isset($relateProductData) and ! empty($relateProductData)) {
                                foreach ($relateProductData as $product) {
                                    if($product->RSKnummer == '') {
                                        continue;
                                    }
                                    ?>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="prdts_details_img_area text-center">
                                            <div class="prdts_img_area">
                                                <div class="prdts_img"> 
                                                     <a class="vvsoffert-product-url" href="<?php echo site_url('product/' . url_title($product->Name) . '-pid-' . $product->id); ?>" id="<?php echo $product->id; ?>" >
                                                     <?php if (file_exists($product->ImageName)) { ?>
                                                    <img src="<?php echo site_url($product->ImageName); ?>" class="img-responsive center-block mst5" style="height: 145px; width: 145px;" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } else if(!empty($product->ImageName)) {
                                                    ?>
                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/<?php echo explode('/', $product->ImageName)[1] . '/' . explode('/', explode('.', $product->ImageName)[0])[2] . '.jpg'; ?>" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } else { 
                                                    ?>
                                                    <img src="https://vvsoffert.se/images/NAPICTURE.jpg" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } ?>
                                                        </a>
                                                </div>
                                            </div>
                                            <div class="prdts_details_content_area">
                                                <div class="prdts_details_title">
                                                    <h5><a class="vvsoffert-product-url" href="<?php echo site_url('product/' . url_title($product->Name) . '-pid-' . $product->id); ?>" id="<?php echo $product->id; ?>" ><? echo $product->Name; ?></h5>
                                                </div>
                                                <!--<div class="prdts_details_type"><a href="<?php echo site_url($product->CSLUG); ?>"><?php echo $product->CNAME; ?></a></div>-->
                                                <div class="prdts_details_type"><a href=""><?php echo $product->CNAME; ?></a></div>
                                                <br>
                                                <div class="prdts_details_rsk_number paid_text1 border_bottom1"><b>RSK-No.</b><span class="sub_color"><?php echo $product->RSKnummer; ?></span></div>

                                                <div class="prdts_details_rsk_number paid_text1 border_bottom1"><b>Tillverkare:</b><span class="sub_color"> <?php echo $product->MName; ?></span></div>
                                            </div>

                                        </div>

                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>


    </div>  	
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form name="add_to_list_form" id="add_to_list_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Till lista</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id" value="<?= $productData->id ?>">
                    <input type="hidden" name="product_rsk" id="product_rsk" value="<?= $productData->RSKnummer ?>">
                    <select name="list_id" id="list_id" class="form-control">
                        <option value="0">Välj lista</option>
                        <?php foreach ($all_list as $k => $v) { ?>
                            <option value="<?= $v->id ?>"><?= $v->name ?></option>   
                        <?php }
                        ?>
                    </select>
                    <div class="help-block error-msg err-list_id mst4"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Stänga</button>
                    <input type="submit" class="btn btn-default" value="Lämna">
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="quoteModal">
    <div class="modal-dialog" style="width: 450px;">

        <!-- Modal content-->
        <div style="width: 400px;" class="modal-content">
            <form name="send_quote_form" id="send_quote_form" method="post" action="">
                <div class="modal-header" style="padding: 10px; border-bottom: 0px solid #e5e5e5;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-transform: capitalize; text-align: center;"><small style="color: #333333;font-weight: bold; padding-left: 6px;">Offertförfrågan på</small><br><b style="color: #6e7278;" id="productName"><?= $productData->Name ?></b></h4>
                    <br>&nbsp;&nbsp;&nbsp;
                    <small style="color: #333333;font-weight: bold; padding-left: 6px;">RSK-no : </small><b style="color: #6e7278;" id="productName"><?= $productData->RSKnummer ?></b></h4>
                </div>
                <div class="modal-body" style="padding: 0px 25px;">
                    <input type="hidden" name="product_name" id="product_name" value="<?= $productData->Name ?>">
                    <input type="hidden" name="product_id" id="product_id" value="<?= $productData->id ?>">
                    <input type="hidden" name="product_rsk" id="product_rsk" value="<?= $productData->RSKnummer ?>">
                    <input type="hidden" name="product_manufacturer" id="product_manufacturer" value="<?= $productData->MName ?>">
                    <div class="form-group">
                        <input style="border: 1px solid #d1d3d5; border-radius: 2px;" type="text" placeholder="Ditt Namn *" class="form-control" value="" id="name" name="name" autocomplete="off">
                        
                    </div>
                    <div class="form-group">
                        <input style="border: 1px solid #d1d3d5; border-radius: 2px;" type="text" placeholder="E-post *" class="form-control" value="" id="email" name="email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input style="border: 1px solid #d1d3d5; border-radius: 2px;" type="text" placeholder="Telefon Nummer" class="form-control" value="" id="telefon" name="telefon" autocomplete="off">
                    </div>
                    <div style="display: none;" class="form-group">
                        <input style="border: 1px solid #d1d3d5; border-radius: 2px;" type="text" placeholder="Produkt Mängd *" class="form-control" value="" id="quantity" name="quantity" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input style="border: 1px solid #d1d3d5; border-radius: 2px;" type="text" placeholder="Ämne" class="form-control" value="" id="subject" name="subject" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <textarea style="border: 1px solid #d1d3d5; border-radius: 2px;" name="message" id="message" class="form-control" placeholder="Ditt Meddelande *" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center; padding: 5px 25px 15px 25px; border-top: 0px solid #e5e5e5;">
                    <input style="background-color: #2eb398; color: #ffffff;" type="submit" class="btn btn-sm" id="sendQuote" value="Skicka">
                </div>
            </form>
        </div>

    </div>
</div>
</div>



