    <div class="col-xs-12 col-sm-9 col-xl-10 table_content">
        <div class="overall_content">
            <div class="section_content">
                <div class="table_header">
                    <div class="table_title fl"><i class="fa fa-key"></i> Ändra konto lösenord</div>
                    <div class="clearfix"></div>
                   
                   
                    <div class="signup_screen">
                         <?php $array = $this->session->flashdata('message');
                            if (!empty($array)) {
                        ?>
                           <div class="alert alert-success">
                               <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
  <strong>Framgång!</strong> <?php echo $array['content']; ?>
</div> 
                            
                       <?php  $this->session->unset_userdata('message'); } ?>
                        
                        <div class="signup_form">
                            <?php echo form_open(); ?>
                                <div class="form-group col-xs-12 col-sm-12">
                                    <div class="icon-addon">
                                        <input type="password" placeholder="Gammalt lösenord" class="form-control" id="old_password" name="old_password" value="">
                                        <label for="old_password" class="fa fa-key" rel="tooltip" title="Old password"></label>
                                       
                                    </div>
                                    <span style="color:red;"><?php echo form_error('old_password') ?></span>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12">
                                    <div class="icon-addon">
                                        <input type="password" placeholder="Nytt lösenord" class="form-control" id="new_password" name="new_password" value="">
                                        <label for="new_password" class="fa fa-key" rel="tooltip" title="new_password"></label>
                                    </div>
                                    <span style="color:red;"><?php echo form_error('new_password') ?></span>
                                </div>
                                
                                <div class="form-group col-xs-12 col-sm-12">
                                    <div class="icon-addon">
                                        <input type="password" placeholder="Bekräfta lösenord" class="form-control" id="cn_password" name="cn_password" value="">
                                        <label for="cn_password" class="fa fa-key" rel="tooltip" title="Confirm Password"></label>
                                    </div>
                                     <span style="color:red;"><?php echo form_error('cn_password') ?></span>
                                </div>
                                
                                
                                <div class="form-group text-center account_btn">
                                    <!--<a href="#" class="reg-btn">Create an Account</a>-->
                                    <input type="submit" name="submit" id="sbmt" class="reg-btn" value="Ändra lösenord">
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