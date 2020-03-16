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
    .mst3{color:red;}
</style>
<div class="signup_screen">
    <h2 class="screen_title">Logga in</h2>
    <?php
    if ($this->session->flashdata('error')) {
        echo '<div class="alert alert-danger">' . $this->session->flashdata("error") . '</div>';
    }
    ?>
    <div class="signup_form">
        <form action="<?php echo $this->config->item('base_url'); ?>login" method="post">
            <?php show_session_message(); ?>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="text" placeholder="E-post" class="form-control" id="email" name="email">
                    <label for="email" class="fa fa-envelope" rel="tooltip" title="E-post"></label>

                </div>
                <span class="mst3"><?php echo form_error('email') ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="password" placeholder="Lösenord" class="form-control" name="password" id="password">
                    <label for="password" class="fa fa-lock" rel="tooltip" title="Lösenord"></label>
                </div>
                <span class="mst3"><?php echo form_error('password') ?></span>
            </div>
            <div class="form-group text-center account_btn">
                <div class="form-group">
                <a href="<?= site_url('forgot-password')?>" class="">Glömt ditt lösenord?</a>
                </div>
                <input type="submit" name="sbmt" id="sbmt" class="reg-btn" value="Logga in">
            </div>
            <div class="clearfix"></div>
        </form>
    </div>  	
</div>
