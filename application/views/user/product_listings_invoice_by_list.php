<style>
    .prodcut_img img.img-responsive {
        height: 50px;
        margin: 0;
    }
    .invoice-table > tbody > tr > td {
        line-height:1 !important;
        padding: 10px !important;
    }
</style>
<div class="col-xs-12 col-sm-12 table_content">
    <div class="overall_content">
        <div class="section_content">
            <div class="table_header">
                <div class='row'>
                    <div class="col-md-6">
                        <h2>VVS OFFERT</h2>
                        <h4>Snabbt och lätt med vvsoffert.</h2>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                        <h2><?php echo isset($_REQUEST['invoice_type']) ? $_REQUEST['invoice_type'] : ''; ?></h2>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-6">
                        <?php if (!empty($model)) { ?>
                            <p><?php echo $model->company_name; ?></p>
                            <p><?php echo $model->contact ?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                        <p><?php echo isset($_REQUEST['invoice_type']) ? $_REQUEST['invoice_type'] : ''; ?>#<?php echo isset($_REQUEST['invoice_number']) ? $_REQUEST['invoice_number'] : ''; ?></p>
                        <p>Datum: <?php echo date('Y-m-d '); ?></p>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class="col-md-6">
                        <?php if (isset($_REQUEST['name'])) { ?>
                            <p><b>Kundnamn</b>: <?php echo isset($_REQUEST['name']) ? $_REQUEST['name'] : ''; ?></p>
                        <?php } ?>
                        <?php if (isset($_REQUEST['email'])) { ?>
                            <p><b>E-post</b>: <?php echo isset($_REQUEST['email']) ? $_REQUEST['email'] : ''; ?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                        <?php if (isset($_REQUEST['address'])) { ?>
                            <p><?php echo $_REQUEST['address']; ?></p>
                        <?php } ?>
                        <p>
                            <?php if (isset($_REQUEST['city'])) { ?>
                                <?php echo $_REQUEST['city']; ?>
                            <?php } ?> 
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <h3>Kommentarer</h3>
                <p> <?php if (isset($_REQUEST['special_comments'])) { ?>
                        <?php echo $_REQUEST['special_comments']; ?>
                    <?php } ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered invoice-table">
                    <thead>
                        <tr>
                            <th>Antal</th>
                            <th>RSK NUMMER</th>
                            <th>Produktnamn</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grandTotal = 0;
                        if (count($productlist) > 0) {
                            foreach ($productlist as $k => $v) {
                                if (isset($_REQUEST['store_name']) && isset($v[$_REQUEST['store_name']])) {
                                    $integeralValue = floatval(str_replace(',', '', $v[$_REQUEST['store_name']]));
                                } else {
                                    $integeralValue = 0;
                                }
                                $grandTotal += $integeralValue;
                                $totalValueRow = number_format("$integeralValue", 2, ".", "");
                                ?>
                                <tr>
                                    <td><?= $v['QUANTITY'] ?></td>
                                    <td><?= $v['RSK_NO'] ?></td>
                                    <td><?= $v['PRO_NAME'] ?></td>                                  
                                    <td><?= $totalValueRow ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="11">
                                    Ingen produkt hittades !!
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3" style="text-align:right">
                                <b>Totalpris ex moms:</b>
                            </td>
                            <td><b>
                                    <?= number_format($grandTotal, 2, ".", "") ?></b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <center><b>Här kan du redigera fakturan eller spara den till PDF !</b></center>
            <div style="text-align:right; padding: 15px 0;">
                <a target="_blank" href="<?php echo site_url('list-invoice-edit') . '?action=pdf_export&company_name=' . $model->company_name . '&company_contact=' . $model->contact . '&' . http_build_query($_POST); ?>" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Redigera <i class="fa fa-pencil"></i></a>
                <a target="_blank" href="<?php echo site_url('pdf-export-invoice') . '?action=send_email&company_name=' . $model->company_name . '&company_contact=' . $model->contact . '&' . http_build_query($_POST); ?>" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Skicka E-post</a>
                <a target="_blank" href="<?php echo site_url('pdf-export-invoice') . '?action=pdf_export&company_name=' . $model->company_name . '&company_contact=' . $model->contact . '&' . http_build_query($_POST); ?>" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Spara PDF</a>
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