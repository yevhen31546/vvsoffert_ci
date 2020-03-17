<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>.mst1{height:145px;}</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/magnific-popup.css'); ?>">

<!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
<!--<script>-->
<!--(adsbygoogle = window.adsbygoogle || []).push({-->
<!--google_ad_client: "ca-pub-3988943093889951",-->
<!--enable_page_level_ads: true-->
<!--});-->
<!--</script>-->


<section class="gallery_tabs site_products">
    <div class="slider_products container">
        <div style="background: #18435f; border-top: 5px solid #1e9f2e; color: #ffffff;" class="row">
            <div class="col-sm-12 col-xs-12">
                <h4 id="vvs-offert-banner" class="hidden-xs" style="padding-left: 10px; margin-top: 20px;
                font-family: Helvetica; font-size: 160%; line-height: 30px; display: flex !important;">
                    <img style="display: inline-block;" src="<?php echo site_url('assets/img/logo.png'); ?>"
                         class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser
                         |Vvsoffert | Vvs online | Rörgrossist" width="168" height="26">
                    &nbsp;<div style="margin-top: 5px;">Få offert från rörmokare</div>
                </h4>
            </div>

            <!-- Inquere form start -->
            <?php echo form_open(); ?>

                <div class="col-sm-offset-1 col-sm-10 col-xs-12"
                     style="padding-left: 20px; padding-right: 20px;padding-top: 20px; margin-bottom: 20px;">
                <?php
                $array = $this->session->flashdata('message');
                if (!empty($array)) {
                    ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        <strong>Framgång!</strong> <?php echo $array['content']; ?>
                    </div>

                    <?php
                    $this->session->unset_userdata('message');
                }
                ?>
                <!-- quote category -->
                <div class="row">
                    <div class="form-group col-md-6 col-sm-3">
                        <label for="quote_category">Vad behöver du hjälp med?</label>
                        <select class="form-control" id="quote_category" name="quote_category">
                            <option value="1" <?php echo  set_select('quote_cateogry', '1', TRUE); ?>>
                                Badrumsrenovering
                            </option>
                            <option value="2" <?php echo  set_select('quote_cateogry', '2'); ?>>
                                Köksrenovering
                            </option>
                            <option value="3" <?php echo  set_select('quote_cateogry', '3'); ?>>
                                Stambyte
                            </option>
                            <option value="4" <?php echo  set_select('quote_cateogry', '4'); ?>>
                                Vatten
                            </option>
                            <option value="5" <?php echo  set_select('quote_cateogry', '5'); ?>>
                                VVS-arbeten / Rördragning
                            </option>
                            <option value="6" <?php echo  set_select('quote_cateogry', '6'); ?>>
                                Värmepumpar
                            </option>
                        </select>
                    </div>
                </div>
                <!-- quote description -->
                <div class="row">
                    <div class="form-group col-md-12 col-sm-6">
                        <label for="quote_description">Beskrivning av arbetet</label>
                        <textarea class="form-control" rows="4" name="quote_description"
                                  placeholder="Tips: En bra och tydlig beskrivning möjliggör fler och bättre svar"
                                  id="quote_description"><?php echo set_value('quote_description'); ?></textarea>
                    </div>
                    <span class="text-danger error-msg" ><?php echo form_error('quote_description') ?></span>
                </div>
                <!-- quote zip and timespan -->
                <div class="row">
                    <div class="form-group col-md-6 col-sm-3">
                        <label for="quote_zip">Postnummer</label>
                        <input type="text" class="form-control" id="quote_zip" name="quote_zip"
                               value="<?php echo set_value('quote_zip'); ?>">
                        <span class="text-danger error-msg" ><?php echo form_error('quote_zip') ?></span>
                    </div>

                    <div class="form-group col-md-6 col-sm-3">
                        <label for="quote_timespan">När ska arbetet vara klart?</label>
                        <select class="form-control" id="quote_timespan" name="quote_timespan">
                            <option value="1" <?php echo  set_select('quote_timespan', '1', TRUE); ?>>
                                Klart inom en vecka
                            </option>
                            <option value="2" <?php echo  set_select('quote_timespan', '2'); ?>>
                                Klart inom en månad
                            </option>
                            <option value="3" <?php echo  set_select('quote_timespan', '3'); ?>>
                                Klart inom 3 månader
                            </option>
                            <option value="4" <?php echo  set_select('quote_timespan', '4'); ?>>
                                Klart inom ett halvår
                            </option>
                            <option value="5" <?php echo  set_select('quote_timespan', '5'); ?>>
                                Klart inom ett år
                            </option>
                        </select>
                    </div>
                </div>
                <!-- quote buyertype and name -->
                <div class="row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="quote_buyertype">Vem representerar du?</label>
                        <select class="form-control" id="quote_buyertype" name="quote_buyertype">
                            <option value="1" <?php echo  set_select('quote_buyertype', '1', TRUE); ?>>
                                Privatperson
                            </option>
                            <option value="2" <?php echo  set_select('quote_buyertype', '2'); ?>>
                                Företag
                            </option>
                            <option value="3" <?php echo  set_select('quote_buyertype', '3'); ?>>
                                Entreprenör/Byggare
                            </option>
                            <option value="4" <?php echo  set_select('quote_buyertype', '4'); ?>>
                                Bostadsrättsförening
                            </option>
                            <option value="5" <?php echo  set_select('quote_buyertype', '5'); ?>>
                                Annan förening
                            </option>
                            <option value="6" <?php echo  set_select('quote_buyertype', '6'); ?>>
                                Myndighet/Kommun
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6 col-sm-6">
                        <label for="quote_name">Ditt namn</label>
                        <input type="text" class="form-control" id="quote_name" name="quote_name"
                               value="<?php echo set_value('quote_name'); ?>">
                        <span class="text-danger error-msg" ><?php echo form_error('quote_name') ?></span>
                    </div>
                </div>
                <!-- quote email and phone -->
                <div class="row">
                    <div class="form-group col-md-6 col-sm-3">
                        <label for="quote_email">Epost adress</label>
                        <input type="text" class="form-control" id="quote_email" name="quote_email"
                               value="<?php echo set_value('quote_email'); ?>">
                        <span class="text-danger error-msg" ><?php echo form_error('quote_email') ?></span>
                    </div>

                    <div class="form-group col-md-6 col-sm-3">
                        <label for="quote_phone">Telefon</label>
                        <input type="text" class="form-control" id="quote_phone" name="quote_phone"
                               value="<?php echo set_value('quote_phone'); ?>">
                        <span class="text-danger error-msg" ><?php echo form_error('quote_phone') ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" name="quote_terms" id="quote_terms"
                           value="Accept TOS" <?php echo set_checkbox('quote_terms', 'Accept TOS'); ?> />
                    <label for="quote_terms">
                        &nbsp;Jag godkänner att vvsoffert.se lagrar och använder mina personuppgifter enligt
                        <a href="<?php echo base_url()."tos.pdf"; ?>" target="_blank" title="Läs avtalsvillkoren">
                            användarvillkoren.
                        </a>
                    </label>
                    <span class="text-danger error-msg" ><?php echo form_error('quote_terms') ?></span>
                </div>
            </div>

            <div class="col-sm-12 hidden-xs">

            <div style="border: none; background: inherit; padding-top: 20px; text-align: center;
            padding-bottom: 30px;" class="generic_content active clearfix">
                <div class="generic_feature_list">
                    <div class="generic_price_btn clearfix">
                        <input type="submit" name="submit" class="btn btn-success" value="SKICKA FÖRFRÅGAN">
                    </div>
                </div>
            </div>

            <?php echo form_close(); ?>
            <!-- Inquere form end -->

        </div>
    </div>
