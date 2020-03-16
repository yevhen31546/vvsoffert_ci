<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="<?= site_url('admin/dashboard'); ?>">Admin</a> <a class="breadcrumb-item" href="<?= site_url('admin/calculator'); ?>">Plumbing Cost Calculator</a> <span class="breadcrumb-item active">Add Service</span>
        </nav>

        <div class="box">
            <div class="box-inner"> 
                <form action="" method="post">
                    <div class="box-title">
                        <h2>Add Plumbing Service</h2>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" id="create-group-btn" name="submit" value="save">Save</button>
                                <a href="<?php echo site_url('admin/calculator'); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label >Service Title <span class="required">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('title', '<span class="text-danger error-msg">', '</span>'); ?> 
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