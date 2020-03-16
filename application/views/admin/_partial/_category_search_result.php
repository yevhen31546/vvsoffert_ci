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
                            <h2><a href="<?php echo site_url('admin/categories?pid=' . $categories->id . '&pid2=' . $categories->pid); ?>"><?php echo $categories->name; ?></a></h2>
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