<script type="text/javascript">
    $(document).ready(function () {
<?php if ($this->session->flashdata('warning')) { ?>
            $.growl.warning({title: "Warning", message: "<?php echo $this->session->flashdata('warning'); ?>"});
<?php } elseif ($this->session->flashdata('welcome')) { ?>
            $.growl.notice({title: "Welcome", message: "<?php echo $this->session->flashdata('welcome'); ?>"});
<?php } elseif ($this->session->flashdata('error')) { ?>
            $.growl.error({title: "Error", message: "<?php echo $this->session->flashdata('error'); ?>"});
<?php } elseif ($this->session->flashdata('success')) { ?>
            $.growl.notice({title: "Success", message: "<?php echo $this->session->flashdata('success'); ?>"});
<?php } ?>
    });
</script>
<style>
    .mst8{max-width: 100% !important;}
</style>
<div class="container">
<div class="signup_screen mst8">
    <h2 class="screen_title">Licensvillkor</h2>
    <div>
    <?php
echo $cmsInfo->content;
?>    
    </div>
    
</div>
</div>
