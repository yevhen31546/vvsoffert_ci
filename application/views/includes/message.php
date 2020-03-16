<?php
if (isset($type) and $type == 0) {
    $class = "warning";
} elseif (isset($type) and $type == 2) {
    $class = "danger";
} else {
    $class = "success";
}
?>
<div class="alert alert-<?php echo $class; ?> alert-dismissible" role="alert">  
    <strong><?php echo $title; ?>!</strong> <br>
    <?php echo $content; ?> 
</div>