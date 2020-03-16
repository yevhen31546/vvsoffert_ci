<div class="col-xs-12 col-sm-9 col-xl-10 table_content">
    <!-- <div class="overall_content"> -->
        <div class="section_content">
            <!-- <div class="table_header"> -->
                <?php
                    $model='';
                    if($this->data['model']){
                        $data = $this->data['model']; 
                        $model = $data[0];
                    } 
                ?>
                <!-- <div class="signup_screen"> -->
                    <div class="signup_form">
                        <form action="<?php echo base_url('/user/set_company');?>" method="post" id="set_company" accept-charset="utf-8">
                            <div class="col-md-6">
                                <div class="table_title fl" style = "font-size: 30px"> Kontaktuppgifter</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Företagsnamn</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="company_name" name="company_name" value="<?php echo set_value('company_name', $model? $model->company_name :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Postadress</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="address1" name="address1" value="<?php echo set_value('address1',$model? $model->address1 :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label"></label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="address2" name="address2" value="<?php echo set_value('address2', $model? $model->address2 :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Postnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="post_code" name="post_code" value="<?php echo set_value('post_code', $model? $model->post_code :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Postort</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="city" name="city" value="<?php echo set_value('city', $model? $model->city :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Säte</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="domicile_place" name="domicile_place" value="<?php echo set_value('domicile_place', $model? $model->domicile_place :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Telefonnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="phone_num" name="phone_num" value="<?php echo set_value('phone_num', $model? $model->phone_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Mobilnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="mobile_num" name="mobile_num" value="<?php echo set_value('mobile_num', $model? $model->mobile_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">E-postaddress</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="email_address" name="email_address" value="<?php echo set_value('email_address', $model? $model->email_address :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Webbplats</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="website" name="website" value="<?php echo set_value('website', $model? $model->website :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>

                                
                            </div>

                            <div class="col-md-6">
                                <div class="table_title fl" style = "font-size: 30px"> Företagsuppgifter</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Organisationsnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="corporate_id" name="corporate_id" value="<?php echo set_value('corporate_id', $model? $model->corporate_id :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">GLN</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="gln" name="gln" value="<?php echo set_value('gln', $model? $model->gln :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Inhemsk valuta</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="local_currency" name="local_currency" value="<?php echo set_value('local_currency', $model? $model->local_currency :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Momsregistreringsnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="vat_num" name="vat_num" value="<?php echo set_value('vat_num', $model? $model->vat_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Bankgiro</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="bankiro" name="bankiro" value="<?php echo set_value('bankiro', $model? $model->bankiro :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">PlusGiro</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="plus_giro" name="plus_giro" value="<?php echo set_value('plus_giro', $model? $model->plus_giro :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Swish</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="swish" name="swish" value="<?php echo set_value('swish', $model? $model->swish :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                            <!--    <div class="table_title fl" style = "font-size: 30px"> Visa/Dölj tillval i menyn</div>-->
                            <!--    <div class="clearfix"></div>-->
                            <!--    <hr style="border-top: 3px solid #ff9310;">-->
                            <!--    <div class="form-group checkbox-form">-->
                            <!--        <div class="checkbox">-->
                            <!--            <label>-->
                            <!--                <input id="usesQuotes" name="use_quote" type="checkbox" <?php echo $model? $model->use_quote :''; ?>>-->
                            <!--                <span style="font-weight: 700;">Visa Offerter i menyn</span>-->
                            <!--            </label>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="form-group checkbox-form">-->
                            <!--        <div class="checkbox">-->
                            <!--            <label>-->
                            <!--                <input id="usesOrder" name="use_order" type="checkbox" <?php echo $model? $model->use_order :''; ?>>-->
                            <!--                <span style="font-weight: 700;">Visa Order i menyn</span>-->
                            <!--            </label>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <div class="table_title fl" style = "font-size: 30px"> Omstart av företag</div>-->
                            <!--    <div class="clearfix"></div>-->
                            <!--    <hr style="border-top: 3px solid #ff9310;">-->
                            <!--    <div class="form-group">-->
                            <!--        <div class="input-text-block" style = "font-size: 18px">Vid omstart nollställs ditt företag, det innebär att all registrerad information i programmet raderas. Raderad information går inte att återskapa. Du kan bara göra omstarten om du är registrerad som administratör för programmet..-->
                            <!--        </div>-->
                            <!--        <div class="clearfix"></div>-->
                            <!--        <br>-->
                            <!--        <div class="form-input">-->
                            <!--            <input id="resetCompany" class="btn btn-default" title="Reset" value="Återställa"/>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <div class="table_title fl" style = "font-size: 30px"> Arkiverade företag</div>-->
                            <!--    <div class="clearfix"></div>-->
                            <!--    <hr style="border-top: 3px solid #ff9310;">-->
                            <!--    <div class="form-group">-->
                            <!--        <div class="input-text-block" style = "font-size: 18px">-->
                            <!--            <span>När du har startat ditt företag kan du komma åt dina tidigare företagsuppgifter i en skrivskyddad version. Du kan inte ändra något i den skrivskyddade versionen, men har möjlighet att exportera data.</span>-->
                            <!--        </div>                                    -->
                            <!--        <div class="notAbleToAddMore"  style = "font-size: 18px">-->
                            <!--            <span>För närvarande är det inte möjligt att lägga till mer än 50 kunder på en faktura. Om du vill skicka den till fler kunder gör du en kopia av den och lägg till de övriga.</span>-->
                            <!--        </div>-->
                            <!--        <br>-->
                            <!--        <div class="clearfix"></div>-->
                            <!--        <div class="col-xs-12 col-sm-12" style="height:40px;">-->
                            <!--            <div class="col-md-4 col-sm-12">-->
                            <!--                <label class="form-label control-label">Välj företag</label>-->
                            <!--            </div>-->
                            <!--            <div class="col-md-8 col-md-12">-->
                            <!--                <input type="text" placeholder="" class="form-control" id="archive_company" name="archive_company" value="<?php echo set_value('archive_company', $model? $model->archive_company :''); ?>">-->
                            <!--            </div>-->
                            <!--            <span style="color:red;"><?php ?></span>-->
                            <!--        </div>-->

                            <!--    </div>-->
                            </div>
                            <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">

                            <div class="form-group text-center account_btn">
                                <!--<a href="#" class="reg-btn">Create an Account</a>-->
                                <!-- <button type="button" class="btn btn-success" style = "font-size:18px;<?php if(isset($singlelist)){?>display:none;<? } ?>" id ="add_project_btn" >Bekräfta</button> -->
                                <input type="submit" id="sbmt" class="reg-btn btn btn-success" value="Spara">
                                <!--<input type="submit" id="cancel" class="reg-btn btn btn-second" value="Annullera">-->
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>  	
                <!-- </div> -->
            <!-- </div> -->


        <!-- </div> -->
    </div>
</div>
<div class="clearfix"></div>
</div>
