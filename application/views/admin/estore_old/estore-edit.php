
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/estore'); ?>">E-Store</a> <span class="breadcrumb-item active">Create Store</span> </nav>

        <div class="box">
            <div class="box-inner"> 
                <form id="update_store_" name="update_store_" method="post" action="">
                    <div class="box-title">
                        <h2>Store Info : <?=  $storeInfo->name ?></h2>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" id="btn-submit" name="submit" value="save">Save</button>
                                <a href="<?php echo site_url('admin/estore'); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <?php show_session_message(); ?>      
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label >Name</label>
                                <input type="hidden" class="form-control" name="store_id" id="store_id" value="<?= trim($storeInfo->id) ?>"/>
                                <input type="text" class="form-control" name="name" id="estore-name" value="<?= trim($storeInfo->name) ?>" placeholder="Store Name"/>
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