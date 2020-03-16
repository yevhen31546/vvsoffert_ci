 
    <div class="admin-content">
      <div class="container">
        <nav class="breadcrumb"> 
        	<a class="breadcrumb-item" href="#">Admin</a> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/categories'); ?>">Categories</a> 		
            <?php
				if(isset($parent_category) and !isset($sub_category))
				{
					echo '<span class="breadcrumb-item active">'.$parent_category->name.'</span>';
				}
				if(isset($parent_category) and isset($sub_category))
				{
					echo '<span class="breadcrumb-item">'.anchor('admin/categories?pid='.$pid, $parent_category->name).'</span>';
					echo '<span class="breadcrumb-item active">'.$sub_category->name.'</span>';
				}
			?>
         </nav>
        
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
            
           <div class="table-wrapper">
              <table class="table table-bordered">
                <thead>
                  <tr>                    
                    <th class="min-width center">Sl.No</th>
                    <th>Title</th>
                    <?php if($pid2==0) { ?>     
                    <th class="min-width center">No of Sub. Category</th>                
                    <?php } ?>
                    <th class="min-width center">No of Products</th>  
                    <th class="center" width="30"></th>                  
                  </tr>
                </thead>
                <tbody>
                 <?php 
				 	$slno=1;
					 foreach($main_categories as $categories)
					 { ?>
                  <tr>                    
                    <td class="min-width center id">#<?php echo $slno++; ?></td>
                    <td> 
                    <?php										
						if(isset($parent_category) and isset($sub_category))
						{
							?>
							<h2><?php echo $categories->name; ?></h2>
                            <?php
						}
						else
						{
							?>
                            	<h2><a href="<?php echo site_url($pid>0?'admin/categories?pid='.$parent_category->id.'&pid2='.$categories->id:'admin/categories?pid='.$categories->id); ?>"><?php echo $categories->name; ?></a></h2>
                            <?php
						}
					?>                      
                    </td>        
                    <?php if($pid2==0) { ?>              
                    <td class="min-width price">
                     <?php echo $subcategory[$categories->id]; ?>
                    </td> 
                    <?php } ?>
                    <td class="min-width price">
                     <?php echo $categories->pcount; ?>
                    </td>  
                    <td class="">
                     	<a class="" href="<?php echo site_url('admin/categories/edit/'.$categories->id); ?>" title="Edit Category"><i class="fa fa-edit"></i></a>                                                                    
                    </td>               
                  </tr>
                  <?php } ?>
                  
                </tbody>
              </table>
            </div> 
        
        <!-- /.box -->        
      </div>
      <!-- /.container --> 
    </div>
    <!-- /.admin-content -->