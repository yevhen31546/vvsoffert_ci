
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="<?= site_url('admin/dashboard'); ?>">Admin</a> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/estore/index'); ?>">E-Store</a>
            <?php if (isset($storeInfo) && !empty($storeInfo)) : ?>
                <span class="breadcrumb-item active"><?= ucwords($storeInfo->name); ?></span>
            <?php endif; ?>
        </nav>

        <div class="box">
            <div class="box-inner"> 
                <form id="upload_store_products" name="upload_store_products" method="post" action="<?php echo site_url('admin/estore/upload_product'); ?>" enctype="multipart/form-data">
                    <div class="box-title">
                        <h2>E-Store: <?= ucwords($storeInfo->name) . ' -> Send Excel File By Email'; ?></h2>
                        <div class="pull-right">
                                <a href="<?php echo base_url() . 'uploads/sample_excel/sample_e_store_mail_excel.xlsx'; ?>" target="_blank" class="btn btn-primary" download="sample_e_store_mail_excel.xlsx">Sample Mail Excel File</a>
                        </div>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" id="btn-submit" name="submit" value="save">Send Email</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url("admin/estore/estore_data/$storeInfo->id/$storeInfo->name"); ?>" class="btn btn-info">Back</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <?php show_session_message(); ?>    
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Send To ( Email Address ) <span class="required">*</span></label>
                                <input type="text" class="form-control" id="emailTo" name="emailTo" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('emailTo', '<span class="text-danger error-msg">', '</span>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Email Subject <span class="required">*</span></label>
                                <input type="text" class="form-control" id="emailSubject" name="emailSubject" value="VVSOFFERT.SE: Fix E-Store Product Data"/>
                                <div class="help-block"></div>
                                <?php echo form_error('emailSubject', '<span class="text-danger error-msg">', '</span>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Excel File <span class="required">*</span></label>
                                <input type="file" id="excelFile" name="excelFile" size="100" />
                                <div class="help-block"></div>
                                <?php echo form_error('excelFile', '<span class="text-danger error-msg">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Email Body (Message) </label>
                                <textarea style="width: 100%;" rows="9" id="emailBody" name="emailBody"><?= "Hello there,\n\nThis is a regular notification for you to check if your E-Store products data and fix or update the information if necessary.\n\nAn Excel File is attached below where you can find the products data.\n\nSincerely,\nVVSOFFERT.SE  Support Team.";  ?></textarea>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
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