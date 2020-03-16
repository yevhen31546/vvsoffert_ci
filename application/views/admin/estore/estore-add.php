
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/estore'); ?>">E-Store</a> <span class="breadcrumb-item active">Create Store</span> </nav>

        <div class="box">
            <div class="box-inner"> 
                <form method="post" enctype='multipart/form-data' action="<?php echo site_url('admin/estore/create'); ?>">
                    <div class="box-title">
                        <h2>Add New Store</h2>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" value="save">Save</button>
                                <a href="<?php echo site_url('admin/estore'); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <?php show_session_message(); ?>
                    <div class="form-group">
                        <label>Logo <span class="required">*</span></label>
                        <div class="thumbnail">
                            <input type='file' name='logoFile' size='100' />
                        </div>
                        <?php echo form_error('logoFile', '<span class="text-danger error-msg">', '</span>'); ?>
                        <!-- <span class="text-danger error-msg" id="err_logoFile"></span> -->
                    </div> 
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label >Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Store Name"/>
                                <div class="help-block"></div>
                                <?php echo form_error('name', '<span class="text-danger error-msg">', '</span>'); ?>
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