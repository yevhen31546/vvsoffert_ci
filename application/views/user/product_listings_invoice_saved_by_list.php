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
        <form action="<?php echo site_url('list-invoice-save'); ?>" method='post'>
            <div class="section_content">
                <div class="table_header">
                    <div class='row'>
                        <div class="col-md-6">
                            <h2><?php echo $post["site_name"]; ?></h2>
                            <h4><?php echo $post["company_contact"] ?></h4>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <h2><?php echo $post["invoice_typeh"]; ?></h2>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6">
                            <p><?php echo $post["company_name"]; ?></p>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <p><?php echo $post["invoice_type"]; ?>#<?php echo $post["invoice_number"]; ?></p>
                            <p><?php echo $post["date_text"]; ?>:<?php echo $post["date_value"]; ?></p>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class="col-md-6">
                                <p><b><?php echo $post["customer_name_text"]; ?></b>: <?php echo $post["customer_name"]; ?></p>
                                <p><b><?php echo $post["email_text"]; ?></b>: <?php echo $post["email"]; ?></p>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                                <p><?php echo $post["address"]; ?></p>
                            <p>
                                    <?php echo $post["city"]; ?>
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <h3><?php echo $post["special_comments_text"]; ?></h3>
                            <?php echo $post["special_comments"]; ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered invoice-table">
                        <thead>
                            <tr>
                                <th><?php echo $post["quantity"]; ?></th>
                                <th><?php echo $post["rsk_number"]; ?></th>
                                <th><?php echo $post["productname"]; ?></th>
                                <th><?php echo $post["total"]; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            if (count($post['products']) > 0) {
                                foreach ($post['products'] as $k => $v) {
                                    if (isset($post['products'][$k]) && isset($post['products'][$k]['total'])) {
                                        $integeralValue = floatval(str_replace(',', '', $post['products'][$k]['total'])) * floatval(str_replace(',', '', $post['products'][$k]['quantity']));
                                    } else {
                                        $integeralValue = 0;
                                    }
                                    $grandTotal += $integeralValue;
                                    $totalValueRow = number_format("$integeralValue", 2, ".", "");
                                    ?>
                                    <tr>
                                        <td><?php echo $post['products'][$k]['quantity']; ?></td>
                                        <td><?php echo $post['products'][$k]['rsk_number']; ?></td>
                                        <td><?php echo $post['products'][$k]['productname']; ?></td>                                  
                                        <td><?php echo $totalValueRow; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="11">
                                        <?php echo $post["nofound"]; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3" style="text-align:right">
                                    <b>Totalpris ex moms</b>
                                </td>
                                <td><b>
                                        <?php echo number_format($grandTotal, 2, ".", ""); ?></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <center><b><?php echo $post["thanks_for_your_bussiness"]; ?></b></center>
                <div style="text-align:right; padding: 15px 0;">
                    <a href="<?php echo site_url('list-invoice-reedit') . '?' . http_build_query($_POST); ?>" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Edit</a>
                    <a target="_blank" href="<?php echo site_url('pdf-export-invoice-edited') . '?' . http_build_query($_POST); ?>" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Send Email</a>
                    <a target="_blank" href="<?php echo site_url('pdf-export-invoice-edited') . '?action=pdf_export&' . http_build_query($_POST); ?>" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Download as PDF</a>
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
        </form>
    </div>
</div>
<div class="clearfix"></div>
</div>