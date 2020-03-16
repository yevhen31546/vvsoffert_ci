<div class="alert alert-<?php echo (isset($type) and $type==2)?'danger':'success'; ?> alert-dismissible" role="alert">  
  <strong><?php echo $title; ?>!</strong> <br>
<?php echo $content; ?> </div>