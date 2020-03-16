<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/groups'); ?>">Groups</a> <span class="breadcrumb-item active">Edit Group</span> </nav>

        <div class="box">
            <div class="box-inner"> 
                <form id="create-group" method="post" name="create-group" enctype="multipart/form-data">
                    <div class="box-title">
                        <h2>Create Group</h2>
                        <div class="pull-right">
                            <label class="form-check-label">
                                <button type="submit" class="btn btn-success" id="create-group-btn" name="submit" value="save">Save</button>
                                <a href="<?php echo site_url('admin/groups'); ?>" class="btn btn-info">Back</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.box-title -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label >Name</label>
                                <input type="text" class="form-control" id="group_name" name="group_name" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('name') ?> 
                            </div>
                            <div class="form-group">
                                <label>Group Image</label>
                                <div class="input-group cust-img-upload-btn" onclick="$('#group_image').click();">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Browse</span>
                                    <input type="text" disabled="true" class="form-control" id="group_image_name"/>
                                </div>
                                <input type="file" style="width: 0; height: 0;" name="group_image" id="group_image"/>
                                <div class="help-block"></div>
                                <?php echo form_error('group_image') ?> 
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="clearfix view_upload_image" id="view_upload_image">
                                <img class="img-preview img-responsive noDisplay" src="" id="upload_preview_img"/>
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