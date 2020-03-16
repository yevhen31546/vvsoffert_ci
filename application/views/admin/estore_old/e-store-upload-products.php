
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="#">Admin</a> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/estore/index'); ?>">E-Store</a>
            <?php if (isset($storeInfo) && count($storeInfo) > 0) : ?>
                <span class="breadcrumb-item active"><?= ucwords($storeInfo->name) ?></span>
            <?php endif; ?>
        </nav>

        <div class="box">
            <div class="box-inner"> 
                <form id="upload_store_products" name="upload_store_products" method="post" action="<?php echo site_url('admin/estore/upload_product'); ?>" enctype="multipart/form-data">
                    <div class="box-title">
                        <h2>Store Info : <?= ucwords($storeInfo->name) ?></h2>
                        <div class="pull-right">
                            <div class="cust-dropdown">
                                <a href="#" class="cust-dropdown-toggle">Sample Excel File</a>
                                <ul class="cust-dropdown-menu">
                                    <li><a href="<?php echo base_url() . 'uploads/sample_excel/import_and_sync_price_for_rsk_no.xlsx'; ?>" target="_blank" class="" download="sample_store_product_excel.xlsx">Upload E-store product Excel</a></li>
                                    <li><a href="<?php echo base_url() . 'uploads/sample_excel/import_and_sync_price_for_rsk_no.xlsx'; ?>" target="_blank" class="" download="import_and_sync_price_for_rsk_no.xlsx">Sync Price Excel</a></li>
                                    <li><a href="<?php echo base_url() . 'uploads/sample_excel/import_and_sync_discount_price_for_rsk_no.xlsx'; ?>" target="_blank" class="" download="import_and_sync_discount_price_for_rsk_no.xlsx">Sync Discount Price Excel</a></li>
                                    <li><a href="<?php echo base_url() . 'uploads/sample_excel/import_and_sync_name_for_rsk_no.xlsx'; ?>" target="_blank" class="" download="import_and_sync_name_for_rsk_no.xlsx">Sync Name Excel</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <!--<a href="<?php // echo base_url() . 'uploads/sample_excel/sample_store_product_excel.xlsx';      ?>" target="_blank" class="btn btn-warning" download="sample_store_product_excel.xlsx">Sample Excel File</a>-->
                                <button type="submit" class="btn btn-success" disabled="true" id="btn-submit" name="submit" value="save">Upload Product</button>
                                <a href="<?php echo site_url("admin/estore/estore_data/$storeInfo->id/$storeInfo->name"); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <?php show_session_message(); ?>      
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose Import Type</label>
                                <select class="form-control" id="pro_import_type" name="pro_import_type">
                                    <option value="">Select Import Type</option>
                                    <option value="0">Upload E-store Products</option>
                                    <option value="1">Update price for RSK no</option>
                                    <option value="2">Update discount price for RSK no</option>
                                    <option value="3">Update name for RSK no</option>
                                </select>
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose File</label>
                                <div class="input-group cust-img-upload-btn" onclick="$('#product_file').click();">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Browse</span>
                                    <input type="text" disabled="true" class="form-control" id="product_file_name"/>
                                </div>
                                <input type="hidden" name="store_id" id="store_id" value="<?= $storeInfo->id ?>"/>
                                <input type="file" style="width: 0; height: 0;" name="product_file" id="product_file"/>
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12 col-md-12">
                            <div class="alert alert-info text-center" role="alert">
                                <strong style="font-weight: 600; font-size: 15px;">Note: Upload section only except Excel files.</strong>
                                <p>(You can upload 15,000 record at a time. Other wish script doesn't work properly)</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box --> 
    </div>
    <!-- /.container --> 
</div>
<!-- /.admin-content -->