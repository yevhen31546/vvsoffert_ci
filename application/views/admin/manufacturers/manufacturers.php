 
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Admin</a> <span class="breadcrumb-item active">Manufacturers</span> 
            <div class="pull-right">
                <a class="btn btn-default" href="<?php echo site_url('admin/manufacturers/import_manufacturers'); ?>">Import Manufacturers</a>
                <!--<a class="btn btn-default" href="<?php // echo site_url('admin/groups/create'); ?>">New Group</a>-->
            </div>
        </nav>
        <div class="table-header clearfix">
            <form id="menufacture_search_form" method="post" action="">
                <div class="search-content">
                    <div class="row">
                        <input type="hidden" name="_page_no" id="_page_no" value="1"/>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <input type="text" name="s_key" id="menufacture_s_key" value="" class="form-control" placeholder="Search By Menufacture Name"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_sort_by" id="menufacture_s_sort_by" class="form-control" onchange="$('#menufacture_search_form').submit();">
                                        <option value="t.name">Sort By</option>
                                        <option value="t.name">Sort By Name</option>
                                        <option value="total_product">Sort By Total Products</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_order_by" id="menufacture_s_order_by" class="form-control" onchange="$('#menufacture_search_form').submit();">
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
        <div class="" id="manufactures_Search_Res">
            <div class="table-header clearfix">
                <div class="table-header-count">
                    <strong><?php echo $total_menufacture; ?></strong> results
                </div>
                <!-- /.table-header-count -->
                <div class="table-header-actions hide">
                    <a href="#" class="btn btn-primary"><i class="fa fa-filter"></i> Apply filters</a>
                    <a href="#" class="btn"><i class="fa fa-download"></i> Export All</a>
                </div>
                <div class="table-header-actions">
                    <ul class="pagination cust-pagination pull-right">
                        <?php if ($totalPages > 1) : ?>
                            <li class="page-item"><a href="javascript:;" onclick="getmanufacturepaginationData(this)" data-pageNumber="1" id="pagination_li_first_1" class="page-link">First</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getmanufacturepaginationData(this)" data-pageNumber="<?= ($crntPage > 1) ? $crntPage - 1 : 1 ?>" id="pagination_li_previous_<?= $crntPage - 1 ?>" class="page-link">Previous</a></li>
                            <?php for ($count = 1; $totalPages >= $count; $count++) : ?>
                                <?php if ($count >= $crntPage - 3 && $count <= $crntPage + 3) : ?>
                                    <?php if ($count == $crntPage) : ?>
                                        <li class="page-item active"><a href="javascript:;" onclick="getmanufacturepaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a href="javascript:;" onclick="getmanufacturepaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item"><a href="javascript:;" onclick="getmanufacturepaginationData(this)" data-pageNumber="<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" id="pagination_li_next_<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" class="page-link">Next</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getmanufacturepaginationData(this)" data-pageNumber="<?= $totalPages ?>" id="pagination_li_last_<?= $totalPages ?>" class="page-link">Last</a></li>
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
                            <!--<th class="min-width center">Sl.No</th>-->
                            <th>Title</th>                    
                            <th class="min-width center">No of Products</th> 
                            <th class="center" width="30"></th>                    
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($menufactureData as $group) {
                            ?>
                            <tr>                    
                                <!--<td class="min-width center id">#<?php // echo $slno++;     ?></td>-->
                                <td>                      
                                    <h2>
                                        <?php echo $group['name']; ?>
                                    </h2>
                                </td>                    
                                <td class="min-width price">
                                    <?php echo $group['total_product']; ?>
                                </td>  
                                <td class="">                     	
                                    <a class="" href="<?php echo site_url('admin/manufacturers/edit/' . $group['slug']); ?>" title="edit group"><i class="fa fa-edit"></i></a>                                               
                                </td>                
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
                <?php // echo $this->pagination->create_links(); ?>
            </div>
        </div> 

        <!-- /.box -->        
    </div>
    <!-- /.container --> 
</div>
<!-- /.admin-content -->