</section>
<section class="site_products">
    <div class="product_header">
        <h2>Populära vvs produkter</h2>
        <p>Här hittar du dom vanligaste vvs produkterna</p>
    </div>
    <div class="slider_products container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
             <!--Indicators -->
            <ol class="carousel-indicators">
                                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                                        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
                                                        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
                                                        <li data-target="#myCarousel" data-slide-to="3" class=""></li>
                                                        <li data-target="#myCarousel" data-slide-to="4" class=""></li>
                                                        <li data-target="#myCarousel" data-slide-to="5" class=""></li>
                                        </ol>
            <div class="carousel-inner">
                                                                    <div class="item active">
                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/19/8377378.jpg" class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145"  height="145"> 
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/FM-Mattsson-9000E-II-Duschset-pid-220771">FM Mattsson 9000E ...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/sanitetsarmatur-utrustning">Sanitetsarmatur/-u...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">837 73 78</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">FMM</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">9000E II</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/5/8309081.jpg" class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145"  height="145"> 
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/FM-Mattsson-9000E-II-Köksblandare-pid-217414">FM Mattsson 9000E ...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/blandare">Blandare</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">830 90 81</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">FMM</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">9000E</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/5/8235452.jpg" class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145"  height="145"> 
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Tvättställsblandare-9000E-II-med-silpluggventil-pid-215190">Tvättställsbland...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/blandare">Blandare</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">823 54 52</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">FMM</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">9000E II</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/24/8073678.jpg" class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="326"  height="145"> 
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Vattenlåssats-Falu-44100-pid-212081">Vattenlåssats, Fa...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/vattenlaskonsolerfixturer">Vattenlås/Konsole...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">807 36 78</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Faluplast</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Falu 44100</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                            <div class="clearfix"></div>
                            </div>
                                                                                                    <div class="item ">
                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/1044/7856918.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Ifö-Sign-6893-pid-208193">Ifö Sign 6893</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/wc-stolarbideerurinaler">WC-stolar/Bidéer/...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">785 69 18</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Geberit AB</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Sign</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/26/7856826.jpg" class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145"  height="145"> 
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/IFÖ-SIGN-6861-pid-208107">IFÖ SIGN 6861</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/wc-stolarbideerurinaler">WC-stolar/Bidéer/...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">785 68 26</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Geberit AB</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Sign</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/1038/7856903.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Ifö-Sign-6860-pid-208045">Ifö Sign 6860</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/wc-stolarbideerurinaler">WC-stolar/Bidéer/...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">785 69 03</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Geberit AB</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Sign</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/21/7606570.jpg" class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145"  height="145"> 
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Ifö-Spira-15022-pid-206823">Ifö Spira 15022</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/tvattstalldricksfontaner">Tvättställ/Drick...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">760 65 70</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Geberit AB</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Ifö Spira 15022</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                            <div class="clearfix"></div>
                            </div>
                                                                                                    <div class="item ">
                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/953/6944314.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Nibe-Eminent-CU-55-pid-193806">Nibe Eminent-CU 55</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/vatten-medievarmaretankar">Vatten-/Medievärm...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">694 43 14</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Nibe</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">EMINENT-CU 55</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/905/6251305.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Nibe-F730-pid-181086">Nibe F730</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/pannorvarmepumpar">Pannor/Värmepumpa...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">625 13 05</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Nibe</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">F 730</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/836/5853144.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Pumppaket-SQE-2-70-pid-173509">Pumppaket, SQE 2-7...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/pumpar">Pumpar</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">585 31 44</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Grundfos</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">SQE 2-70</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/703/7113522.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Golvbrunn-Oden-pid-164292">Golvbrunn, Oden</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/betackningarbrunnar">Betäckningar/Brun...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">711 35 22</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Purus</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Oden</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                            <div class="clearfix"></div>
                            </div>
                                                                                                    <div class="item ">
                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/666/5207907.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Installationssats-A500-11-pid-159024">Installationssats,...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/matinstrument">Mätinstrument</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">520 79 07</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Beulco</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">A500-11</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/618/4891630.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Injusteringsventil-STAD-G15-pid-153047">Injusteringsventil...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/reglerventilerovrig-armatur">Reglerventiler/Öv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">489 16 30</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">IMI TA</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">STAD</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/613/4818209.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Ventildel-RA-N-10-pid-151824">Ventildel, RA-N, 1...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/reglerventilerovrig-armatur">Reglerventiler/Öv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">481 82 09</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Danfoss</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">RA-N</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/610/4805916.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Radiatorkoppel-VRVMFA-2-rörs-pid-151615">Radiatorkoppel, VR...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/reglerventilerovrig-armatur">Reglerventiler/Öv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">480 59 16</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">MMA</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">VRVMFA-15</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                            <div class="clearfix"></div>
                            </div>
                                                                                                    <div class="item ">
                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/609/4820210.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Propp-10-pid-151284">Propp 10</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/reglerventilerovrig-armatur">Reglerventiler/Öv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">482 02 10</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Ezze</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">-</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/607/4806737.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Termostatdel-Evosense-0-28-pid-151031">Termostatdel, Evos...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/reglerventilerovrig-armatur">Reglerventiler/Öv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">480 67 37</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">MMA</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Evosense</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/607/4819054.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Regulatordel-RA-2990-7-28-pid-151006">Regulatordel, RA 2...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/reglerventilerovrig-armatur">Reglerventiler/Öv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">481 90 54</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Danfoss</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">RA 2990</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/592/8546954.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Kulventil-Vatette-12-med-vred-pid-147905">Kulventil, Vatette...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/va-armaturstangventiler">VA-armatur/Stängv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">854 69 54</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Gustavsberg</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Vatette</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                            <div class="clearfix"></div>
                            </div>
                                                                                                    <div class="item ">
                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/592/8546961.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Kulventil-Vatette-12X10-med-vred-pid-145096">Kulventil, Vatette...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/va-armaturstangventiler">VA-armatur/Stängv...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">854 69 61</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Gustavsberg</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Vatette</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/502/3811406.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Rörklamma-Falu-Snap-dubbel-12-15-FK-pid-134465">Rörklamma, Falu S...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/fastdetaljertatningisolering">Fästdetaljer/Tät...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">381 14 06</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Faluplast</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Falu Snap 14005</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/451/3820131.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Takjärn-Universal-L2m-pid-129577">Takjärn, Universa...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/fastdetaljertatningisolering">Fästdetaljer/Tät...</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">382 01 31</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">ReTherm Kruge</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Universal</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                                                                        <div class="col-xs-12 col-sm-3 product text-center">
                                <div class="product_content text-center">
                                    <div class="product_img"> 
                                                                                    <img src="https://vvsoffert.se/scraper/images/images_thumb/380/2830033.jpg"
                                                      class="img-responsive center-block mst1" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="145" height="145">
                                                                            </div>
                                    <div class="product_title">
                                        <h3><a href="https://vvsoffert.se/product/Böj-Nordic-110-mm-x-45-pid-123643">Böj, Nordic 110 m...</a></h3>
                                    </div>
                                    <div class="product_type"><a href="https://vvsoffert.se/plastror-avlopp">Plaströr - Avlopp</a></div>
                                    <div class="product_rsk_number paid_text border_bottom"><b>RSK-Nr.</b><span class="sub_color">283 00 33</span></div>
                                    <div class="product_manufacturer paid_text border_bottom"><b>Tillverkare</b> <span class="sub_color">Pipelife</span></div>
                                    <div class="product_name paid_text">Produktnamn</div>
                                    <div class="product_std sub_color">Nordic</div>
                                </div>
                            </div>
                            <!--end-product-->
                                                            <div class="clearfix"></div>
                            </div>
                        </div>
                                                
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</section>

<script type="text/javascript">
    

function setVideoStage() {

  var elmnt = document.getElementById("vvs-offert-banner");
  elmnt.scrollIntoView();

}


function setVideoStageM() {

  var elmnt = document.getElementById("vvs-offert-banner-m");
  elmnt.scrollIntoView();
  
}


</script>