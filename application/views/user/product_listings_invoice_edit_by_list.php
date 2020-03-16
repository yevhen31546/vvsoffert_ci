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
                            <h2><input type="text" name="site_name" value="VVS OFFERT"/></h2>
                            <!--<h4><input type="text" name="site_decription" value="Här kan du jämföra vvsartiklar, pris, lagersaldo från grossister."/></h2>-->
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <h2><input type="text" name="invoice_typeh" value="<?php echo isset($_GET['invoice_type']) ? $_GET['invoice_type'] : ''; ?>" /></h2>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6">
                            <p><input type="text" name="company_name" value="<?php echo $model->company_name; ?>"/></p>
                            <p><input type="text" name="company_contact" value="<?php echo $model->contact ?>"/></p>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <p><input type="text" name="invoice_type" value="<?php echo isset($_GET['invoice_type']) ? $_GET['invoice_type'] : ''; ?>"/>#<input type="text" name="invoice_number" value="<?php echo isset($_GET['invoice_number']) ? $_GET['invoice_number'] : ''; ?>"/></p>
                            <p><input type="text" name="date_text" value="Date"/>:<input type="text" name="date_value" value="<?php echo date('Y-m-d H:i:s'); ?>"/></p>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class="col-md-6">
                            <p><b><input type="text" name="customer_name_text" value="Customer Name"/></b>: <input type="text" name="customer_name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>"/></p>
                            <p><b><input type="text" name="email_text" value="Email" /></b>: <input type="text" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>" /></p>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <p><input type="text" name="address" value="<?php echo $_GET['address']; ?>"/></p>
                            <p>
                                <input type="text" name="city" value="<?php echo $_GET['city']; ?>"/>
                            </p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <h3><input type="text" name="special_comments_text" value="Special Comments"/></h3>
                    <p> 
                        <input type="text" name="special_comments" value="<?php echo $_GET['special_comments']; ?>"/>
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered invoice-table">
                        <thead>
                            <tr>
                                <th><input type="text" name="quantity" value="Antal"/></th>
                                <th><input type="text" name="rsk_number" value="RSK NUMMER"/></th>
                                <th><input type="text" name="productname" value="Produktnamn"/></th>
                                <th><input type="text" name="total" value="Total"/></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            if (count($productlist) > 0) {
                                foreach ($productlist as $k => $v) {
                                    if (isset($_GET['store_name']) && isset($v[$_GET['store_name']])) {
                                        $integeralValue = floatval(str_replace(',', '', $v[$_GET['store_name']]));
                                    } else {
                                        $integeralValue = 0;
                                    }
                                    $grandTotal += $integeralValue;
                                    $totalValueRow = number_format("$integeralValue", 2, ".", "");
                                    ?>
                                    <tr>
                                        <td><input type="text" name="products[<?php echo $k; ?>][quantity]" value="<?= $v['QUANTITY'] ?>"/></td>
                                        <td><input type="text" name="products[<?php echo $k; ?>][rsk_number]" value="<?= $v['RSK_NO'] ?>"/></td>
                                        <td><input type="text" name="products[<?php echo $k; ?>][productname]" value="<?= $v['PRO_NAME'] ?>"/></td>                                  
                                        <td><input type="hidden" name="products[<?php echo $k; ?>][total]" value="<?= $totalValueRow ?>"/><?= $totalValueRow ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="11">
                                        <input type="text" name="nofound" value="Ingen produkt hittades !!" />
                                    </td>
                                </tr>
                            <?php } ?>
<!--                            <tr>
                    <td colspan="3" style="text-align:right">
                        <b><input type="text" name="grand_total_text" value="Totalpris ex moms:"/></b>
                    </td>
                    <td><b>
                            <input type="text" name="grand_total" value="<?= number_format($grandTotal, 2, ".", "") ?>"/></b>
                    </td>
                </tr>-->
                        </tbody>
                    </table>
                </div>
                <input name="getParams" value="<?php echo http_build_query($_GET); ?>" type="hidden"/>
                <center><b><input type="text" name="thanks_for_your_bussiness" value="Thanks for Your Bussiness"/></b></center>
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