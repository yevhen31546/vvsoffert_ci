 
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="#">Admin</a> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/categories'); ?>">Categories</a> 		
            <?php
            if (isset($parent_category) and ! isset($sub_category)) {
                echo '<span class="breadcrumb-item active">' . $parent_category->name . '</span>';
            }
            if (isset($parent_category) and isset($sub_category)) {
                echo '<span class="breadcrumb-item">' . anchor('admin/categories?pid=' . $pid, $parent_category->name) . '</span>';
                echo '<span class="breadcrumb-item active">' . $sub_category->name . '</span>';
            }
            ?>

            <div class="pull-right">
                <a class="btn btn-default" href="<?php echo site_url('admin/categories/import_category'); ?>">Import Categories</a>
                <!--<a class="btn btn-default" href="<?php // echo site_url('admin/categories/create');   ?>">New Group</a>-->
            </div>
        </nav>
        <div class="table-header clearfix">
            <form id="category_search_form_" method="post" action="">
                <div class="search-content">
                    <div class="row">
                        <input type="hidden" name="_page_no" id="_page_no" value="1"/>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <input type="hidden" name="_pid" id="cat_pid" value="<?= isset($_GET["pid"]) ? $_GET["pid"] : "" ?>" class="form-control"/>
                                    <input type="hidden" name="_pid2" id="cat_pid2" value="<?= isset($_GET["pid2"]) ? $_GET["pid2"] : "" ?>" class="form-control"/>
                                    <input type="text" name="s_key" id="category_s_key_" value="" class="form-control" placeholder="Search By Category Name"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_sort_by" id="category_s_sort_by" class="form-control" onchange="$('#category_search_form_').submit();">
                                        <option value="t.name">Sort By</option>
                                        <option value="t.name">Sort By Name</option>
                                        <?php if (!isset($_GET['pid2'])) : ?>
                                            <option value="subCatCount">Sort By Sub Category</option>
                                        <?php endif; ?>
                                        <option value="pCount">Sort By Total Products</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_order_by" id="category_s_order_by" class="form-control" onchange="$('#category_search_form_').submit();">
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
        <div class="" id="searchCategoryResult">
            <div class="table-header clearfix">
                <div class="table-header-count">
                    <strong><?php echo $totalCategory; ?></strong> results
                </div>
                <!-- /.table-header-count -->
                <div class="table-header-actions hide">
                    <a href="#" class="btn btn-primary"><i class="fa fa-filter"></i> Apply filters</a>
                    <a href="#" class="btn"><i class="fa fa-download"></i> Export All</a>
                </div>
                <!-- /.table-header-actions -->
                <div class="table-header-actions">
                    <ul class="pagination cust-pagination pull-right">
                        <?php if ($totalPages > 1) : ?>
                            <li class="page-item"><a href="javascript:;" onclick="getCategoeyPaginationData(this)" data-pageNumber="1" id="category_pagination_li_first_1" class="page-link">First</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getCategoeyPaginationData(this)" data-pageNumber="<?= ($crntPage > 1) ? $crntPage - 1 : 1 ?>" id="category_pagination_li_previous_<?= $crntPage - 1 ?>" class="page-link">Previous</a></li>
                            <?php for ($count = 1; $totalPages >= $count; $count++) : ?>
                                <?php if ($count >= $crntPage - 3 && $count <= $crntPage + 3) : ?>
                                    <?php if ($count == $crntPage) : ?>
                                        <li class="page-item active"><a href="javascript:;" onclick="getCategoeyPaginationData(this)" data-pageNumber="<?= $count ?>" id="category_pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a href="javascript:;" onclick="getCategoeyPaginationData(this)" data-pageNumber="<?= $count ?>" id="category_pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item"><a href="javascript:;" onclick="getCategoeyPaginationData(this)" data-pageNumber="<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" id="category_pagination_li_next_<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" class="page-link">Next</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getCategoeyPaginationData(this)" data-pageNumber="<?= $totalPages ?>" id="category_pagination_li_last_<?= $totalPages ?>" class="page-link">Last</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php show_session_message(); ?>
            <div class="table-wrapper">
                <table class="table table-bordered">
                    <thead>
                        <tr>                    
                            <th class="min-width center">Sl.No</th>
                            <th>Title</th>
                            <?php if ($pid2 == 0) { ?>     
                                <th class="min-width center">No of Sub. Category</th>                
                            <?php } ?>
                            <th class="min-width center">No of Products</th>  
                            <th class="center" width="30"></th>                  
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slno = $offset + 1;
                        foreach ($allCategory as $categories) {
                            ?>
                            <tr>                    
                                <td class="min-width center id">#<?php echo $slno++; ?></td>
                                <td> 
                                    <?php if ($categories->pid == null && $categories->pid2 == null && $categories->subCatCount > 0) : ?>
                                        <h2><a href="<?php echo site_url('admin/categories?pid=' . $categories->id); ?>"><?php echo $categories->name; ?></a></h2>
                                    <?php elseif ($categories->pid != null && $categories->pid2 == null) : ?>
                                        <h2><a href="<?php echo site_url('admin/categories?pid=' . $categories->pid . '&pid2=' . $categories->id); ?>"><?php echo $categories->name; ?></a></h2>
                                    <?php else : ?>
                                        <h2><?php echo $categories->name; ?></h2>
                                    <?php endif; ?>
                                </td>        
                                <?php if ($categories->pid2 == NULL || $categories->pid2 == "") { ?>              
                                    <td class="min-width price">
                                        <?php echo $categories->subCatCount; ?>
                                    </td> 
                                <?php } ?>
                                <td class="min-width price">
                                    <?php echo $categories->pCount; ?>
                                </td>  
                                <td class="">
                                    <a class="" href="<?php echo site_url('admin/categories/edit/' . $categories->id); ?>" title="Edit Category"><i class="fa fa-edit"></i></a>                                                                    
                                    <a class="" href="javascript:;" title="Delete Category" onclick="delete_pro_category(this)" id="delete_cat_<?= $categories->id ?>" data-targetId="<?= $categories->id ?>"><i class="fa fa-trash-o"></i></a>
                                </td>               
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div> 
        </div>

        <!-- /.box -->        
    </div>
    <!-- /.container --> 
</div>
<!-- /.admin-content -->