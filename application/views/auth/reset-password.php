
<!-- /.page-title -->
<div class="container">
  <div class="row mb80">
    <div class="col-sm-4 offset-sm-4">
      <h3 class="page-title-small"> You have requested to reset your password.</h3>
      <?php show_session_message(); ?>
       <?php echo form_open(); ?>
        <div class="form-group">               
           <input type="password" name="password" class="form-control" placeholder="New Password">
          <?php echo form_error('password') ?>
        </div>
        <!-- /.form-group -->
        <div class="form-group">
          <label for="login-form-password">Password</label>
          <input type="password" name="cpassword" class="form-control" placeholder="Confirm New Password">
          <?php echo form_error('cpassword') ?>
        </div>
        <!-- /.form-group -->
        <button type="submit" class="btn btn-primary pull-right" name="reset" value="reset password">Reset Password</button>
        <a href="<?php echo site_url('admin'); ?>" class="">Back To Login</a>
      <?php echo form_close(); ?> 
    </div>
    <!-- /.col-sm-4 --> 
  </div>
  <!-- /.row --> 
</div>
<!-- /.container-fluid -->



