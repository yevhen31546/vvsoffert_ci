
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Admin</a> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/categories/index'); ?>">Categories</a>
            <span class="breadcrumb-item active">Import Categories</span>
        </nav>

        <div class="box">
            <div class="box-inner"> 
                <form id="import_categories_file_form" name="import_categoriess_file_form" method="post" action="<?php echo site_url('admin/categories/import_category'); ?>" enctype="multipart/form-data">
                    <div class="box-title">
                        <h2>Import Categories</h2>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" disabled="true" id="btn-submit" name="submit" value="save">Upload Categories</button>
                                <a href="<?php echo base_url() . 'uploads/sample_excel/Category_Sample_Excel.xlsx'; ?>" target="_blank" class="btn btn-warning" download="Category_Sample_Excel.xlsx">Sample Excel File</a>
                                <a href="<?php echo site_url("admin/categories/index"); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <?php show_session_message(); ?>      
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose File</label>
                                <div class="input-group cust-img-upload-btn" onclick="$('#import_categories_file').click();">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Browse</span>
                                    <input type="text" disabled="true" class="form-control" id="categories_file_name"/>
                                </div>
                                <input type="file" style="width: 0; height: 0;" name="import_categories_file" id="import_categories_file"/>
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12 col-md-12">
                            <div class="alert alert-info text-center" role="alert">
                                <strong style="font-weight: 600; font-size: 15px;">Note: Upload section only except Excel files.</strong>
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