<?php
    //echo 333;exit;
?>
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
                        <form action="<?php echo base_url('/user/add_new_customer_update');?>" method="post" id="set_company" accept-charset="utf-8">
                            <div class="col-md-6">
                                <div class="table_title fl" style = "font-size: 30px"> Ny kund</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="active" name="status" type="checkbox" <?php echo $model? $model->status :''; ?>>
                                            <span style="font-weight: 700;">Aktiv</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;display:none;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Customer id</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="id" name="id" value="<?php echo set_value('id', $model? $model->id :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <!--<div class="col-xs-12 col-sm-12" style="height:auto;">-->
                                <!--        <div class="col-md-4 col-sm-12">-->
                                <!--            <label class="form-label control-label">Kundnr</label>-->
                                <!--        </div>-->
                                <!--        <div class="col-md-8 col-sm-12">-->
                                <!--            <input type="text" placeholder="" class="form-control" id="customer_num" name="customer_num" value="<?php echo set_value('customer_num', $model? $model->customer_num :''); ?>">-->
                                <!--        </div>-->
                                <!--        <span style="color:red;"><?php ?></span>-->
                                <!--</div>-->
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Kundnamn</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="first_name" name="first_name" value="<?php echo set_value('first_name',$model? $model->first_name :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Efternamn</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name',$model? $model->last_name :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Kundtyp</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <select class="form-control" name="customer_type" required="">
                                                <?php
                                                    if($model->customer_type)
                                                        echo '<option value="'.$model->customer_type.'">'.$model->customer_type.'</option>';
                                                ?>
                                                <option value="Company">Företag</option>
                                                <option value="Private Individual">Privatperson</option>
                                            </select>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Person/Organisationsnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="id_number" name="id_number" value="<?php echo set_value('id_number', $model? $model->id_number :''); ?>">
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
                                            <label class="form-label control-label">Land</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <select class="form-control" name="country" required="">
                                                <?php
                                                    if($model->country)
                                                    echo '<option value="'.$model->country.'">'.$model->country.'</option>';
                                                ?>
                                                <option value="Sweden">Sverige</option>
                                                <option value="United States of America">England</option>
                                            </select>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Språk på försäljningsdok.</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <select class="form-control" name="language" required="">
                                                <?php
                                                    if($model->language)
                                                    echo '<option value="'.$model->language.'">'.$model->language.'</option>';
                                                ?>
                                                <option value="swedish">Svenska</option>
                                                <option value="enlish">Engelska</option>
                                            </select>
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
                                            <label class="form-label control-label">Momsregistreringsnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="vat_num" name="vat_num" value="<?php echo set_value('vat_num', $model? $model->vat_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Telefonnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="phone_number" name="phone_number" value="<?php echo set_value('phone_number', $model? $model->phone_number :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Mobilnummer</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo set_value('mobile_number', $model? $model->mobile_number :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">E-post</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="email" name="email" value="<?php echo set_value('email', $model? $model->email :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">E-postadress</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="email_cc_address" name="email_cc_address" value="<?php echo set_value('email_cc_address', $model? $model->email_cc_address :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Hemsida</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="web_address" name="web_address" value="<?php echo set_value('web_address', $model? $model->web_address :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Anteckningar</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <!-- <input type="text" placeholder="" class="form-control" id="domicile_place" name="domicile_place" value="<?php echo set_value('domicile_place', $model? $model->domicile_place :''); ?>"> -->
                                            <textarea name="note" id="note" style="width:100%;"></textarea>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                    <!--<div class="form-group checkbox-form">-->
                                        <div class="checkbox">
                                            <label>
                                                <input id="reverse_tax" name="reverse_tax" type="checkbox" <?php echo $model->reverse_tax? 'checked' :''; ?>>
                                                <span style="font-weight: 700;">Omvänd skattskyldighet</span>
                                            </label>
                                        </div>
                                    <!--</div>-->
                                </div>
                                
                            <!--</div>-->
                                

                            <!--<div class="col-md-6">-->
                                <div class="table_title fl" style = "font-size: 30px"> Referens</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Namn</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="ref_name" name="ref_name" value="<?php echo set_value('ref_name', $model? $model->ref_name :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">E-postadress</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="ref_email_address" name="ref_email_address" value="<?php echo set_value('ref_email_address', $model? $model->ref_email_address :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Telefonnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="ref_phone_num" name="ref_phone_num" value="<?php echo set_value('ref_phone_num', $model? $model->ref_phone_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Mobilnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="ref_mobile_num" name="ref_mobile_num" value="<?php echo set_value('ref_mobile_num', $model? $model->ref_mobile_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>

                                <div class="table_title fl" style = "font-size: 30px"> Leverans</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Leveransvillkor</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="term_delivery" name="term_delivery" value="<?php echo set_value('term_delivery', $model? $model->term_delivery :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Leveranssätt</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="delivery_method" name="delivery_method" value="<?php echo set_value('delivery_method', $model? $model->delivery_method :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="table_title fl" style = "font-size: 30px"> Betalning</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Betalningsvillkor</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                        <select class="form-control" name="payment_term" required="">
                                                <?php
                                                    if($model->payment_term)
                                                        echo '<option value="'.$model->payment_term.'">'.$model->payment_term.'</option>';
                                                ?>
                                                <option value="Net 0 days">0 dagar netto</option>
                                                <option value="Net 7 days">7 dagar netto</option>
                                                <option value="Net 10 days">10 dagar netto</option>
                                                <option value="Net 14 days">14 dagar netto</option>
                                                <option value="Net 15 days">15 dagar netto</option>
                                                <option value="Net 20 days">20 dagar netto</option>
                                                <option value="Net 30 days">30 dagar netto</option>
                                                <option value="Net 45 days">45 dagar netto</option>
                                                <option value="Net 60 days">60 dagar netto</option>
                                                <option value="Net 90 days">90 dagar netto</option>
                                                <option value="Net 120 days">120 dagar netto</option>
                                                <option value="Cash">Kontant</option>
                                                <option value="Card payment">Kortbetalning</option>
                                            </select>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Valuta</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <select class="form-control" name="currency" required="">
                                                <?php
                                                    if($model->currency)
                                                        echo '<option value="'.$model->currency.'">'.$model->currency.'</option>';
                                                ?>
                                                <option value="SEK">SEK</option>
                                                <option value="USD">USD</option>
                                                <option value="GBP">GBP</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Betala till företagskonto</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <select class="form-control" name="pay_account" required="">
                                                <?php
                                                    if($model->pay_account)
                                                        echo '<option value="'.$model->pay_account.'">'.$model->pay_account.'</option>';
                                                ?>
                                                <option value="Primary operating account">Primärt användarkonto</option>
                                                <option value="Bank operating account">Bankkonto</option>
                                            </select>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Kundrabatt</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="customer_discount" name="customer_discount" value="<?php echo set_value('customer_discount', $model? $model->customer_discount :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>                                

                                <div class="table_title fl" style = "font-size: 30px"> Kund etiketter</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Kunder taggade med</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="customer_tagged" name="customer_tagged" value="<?php echo set_value('customer_tagged', $model? $model->customer_tagged :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
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
