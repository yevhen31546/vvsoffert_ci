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
<div style="padding: 0px 15px 0px 15px; border-left: none; border-right: none; max-width: 500px;" class="signup_screen">
    <div style="background: #18435f; text-align: center; padding-bottom: 10px; margin-bottom: 30px;" class="row hidden-xs">
        <h1 style="display: inline-flex; line-height: 40px; color: #ffffff;">Logga in&nbsp;<img src="<?php echo site_url('assets/img/logo.png'); ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="224" height="40">&nbsp;</h1>
    </div>

    <div style="background: #18435f; text-align: center; padding-bottom: 10px; margin-bottom: 30px;" class="row hidden-lg hidden-md hidden-sm">
        <h1 style="display: -webkit-inline-box; color: #ffffff;">Logga&nbsp;In&nbsp;<img src="<?php echo site_url('assets/img/logo.png'); ?>" style="width: 120px !important; height: 22px !important;" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist"></h1>
    </div>
    <br>
    <?php
    if ($this->session->flashdata('error')) {
        echo '<div class="alert alert-danger">' . $this->session->flashdata("error") . '</div>';
    }
    ?> 
    <br>
    <div class="signup_form">
        <!-- <form action="<?php //echo $this->config->item('base_url'); ?>login" method="post"> -->
        <form action="https://vvsoffert.se/logga-in" method="post">
            <?php show_session_message(); ?>
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                    <label style="font-size: 36px;" for="email" class="fa fa-envelope fa-2x" rel="tooltip" title="E-post"></label> 
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="text" placeholder="Ditt E-post" class="form-control" id="email" name="email">
                <span class="mst3"><?php echo form_error('email') ?></span>
            </div>
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                    <label style="font-size: 36px;" for="password" class="fa fa-lock fa-2x" rel="tooltip" title="Lösenord"></label>
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="password" placeholder="Ditt Lösenord" class="form-control" name="password" id="password">
                <span class="mst3"><?php echo form_error('password') ?></span>
            </div>
            <div class="col-md-12 col-xs-12" style="min-height: 40px;"></div>
            <div class="form-group text-center account_btn">
                <div class="form-group">
                <a href="<?= site_url('glomt-ditt-losenord')?>" class=""><span style="font-size: 18px;">Glömt ditt lösenord?</span></a>
                </div>
                <button style="background-color: #1e9f2e; color: #ffffff;" type="submit" name="sbmt" id="sbmt" class="btn btn-success"><b>Logga In</b> <i class="fa fa-sign-in-alt"></i></button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>  	
</div>
