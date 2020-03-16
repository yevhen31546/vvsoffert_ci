    <div class="col-xs-12 col-sm-9 table_content">
        <div class="overall_content">
            <div class="section_content">
                <div class="table_header">
                    <div class="table_title fl"><i class="fa fa-list"></i><?=(isset($singlelist))?' Redigera':' Lägg till'?> Projekt/Lista</div>
                    <div class="clearfix"></div>
                   
                   
                    <div class="signup_screen">
                         <?php $array = $this->session->flashdata('message');
                        if(count($array) > 0){ ?>
                           <div class="alert alert-success">
                               <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
  <strong>Klart!</strong> <?php echo $array['content']; ?>
</div> 
                            
                       <?php  $this->session->unset_userdata('message'); } ?>
                        
                        
                        <div class="signup_form">
                            <?php echo form_open(); ?>
                                <div class="form-group col-xs-12 col-sm-12">
                                    <div class="icon-addon">
                                        <?php
                                        if(isset($singlelist)){
                                        ?>
                                         <input type="hidden" name="id" value="<?=$singlelist->id?>">
                                        <?php } ?>
                                        <input type="text" placeholder="Lista namn" class="form-control" id="name" name="name" value="<?=(isset($singlelist) && $singlelist->name!='')?$singlelist->name:''?>">
                                        <label for="name" class="fa fa-address-book" rel="tooltip" title="Lista namn"></label>
                                       
                                    </div>
                                    <span style="color:red;"><?php echo form_error('name') ?></span>
                                </div>
                                
                                <div class="form-group text-center account_btn">
                                    <!--<a href="#" class="reg-btn">Create an Account</a>-->
                                    <input type="submit" name="submit" id="sbmt" class="reg-btn" value="Lämna">
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