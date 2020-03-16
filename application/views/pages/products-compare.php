<div class="main">
          <div class="main-inner">
            <div class="page-title">
              <div class="container">
                <h1>Compare Listings
                </h1>                
                <!-- /.page-title-actions -->
              </div>
              <!-- /.container-->
            </div>
            <!-- /.page-title -->
            <div class="container">
              <div class="listing-compare-wrapper">
                <div class="row">
                  <div class="listing-compare-description-wrapper col-md-3">
                    <div class="listing-compare-description">
                      <ul>
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
                    <!-- /.listing-compare-description -->
                  </div>
                  <!-- /.col-sm-3 -->
                  <div class="listing-compare-col-wrapper col-md-3">
                    <div class="listing-compare-col">
                      <div class="listing-compare-image">
                        <a href="<?php echo site_url('product?no='.$productData1->id); ?>" class="listing-compare-image-link" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $productData1->ImageName; ?>');">
                        </a>
                      </div>
                      <!-- /.listing-compare-image -->
                      <div class="listing-compare-title">
                        <h2><a href="<?php echo site_url('product?no='.$productData1->id); ?>"><?php echo $productData1->Name; ?></a></h2>                       
                      </div>
                      <!-- /.listing-compare-title -->
                      <ul class="listing-compare-list">                        
                        <li><?php echo $productData1->RSKnummer; ?></li>
                        <li><?php echo $productData1->MName; ?></li>
                        <li><?php echo $productData1->Tillverkarensartikelnummer; ?></li>
                        <li><?php echo $productData1->GTIN; ?></li>
                        <li><?php echo $productData1->Produkt; ?></li>
                        <li><?php echo $productData1->Produktnamn; ?></li>
                        <li><?php echo $productData1->Dimension; ?></li>
                        <li><?php echo $productData1->Storlek; ?></li>
                        <li><?php echo $productData1->TryckFlodeTemp; ?></li>
                        <li><?php echo $productData1->EffektEldata; ?></li>
                        <li><?php echo $productData1->Funktion; ?></li>
                        <li><?php echo $productData1->Utforande; ?></li>
                        <li><?php echo $productData1->Farg; ?></li>
                        <li><?php echo $productData1->Ytbehandling; ?></li>
                        <li><?php echo $productData1->Material; ?></li>
                        <li><?php echo $productData1->Standard; ?></li>
                        <li><?php echo $productData1->Ovriginfo; ?></li>
                        <li><?php echo $productData1->EgenbenamningSvensk; ?></li>
                        <li><?php echo $productData1->Ersattav; ?></li>
                        <li><?php echo $productData1->Varumarke; ?></li>
                        <li><?php echo !empty($productData1->Tillverkarensproduktsida)?'<a href="'.$productData1->Tillverkarensproduktsida.'" target="new">'.$productData1->MName.'</a>':''; ?></li>                           
                      </ul>
                      <!-- /.listing-compare-list -->
                    </div>
                    <!-- /.listing-compare-col -->
                  </div>
                  <!-- /.listing-compare-col-wrapper -->
                  <div class="listing-compare-col-wrapper col-md-3">
                    <div class="listing-compare-col">
                      <div class="listing-compare-image">
                        <a href="<?php echo site_url('product?no='.$productData2->id); ?>" class="listing-compare-image-link" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $productData2->ImageName; ?>');">
                        </a>
                      </div>
                      <!-- /.listing-compare-image -->
                      <div class="listing-compare-title">
                        <h2><a href="<?php echo site_url('product?no='.$productData2->id); ?>"><?php echo $productData2->Name; ?></a></h2>                        
                      </div>
                      <!-- /.listing-compare-title -->
                      <ul class="listing-compare-list">
                        <li><?php echo $productData2->RSKnummer; ?></li>
                        <li><?php echo $productData2->MName; ?></li>
                        <li><?php echo $productData2->Tillverkarensartikelnummer; ?></li>
                        <li><?php echo $productData2->GTIN; ?></li>
                        <li><?php echo $productData2->Produkt; ?></li>
                        <li><?php echo $productData2->Produktnamn; ?></li>
                        <li><?php echo $productData2->Dimension; ?></li>
                        <li><?php echo $productData2->Storlek; ?></li>
                        <li><?php echo $productData2->TryckFlodeTemp; ?></li>
                        <li><?php echo $productData2->EffektEldata; ?></li>
                        <li><?php echo $productData2->Funktion; ?></li>
                        <li><?php echo $productData2->Utforande; ?></li>
                        <li><?php echo $productData2->Farg; ?></li>
                        <li><?php echo $productData2->Ytbehandling; ?></li>
                        <li><?php echo $productData2->Material; ?></li>
                        <li><?php echo $productData2->Standard; ?></li>
                        <li><?php echo $productData2->Ovriginfo; ?></li>
                        <li><?php echo $productData2->EgenbenamningSvensk; ?></li>
                        <li><?php echo $productData2->Ersattav; ?></li>
                        <li><?php echo $productData2->Varumarke; ?></li>
                        <li><?php echo !empty($productData2->Tillverkarensproduktsida)?$productData2->MName:''; ?></li>
                      </ul>
                      <!-- /.listing-compare-list -->
                    </div>
                    <!-- /.listing-compare-col -->
                  </div>
                  <!-- /.listing-compare-col-wrapper -->
                  
                  <?php if(isset($productData3)) { ?>
                  <div class="listing-compare-col-wrapper col-md-3">
                    <div class="listing-compare-col">
                      <div class="listing-compare-image">
                        <a href="<?php echo site_url('product?no='.$productData3->id); ?>" class="listing-compare-image-link" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $productData3->ImageName; ?>');">
                        </a>
                      </div>
                      <!-- /.listing-compare-image -->
                      <div class="listing-compare-title">
                        <h2><a href="<?php echo site_url('product?no='.$productData3->id); ?>"><?php echo $productData3->Name; ?></a></h2>                       
                      </div>
                      <!-- /.listing-compare-title -->
                      <ul class="listing-compare-list">
                        <li><?php echo $productData3->RSKnummer; ?></li>
                        <li><?php echo $productData3->MName; ?></li>
                        <li><?php echo $productData3->Tillverkarensartikelnummer; ?></li>
                        <li><?php echo $productData3->GTIN; ?></li>
                        <li><?php echo $productData3->Produkt; ?></li>
                        <li><?php echo $productData3->Produktnamn; ?></li>
                        <li><?php echo $productData3->Dimension; ?></li>
                        <li><?php echo $productData3->Storlek; ?></li>
                        <li><?php echo $productData3->TryckFlodeTemp; ?></li>
                        <li><?php echo $productData3->EffektEldata; ?></li>
                        <li><?php echo $productData3->Funktion; ?></li>
                        <li><?php echo $productData3->Utforande; ?></li>
                        <li><?php echo $productData3->Farg; ?></li>
                        <li><?php echo $productData3->Ytbehandling; ?></li>
                        <li><?php echo $productData3->Material; ?></li>
                        <li><?php echo $productData3->Standard; ?></li>
                        <li><?php echo $productData3->Ovriginfo; ?></li>
                        <li><?php echo $productData3->EgenbenamningSvensk; ?></li>
                        <li><?php echo $productData3->Ersattav; ?></li>
                        <li><?php echo $productData3->Varumarke; ?></li>
                        <li><?php echo $productData3->Tillverkarensproduktsida; ?></li>
                      </ul>
                      <!-- /.listing-compare-list -->
                    </div>
                    <!-- /.listing-compare-col -->
                  </div>
                  <!-- /.listing-compare-col-wrapper -->
                  <?php } ?>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.listing-compare-wrapper -->
            </div>
            <!-- /.container-fluid -->
          </div>
          <!-- /.main-inner -->
        </div>