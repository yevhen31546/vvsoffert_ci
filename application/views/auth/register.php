<div class="d-100vh-va-middle">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card-group">
        <div class="card p-2" style="background:none; border:none">
          <h1 class="text-center mb-1"><?php echo $this->config->item('site_name'); ?></h1>
          <div class="card-block" style="background:#fff; border:1px solid #d1d4d7">
            <h1>
              <?php page_title(); ?>
            </h1>
            <p class="text-muted">Submit the following details to set up your account.</p>
            <form action="<?php echo $action; ?>" method="post">
              <div class="form-group">
                <label for="varchar">First Name </label>
                <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter Your First Name" value="<?php echo $fname; ?>" autocomplete="off" />
                <?php echo form_error('fname') ?> </div>
              <div class="form-group">
                <label for="varchar">Last Name</label>
                <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Your Last Name" value="<?php echo $lname; ?>" autocomplete="off" />
                <?php echo form_error('lname') ?> </div>
              <div class="form-group">
                <label for="varchar">Email</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="We will send the confirmation to verify to your email. " value="<?php echo $email; ?>" autocomplete="off" />
                <?php echo form_error('email') ?> </div>
              <div class="form-group">
                <label for="varchar">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Used for login." value="<?php echo $username; ?>" autocomplete="off" />
                <?php echo form_error('username') ?> </div>
              <div class="form-group">
                <label for="varchar">Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?php echo $phone; ?>" autocomplete="off" />
                <?php echo form_error('phone') ?> </div>
              <div class="form-group">
                <label for="varchar">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
                <?php echo form_error('password') ?> </div>
              <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
