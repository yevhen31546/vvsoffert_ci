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
    .mst7{color:red;}
</style>
<div class="signup_screen forgot_password_screen">
    <h2 class="screen_title">Ändra lösenord</h2>
        <h3 class="page-title-small"> Du har begärt att återställa ditt lösenord.</h3>
    <?php
    if ($this->session->flashdata('error')) {
        echo '<div class="alert alert-danger">' . $this->session->flashdata("error") . '</div>';
    }
    ?>
    <div class="signup_form">
        <?php echo form_open(); ?>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="password" name="password" class="form-control" placeholder="Nytt lösenord" value="<?=$password?>">
                    <label for="password" class="fa fa-key" rel="tooltip" title="Nytt lösenord"></label>
                </div>
                <span class="mst7"><?php echo form_error('password') ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="password" name="cpassword" class="form-control" placeholder="Bekräfta nytt lösenord">
                    <label for="cpassword" class="fa fa-key" rel="tooltip" title="Bekräfta nytt lösenord"></label>
                </div>
                <span class="mst7"><?php echo form_error('cpassword') ?></span>
            </div>
            <div class="form-group text-center account_btn">
                 <div class="form-group">
                <a href="<?php echo site_url('logga-in'); ?>" class="">Tillbaka till login</a>
                </div>
                <input type="submit" name="reset" value="Återställ lösenord" class="reg-btn">
            </div>
            <div class="clearfix"></div>
        <?php echo form_close(); ?> 
    </div>  	
</div>


