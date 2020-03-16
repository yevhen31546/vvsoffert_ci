<!-- /.page-title -->
<div class="container">
  <div class="row mb80">
    <div class="col-sm-4 offset-sm-4">
      <h3 class="page-title-small"> Sign In to your account </h3>
      <?php show_session_message(); ?>
       <?php echo form_open(); ?>
        <div class="form-group">
          <label for="login-form-email">Username</label>
          <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" autocomplete="off">
          <?php echo form_error('username') ?>
        </div>
        <!-- /.form-group -->
        <div class="form-group">
          <label for="login-form-password">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Password" value="">
           <?php echo form_error('password') ?>
        </div>
        <!-- /.form-group -->
        <button type="submit" class="btn btn-primary pull-right"  name="login" value="login">Login</button>
        <a href="<?php echo site_url('admin/forgot-password'); ?>" class="">Forgot password?</a>
      <?php echo form_close(); ?> 
    </div>
    <!-- /.col-sm-4 --> 
  </div>
  <!-- /.row --> 
</div>
<!-- /.container-fluid -->


