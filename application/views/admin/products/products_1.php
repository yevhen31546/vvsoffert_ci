 
    <div class="admin-content">
      <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <span class="breadcrumb-item active">Products</span> </nav>
        
        <div class="table-header clearfix">
              <div class="table-header-count">
                <strong><?php echo $total_rows; ?></strong> results
              </div>
              <!-- /.table-header-count -->
              <div class="table-header-actions hide">
                <a href="#" class="btn btn-primary"><i class="fa fa-filter"></i> Apply filters</a>
                <a href="#" class="btn"><i class="fa fa-download"></i> Export All</a>
              </div>
              <!-- /.table-header-actions -->
            </div>
            <?php show_session_message(); ?>
           <div class="table-wrapper">
           	<?php echo $this->pagination->create_links(); ?>
           	<table class="table table-bordered">
                    <a href="<?php echo site_url('admin/products/add'); ?>" class="btn btn-default" target="new"> Add New Product</a>
                <thead>
                  <tr>                   
                    <th class="min-width center">ID</th>
                    <th class="min-width center">Name</th>
                    <th class="min-width center">RSK</th>
                    <th class="min-width center">Tillverkare</th>
                    <th class="min-width center">Produktnamn</th>  
                    <th class="center" width="30"></th>                                        
                  </tr>
                </thead>
                <tbody>
                	 <?php 			 	
					 foreach($productsList as $product)
					 { ?>
                  <tr>                   
                    <td class="min-width center id">#<?php echo $slno++; ?></td>
                    <td>
                        <?php if(file_exists($product->ImageName)){?>
                        <div class="avatar squared" style="background-image: url('<?php echo site_url($product->ImageName); ?>')"></div>
             <?php }else{ ?>
                      <div class="avatar squared" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>')"></div>
             <?php } ?>
                      <h2>
                        <a href="#">Freelance Office</a>
                        <span>RSK-Nr: <?php echo $product->RSKnummer0; ?></span>
                      </h2>
                    </td>
                    <td class="min-width no-wrap center">
                      <span class="tag"><?php echo !empty($product->RSKnummer0)?$product->RSKnummer0:'-'; ?></span>
                    </td>                    
                    <td class="min-width center">
                      <?php echo !empty($product->MName)?$product->MName:'-'; ?>
                      <!-- /.status -->
                    </td>
                    <td class="min-width center">
                      <?php echo !empty($product->Produktnamn)?$product->Produktnamn:'-'; ?>
                    </td>
                    <td class="">
                     	<a class="" href="<?php echo site_url('product?pname='.url_title($product->Name).'&no='.$product->id); ?>" target="new" title="view in website"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;
                        <a class="" href="<?php echo site_url('admin/products/edit/'.$product->id); ?>" title="edit product"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;                                               
                        <a class="" href="javascript:;" onclick="deleteProduct('<?=$product->id?>');" title="delete product"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;                                               
                    </td>
                  </tr>
                  <?php } ?>
                                                      
                </tbody>
              </table>
              <?php echo $this->pagination->create_links(); ?>
            </div> 
        
        <!-- /.box -->        
      </div>
      <!-- /.container --> 
    </div>
    <!-- /.admin-content -->