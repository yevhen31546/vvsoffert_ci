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
                        <h4>Här kan du jämföra vvsartiklar, pris, lagersaldo från grossister.</h2>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                        <h2>Inovice</h2>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-6">
                        <p>Street Address:</p>
                        <p>P ST zip city state country</p>
                        <p>Phone: Phone, Fax: fax</p>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                        <p>Invoice#<?php echo(rand(1, 1000)); ?></p>
                        <p>Date:<?php echo date('Y-m-d H:i:s'); ?></p>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class="col-md-6">
                        <?php if (isset($_REQUEST['name']) || isset($_REQUEST['last_name'])) { ?>
                            <p><b>Customer Name</b>: <?php echo isset($_REQUEST['name']) ? $_REQUEST['name'] : ''; ?> <?php echo isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : ''; ?></p>
                        <?php } ?>
                        <?php if (isset($_REQUEST['contact'])) { ?>
                            <p><b>Telphone</b>: <?php echo isset($_REQUEST['contact']) ? $_REQUEST['contact'] : ''; ?></p>
                        <?php } ?>
                        <?php if (isset($_REQUEST['email'])) { ?>
                            <p><b>Email</b>: <?php echo isset($_REQUEST['email']) ? $_REQUEST['email'] : ''; ?></p>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <?php if (isset($_REQUEST['address'])) { ?>
                            <p><?php echo $_REQUEST['address']; ?></p>
                        <?php } ?>
                        <p>
                            <?php if (isset($_REQUEST['city'])) { ?>
                                <?php echo $_REQUEST['city']; ?>
                            <?php } ?> 
                            <?php if (isset($_REQUEST['zip'])) { ?>
                                <?php echo $_REQUEST['zip']; ?>
                            <?php } ?>
                        </p>
                        <p>
                            <?php if (isset($_REQUEST['state'])) { ?>
                                <?php echo $_REQUEST['state'] ?>
                            <?php } ?> 
                            <?php if (isset($_REQUEST['country'])) { ?>
                                <?php echo $_REQUEST['country']; ?>
                            <?php } ?>
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <h3>Special Comments</h3>
                <p> <?php if (isset($_REQUEST['special_comments'])) { ?>
                        <?php echo $_REQUEST['special_comments']; ?>
                    <?php } ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered invoice-table">
                    <thead>
                        <tr>
                            <th>QUANTITY</th>
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
                                $totalValueRow = number_format("$integeralValue", 2, ".", ",");
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
                                <b>Grand Total:</b>
                            </td>
                            <td><b>
                                    <?= $grandTotal ?></b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <center><b>Thanks for Your Bussiness</b></center>
            <div style="text-align:right; padding: 15px 0;">
                <a href="#" class="reg-btn">Send Email</a>
                <a href="#" class="reg-btn">Download as PDF</a>
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