<div class="table-header clearfix">
    <div class="table-header-count">
        <strong><?php echo $total_products; ?></strong> results
    </div>
    <!-- /.table-header-count -->
    <div class="table-header-actions hide">
        <a href="#" class="btn btn-primary"><i class="fa fa-filter"></i> Apply filters</a>
        <a href="#" class="btn"><i class="fa fa-download"></i> Export All</a>
    </div>
    <div class="table-header-actions">
        <ul class="pagination cust-pagination pull-right">
            <?php if ($totalPages > 1) : ?>
                <li class="page-item"><a href="javascript:;" onclick="getProductPaginationData(this)" data-pageNumber="1" id="pagination_li_first_1" class="page-link">First</a></li>
                <li class="page-item"><a href="javascript:;" onclick="getProductPaginationData(this)" data-pageNumber="<?= ($crntPage > 1) ? $crntPage - 1 : 1 ?>" id="pagination_li_previous_<?= $crntPage - 1 ?>" class="page-link">Previous</a></li>
                <?php for ($count = 1; $totalPages >= $count; $count++) : ?>
                    <?php if ($count >= $crntPage - 3 && $count <= $crntPage + 3) : ?>
                        <?php if ($count == $crntPage) : ?>
                            <li class="page-item active"><a href="javascript:;" onclick="getProductPaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                        <?php else : ?>
                            <li class="page-item"><a href="javascript:;" onclick="getProductPaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>
                <li class="page-item"><a href="javascript:;" onclick="getProductPaginationData(this)" data-pageNumber="<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" id="pagination_li_next_<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" class="page-link">Next</a></li>
                <li class="page-item"><a href="javascript:;" onclick="getProductPaginationData(this)" data-pageNumber="<?= $totalPages ?>" id="pagination_li_last_<?= $totalPages ?>" class="page-link">Last</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- /.table-header-actions -->
</div>
<?php show_session_message(); ?>
<div class="table-wrapper">
    <?php // echo $this->pagination->create_links(); ?>
    <table class="table table-bordered">
        <thead>
            <tr>                   
                <!--<th class="min-width center">ID</th>-->
                <th class="min-width center">Name</th>
                <th class="min-width center">Created Date</th>
                <th class="min-width center">RSK</th>
                <th class="min-width center">Tillverkare</th>
                <th class="min-width center">Markera som populär</th>
                <th class="min-width center">Produktnamn</th>  
                <th class="center" width="30"></th>                                        
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($productsData as $product) {
                ?>
                <tr>                   
                    <!--<td class="min-width center id">#<?php // echo $slno++;  ?></td>-->
                    <td>
                        <?php if (file_exists($product->ImageName)) { ?>
                            <div class="avatar squared" style="background-image: url('<?php echo site_url($product->ImageName); ?>')"></div>
                        <?php } else { ?>
                            <div class="avatar squared" style="background-image: url('http://www.vvsoffert.se/scraper/<?php echo $product->ImageName; ?>')"></div>
                        <?php } ?>
                        <h2>
                            <a href="<?php echo site_url('product/' . url_title($product->Name) . '-pid-' . $product->id); ?>"><?= $product->Name ?></a>
                            <span>RSK-Nr: <?php echo $product->RSKnummer0; ?></span>
                        </h2>
                    </td>
                    <td class="min-width center">
                        <?php echo!empty($product->CreatedDate) ? $product->CreatedDate : '-'; ?>
                        <!-- /.status -->
                    </td>
                    <td class="min-width no-wrap center">
                        <!--<span class="tag"><?php echo!empty($product->RSKnummer0) ? $product->RSKnummer0 : '-'; ?></span>-->
                        <span class="tag"><?php echo!empty($product->RSKnummer0) ? $product->RSKnummer0 : $product->RSKnummer; ?></span>
                    </td>                    
                    <td class="min-width center">
                        <?php echo!empty($product->MName) ? $product->MName : '-'; ?>
                        <!-- /.status -->
                    </td>
                    <td class="min-width center">
                                    <?php echo!empty($product->markera_populer == 1) ? "YES": 'NO'; ?>
                                    <!-- /.status -->
                                </td>
                    <td class="min-width center">
                        <?php echo!empty($product->Produktnamn) ? $product->Produktnamn : '-'; ?>
                    </td>
                    <td class="">
                        <a class="" href="<?php echo site_url('product/' . url_title($product->Name) . '-pid-' . $product->id); ?>" target="new" title="view in website"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;
                        <a class="" href="<?php echo site_url('admin/products/edit/' . $product->id); ?>" title="edit product"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;                                               
                        <a class="" href="javascript:;" onclick="deleteProduct('<?= $product->id ?>');" title="delete product"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;                                               
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
    <?php // echo $this->pagination->create_links(); ?>
</div>