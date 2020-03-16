<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="#">Admin</a> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/estore/index'); ?>">E-Store</a>
            <?php if (isset($storeDetails) && !empty($storeDetails)) : ?>
                <span class="breadcrumb-item active"><?= ucwords($storeDetails->name) ?></span>
            <?php endif; ?>

            <a class="btn btn-default pull-right" href="<?php echo site_url('admin/estore/import_product/' . $storeDetails->id); ?>">Upload Product</a>
        </nav>
        <div class="table-header clearfix">
            <form id="estore_product_search_form_" method="post" action="">
                <div class="search-content">
                    <div class="row">
                        <input type="hidden" name="_page_no" id="_page_no" value="1"/>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <input type="hidden" name="s_store" id="estore_product_s_store_id_" value="<?= $storeDetails->id ?>"/>
                                    <input type="text" name="s_key" id="estore_product_s_key_" value="" class="form-control" placeholder="Search By Product Name & RSK Number"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_sort_by" id="estore_product_s_sort_by" class="form-control" onchange="$('#estore_product_search_form_').submit();">
                                        <option value="t.product_name">Sort By</option>
                                        <option value="t.product_name">Sort By Product Name</option>
                                        <option value="t.rsk_no">Sort By RSK No</option>
                                        <option value="t.discount_group	">Sort By Discount Group</option>
                                        <option value="t.unit">Sort By Unit</option>
                                        <option value="t.price">Sort By Price</option>
                                        <option value="t.in_stock">Sort By IN STOCK</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_order_by" id="estore_product_s_order_by" class="form-control" onchange="$('#estore_product_search_form_').submit();">
                                        <option value="ASC">Order By</option>
                                        <option value="ASC">Order By Ascending</option>
                                        <option value="DESC">Order By Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="" id="searchEStoreProductResult">
            <div class="table-header clearfix">
                <div class="table-header-count">
                    <strong><?php echo $total_store_product; ?></strong> results
                </div>
                <!-- /.table-header-count -->
                <div class="table-header-actions hide">
                    <a href="#" class="btn btn-primary"><i class="fa fa-filter"></i> Apply filters</a>
                    <a href="#" class="btn"><i class="fa fa-download"></i> Export All</a>
                </div>
                <div class="table-header-actions">
                    <ul class="pagination cust-pagination pull-right">
                        <?php if ($totalPages > 1) : ?>
                            <li class="page-item"><a href="javascript:;" onclick="getEstoreProductPaginationData(this)" data-pageNumber="1" id="pagination_li_first_1" class="page-link">First</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getEstoreProductPaginationData(this)" data-pageNumber="<?= ($crntPage > 1) ? $crntPage - 1 : 1 ?>" id="pagination_li_previous_<?= $crntPage - 1 ?>" class="page-link">Previous</a></li>
                            <?php for ($count = 1; $totalPages >= $count; $count++) : ?>
                                <?php if ($count >= $crntPage - 3 && $count <= $crntPage + 3) : ?>
                                    <?php if ($count == $crntPage) : ?>
                                        <li class="page-item active"><a href="javascript:;" onclick="getEstoreProductPaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a href="javascript:;" onclick="getEstoreProductPaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item"><a href="javascript:;" onclick="getEstoreProductPaginationData(this)" data-pageNumber="<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" id="pagination_li_next_<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" class="page-link">Next</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getEstoreProductPaginationData(this)" data-pageNumber="<?= $totalPages ?>" id="pagination_li_last_<?= $totalPages ?>" class="page-link">Last</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- /.table-header-actions -->
            </div>
            <?php show_session_message(); ?>
            <div class="table-wrapper">
                <table class="table table-bordered">
                    <thead>
                        <tr>                    
                            <th style="width: 5%;" class="min-width center">#</th>
                            <th style="width: 20%;">Product Name</th>                    
                            <th class="min-width center" style="width: 10%;">RSK No</th>                    
                            <th class="min-width center" style="width: 15%;">Discount Group</th>                    
                            <th class="min-width center" style="width: 5%;">Unit</th>                    
                            <th class="min-width center" style="width: 5%;">Price</th>                    
                            <th class="min-width center" style="width: 10%;">In Stock</th>                    
                            <th class="center" style="width: 30%;">E-Store Link</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($store_product_data) > 0) : ?>
                            <?php
                            $slno = ($_limit * ($crntPage - 1)) + 1;
                            foreach ($store_product_data as $storePro) {
                                ?>
                                <tr>                    
                                    <td class="min-width center id">#<?php echo $slno++; ?></td>
                                    <td>                      
                                        <h2>
                                            <?php echo $storePro->product_name ?>
                                        </h2>
                                    </td>                    
                                    <td class="min-width price">
                                        <?php echo $storePro->rsk_no; ?>
                                    </td>   
                                    <td class="min-width price">
                                        <?php echo $storePro->discount_group; ?>
                                    </td>   
                                    <td class="min-width price">
                                        <?php echo $storePro->unit; ?>
                                    </td>   
                                    <td class="min-width price">
                                        <?php echo $storePro->price; ?>
                                    </td>   
                                    <td class="min-width price">
                                        <?php echo $storePro->in_stock; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $storePro->e_store_link; ?>"><?php echo $storePro->e_store_link; ?></a>
                                    </td>
<!--                                    <td class="">                     	
                                        <a class="" id="update_store_<?= $storePro->id ?>" href="<?php e//cho site_url('admin/estore/edit/' . $storePro->id); ?>" title="View Product"><i class="fa fa-edit"></i></a>                                               
                                        <a class="" onclick="deleteStore(this);" href="javascript:;" id="delete_store_<?= $storePro->id ?>" data-targetId="<?= $storePro->id ?>" title="Delete Product"><i class="fa fa-trash-o"></i></a>                                               
                                    </td>               -->
                                </tr>
                            <?php } ?>
                        <?php else : ?>
                            <tr>                    
                                <td colspan="8" class="min-width center id">
                                    <p style="text-transform: uppercase;">You haven't added any product yet on this store.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box -->        
    </div>
    <!-- /.container --> 
</div>
<!-- /.admin-content -->