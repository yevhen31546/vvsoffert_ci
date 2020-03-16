<div class="col-xs-12 col-sm-9 table_content">
    <div class="overall_content">
        <div class="section_content">
            <div class="admin-content">
                <div class="">
                    <div class="" id="searchEStoreResult">
                        <div class="table-header clearfix">
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
                        <div class="table-wrapper">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>                    
                                        <th style="width: 10%; text-transform: uppercase; padding: 8px;" class="min-width center">Sl. No</th>
                                        <th style="width: 50%; text-transform: uppercase; padding: 8px;">Butik</th>                    
                                        <th class="min-width center" style="width: 30%; padding: 8px; text-transform: uppercase;">antal artiklar</th>                    
                                        <th class="center" style="width: 10%; padding: 8px;"></th>   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($storeData) > 0) : ?>
                                        <?php
                                        $slno = ($_limit * ($crntPage - 1)) + 1;
                                        foreach ($storeData as $store) {
                                            ?>
                                            <tr>                    
                                                <td style="padding: 8px;" class="min-width center id">#<?php echo $slno++; ?></td>
                                                <td style="padding: 8px;" >                      
                                                    <?php
                                                    $CI = & get_instance();
                                                    $urlName = $CI->geturlencodetext($store->name);
                                                    ?>
                                                    <?php echo $store->name ?>
                                                </td>                    
                                                <td style="padding: 8px;" class="min-width price">
                                                    <?php echo $store->pCount; ?>
                                                </td>   
                                                <td style="padding: 8px;"  class="">                     	
                                                    &nbsp;&nbsp;
                                                    <a class="" id="update_store_<?= $store->id ?>" href="<?php echo site_url('import-product-rsk-estore-price/' . $store->id); ?>" title="Upload Product"><i class="fa fa-upload" aria-hidden="true"></i></a>                                               
                                                    &nbsp;&nbsp;
                                                </td>               
                                            </tr>
                                        <?php } ?>
                                    <?php else : ?>
                                        <tr>                    
                                            <td style="padding: 8px;" colspan="4" class="min-width center id">
                                                <p style="text-transform: uppercase;">You haven't added any store yet.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <br><br>
                        </div>
                    </div>
                    <!-- /.box -->        
                </div>
                <!-- /.container --> 
            </div>
        </div>
    </div>
</div>
<!-- /.admin-content -->