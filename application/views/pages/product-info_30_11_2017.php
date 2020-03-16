<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="main-wrapper">
  <div class="main">
    <div class="main-inner">
      <div class="listing-hero">
        <div class="listing-hero-inner">
          <div class="container"> 
            <!-- /.listing-hero-image -->
            <h1>RSK-Nr: <?php echo $productData->RSKnummer0; ?> <i class="fa fa-check"></i></h1>
            <address>
            Inlagd: <?php echo(strftime('%d. %B %Y',strtotime($productData->CreatedDate))); ?><br>
            RSK-nr enhet: <?php echo $productData->Unit; ?>
            </address>
          </div>
          <!-- /.container --> 
        </div>
        <!-- /.listing-hero-inner --> 
      </div>
      <!-- /.listing-hero -->
      <div class="listing-toolbar-wrapper"> </div>
      <!-- /.listing-toolbar-wrapper -->
      <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="<?php echo site_url(); ?>">Home</a> <a class="breadcrumb-item" href="#"><?php echo $groupData->name; ?></a> <a class="breadcrumb-item" href="<?php echo site_url('products?c='.urlencode($productData->CNAME).'&no='.$productData->CID); ?>"><?php echo $productData->CNAME; ?></a> <span class="breadcrumb-item active"><?php echo $productData->Name; ?></span> </nav>
        <div class="row">
          <div class="col-md-8 col-lg-7">
            <div class="listing-detail-section" id="listing-detail-section-description" data-title="Description">
              <div class="gallery">
                  <?php if(file_exists($productData->ImageName)){?>
                 <div class="gallery-item" style="background-image: url(<?php echo $productData->ImageName; ?>);"> </div>
             <?php }else{ ?>
                <div class="gallery-item" style="background-image: url(http://www.vvsoffert.se/scraper/<?php echo $productData->ImageName; ?>);"> </div>
             <?php } ?>
                <!-- /.gallery-item --> 
              </div>
              <!-- /.gallery --> 
              <!-- /.row --> 
            </div>
            <!-- /.listing-detail-section --> 
            
            <!-- /.listing-detail-section -->
            <div class="listing-detail-section" id="listing-detail-section-menu" data-title="Menu">
              <h2>Översikt</h2>
              <table class="table">
                <tbody>
                  <tr>
                    <th>RSK-nummer</th>
                    <td><?php echo $productData->RSKnummer; ?></td>
                  </tr>
                  <tr>
                    <th>Tillverkare</th>
                    <td><?php echo $productData->MName; ?></td>
                  </tr>
                  <tr>
                    <th>Tillverkarens artikelnummer</th>
                    <td><?php echo $productData->Tillverkarensartikelnummer; ?></td>
                  </tr>
                  <tr>
                    <th>GTIN</th>
                    <td><?php echo $productData->GTIN; ?></td>
                  </tr>
                  <tr>
                    <th>Produkt</th>
                    <td><?php echo $productData->Produkt; ?></td>
                  </tr>
                  <tr>
                    <th>Produktnamn</th>
                    <td><?php echo $productData->Produktnamn; ?></td>
                  </tr>
                  <tr>
                    <th>Dimension</th>
                    <td><?php echo $productData->Dimension; ?></td>
                  </tr>
                  <tr>
                    <th>Storlek</th>
                    <td><?php echo $productData->Storlek; ?></td>
                  </tr>
                  <tr>
                    <th>Tryck/Flöde/Temp</th>
                    <td><?php echo $productData->TryckFlodeTemp; ?></td>
                  </tr>
                  <tr>
                    <th>Effekt/Eldata</th>
                    <td><?php echo $productData->EffektEldata; ?></td>
                  </tr>
                  <tr>
                    <th>Funktion</th>
                    <td><?php echo $productData->Funktion; ?></td>
                  </tr>
                  <tr>
                    <th>Utförande</th>
                    <td><?php echo $productData->Utforande; ?></td>
                  </tr>
                  <tr>
                    <th>Färg</th>
                    <td><?php echo $productData->Farg; ?></td>
                  </tr>
                  <tr>
                    <th>Ytbehandling</th>
                    <td><?php echo $productData->Ytbehandling; ?></td>
                  </tr>
                  <tr>
                    <th>Material</th>
                    <td><?php echo $productData->Material; ?></td>
                  </tr>
                  <tr>
                    <th>Standard</th>
                    <td><?php echo $productData->Standard; ?></td>
                  </tr>
                  <tr>
                    <th>Övrig info	</th>
                    <td><?php echo $productData->Ovriginfo; ?></td>
                  </tr>
                  <tr>
                    <th>Egen benämning Svensk</th>
                    <td><?php echo $productData->EgenbenamningSvensk; ?></td>
                  </tr>
                  <tr>
                    <th>Ersatt av	</th>
                    <td><?php echo $productData->Ersattav; ?></td>
                  </tr>
                  <tr>
                    <th>Varumärke</th>
                    <td><?php echo $productData->Varumarke; ?></td>
                  </tr>
                   <tr>
                    <th>Tillverkarens produktsida</th>
                    <td><?php echo $productData->Tillverkarensproduktsida; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.listing-detail-section --> 
            
          </div>
          <!-- /.col-* -->
          <div class="col-md-4 col-lg-5">
            <div class="sidebar">
              <div class="widget hide">
                <div class="author-small">
                  <div class="avatar" style="background-image: url('assets/img/tmp/user-8.jpg');"></div>
                  <h3>Advertistment</h3>
                  <p>Tubman AB
                    Idrottsvägen 8
                    134 50 GUSTAVSBERG
                    08-4041140</p>
                  <div class="author-small-actions"> <a href="" class="btn btn-primary">Profile</a> <a href="#" class="btn">Contact</a> </div>
                  <!-- /.author-small-actions --> 
                </div>
                <!-- /.author-small --> 
              </div>
              <!-- /.widget --> 
              
              <!-- /.widget -->
              <div class="widget">
                <h3 class="widgettitle">Related Products </h3>
                <div class="row">
                	<?php
						if(isset($relateProductData) and !empty($relateProductData))
						{
							foreach($relateProductData as $product)
							{
								?>
                                	<div class="col-md-6 col-lg-6">
                                	<div class="listing-row-medium pad-5">
                                        <div class="listing-row-medium-inner"> <a href="<?php echo site_url('product?c='.urlencode($product->CNAME).'&p='.urlencode($product->Name).'&no='.$product->id); ?>" class="listing-row-medium-image">
                                                <?php if(file_exists($product->ImageName)){?>
                 <img src="<?php echo $product->ImageName; ?>" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">
             <?php }else{ ?>
                 <img src="http://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"> 
             <?php } ?>
                                            </a>
                                          <div class="listing-row-medium-content"> <a class="listing-row-medium-price" href="<?php echo site_url('products?c='.urlencode($product->CNAME).'&no='.$product->CID); ?>"><?php echo $product->CNAME; ?></a>
                                            <h4 class="listing-row-medium-title"><a href="<?php echo site_url('product?c='.urlencode($product->CNAME).'&p='.urlencode($product->Name).'&no='.$product->id); ?>"><?php echo $product->Name; ?></a></h4>
                                            <div class="listing-row-medium-address">Tillverkare: <?php echo $product->MName; ?> </div>
                                            <!-- /.listing-row-medium-address --> 
                                          </div>
                                          <!-- /.listing-row-medium-content --> 
                                        </div>
                                        <!-- /.listing-row-medium-inner --> 
                                      </div>
                                      <!-- /.listings-row-medium -->
                                      </div>
                                <?php
							}
						}
					?>
                  
                  
                  
                 
                </div>
              </div>
              <!-- /.widget --> 
            </div>
            <!-- /.sidebar --> 
          </div>
          <!-- /.col-* --> 
        </div>
        <!-- /.row --> 
      </div>
      <!-- /.container-fluid --> 
    </div>
    <!-- /.main-inner --> 
  </div>
  <!-- /.main --> 
</div>
