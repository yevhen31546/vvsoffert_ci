
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/estore'); ?>">E-Store</a> <span class="breadcrumb-item active">Update Store</span> </nav>

        <div class="box">
            <div class="box-inner"> 
                <form id="update_store_" enctype='multipart/form-data' name="update_store_" method="post" action="">
                    <div class="box-title">
                        <h2>Edit E-Store: <?=  $storeInfo->name ?></h2>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" id="btn-submit" name="submit" value="save">Save</button>
                                <a href="<?php echo site_url('admin/estore'); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <?php show_session_message(); ?>    
                    <div class="form-group">
                        <label>Logo <span class="required">*</span></label>
                        <div class="thumbnail">
                            <?php if(file_exists($storeInfo->logoImage)){?>
                                 <img src="<?php echo site_url($storeInfo->logoImage); ?>" class="img-squared" alt="<?php echo $storeInfo->logoImage; ?>" style="width:100px; height: 60px;">
                             <?php }else{ ?>
                                 <img src="http://www.vvsoffert.se/scraper/<?php echo $storeInfo->logoImage; ?>" class="img-squared" alt="<?php echo $storeInfo->logoImage; ?>" style="width:100px; height: 60px;">
                                 
                             <?php }
                             ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='file' name='logoFile' size='100' />
                        </div>
                        <?php echo form_error('logoFile', '<span class="text-danger error-msg">', '</span>'); ?>
                    </div>   
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label >Name <span class="required">*</span></label>
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