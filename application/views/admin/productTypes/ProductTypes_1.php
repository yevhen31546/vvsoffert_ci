 
    <div class="admin-content">
      <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <span class="breadcrumb-item active">Product Types</span> </nav>
        
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
              <table class="table table-bordered">
                <thead>
                  <tr>                    
                    <th class="min-width center">Sl.No</th>
                    <th>Title</th>                    
                    <th class="min-width center">No of Products</th>   
                    <th class="center" width="30"></th>                 
                  </tr>
                </thead>
                <tbody>
                 <?php 			 
					 foreach($ProductTypes as $group)
					 { if(!empty($group->name)) {  
					 ?>
                  <tr>                    
                    <td class="min-width center id">#<?php echo $slno++; ?></td>
                    <td>                      
                      <h2>
                        <?php echo $group->name; ?>
                      </h2>
                    </td>                    
                    <td class="min-width price">
                      <?php echo $group->total; ?>
                    </td>   
                    <td class="">                     	
                        <a class="" href="<?php echo site_url('admin/ProductTypes/edit/'.$group->slug); ?>" title="edit group"><i class="fa fa-edit"></i></a>                                               
                    </td>               
                  </tr>
                  <?php } } ?>
                  
                </tbody>
              </table>
              <?php echo $this->pagination->create_links(); ?>
            </div> 
        
        <!-- /.box -->        
      </div>
      <!-- /.container --> 
    </div>
    <!-- /.admin-content -->