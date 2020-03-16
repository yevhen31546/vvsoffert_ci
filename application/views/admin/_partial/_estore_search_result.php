<div class="table-header clearfix">
    <div class="table-header-count">
        <strong><?php echo $total_stores; ?></strong> results
    </div>
    <!-- /.table-header-count -->
    <div class="table-header-actions hide">
        <a href="#" class="btn btn-primary"><i class="fa fa-filter"></i> Apply filters</a>
        <a href="#" class="btn"><i class="fa fa-download"></i> Export All</a>
    </div>
    <div class="table-header-actions">
        <ul class="pagination cust-pagination pull-right">
            <?php if ($totalPages > 1) : ?>
                <li class="page-item"><a href="javascript:;" onclick="getEstorePaginationData(this)" data-pageNumber="1" id="pagination_li_first_1" class="page-link">First</a></li>
                <li class="page-item"><a href="javascript:;" onclick="getEstorePaginationData(this)" data-pageNumber="<?= ($crntPage > 1) ? $crntPage - 1 : 1 ?>" id="pagination_li_previous_<?= $crntPage - 1 ?>" class="page-link">Previous</a></li>
                <?php for ($count = 1; $totalPages >= $count; $count++) : ?>
                    <?php if ($count >= $crntPage - 3 && $count <= $crntPage + 3) : ?>
                        <?php if ($count == $crntPage) : ?>
                            <li class="page-item active"><a href="javascript:;" onclick="getEstorePaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                        <?php else : ?>
                            <li class="page-item"><a href="javascript:;" onclick="getEstorePaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>
                <li class="page-item"><a href="javascript:;" onclick="getEstorePaginationData(this)" data-pageNumber="<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" id="pagination_li_next_<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" class="page-link">Next</a></li>
                <li class="page-item"><a href="javascript:;" onclick="getEstorePaginationData(this)" data-pageNumber="<?= $totalPages ?>" id="pagination_li_last_<?= $totalPages ?>" class="page-link">Last</a></li>
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
                <th style="width: 10%; text-transform: uppercase;" class="min-width center">Sl. No</th>
                            <th style="width: 30%; text-transform: uppercase;">E-Store Name</th>
                            <th style="width: 35%; text-transform: uppercase;">E-Store Logo</th>              
                <th class="min-width center" style="width: 15%; text-transform: uppercase;">No of Products</th>                    
                <th class="center" style="width: 10%;"></th>   
            </tr>
        </thead>
        <tbody>
            <?php if (count($storeData) > 0) : ?>
                <?php
                $slno = ($_limit * ($crntPage - 1)) + 1;
                foreach ($storeData as $store) {
                    ?>
                    <tr>                    
                        <td class="min-width center id">#<?php echo $slno++; ?></td>
                        <td>                      
                            <h2>
                                <?php
                                $CI = & get_instance();
                                $urlName = $CI->geturlencodetext($store->name);
                                ?>
                                <a href="<?php echo site_url('admin/estore/estore_data/' . $store->id . "/" . $urlName); ?>"><?php echo $store->name ?></a>
                            </h2>
                        </td>
                        <td>
                            <?php if(file_exists($store->logoImage)){?>
                                 <img src="<?php echo site_url($store->logoImage); ?>" class="img-squared" alt="<?php echo $store->logoImage; ?>" style="width:100px; min-height: 60px !important;">
                             <?php }else{ ?>
                                 <img src="http://www.vvsoffert.se/scraper/<?php echo $store->logoImage; ?>" class="img-squared" alt="<?php echo $store->logoImage; ?>" style="width:100px; min-height: 60px !important;">
                                 
                             <?php }
                             ?>
                        </td>                    
                        <td class="min-width price">
                            <?php echo $store->pCount; ?>
                        </td>   
                        <td class="">                     	
                            <a class="" id="update_store_<?= $store->id ?>" href="<?php echo site_url('admin/estore/edit/' . $store->id); ?>" title="Update Store"><i class="fa fa-edit"></i></a>                                               
                            &nbsp;&nbsp;
                            <a class="" id="update_store_<?= $store->id ?>" href="<?php echo site_url('admin/estore/import_product/' . $store->id); ?>" title="Upload Product"><i class="fa fa-upload" aria-hidden="true"></i></a>                                               
                            &nbsp;&nbsp;
                            <a class="" onclick="deleteStore(this);" href="javascript:;" id="delete_store_<?= $store->id ?>" data-targetId="<?= $store->id ?>" title="Delete group"><i class="fa fa-trash-o"></i></a>                                               
                        </td>               
                    </tr>
                <?php } ?>
            <?php else : ?>
                <tr>                    
                    <td colspan="4" class="min-width center id">
                        <p style="text-transform: uppercase;">You haven't added any store yet.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>