<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="main-wrapper">
        <div class="main">
          <div class="main-inner">
            <div class="page-title">
              <div class="container">
                <h1>Products List
                </h1>                
                <!-- /.page-title-actions -->
              </div>
              <!-- /.container-fluid -->
            </div>
            <!-- /.page-title -->
            <div class="container">
              <div class="row">
                <div class="col-sm-4 col-md-3 sidebar-wrapper-col">
                  <div class="sidebar">
                  	<?php echo form_open(site_url('Products?'.$actionParam),array('method'=>'get')); ?>
                    <div class="filter">
                        <div class="overview mb-3">  
                            <h4>Total Products : <span class="pull-right"><?php echo $total_rows; ?></span></h4>                                                
                        </div>
                         <div class="overview category-column mb-3 hide" id="pdt-compare-wrap">                         
                          <h3>Products To Complare</h3>   
                          <ul class="mb-0" id="pdt-compare">                           
                          </ul>
                          <button type="button" class="btn btn-primary btn-block mt-2" id="goToCompare">Compare</button>
                        </div> 
                        
                        <div class="form-group">
                        	<label>Search</label>
	                        <input type="text" class="form-control mb-2" name="search" placeholder="Search by RSK ..." value="<?php echo isset($text)?$text:''; ?>">          
    	             	</div> 
                        <div class="form-group">
                        	<label>Tillverkare</label>
	                        <?php echo isset($manufacturerList)?form_dropdown('tillverkare',$manufacturerList,$currentManu,'class="form-control"'):'';   ?>
    	             	</div>  
                        <div class="form-group">
                            <div class="row">
                                <div class="form-group col-xl-6">                              
                                  <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group col-xl-6">
                                  <a href="<?php echo site_url('Products'); ?>" class="btn btn-primary btn-block">Reset</a>
                                </div>
                                <!-- /.form-group -->
                             </div>                        
                        </div>
                      
                        <div id="treeview1" class=""></div>
                        
                                                                                                                                                   
                      
                    </div>
                    <!-- /.filter -->
                    <?php 						
						if(isset($currentCategory) and !empty($currentCategory))
						{						
							echo form_hidden('cno', urlencode($currentCategory));
						}
						if(isset($currentCategory2) and !empty($currentCategory2))
						{						
							echo form_hidden('c2no', urlencode($currentCategory2));
						}
						if(isset($currentCategory3) and !empty($currentCategory3))
						{						
							echo form_hidden('c3no', urlencode($currentCategory3));
						}						
					?>
                    <?php echo form_close(); ?>
                  </div>
                  <!-- /.sidebar -->
                </div>
                <!-- /.col-* -->
                <div class="col-sm-8 col-md-9">
                  <div class="content">
                  	<div class="row">                    	
                      <div class="col-sm-12">
                      	<?php echo $this->pagination->create_links(); ?>                        
                      </div>                      
                    </div>
                    
                    <div class="row">
                    	<?php
							foreach($productsList as $product)
							{
						?>
                      <div class="col-md-6 col-lg-4">
                        <div class="listing-box">
                          <div class="listing-box-inner">
                            <a href="<?php echo site_url('product?pname='.url_title($product->Name).'&no='.$product->id); ?>" class="listing-box-image">
                              <span class="listing-box-image-content" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>')"></span><!-- /.listing-box-image-content -->                                                            
                            </a><!-- /.listing-box-image -->
                            <span class="listing-box-category tag"><a href="<?php echo site_url('Products?cno='.$product->CID); ?>"><?php echo $product->CNAME; ?></a></span>
                            <div class="listing-box-content">
                              <h2><a href="<?php echo site_url('product?pname='.url_title($product->Name).'&no='.$product->id); ?>"><?php echo $product->Name; ?></a></h2>
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
                            <div class="pad-5 text-center" style="padding:10px">
                           		<label><input type="checkbox" value="<?php echo $product->id; ?>" class="add-to-compare" id="c<?php echo $product->id; ?>"> Add To Compare</label>
                            </div>
                          </div>
                          <!-- /.listing-box-inner -->
                        </div>
                        <!-- /.listing-box -->
                      </div>
                      <!-- /.col-* -->
                      <?php } ?>
                      
                      <!-- /.col-* -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                      <div class="col-sm-12">
                      	<?php echo $this->pagination->create_links(); ?>                        
                      </div>                      
                    </div>
                  </div>
                  <!-- /.content -->
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