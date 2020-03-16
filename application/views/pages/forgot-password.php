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
    .mst2{color:red;}
</style>
<div class="signup_screen forgot_password_screen">
    <h2 class="screen_title">Glömt ditt lösenord</h2>
        <h3 class="page-title-small"> Skicka in din e-postadress. Du kommer att få ny e-post för att ange ditt nya lösenord. </h3>
    <?php
    if ($this->session->flashdata('error')) {
        echo '<div class="alert alert-danger">' . $this->session->flashdata("error") . '</div>';
    }
    ?>
    <div class="signup_form">
        <?php echo form_open(); ?>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="text" placeholder="E-post" class="form-control" id="email" name="email" value="<?=$email?>">
                    <label for="email" class="fa fa-envelope" rel="tooltip" title="E-post"></label>

                </div>
                <span class="mst2"><?php echo form_error('email') ?></span>
            </div>
            <div class="form-group text-center account_btn">
                 <div class="form-group">
                <a href="<?php echo site_url('login'); ?>" class="">Tillbaka till login</a>
                </div>
                <input type="submit" name="reset" value="glömt ditt lösenord" class="reg-btn">
            </div>
            <div class="clearfix"></div>
        <?php echo form_close(); ?> 
    </div>  	
</div>



