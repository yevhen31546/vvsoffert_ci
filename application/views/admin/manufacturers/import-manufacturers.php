
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/dashboard'); ?>">Admin</a> 
            <a class="breadcrumb-item" href="<?php echo site_url('admin/manufacturers/index'); ?>">Manufacturers</a>
            <span class="breadcrumb-item active">Import Manufacturers</span>
        </nav>

        <div class="box">
            <div class="box-inner"> 
                <form id="import_manufacturers_file_form" name="import_manufacturers_file_form" method="post" action="<?php echo site_url('admin/manufacturers/import_manufacturers'); ?>" enctype="multipart/form-data">
                    <div class="box-title">
                        <h2>Import Manufacturers</h2>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" disabled="true" id="btn-submit" name="submit" value="save">Upload Manufacturers</button>
                                <a href="<?php echo base_url() . 'uploads/sample_excel/Manufacture_Sample_Excel.xlsx'; ?>" target="_blank" class="btn btn-warning" download="Manufacture_Sample_Excel.xlsx">Sample Excel File</a>
                                <a href="<?php echo site_url("admin/manufacturers/index"); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <?php show_session_message(); ?>      
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose File</label>
                                <div class="input-group cust-img-upload-btn" onclick="$('#import_manufacturers_file').click();">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Browse</span>
                                    <input type="text" disabled="true" class="form-control" id="manufacturers_file_name"/>
                                </div>
                                <input type="file" style="width: 0; height: 0;" name="import_manufacturers_file" id="import_manufacturers_file"/>
                                <div class="help-block"></div>
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