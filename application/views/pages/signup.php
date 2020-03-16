<div style="padding: 0px 15px 0px 15px; border-left: none; border-right: none; max-width: 530px;" class="signup_screen">
    <div style="background: #18435f; text-align: center; padding-bottom: 10px; margin-bottom: 30px;" class="row hidden-xs">
        <h1 style="display: inline-flex; line-height: 40px; color: #ffffff;">Prova&nbsp;<img src="<?php echo site_url('assets/img/logo.png'); ?>" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist" width="224" height="40">&nbsp;Gratis I 14 Dagar</h1>
    </div>

    <div style="background: #18435f; text-align: center; padding-bottom: 10px; margin-bottom: 30px;" class="row hidden-lg hidden-md hidden-sm">
        <h1 style="display: -webkit-inline-box; color: #ffffff;">Prova&nbsp;<img src="<?php echo site_url('assets/img/logo.png'); ?>" style="width: 100px !important; height: 22px !important;" class="img-responsive" alt="Vvs offert | Rörkalkyl | Vvskalkyl | Anbud | Vvspriser |Vvsoffert | Vvs online | Rörgrossist">&nbsp;Gratis I 14 Dagar</h1>
    </div>
    <br>
    <?php
    if ($this->session->flashdata('error')) {
        echo '<div class="alert alert-danger">' . $this->session->flashdata("error") . '</div>';
    }
    ?>
    <br>
    <div class="signup_form">
        <form name="sign_up_form" id="sign_up_form" method="post">
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                <label style="font-size: 36px;" for="name" class="fa fa-user fa-2x" rel="tooltip" title="Förnamn"></label>
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="text" placeholder="Ditt Namn" class="form-control" id="name" name="name" autocomplete="off">
                <span class="text-danger error-msg" id="err_name"></span>
            </div>
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                <label style="font-size: 36px;" for="email" class="fa fa-phone" rel="tooltip" title="Telefon"></label>
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="text" placeholder="Ditt Telefon Nummer" class="form-control" id="contact" name="contact" autocomplete="off">
                <span class="text-danger error-msg" id="err_contact"></span>
            </div>
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                <label style="font-size: 36px;" for="email" class="fa fa-envelope" rel="tooltip" title="E-post"></label>
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="text" placeholder="Ditt E-post" class="form-control" id="email" name="email" autocomplete="off">
                <span class="text-danger error-msg" id="err_email"></span>
            </div>
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                <label style="font-size: 36px;" for="email" class="fa fa-lock" rel="tooltip" title="Lösenord"></label>
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="password" placeholder="Skriv In Lösenord" class="form-control" id="password" name="password" autocomplete="off">
                <span class="text-danger error-msg" id="err_password"></span>
            </div>
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                <label style="font-size: 36px;" for="email" class="fa fa-lock" rel="tooltip" title="Bekräfta lösenord"></label>
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="password" placeholder="Bekräfta Lösenord" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off">
                <span class="text-danger error-msg" id="err_confirm_password"></span>
            </div>
            <div style="padding: 5px; background: #d1d3d5; text-align: center; color: #18435f; margin-bottom: 25px;" class="form-group col-xs-2 col-md-2">
                <label style="font-size: 36px;" for="email" class="fa fa-id-badge" rel="tooltip" title="Org.Nr"></label>
            </div>
            <div style="padding: 0px; margin-bottom: 25px;" class="form-group col-xs-10 col-md-10">
                <input type="text" placeholder="Ange Organisation Nummer" class="form-control" id="org_no" name="org_no" autocomplete="off">
                <span class="text-danger error-msg" id="err_org_no">
            </div>
            <div class="col-md-12 col-xs-12" style="min-height: 40px;"></div>
            <div class="form-group text-center account_btn">
                <button style="background-color: #1e9f2e; color: #ffffff;" type="submit" name="sbmt" id="sbmt" class="btn btn-success"><b>Skapa Konto</b> <i class="fa fa-arrow-right"></i></button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>   	
</div>