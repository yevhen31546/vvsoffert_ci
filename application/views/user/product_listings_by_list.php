<style>
    .prodcut_img img.img-responsive {
        height: 50px;
        margin: 0;
    }
</style>
<div class="col-xs-12 col-sm-9 col-xl-10 table_content">
    <div class="overall_content">
        <div class="section_content">
            <div class="table_header">
                <div class="table_title fl"><p style = "font-size: 30px"><a href="<?php echo site_url('add-list'); ?>"><i class="fa fa-chevron-left" style = "font-size: 25px; margin-right: 10px;"></i></a>Detaljer</p></div>
                <div class="Export_content fr">
                    <!-- <button type="button" class="btn btn-success">
                        <a href="<?php echo site_url('list-invoice-form') . '?id=' . $_GET['id'].'&type=1'; ?>" style = "font-size: 20px; color: white;">
                            <i class="far fa-file" style = "margin-right: 5px;"></i>Gör offer
                        </a>
                    </button>
                    <button type="button" class="btn btn-success">
                        <a href="<?php echo site_url('list-invoice-form') . '?id=' . $_GET['id'].'&type=2'; ?>" style = "font-size: 20px; color: white;">
                            <i class="far fa-file" style = "margin-right: 5px;"></i>Gör ÄTA
                        </a>
                    </button>
                    <button type="button" class="btn btn-success">
                        <a href="<?php echo site_url('list-invoice-form') . '?id=' . $_GET['id'].'&type=3'; ?>" style = "font-size: 20px; color: white;">
                            <i class="far fa-file" style = "margin-right: 5px;"></i>Gör faktura
                        </a>
                    </button> -->
                    <button type ="butoon" class ="btn btn-success">
                        <a target="_blank" href="<?php echo site_url('export-excel') . '?id=' . $_GET['id']; ?>"  style = "font-size: 20px; color: white;">
                            <i class="far fa-share-square" style = "margin-right: 5px;"></i> Bästa pris excel
                        </a>
                    </button>
<!--                     <a target="_blank" href="<?php //echo site_url('pdf-export') . '?id=' . $_GET['id'];  ?>">
                        <i class="fa fa-share-square-o"></i> Exportera PDF
                    </a> -->
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="table-responsive" style = "margin-top: 30px; font-size: 20px;">
                <table id = "datatable" class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Bild</th>
                            <th scope="col">Produktnamn</th>
                            <th scope="col">Tillverkare</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">RSK-Nr</th>
                            <th scope="col">Redigera</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($productlist) > 0) {
                            foreach ($productlist as $k => $v) {
                                ?>
                                <tr>
                                    <td data-label="No"><?= $k + 1 ?></td>
                                    <td data-label="Bild" class="prodcut_img">
                                        <!--<div class="xs_img">-->
                                        <div class="">
                                            <?php if (file_exists($v->ImageName)) { ?>
                                                <img src="<?= $v->ImageName ?>" class="center-block img-responsive"> 
                                            <?php } else { ?>
                                                <img src="https://www.vvsoffert.se/scraper/<?php echo $v->ImageName; ?>" class="center-block img-responsive">
                                            <?php } ?>

                                        </div>
                                    </td>
                                    <td data-label="Produktnamn"><?= $v->Name ?></td>
                                    <td data-label="Tillverkare"><?= $v->manufacturer_name ?></td>
                                    <td data-label="Kategori"><?= $v->category1_name ?></td>
                                    <td data-label="RSK-Nr"><?= $v->RSKnummer ?></td>
                                    <td data-label="Redigera" width="50" class="xs_width">
                                        <div class="option_btn">
                                            <a target="_blank" href="<?php echo site_url('product/' . url_title($v->Name) . '-pid-' . $v->id); ?>">
                                                <i class="fa fa-eye fl"></i>
                                            </a>
                                            <a id="<?= $v->id ?>" class="" href="javascript:;" onclick="deleteProductFromUserList(this)" data-targetSlug="<?= $v->list_master_pro_id ?>" data-list-id="<?= $_GET['id'] ?>">
                                                <i class="fas fa-trash-alt fr" style = "color: #d9534f"></i>
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