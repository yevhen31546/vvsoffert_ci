 
    <div class="admin-content">
      <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <span class="breadcrumb-item active">Dashboard</span> </nav>
        <div class="stats">
          <div class="row">
            <div class="col-md-6 col-lg-3">
              <div class="stat-box stat-box-red">
                <div class="stat-box-icon"><i class="fa fa-pie-chart"></i></div>
                <strong><?php echo $total_products; ?></strong> <span>Total Products</span> </div>
              <!-- /.stat-box --> 
            </div>
            <!-- /.col-* -->            
            <div class="col-md-6 col-lg-3">
              <div class="stat-box stat-box-blue">
                <div class="stat-box-icon"><i class="fa fa-diamond"></i></div>
                <strong><?php echo $total_categories; ?></strong> <span>Total Catgories</span> </div>
              <!-- /.stat-box --> 
            </div>
            <!-- /.col-* -->
            <div class="col-md-6 col-lg-3">
              <div class="stat-box stat-box-purple">
                <div class="stat-box-icon"><i class="fa fa-database"></i></div>
                <strong><?php echo $total_manufacturer; ?></strong> <span>Total Manufacturers</span> </div>
              <!-- /.stat-box --> 
            </div>
            <!-- /.col-* --> 
            <div class="col-md-6 col-lg-3">
              <div class="stat-box stat-box-green">
                <div class="stat-box-icon"><i class="fa fa-comments"></i></div>
                <strong><?php echo $total_ptypes; ?></strong> <span>Total Product Types</span> </div>
              <!-- /.stat-box --> 
            </div>
            <!-- /.col-* -->
          </div>
          <!-- /.row --> 
        </div>
        <!-- /.stats --> 
        
        <!-- /.box -->
        <div class="cards-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="box">
                <div class="box-inner">
                  <div class="box-title clearfix">
                    <h2>Groups Products</h2>
                  </div>
                  <!-- /.box-title -->
                  <div class="cards">
                    <div class="row">
                     
                     <?php 
					 foreach($groupsData as $group)
					 { ?>
                          <div class="col-md-6 col-lg-6">
                            <div class="stat-box stat-box-blue">
                              <div class="stat-box-icon"><i class="fa fa-diamond"></i></div>
                              <strong><?php echo $group['total']; ?></strong> <span><?php echo $group['name']; ?></span> </div>
                            <!-- /.stat-box --> 
                          </div>
                     <?php } ?>
                    </div>
                    <!-- /.row --> 
                  </div>
                  <!-- /.cards --> 
                </div>
                <!-- /.box-inner --> 
              </div>
              <!-- /.box --> 
            </div>
            <!-- /.col --> 
            
            <!-- /.col --> 
          </div>
          <!-- /.row --> 
        </div>
        <!-- /.cards-wrapper -->
        
        <div class="cards-wrapper">
          <div class="row"> 
            
            <!-- /.col -->
            <div class="col-lg-12">
              <div class="box">
                <div class="box-inner">
                  <div class="box-title clearfix">
                    <h2>Most recent Products</h2>
                  </div>
                  <!-- /.box-title -->
                  <div class="cards">
                    <div class="row">
                      <?php foreach($recentProducts as $product) { ?>
                      <div class="col-md-6 col-lg-4">
                        <div class="listing-box">
                          <div class="listing-box-inner">
                            <a href="#" class="listing-box-image">
                              <span class="listing-box-image-content" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>')"></span><!-- /.listing-box-image-content -->                                                            
                            </a><!-- /.listing-box-image -->
                            <span class="listing-box-category tag"><a href="<?php echo site_url('Products?cno='.$product->CID); ?>"><?php echo $product->CNAME; ?></a></span>
                            <div class="listing-box-content">
                              <h2><a href="#"><?php echo $product->Name; ?></a></h2>
                              <h3><strong>RSK-Nr: <?php echo $product->RSKnummer0; ?></strong></h3>                              
                            </div>
                            <!-- /.listing-box-content -->
                            <div class="listing-box-content mb-0">                              	
                                <dl>
                                  <dt>RSK-Nr.</dt>
                                  <dd><?php echo !empty($product->RSKnummer0)?$product->RSKnummer0:'-'; ?></dd>
                                  <dt>Tillverkare</dt>
                                  <dd><?php echo !empty($product->MName)?$product->MName:'-'; ?></dd>
                                  <dt>Produktnamn</dt>
                                  <dd><?php echo !empty($product->Produktnamn)?$product->Produktnamn:'-'; ?></dd>
                                </dl>                                                                
                              </div>                           
                          </div>
                          <!-- /.listing-box-inner -->
                        </div>
                        <!-- /.listing-box -->
                      </div>
                      <!-- /.col-* -->
                      <?php } ?>
                      
                      <!-- /.col-* -->
                      
                      <!-- /.col-* -->
                      
                      <!-- /.col-* --> 
                    </div>
                    <!-- /.row --> 
                  </div>
                  <!-- /.cards --> 
                </div>
                <!-- /.box-inner --> 
              </div>
              <!-- /.box --> 
            </div>
            <!-- /.col --> 
          </div>
          <!-- /.row --> 
        </div>
        
        <!-- /.box --> 
      </div>
      <!-- /.container --> 
    </div>
    <!-- /.admin-content -->