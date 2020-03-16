
<!-- /.page-title -->
<div class="container">
  <div class="row mb80">
    <div class="col-sm-6 offset-sm-3">
      <h3 class="page-title-small"> Submit your email address. You will receive new email to set your new password. </h3>
      <?php show_session_message(); ?>
       <?php echo form_open(); ?>
        <div class="form-group">
        	<div class="input-group mb-0"> <span class="input-group-addon"><i class="icon-user"></i> </span>
              <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email address." value="<?php echo $email; ?>" autocomplete="off" />
            </div> 
            <?php echo form_error('email') ?>          
        </div>       
        <button type="submit" class="btn btn-primary pull-right" name="reset" value="forgot password">Reset</button>
        <a href="<?php echo site_url('admin'); ?>" class="">Back To Login</a>
      <?php echo form_close(); ?> 
    </div>
    <!-- /.col-sm-4 --> 
  </div>
  <!-- /.row --> 
</div>
<!-- /.container-fluid -->


