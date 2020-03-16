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
                    <!--<td class="min-width center id">#<?php // echo $slno++;       ?></td>-->
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