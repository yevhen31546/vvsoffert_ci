 <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="row first_row">
      
      
                        <h1 class="inner_cities"></h1>

                    <div class="row first_row">
	
                        <?php
                        
                        
                        foreach ($productsList as $product) 
                        {
                            ?>
                            <div class="col-md-4 col-sm-6 mrg-20">
                              
                                <div class="prdts_listing_content text-center">
                                    <div class="prdts_img_area">

                                        <div class="prdts_img"> 
                                            <a href="<?php echo site_url('product/' . url_title($product['Name']) . '-pid-' . $product['id']); ?>" >
                                                <?php if (file_exists($product['ImageName'])) { ?>
                                                    <img src="<?php echo $product['ImageName']; ?>" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"> 
                                                <?php } else { ?>
                                                    <img src="https://www.vvsoffert.se/scraper/<?php echo $product['ImageName']; ?>" class="img-responsive center-block mst5" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="prdts_content_area">
                                        <div class="prdts_title">
                                            <h5><a href="<?php echo site_url('product/' . url_title($product['Name']) . '-pid-' . $product['id']); ?>" id="prodname_<?php echo $product['id']; ?>"><?php echo $product['Name']; ?></a></h5>
                                        </div>
                                        <div class="prdts_type"><a href=""><?php echo $product['catname']; ?></a></div>
                                        <div class="prdts_rsk_number paid_text1 border_bottom1"><b>RSK-No.</b><span class="sub_color"> <?php echo!empty($product['RSKnummer0']) ? $product['RSKnummer0'] : '-'; ?></span></div>
                                        <div class="prdts_manufacturer paid_text1 border_bottom1"><b>Tillverkare</b> <span class="sub_color"> <?php echo $product['name']  ?></span></div>
                                        <div class="prdts_name paid_text1"><b>Produktnamn </b><span class="sub_color"><?php echo!empty($product['Produktnamn']) ? $product['Produktnamn'] : '-'; ?></span></div>
                                    </div>
                                    <?php if (isset($user_id) && $user_id != 0) { ?>
                                        <div class="add_compare_area add_compare_area-cst">
                                            <!--<a href="javascript:;" onclick="addToList('<?php // $product->id  ?>')">-->
                                            <a href="javascript:;" id="add_to_list_<?= $produc['id'] ?>" data-productId="<?= $product['id'] ?>" data-rskNo="<?= $product['RSKnummer'] ?>" onclick="addToList(this)">
                                                <i class="fa fa-heart-o" aria-hidden="true">Lägg till i din Projekt/lista</i>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="add_compare_area add_compare_area-cst">
                                            <a href="<?= site_url('login') ?>">
                                                <i class="fa fa-heart-o" aria-hidden="true">Lägg till i din Projekt/lista</i>
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <div class="add_compare_area">
                                        <input type="checkbox"  value="<?php echo $product['id']; ?>" class="add-to-compare" name="cc" id="c<?php echo $product['id']; ?>"/>
                                        <label for="c<?php echo $product['id']; ?>"><span></span>Lägg till för att jämföra</label>
                                    </div>

                                </div>

                            </div>
							<?php
                             }
                             
                             ?>

                    </div>
<div class="row">            

                        <div class="col-sm-12">
                            <div class="pagination_area">
                                <div class="pagination_text pull-left">
                                    <div id="body">


   <div align="right" id="pagination_link">
       <?php print_r($pagination_link);?>
       
   </div>
<div class="table-responsive" id="country_table"></div>
  </div>

 </div>

                                </div>


                                 


                            </div>                       
                        </div>                      
                    </div>
                 
					</div>