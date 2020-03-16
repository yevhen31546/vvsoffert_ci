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
                        <form action="<?php echo base_url('/user/set_invoice');?>" method="post" id="set_company" accept-charset="utf-8">
                            <div class="col-md-6">
                                <div class="table_title fl" style = "font-size: 30px"> Sales invoicing </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="has_ftax" name="has_ftax" type="checkbox" <?php echo $model? $model->has_ftax :''; ?>>
                                            <span style="font-weight: 400;">Approved for F-tax</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="vat_reserve" name="vat_reserve" type="checkbox" <?php echo $model? $model->vat_reserve :''; ?>>
                                            <span style="font-weight: 400;">Construction sector, VAT reverse charge rules apply</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="vat_triangle" name="vat_triangle" type="checkbox" <?php echo $model? $model->vat_triangle :''; ?>>
                                            <span style="font-weight: 400;">EU intermediary, VAT triangulation rules apply</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="telecom" name="telecom" type="checkbox" <?php echo $model? $model->telecom :''; ?>>
                                            <span style="font-weight: 400;">Telecom, broadcasting and electronic services, MOSS rules apply</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="show_price" name="show_price" type="checkbox" <?php echo $model? $model->show_price :''; ?>>
                                            <span style="font-weight: 400;">Show prices excl. VAT for private individuals</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Rounding</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Round to nearest krona" style="text-align:right;" class="form-control" id="rounding" name="rounding" value="<?php echo set_value('rounding', $model? $model->rounding :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="table_title fl" style = "font-size: 30px"> Domestic services </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div id="domestic_check" class="checkbox">
                                        <label>
                                            <input id="domestic_service" name="domestic_service" type="checkbox" <?php echo $model? $model->domestic_service :''; ?>>
                                            <span style="font-weight: 400;">Domestic services to private individuals, ROT/RUT rules apply</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12" id="domestic_area" style="display:none;">
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                            <div class="col-md-4">
                                                <label class="form-label control-label">RUT entitlement</label>
                                            </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                            <div class="col-md-4">
                                                <label class="form-label control-label">Limit, buyers under 65 y/o</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" placeholder="25 000,00" style="text-align:right;" class="form-control" id="limit_under" name="limit_under" value="<?php echo set_value('limit_under', $model? $model->limit_under :''); ?>">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label control-label">SEK</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                            <div class="col-md-4">
                                                <label class="form-label control-label">Limit, buyers over 65 y/o</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" placeholder="50 000,00" style="text-align:right;" class="form-control" id="limit_over" name="limit_over" value="<?php echo set_value('limit_over', $model? $model->limit_over :''); ?>">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label control-label">SEK</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                            <div class="col-md-4">
                                                <label class="form-label control-label">Percentage of work eligible</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" placeholder="50,00" style="text-align:right;" class="form-control" id="rut_percent" name="rut_percent" value="<?php echo set_value('rut_percent', $model? $model->rut_percent :''); ?>">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label control-label">%</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <br>
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                            <div class="col-md-4">
                                                <label class="form-label control-label">ROT entitlement</label>
                                            </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                            <div class="col-md-4">
                                                <label class="form-label control-label">Limit</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" placeholder="50 000,00" style="text-align:right;" class="form-control" id="rot_limit" name="rot_limit" value="<?php echo set_value('rot_limit', $model? $model->rot_limit :''); ?>">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label control-label">SEK</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:40px;">
                                            <div class="col-md-4">
                                                <label class="form-label control-label">Percentage of work eligible</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" placeholder="30,00" style="text-align:right;" class="form-control" id="rot_percent" name="rot_percent" value="<?php echo set_value('rot_percent', $model? $model->rot_percent :''); ?>">
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label control-label">%</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                </div>
                                <div class="table_title fl" style = "font-size: 30px"> Payment reminders </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Late payment fee</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" placeholder="10,00" style="text-align:right;" class="form-control" id="payment_fees" name="payment_fees" value="<?php echo set_value('payment_fees', $model? $model->payment_fees :''); ?>">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label control-label">SEK</label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12 form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="charge_reminder" name="charge_reminder" type="checkbox" <?php echo $model? $model->charge_reminder :''; ?>>
                                            <span style="font-weight: 400;">First reminder free of charge</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="table_title fl" style = "font-size: 30px"> Purchase invoices </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="edit_purchase_invoice" name="edit_purchase_invoice" type="checkbox" <?php echo $model? $model->edit_purchase_invoice :''; ?>>
                                            <span style="font-weight: 400;">Allow editing of purchase invoices</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="use_outgoing_payment" name="use_outgoing_payment" type="checkbox" <?php echo $model? $model->use_outgoing_payment :''; ?>>
                                            <span style="font-weight: 400;">Use payment files for outgoing payments</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="debit_purchase_invoice" name="debit_purchase_invoice" type="checkbox" <?php echo $model? $model->debit_purchase_invoice :''; ?>>
                                            <span style="font-weight: 400;">Show debit and credit on purchase invoices</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="table_title fl" style = "font-size: 30px"> Number series (next document number)</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Quote</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="1" class="form-control" id="quote" name="quote" value="<?php echo set_value('quote', $model? $model->quote :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Order</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="1" class="form-control" id="order" name="order" value="<?php echo set_value('order', $model? $model->order :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:40px;">
                                        <div class="col-md-4">
                                            <label class="form-label control-label">Sales invoice</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" placeholder="1" class="form-control" id="sale_invoice" name="sale_invoice" value="<?php echo set_value('sale_invoice', $model? $model->sale_invoice :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">

                            <div class="form-group text-center account_btn">
                                <!--<a href="#" class="reg-btn">Create an Account</a>-->
                                <!-- <button type="button" class="btn btn-success" style = "font-size:18px;<?php if(isset($singlelist)){?>display:none;<? } ?>" id ="add_project_btn" >Bekräfta</button> -->
                                <input type="submit" id="sbmt" class="reg-btn btn btn-success" value="Save">
                                <input type="submit" id="cancel" class="reg-btn btn btn-second" value="Cancel">
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
