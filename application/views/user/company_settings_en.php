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
                                <div class="table_title fl" style = "font-size: 30px"> Company contact details</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Company name</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Company name" class="form-control" id="company_name" name="company_name" value="<?php echo set_value('company_name', $model? $model->company_name :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Address</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Address1" class="form-control" id="address1" name="address1" value="<?php echo set_value('address1',$model? $model->address1 :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label"></label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Address2" class="form-control" id="address2" name="address2" value="<?php echo set_value('address2', $model? $model->address2 :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Postcode</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Postcode" class="form-control" id="post_code" name="post_code" value="<?php echo set_value('post_code', $model? $model->post_code :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">City</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="City" class="form-control" id="city" name="city" value="<?php echo set_value('city', $model? $model->city :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Place of domicile</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Place of domicile" class="form-control" id="domicile_place" name="domicile_place" value="<?php echo set_value('domicile_place', $model? $model->domicile_place :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Phone no</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Phone no" class="form-control" id="phone_num" name="phone_num" value="<?php echo set_value('phone_num', $model? $model->phone_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Mobile no</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Mobile no" class="form-control" id="mobile_num" name="mobile_num" value="<?php echo set_value('mobile_num', $model? $model->mobile_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Email address</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Email address" class="form-control" id="email_address" name="email_address" value="<?php echo set_value('email_address', $model? $model->email_address :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Website</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Website" class="form-control" id="website" name="website" value="<?php echo set_value('website', $model? $model->website :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>

                                <div class="table_title fl" style = "font-size: 30px"> Additional company details</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Corporate identity no</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Corporate identity no" class="form-control" id="corporate_id" name="corporate_id" value="<?php echo set_value('corporate_id', $model? $model->corporate_id :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">GLN</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="GLN" class="form-control" id="gln" name="gln" value="<?php echo set_value('gln', $model? $model->gln :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Local currency</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Local currency" class="form-control" id="local_currency" name="local_currency" value="<?php echo set_value('local_currency', $model? $model->local_currency :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">VAT no</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="VAT no" class="form-control" id="vat_num" name="vat_num" value="<?php echo set_value('vat_num', $model? $model->vat_num :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Bankgiro</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Bankgiro" class="form-control" id="bankiro" name="bankiro" value="<?php echo set_value('bankiro', $model? $model->bankiro :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">PlusGiro</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="PlusGiro" class="form-control" id="plus_giro" name="plus_giro" value="<?php echo set_value('plus_giro', $model? $model->plus_giro :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Swish</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Swish" class="form-control" id="swish" name="swish" value="<?php echo set_value('swish', $model? $model->swish :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="table_title fl" style = "font-size: 30px"> Show/Hide modules</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="usesQuotes" name="use_quote" type="checkbox" <?php echo $model? $model->use_quote :''; ?>>
                                            <span style="font-weight: 700;">Show the Quotes module in menu</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="usesOrder" name="use_order" type="checkbox" <?php echo $model? $model->use_order :''; ?>>
                                            <span style="font-weight: 700;">Show the Orders module in menu</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="table_title fl" style = "font-size: 30px"> Reset company</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group">
                                    <div class="input-text-block" style = "font-size: 18px">If you reset your company, everything in the program will be deleted except your company name and corporate identity number. Your user ID and password for Visma Spcs’ web services will remain the same. Resetting the company requires administrator privileges.
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <div class="form-input">
                                        <input id="resetCompany" class="btn btn-default" title="Reset" value="Reset"/>
                                    </div>
                                </div>

                                <div class="table_title fl" style = "font-size: 30px"> Archived companies</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group">
                                    <div class="input-text-block" style = "font-size: 18px">
                                        <span>When you have restarted your company you can access your previous company data in a read-only version. You cannot change anything in the read-only version, but have the possibility to export data.</span>
                                    </div>                                    
                                    <div class="notAbleToAddMore"  style = "font-size: 18px">
                                        <span>Currently it is not possible to add more than 50 customers to an invoice. If you want to send it to more customers make a copy of it and add the remaining ones.</span>
                                    </div>
                                    <br>
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Select company</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Select company" class="form-control" id="archive_company" name="archive_company" value="<?php echo set_value('archive_company', $model? $model->archive_company :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                    </div>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">

                            <div class="form-group text-center account_btn">
                                <!--<a href="#" class="reg-btn">Create an Account</a>-->
                                <!-- <button type="button" class="btn btn-success" style = "font-size:18px;<?php if(isset($singlelist)){?>display:none;<? } ?>" id ="add_project_btn" >Bekräfta</button> -->
                                <input type="submit" id="sbmt" class="reg-btn btn btn-success" value="Save">
                                <!--<input type="submit" id="cancel" class="reg-btn btn btn-second" value="Cancel">-->
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
