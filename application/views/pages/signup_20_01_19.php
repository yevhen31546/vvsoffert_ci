<div class="signup_screen">
    <h2 class="screen_title">Intresseanmälan </h2> <br/>
  <center> <h4 class="screen_title">Här kan du skicka en intresseanmälan till VVS offert.</h4>
    <h4 class="screen_title">Fyll i dina kontaktuppgifter så hör vi av oss.</h4></center> 
 </h4><br/>
    
    <div class="signup_form">
        <form name="sign_up_form" id="sign_up_form" method="post">
            <div class="form-group col-xs-12 col-sm-6">
                <div class="icon-addon">
                    <input type="text" placeholder="Förnamn" class="form-control" id="name" name="name" autocomplete="off">
                    <label for="name" class="fa fa-user" rel="tooltip" title="Förnamn"></label>
                </div>
                <span class="text-danger error-msg" id="err_name"></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <div class="icon-addon">
                    <input type="text" placeholder="Efternamn" class="form-control" id="last_name" name="last_name" autocomplete="off">
                    <label for="email" class="fa fa-user" rel="tooltip" title="Efternamn"></label>
                </div>
                <span class="text-danger error-msg" id="err_last_name"></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="text" placeholder="Telefon" class="form-control" id="contact" name="contact" autocomplete="off">
                    <label for="email" class="fa fa-phone" rel="tooltip" title="Telefon"></label>
                </div>
                <span class="text-danger error-msg" id="err_contact"></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="text" placeholder="E-post" class="form-control" id="email" name="email" autocomplete="off">
                    <label for="email" class="fa fa-envelope" rel="tooltip" title="E-post"></label>
                </div>
                <span class="text-danger error-msg" id="err_email"></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="password" placeholder="Lösenord" class="form-control" id="password" name="password" autocomplete="off">
                    <label for="email" class="fa fa-lock" rel="tooltip" title="Lösenord"></label>
                </div>
                <span class="text-danger error-msg" id="err_password"></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12 ">
                <div class="icon-addon">
                    <input type="password" placeholder="Bekräfta lösenord" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off">
                    <label for="email" class="fa fa-lock" rel="tooltip" title="Bekräfta lösenord"></label>
                </div>
                <span class="text-danger error-msg" id="err_confirm_password"></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12 ">
                <div class="icon-addon">
                    <input type="text" placeholder="Företagsnamn" class="form-control" id="company_name" name="company_name" autocomplete="off">
                    <label for="email" class="fa fa-industry" rel="tooltip" title="Företagsnamn"></label>
                </div>
                <span class="text-danger error-msg" id="err_company_name"></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12 mg-bottom">
                <div class="icon-addon">
                    <input type="text" placeholder="Org.Nr" class="form-control" id="org_no" name="org_no" autocomplete="off">
                    <label for="email" class="fa fa-id-badge" rel="tooltip" title="Org.Nr"></label>
                </div>
                <span class="text-danger error-msg" id="err_org_no"></span>
            </div>
            <div class="checkbox col-xs-12 col-sm-12">
                <label><input type="checkbox" name="terms_conditions" id="terms_conditions" value="1">Genom att skapa ett konto godkänner du <a href="<?=site_url('terms-condition')?>" target="_blank"><span class="org-color">våra villkor.</span></a></label>
                <span class="text-danger error-msg" id="err_terms_conditions"></span>	
            </div>
            <div class="form-group text-center account_btn">
                <input type="submit" name="sbmt" id="sbmt" class="reg-btn" value="Skapa ett konto">
            </div>
            <div class="clearfix"></div>
        </form>
    </div>   	
</div>