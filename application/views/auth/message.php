<div class="d-100vh-va-middle">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card-group">
        <div class="card p-2" style="background:none; border:none">
          <h1 class="text-center mb-1"><?php echo $this->config->item('site_name'); ?></h1>
          <div class="card-block" style="background:#fff; border:1px solid #d1d4d7">
            <h1 class="text-<?php echo (isset($message['type']) and $message['type']==2)?'danger':'success'; ?>">
              <?php echo $message['title']; ?>
            </h1>
            <p><?php echo $message['content']; ?></p>
            <p><a href="<?php echo site_url('admin/login'); ?>">Back to Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
