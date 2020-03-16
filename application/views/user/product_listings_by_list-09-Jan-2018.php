<style>
    .prodcut_img img.img-responsive {
        height: 50px;
        margin: 0;
    }
</style>
<div class="col-xs-12 col-sm-9 table_content">
    <div class="overall_content">
        <div class="section_content">
            <div class="table_header">
                <div class="table_title fl">Detaljer</div>
                <div class="Export_content fr">
                    <a target="_blank"  href="<?php echo site_url('list-invoice-form') . '?id=' . $_GET['id']; ?>">
                        <i class="fa fa-files-o"></i> Invoice
                    </a>
                    <a target="_blank" href="<?php echo site_url('export-excel') . '?id=' . $_GET['id']; ?>">
                        <i class="fa fa-share-square-o"></i> Exportera Excel
                    </a>
<!--                     <a target="_blank" href="<?php //echo site_url('pdf-export') . '?id=' . $_GET['id'];  ?>">
                        <i class="fa fa-share-square-o"></i> Exportera PDF
                    </a> -->
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Produktnamn</th>
                            <th>Tillverkare</th>
                            <th>Kategori</th>
                            <th>RSK-Nr</th>
                            <th>Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($productlist) > 0) {
                            foreach ($productlist as $k => $v) {
                                ?>
                                <tr>
                                    <td><?= $k + 1 ?></td>
                                    <td class="prodcut_img">
                                        <!--<div class="xs_img">-->
                                        <div class="">
                                            <?php if (file_exists($v->ImageName)) { ?>
                                                <img src="<?= $v->ImageName ?>" class="center-block img-responsive"> 
                                            <?php } else { ?>
                                                <img src="http://www.vvsoffert.se/scraper/<?php echo $v->ImageName; ?>" class="center-block img-responsive">
                                            <?php } ?>

                                        </div>
                                    </td>
                                    <td><?= $v->Name ?></td>
                                    <td><?= $v->manufacturer_name ?></td>
                                    <td><?= $v->category1_name ?></td>
                                    <td><?= $v->RSKnummer ?></td>
                                    <td width="50" class="xs_width">
                                        <div class="option_btn">
                                            <a target="_blank" href="<?php echo site_url('product?pname=' . url_title($v->Name) . '&no=' . $v->id); ?>">
                                                <i class="fa fa-eye fl"></i>
                                            </a>
                                            <a id="<?= $v->id ?>" class="" href="javascript:;" onclick="deleteProductFromUserList(this)" data-targetSlug="<?= $v->list_master_pro_id ?>" data-list-id="<?= $_GET['id'] ?>">
                                                <i class="fa fa-trash-o fr"></i>
                                            </a>
                                            <div class="clearfix"></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">
                                    Ingen produkt hittades !!
                                </td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
            <!--            <div class="table_pagination">
                            <div class="total_pages col-xs-12 col-sm-4 no-gutter">
                                Showing <span>1</span> to <span>6</span> of <span> 100 </span>entries
                            </div>
                            <div class="page_no col-xs-12 col-sm-8 no-gutter">
                                <ul class="pagination fr">
                                    <li><a href="#">1</a></li>
                                    <li class="active"><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">Next</a></li>
                                    <li><a class="last_btn" href="#">Last</a></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>-->
        </div>
    </div>
</div>
<div class="clearfix"></div>
</div>