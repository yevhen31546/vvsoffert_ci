
<div class="admin-content">
  <div class="container">
    <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <span class="breadcrumb-item active">Profile</span> </nav>
    
    <!-- /.stats --> 
    
    <!-- /.box -->
    <div class="box">
      <div class="box-inner">
        <div class="box-title">
          <h2>Admin Profile</h2>
        </div>
        <!-- /.box-title -->
        <div class="row">
          <div class="col-lg-6"> <?php echo form_open(); ?>
            <div class="form-group">
              <label for="exampleInputEmail1">Website Name</label>
              <input type="text" class="form-control" name="sitename" value="<?php echo set_value('sitename',html_entity_decode($userInfo->sitename)); ?>">
              <?php echo form_error('sitename') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" name="email" value="<?php echo set_value('email',$userInfo->email); ?>">
              <?php echo form_error('email') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" name="username" value="<?php echo set_value('username',html_entity_decode($userInfo->username)); ?>">
              <?php echo form_error('username') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Current Password</label>
              <input type="password" class="form-control" name="password">
              <?php echo form_error('password') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">New Password</label>
              <input type="password" class="form-control" name="npassword" value="<?php echo set_value('npassword'); ?>">
              <?php echo form_error('npassword') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Confirm Password</label>
              <input type="password" class="form-control" name="cpassword" value="<?php echo set_value('cpassword'); ?>">
              <?php echo form_error('cpassword') ?>
            </div>
            <div class="form-group">
              <label for="exampleTextarea">Footer Copyrights</label>
              <textarea class="form-control" rows="3" name="copyrights"><?php echo set_value('copyrights',html_entity_decode($userInfo->copyrights)); ?></textarea>
              <?php echo form_error('copyrights') ?>
            </div>
            <div class="form-group">
              <label class="form-check-label">
                <button type="submit" class="btn btn-primary" name="submit" value="save">Submit</button>
              </label>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.box-inner --> 
    </div>
    <!-- /.cards-wrapper --> 
    
    <!-- /.box --> 
  </div>
  <!-- /.container --> 
</div>
<!-- /.admin-content -->