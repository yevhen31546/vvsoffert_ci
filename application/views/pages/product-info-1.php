<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?php echo base_url('assets/custom/css/product_info.css'); ?>" rel="stylesheet" type="text/css">
<style>
    .mst4{color:red;}
</style>
<div class="listing_details_screen">
    <div class="container">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="listing_details_screen_screen_title">
                    <h5>RSK-Nr: <?php echo $productData->RSKnummer0; ?> <i class="fa fa-check-square" aria-hidden="true"></i> </h5>
                    <!-- <p>Inlagd: <?php //echo(strftime('%d. %B %Y', strtotime($productData->CreatedDate))); ?><br>
                        RSK-nr enhet: <?php//echo $productData->Unit; ?></p> -->
                </div>

                <div class="listing_details_breadcrumb_pagination">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url(); ?>">Hem</a> </li>
                        <li><a href="#"><?php echo $groupData->name; ?></a></li>
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
                                <img src="<?php echo $productData->ImageName; ?>" height="400px" width="300px" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                            <?php } else { ?>
                                <img src="https://www.vvsoffert.se/scraper/<?php echo $productData->ImageName; ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="tbl_area">
                        <p><?php echo $productData->Name; ?></p>
                        <?php if (isset($user_id) && $user_id != 0) { ?>
                            <!--<a href="javascript:;" onclick="addToList('<?php // $productData->id ?>')">-->
                            <a href="javascript:;" id="add_to_list_<?= $productData->id ?>" data-productId="<?= $productData->id ?>" data-rskNo="<?= $productData->RSKnummer ?>" onclick="addToList(this)">
                                <i class="far fa-heart"></i>
                                <!--<i class="far fa-heart">Lägg till i projekt/lista</i>-->
                            </a>
                        <?php }else{ ?>
                        <a href="<?= site_url('login')?>">
                                <i class="far fa-heart"></i>
                                <!--<i class="far fa-heart">Lägg till i projekt/lista</i>-->
                            </a>
                        <?php } ?>
                        <div class="table_heading">
                            <h5>Översikt</h5>

                        </div>
                        <div class="oversikt table-responsive">
                            <table class="oversikt_table">

                                <tr>
                                    <td>RSK-nummer</td>
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
                                        <th style="width: 25%;">E-Butik</th>
                                        <th class="hidden-xs" style="width: 25%;">Pris</th>
                                        <th class="hidden-xs" style="width: 25%;">Lagerstatus</th>
                                        <th class="hidden-xs" style="width: 25%;">Länkar</th>
                                        <th class="hidden-lg hidden-md hidden-sm" style="width: 75%;">Detaljer</th>
                                    </tr>
                                    <?php if (isset($otherStore) && count($otherStore) > 0) : ?>
                                        <?php foreach ($otherStore as $v): 
                                           
                                        ?>
                                            <tr>
                                                <td style="width: 25%;">
                                                    <?php if(file_exists($v->logoImage)){?>
                                                         <a href="<?php echo $v->e_store_link; ?>" target="new"><img title="<?php echo 'Gå till ' . $v->seller . ' för ' . $v->product_name; ?>" src="<?php echo site_url($v->logoImage); ?>" class="img-squared" alt="<?php echo $v->logoImage; ?>" style="width:100px; height: 60px;"></a>
                                                     <?php }else{ ?>
                                                         <a href="<?php echo $v->e_store_link; ?>" target="new"><img title="<?php echo 'Gå till ' . $v->seller . ' för ' . $v->product_name; ?>" src="http://www.vvsoffert.se/scraper/<?php echo $v->logoImage; ?>" class="img-squared" alt="<?php echo $v->logoImage; ?>" style="width:100px; height: 60px;"></a>
                                                         
                                                     <?php }
                                                     ?>

                                                </td>
                                                <?php if (!$this->session->userdata('user_id')) { ?>
                                                <td class="hidden-xs" style="width: 25%;"><b style="font-family: Tahoma, Sans-Serif; font-stretch: expanded; font-size: 110%; color: #333333;"><?= $v->price . " kr" ?></b></td>
                                                <?php }else{?>
                                                <td class="hidden-xs" style="width: 25%;"><b style="font-family: Tahoma, Sans-Serif; font-stretch: expanded; font-size: 110%; color: #333333;"><?= ($v->discountprice != '') ? $v->discountprice ." kr" : $v->price ." kr"  ?></b></td>
                                                <?php } ?>
                                                <td class="hidden-xs" style="width: 25%;">
                                                    <?php if (strtolower($v->in_stock) == 'j' || $v->in_stock == 1) : ?>
                                                        <span title="I Lager" style="color: #67c61f !important;"><i class="fa fa-lg fa-shopping-cart"></i>   <i class="fa fa-check"></i></span>
                                                    <?php elseif (strtolower($v->in_stock) == 'n' || $v->in_stock == 0) : ?>
                                                        <span title="Ej I Lager" style="color: #cd3208 !important;"><i class="fa fa-lg fa-shopping-cart"></i>   <i class="fa fa-times"></i></span>
                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="hidden-xs" style="width: 25%;"><a style="width: 137px;" class="btn btn-sm estore" href="<?= $v->e_store_link; ?>"<?= ($v->e_store_link) ? '' : ' disabled="disabled"'; ?>> <i class="fa fa-external-link-alt"></i> Till butiken</a></td>
                                                <td class="hidden-lg hidden-md hidden-sm" style="width: 75%;">
                                                    <?php if(!$this->session->userdata('user_id')) { ?>
                                                        <b style="font-family: Tahoma, Sans-Serif; font-stretch: condensed; font-size: 80%; color: #333333;"><?= $v->price . " kr" ?></b>
                                                    <?php } else {?>
                                                        <b style="font-family: Tahoma, Sans-Serif; font-stretch: condensed; font-size: 80%; color: #333333;"><?= ($v->discountprice != '') ? $v->discountprice ." kr" : $v->price ." kr"  ?></b>
                                                    <?php } ?>
                                                    <br>
                                                    <?php if (strtolower($v->in_stock) == 'j' || $v->in_stock == 1) : ?>
                                                        <span title="I Lager" style="color: #67c61f !important;"><i class="fa fa-shopping-cart"></i>   <i class="fa fa-sm fa-check"></i></span>
                                                    <?php elseif (strtolower($v->in_stock) == 'n' || $v->in_stock == 0) : ?>
                                                        <span title="Ej I Lager" style="color: #cd3208 !important;"><i class="fa fa fa-shopping-cart"></i>   <i class="fa fa-sm fa-times"></i></span>
                                                    <?php else : ?>
                                                    <?php endif; ?>
                                                    <br>
                                                    <a class="btn btn-xs estore" href="<?= $v->e_store_link; ?>"<?= ($v->e_store_link) ? '' : ' disabled="disabled"'; ?>> <i class="fa fa-external-link-alt"></i> Till butiken</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                            <tr><td colspan="3"><p class="text-center text-uppercase">kontakta tillverkare för pris</p></td></tr>
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
                                    ?>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="prdts_details_img_area text-center">
                                            <div class="prdts_img_area">
                                                <div class="prdts_img"> 
                                                     <a class="vvsoffert-product-url" href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>" id="<?php echo $product->id; ?>" >
                                                    <?php if (file_exists($product->ImageName)) { ?>
                                                        <img src="<?php echo $product->ImageName; ?>" class="img-responsive center-block" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                    <?php } else { ?>
                                                        <img src="https://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>" class="img-responsive center-block" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"> 
                                                    <?php } ?>
                                                        </a>

                                                </div>
                                            </div>
                                            <div class="prdts_details_content_area">
                                                <div class="prdts_details_title">
                                                    <h5><a class="vvsoffert-product-url" href="<?php echo site_url('product?pname=' . url_title($product->Name) . '&no=' . $product->id); ?>" id="<?php echo $product->id; ?>" ></h5>
                                                </div>
                                                <div class="prdts_details_type"><a href="<?php echo site_url($product->CSLUG); ?>"><?php echo $product->CNAME; ?></a></div>
                                                <br>
                                                <div class="prdts_details_rsk_number paid_text1 border_bottom1"><b>RSK-No.</b><span class="sub_color"><?php echo $product->RSKnummer0; ?></span></div>

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
                    <h4 class="modal-title">Add to list</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id" value="<?= $productData->id ?>">
                    <input type="hidden" name="product_rsk" id="product_rsk" value="<?= $productData->RSKnummer ?>">
                    <select name="list_id" id="list_id" class="form-control">
                        <option value="0">Select</option>
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

