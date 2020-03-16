<div class="main">
    <div class="main-inner">
        <div class="page-title">
            <div class="container">

                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="listing_details_screen_screen_title-2">
                            <h5>Jämför listor</h5>
                        </div>

                        <div class="listing_details_breadcrumb_pagination-2">
                            <ul class="breadcrumb">
                                <li><a href="https://vvsoffert.se/">Hem</a> </li>
                                <li><a href="#">Jämför produkter</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
                </h1>                
                <!-- /.page-title-actions -->
            </div>
            <!-- /.container-->
        </div>
        <!-- /.page-title -->
        <div class="container">
            <section class="features_table">

                <!--            <div class="row">
                            <div class="col-sm-12 col-md-10 col-md-offset-1 col-4 col-xs-12 no-padding">-->
                <div class="clearfix">

                    <div class="col-sm-3 col-md-6 col-4 col-xs-12 no-padding">
                        <div class="features-table">
                            <ul>

                                <h1>ALLA FUNKTIONER</h1>
                                <li>RSK-nummer</li>
                                <li>Tillverkare</li>
                                <li>Tillverkarens artikelnummer</li>
                                <li>GTIN</li>
                                <li>Produkt</li>
                                <li>Produktnamn</li>
                                <li>Dimension</li>
                                <li>Storlek</li>
                                <li>Tryck/Flöde/Temp</li>
                                <li>Effekt/Eldata</li>
                                <li>Funktion</li>
                                <li>Utförande</li>
                                <li>Färg</li>
                                <li>Ytbehandling</li>
                                <li>Material</li>
                                <li>Standard</li>
                                <li>Övrig info	</li>
                                <li>Egen benämning Svensk</li>
                                <li>Ersatt av</li>
                                <li>Varumärke</li>
                                <li>Tillverkarens produktsida</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-2 col-2 col-xs-12 no-padding">
                        <div class="features-table-free">
                            <ul>
                                <div class="nw-img-height">
                                <?php if (file_exists($productData1->ImageName)) { ?>
                                    <img src="<?php echo base_url().$productData1->ImageName; ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"> 
                                <?php } else { ?>
                                    <img src="https://vvsoffert.se/scraper/<?php echo $productData1->ImageName; ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                <?php } ?>
                                </div>
                                <h1><a href="<?php echo site_url('product?no=' . $productData1->id); ?>"><?php echo $productData1->Name; ?></a></h1>
                                <li><?php echo ($productData1->RSKnummer != '') ? $productData1->RSKnummer : "---"; ?></li>
                                <li><?php echo ($productData1->MName != '') ? $productData1->MName : "---"; ?></li>
                                <li><?php echo ($productData1->Tillverkarensartikelnummer) ? $productData1->Tillverkarensartikelnummer : "---"; ?></li>
                                <li><?php echo ($productData1->GTIN != "") ? $productData1->GTIN : "---"; ?></li>
                                <li><?php echo ($productData1->Produkt != '') ? $productData1->Produkt : "---"; ?></li>
                                <li><?php echo ($productData1->Produktnamn != '') ? $productData1->Produktnamn : "---"; ?></li>
                                <li><?php echo ($productData1->Dimension != '') ? $productData1->Dimension : "---"; ?></li>
                                <li><?php echo ($productData1->Storlek != '') ? $productData1->Storlek : "---"; ?></li>
                                <li><?php echo ($productData1->TryckFlodeTemp != '') ? $productData1->TryckFlodeTemp : "---"; ?></li>
                                <li><?php echo ($productData1->EffektEldata != '') ? $productData1->EffektEldata : "---"; ?></li>
                                <li><?php echo ($productData1->Funktion != '') ? $productData1->Funktion : "---"; ?></li>
                                <li><?php echo ($productData1->Utforande != '') ? $productData1->Utforande : "---"; ?></li>
                                <li><?php echo ($productData1->Farg != '') ? $productData1->Farg : "---"; ?></li>
                                <li><?php echo ($productData1->Ytbehandling != '') ? $productData1->Ytbehandling : "---"; ?></li>
                                <li><?php echo ($productData1->Material != '') ? $productData1->Material : "---"; ?></li>
                                <li><?php echo ($productData1->Standard != '') ? $productData1->Standard : "---"; ?></li>
                                <li><?php echo ($productData1->Ovriginfo != '') ? $productData1->Ovriginfo : "---"; ?></li>
                                <li><?php echo ($productData1->EgenbenamningSvensk != '') ? $productData1->EgenbenamningSvensk : "---"; ?></li>
                                <li><?php echo ($productData1->Ersattav != '') ? $productData1->Ersattav : "---"; ?></li>
                                <li><?php echo ($productData1->Varumarke != '') ? $productData1->Varumarke : "---"; ?></li>
                                <li><?php echo!empty($productData1->Tillverkarensproduktsida) ? '<a href="' . $productData1->Tillverkarensproduktsida . '" target="new">' . $productData1->MName . '</a>' : '---'; ?></li>

                            </ul>
                        </div>

                    </div>
                    <div class="col-sm-3 col-md-2 col-2 col-xs-12 no-padding">
                        <div class="features-table-free">
                            <ul>
                                <div class="nw-img-height">
                                <?php if (file_exists($productData2->ImageName)) { ?>s
                                    <img src="<?php echo $productData2->ImageName; ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"> 
                                <?php } else { ?>
                                    <img src="https://vvsoffert.se/scraper/<?php echo $productData2->ImageName; ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                <?php } ?>
                                </div>
                                <h1><a href="<?php echo site_url('product?no=' . $productData2->id); ?>"><?php echo $productData2->Name; ?></a></h1>
                                <li><?php echo ($productData2->RSKnummer != '') ? $productData2->RSKnummer : "---"; ?></li>
                                <li><?php echo ($productData2->MName != '') ? $productData2->MName : "---"; ?></li>
                                <li><?php echo ($productData2->Tillverkarensartikelnummer) ? $productData2->Tillverkarensartikelnummer : "---"; ?></li>
                                <li><?php echo ($productData2->GTIN != "") ? $productData2->GTIN : "---"; ?></li>
                                <li><?php echo ($productData2->Produkt != '') ? $productData2->Produkt : "---"; ?></li>
                                <li><?php echo ($productData2->Produktnamn != '') ? $productData2->Produktnamn : "---"; ?></li>
                                <li><?php echo ($productData2->Dimension != '') ? $productData2->Dimension : "---"; ?></li>
                                <li><?php echo ($productData2->Storlek != '') ? $productData2->Storlek : "---"; ?></li>
                                <li><?php echo ($productData2->TryckFlodeTemp != '') ? $productData2->TryckFlodeTemp : "---"; ?></li>
                                <li><?php echo ($productData2->EffektEldata != '') ? $productData2->EffektEldata : "---"; ?></li>
                                <li><?php echo ($productData2->Funktion != '') ? $productData2->Funktion : "---"; ?></li>
                                <li><?php echo ($productData2->Utforande != '') ? $productData2->Utforande : "---"; ?></li>
                                <li><?php echo ($productData2->Farg != '') ? $productData2->Farg : "---"; ?></li>
                                <li><?php echo ($productData2->Ytbehandling != '') ? $productData2->Ytbehandling : "---"; ?></li>
                                <li><?php echo ($productData2->Material != '') ? $productData2->Material : "---"; ?></li>
                                <li><?php echo ($productData2->Standard != '') ? $productData2->Standard : "---"; ?></li>
                                <li><?php echo ($productData2->Ovriginfo != '') ? $productData2->Ovriginfo : "---"; ?></li>
                                <li><?php echo ($productData2->EgenbenamningSvensk != '') ? $productData2->EgenbenamningSvensk : "---"; ?></li>
                                <li><?php echo ($productData2->Ersattav != '') ? $productData2->Ersattav : "---"; ?></li>
                                <li><?php echo ($productData2->Varumarke != '') ? $productData2->Varumarke : "---"; ?></li>
                                <li><?php echo!empty($productData2->Tillverkarensproduktsida) ? '<a href="' . $productData2->Tillverkarensproduktsida . '" target="new">' . $productData2->MName . '</a>' : '---'; ?></li>

                            </ul>
                        </div>

                    </div>
                      <?php if (isset($productData3)) { ?>
                    <div class="col-sm-3 col-md-2 col-2 col-xs-12 no-padding">
                        <div class="features-table-free">
                            <ul>
                                <div class="nw-img-height">
                               <?php if (file_exists($productData3->ImageName)) { ?>s
                                    <img src="<?php echo $productData3->ImageName; ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"> 
                                <?php } else { ?>
                                    <img src="http://www.vvsoffert.se/scraper/<?php echo $productData3->ImageName; ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
                                <?php } ?>
                                 </div>
                                <h1><a href="<?php echo site_url('product?no=' . $productData3->id); ?>"><?php echo $productData3->Name; ?></a></h1>
                                <li><?php echo ($productData3->RSKnummer != '') ? $productData3->RSKnummer : "---"; ?></li>
                                <li><?php echo ($productData3->MName != '') ? $productData3->MName : "---"; ?></li>
                                <li><?php echo ($productData3->Tillverkarensartikelnummer) ? $productData3->Tillverkarensartikelnummer : "---"; ?></li>
                                <li><?php echo ($productData3->GTIN != "") ? $productData3->GTIN : "---"; ?></li>
                                <li><?php echo ($productData3->Produkt != '') ? $productData3->Produkt : "---"; ?></li>
                                <li><?php echo ($productData3->Produktnamn != '') ? $productData3->Produktnamn : "---"; ?></li>
                                <li><?php echo ($productData3->Dimension != '') ? $productData3->Dimension : "---"; ?></li>
                                <li><?php echo ($productData3->Storlek != '') ? $productData3->Storlek : "---"; ?></li>
                                <li><?php echo ($productData3->TryckFlodeTemp != '') ? $productData3->TryckFlodeTemp : "---"; ?></li>
                                <li><?php echo ($productData3->EffektEldata != '') ? $productData3->EffektEldata : "---"; ?></li>
                                <li><?php echo ($productData3->Funktion != '') ? $productData3->Funktion : "---"; ?></li>
                                <li><?php echo ($productData3->Utforande != '') ? $productData3->Utforande : "---"; ?></li>
                                <li><?php echo ($productData3->Farg != '') ? $productData3->Farg : "---"; ?></li>
                                <li><?php echo ($productData3->Ytbehandling != '') ? $productData3->Ytbehandling : "---"; ?></li>
                                <li><?php echo ($productData3->Material != '') ? $productData3->Material : "---"; ?></li>
                                <li><?php echo ($productData3->Standard != '') ? $productData3->Standard : "---"; ?></li>
                                <li><?php echo ($productData3->Ovriginfo != '') ? $productData3->Ovriginfo : "---"; ?></li>
                                <li><?php echo ($productData3->EgenbenamningSvensk != '') ? $productData3->EgenbenamningSvensk : "---"; ?></li>
                                <li><?php echo ($productData3->Ersattav != '') ? $productData3->Ersattav : "---"; ?></li>
                                <li><?php echo ($productData3->Varumarke != '') ? $productData3->Varumarke : "---"; ?></li>
                                <li><?php echo!empty($productData3->Tillverkarensproduktsida) ? '<a href="' . $productData3->Tillverkarensproduktsida . '" target="new">' . $productData3->MName . '</a>' : '---'; ?></li>


                            </ul>
                        </div>

                    </div>
                      <?php }?>
                </div>
                <!--          </div>
                                </div>-->


            </section>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.main-inner -->
</div>