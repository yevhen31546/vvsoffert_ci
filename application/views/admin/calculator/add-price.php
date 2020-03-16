<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="<?= site_url('admin/dashboard'); ?>">Admin</a> <a class="breadcrumb-item" href="<?= site_url('admin/calculator'); ?>">Plumbing Cost Calculator</a> <span class="breadcrumb-item active">Add Service Price</span>
        </nav>

        <div class="box">
            <div class="box-inner"> 
                <form action="" method="post">
                    <div class="box-title">
                        <h2>Add Plumbing Service Price</h2>
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
                                <label>Select Service <span class="required">*</span></label>
                                <select class="form-control" id="psId" name="psId">
                                <?php 
                                foreach($all_plumbing_services as $ps)
                                {
                                    $selected = ($ps['id'] == $this->input->post('psId')) ? ' selected="selected"' : "";

                                    echo '<option value="'.$ps['id'].'" '.$selected.'>'.$ps['title'].'</option>';
                                } 
                                ?>
                                </select>
                                <?php echo form_error('psId', '<span class="text-danger error-msg">', '</span>'); ?>                            </div>
                            <div class="form-group">
                                <label>RSK Number <span class="required">*</span></label>
                                <input type="text" class="form-control" id="rskNumber" name="rskNumber" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('rskNumber', '<span class="text-danger error-msg">', '</span>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Job Title <span class="required">*</span></label>
                                <input type="text" class="form-control" id="jobTitle" name="jobTitle" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('jobTitle', '<span class="text-danger error-msg">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Job Description</label>
                                <input type="text" class="form-control" id="jobDescription" name="jobDescription" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('jobDescription', '<span class="text-danger error-msg">', '</span>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Time <span class="required">*</span></label>
                                <input type="text" class="form-control" id="time" name="time" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('time', '<span class="text-danger error-msg">', '</span>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Price <span class="required">*</span></label>
                                <input type="text" class="form-control" id="price" name="price" value=""/>
                                <div class="help-block"></div>
                                <?php echo form_error('price', '<span class="text-danger error-msg">', '</span>'); ?>
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