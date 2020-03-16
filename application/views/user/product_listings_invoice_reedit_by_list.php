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
                            <h2><input type="text" name="site_name" value="<?php echo $post['site_name']; ?>"/></h2>
                            <!--<h4><input type="text" name="site_decription" value="<?php echo $post['site_decription']; ?>"/></h2>-->
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <h2><input type="text" name="invoice_typeh" value="<?php echo $post['invoice_typeh']; ?>" /></h2>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6">
                            <p><input type="text" name="company_name" value="<?php echo $post['company_name']; ?>"/></p>
                            <p><input type="text" name="company_contact" value="<?php echo $post['company_contact'] ? $post['company_contact'] : ''; ?>"/></p>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <p><input type="text" name="invoice_type" value="<?php echo $post['invoice_type']; ?>"/>#<input type="text" name="invoice_number" value="<?php echo $post['invoice_number']; ?>"/></p>
                            <p><input type="text" name="date_text" value="<?php echo $post['date_text']; ?>"/>:<input type="text" name="date_value" value="<?php echo $post['date_value']; ?>"/></p>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class="col-md-6">
                            <p><b><input type="text" name="customer_name_text" value="<?php echo $post['customer_name_text']; ?>"/></b>: <input type="text" name="customer_name" value="<?php echo $post['customer_name']; ?>"/></p>
                            <p><b><input type="text" name="email_text" value="<?php echo $post['email_text']; ?>" /></b>: <input type="text" name="email" value="<?php echo $post['email']; ?>" /></p>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <p><input type="text" name="address" value="<?php echo $post['address']; ?>"/></p>
                            <p>
                                <input type="text" name="city" value="<?php echo $post['city']; ?>"/>
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <h3><input type="text" name="special_comments_text" value="<?php echo $post['special_comments_text']; ?>"/></h3>
                    <p> 
                        <input type="text" name="special_comments" value="<?php echo $post['special_comments']; ?>"/>
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered invoice-table">
                        <thead>
                            <tr>
                                <th><input type="text" name="quantity" value="<?php echo $post['quantity']; ?>"/></th>
                                <th><input type="text" name="rsk_number" value="<?php echo $post['rsk_number']; ?>"/></th>
                                <th><input type="text" name="productname" value="<?php echo $post['productname']; ?>"/></th>
                                <th><input type="text" name="total" value="<?php echo $post['total']; ?>"/></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            if (count($post['products']) > 0) {
                                foreach ($post['products'] as $k => $v) {
                                    if (isset($post['products'][$k]) && isset($post['products'][$k]['total'])) {
                                        $integeralValue = floatval(str_replace(',', '', $post['products'][$k]['total']));
                                    } else {
                                        $integeralValue = 0;
                                    }
                                    $grandTotal += $integeralValue;
                                    $totalValueRow = number_format("$integeralValue", 2, ".", "");
                                    ?>
                                    <tr>
                                        <td><input type="text" name="products[<?php echo $k; ?>][quantity]" value="<?php echo $v['quantity']; ?>"/></td>
                                        <td><input type="text" name="products[<?php echo $k; ?>][rsk_number]" value="<?php echo $v['rsk_number']; ?>"/></td>
                                        <td><input type="text" name="products[<?php echo $k; ?>][productname]" value="<?php echo $v['productname']; ?>"/></td>                                  
                                        <td><input type="hidden" name="products[<?php echo $k; ?>][total]" value="<?= $totalValueRow ?>"/><?= $totalValueRow ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="11">
                                        <input type="text" name="nofound" value="<?php echo $post['nofound']; ?>" />
                                    </td>
                                </tr>
                            <?php } ?>
<!--                            <tr>
            <td colspan="3" style="text-align:right">
                <b><input type="text" name="grand_total_text" value=<?php echo $post['grand_total_text']; ?>"/></b>
            </td>
            <td><b>
                    <input type="text" name="grand_total" value="<?php echo $post['grand_total']; ?>"/></b>
            </td>
        </tr>-->
                        </tbody>
                    </table>
                </div>
                <input name="getParams" value="<?php echo $post['getParams']; ?>" type="hidden"/>
                <center><b><input type="text" name="thanks_for_your_bussiness" value="<?php echo $post['thanks_for_your_bussiness']; ?>"/></b></center>
                <div style="text-align:right; padding: 15px 0;">
                    <button type="submit" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Save</button>
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