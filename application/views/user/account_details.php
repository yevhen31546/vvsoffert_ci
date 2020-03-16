<div class="col-xs-12 col-sm-9 col-xl-10 table_content">
    <div class="overall_content">
        <div class="section_content">
            <div class="table_header">
                <div class="table_title fl" style = "font-size: 20px"><i class="fa fa-user-circle"></i> Kundprofil</div>
                <div class="clearfix"></div>


                <div class="signup_screen">
                    <?php
                    $array = $this->session->flashdata('message');
                    if (!empty($array)) {
                    ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Klart!</strong> <?php echo $array['content']; ?>
                        </div> 

                        <?php
                        $this->session->unset_userdata('message');
                    }
                    ?>

                    <div class="signup_form">
                        <?php echo form_open(); ?>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <!--<label for="name" class="fa fa-user-circle" rel="tooltip" title="name"></label>-->
                                <input type="text" placeholder="Först namn" class="form-control" id="name" name="name" value="<?php echo set_value('name', $model->name); ?>">
                                <i class="fa fa-user"></i>

                            </div>
                            <span style="color:red;"><?php echo form_error('name') ?></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Sista namn" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name', $model->last_name); ?>">
                                <label for="last_name" class="fa fa-user-circle" rel="tooltip" title="Kundnamn"></label>
                            </div>
                            <span style="color:red;"><?php echo form_error('last_name') ?></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Telefon" class="form-control" id="contact" name="contact" value="<?php echo set_value('contact', $model->contact); ?>">
                                <label for="contact" class="fa fa-phone" rel="tooltip" title="contact"></label>
                            </div>
                            <span style="color:red;"><?php echo form_error('contact') ?></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            
                            <div class="icon-addon">
                                <input type="email" placeholder="E-post" class="form-control" id="email" name="email" value="<?php echo set_value('email', $model->email); ?>">
                                <label for="email" class="fa fa-envelope" rel="tooltip" title="email"></label>
                            </div>
                            <span style="color:red;"><?php echo form_error('email') ?></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 ">
                            <div class="icon-addon">
                                <input type="text" placeholder="Företag namn" class="form-control" id="company_name" name="company_name" autocomplete="off" value="<?php echo set_value('company_name', $model->company_name); ?>">
                                <label for="email" class="fa fa-industry" rel="tooltip" title="company_name"></label>
                            </div>
                            <span style="color:red;"><?php echo form_error('company_name') ?></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Organisation siffra" class="form-control" id="org_no" name="org_no" autocomplete="off" value="<?php echo set_value('org_no', $model->org_no); ?>">
                                <label for="email" class="fa fa-id-badge" rel="tooltip" title="Organization Number"></label>
                            </div>
                           <span style="color:red;"><?php echo form_error('org_no') ?></span>
                        </div>

                        <div class="form-group text-center account_btn">
                            <!--<a href="#" class="reg-btn">Create an Account</a>-->
                            <input type="submit" name="submit" id="sbmt" class="reg-btn" value="Uppdatering Profil">
                        </div>
                        <div class="clearfix"></div>
                        <?php echo form_close(); ?>
                    </div>  	
                </div>
            </div>


        </div>
    </div>
</div>
<div class="clearfix"></div>
</div>