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
                                <div class="table_title fl" style = "font-size: 30px"> Försäljningsinställningar </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="has_ftax" name="has_ftax" type="checkbox" <?php echo $model? $model->has_ftax :''; ?>>
                                            <span style="font-weight: 400;">Godkänd för F-skatt</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="vat_reserve" name="vat_reserve" type="checkbox" <?php echo $model? $model->vat_reserve :''; ?>>
                                            <span style="font-weight: 400;">Fakturerar enligt regler för omvänd skattskyldighet</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="vat_triangle" name="vat_triangle" type="checkbox" <?php echo $model? $model->vat_triangle :''; ?>>
                                            <span style="font-weight: 400;">Mellanmans försäljning varor EU</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="telecom" name="telecom" type="checkbox" <?php echo $model? $model->telecom :''; ?>>
                                            <span style="font-weight: 400;">Säljer elektroniska tjänster, telekommunikationstjänster och sändningstjänster (MOSS)r</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="show_price" name="show_price" type="checkbox" <?php echo $model? $model->show_price :''; ?>>
                                            <span style="font-weight: 400;">Visa priser exkl. moms för privatpersoner</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Öresavrundning</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" style="text-align:right;" class="form-control" id="rounding" name="rounding" value="<?php echo set_value('rounding', $model? $model->rounding :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="table_title fl" style = "font-size: 30px"> Husarbete </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div id="domestic_check" class="checkbox">
                                        <label>
                                            <input id="domestic_service" name="domestic_service" type="checkbox" <?php echo $model? $model->domestic_service :''; ?>>
                                            <span style="font-weight: 400;">Fakturerar husarbete</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12" id="domestic_area" style="display:none;">
                                    <div class="col-xs-12 col-sm-12" style="height:auto;">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="form-label control-label">RUT rättighet</label>
                                            </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:auto;">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="form-label control-label">Gräns, köpare under 65 år / år</label>
                                            </div>
                                            <div class="col-md-7 col-md-9">
                                                <input type="text" placeholder="" style="text-align:right;" class="form-control" id="limit_under" name="limit_under" value="<?php echo set_value('limit_under', $model? $model->limit_under :''); ?>">
                                            </div>
                                            <div class="col-md-1 col-md-3">
                                                <label class="form-label control-label">SEK</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:auto;">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="form-label control-label">Gräns, köpare över 65 y / o</label>
                                            </div>
                                            <div class="col-md-7 col-md-9">
                                                <input type="text" placeholder="" style="text-align:right;" class="form-control" id="limit_over" name="limit_over" value="<?php echo set_value('limit_over', $model? $model->limit_over :''); ?>">
                                            </div>
                                            <div class="col-md-1 col-md-3">
                                                <label class="form-label control-label">SEK</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:auto;">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="form-label control-label">Andel av arbetet berättigat</label>
                                            </div>
                                            <div class="col-md-7 col-md-9">
                                                <input type="text" placeholder="" style="text-align:right;" class="form-control" id="rut_percent" name="rut_percent" value="<?php echo set_value('rut_percent', $model? $model->rut_percent :''); ?>">
                                            </div>
                                            <div class="col-md-1 col-md-3">
                                                <label class="form-label control-label">%</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <br>
                                    <div class="col-xs-12 col-sm-12" style="height:auto;">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="form-label control-label">ROT-rättighet</label>
                                            </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:auto;">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="form-label control-label">Begränsa</label>
                                            </div>
                                            <div class="col-md-7 col-md-9">
                                                <input type="text" placeholder="" style="text-align:right;" class="form-control" id="rot_limit" name="rot_limit" value="<?php echo set_value('rot_limit', $model? $model->rot_limit :''); ?>">
                                            </div>
                                            <div class="col-md-1 col-md-3">
                                                <label class="form-label control-label">SEK</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12" style="height:auto;">
                                            <div class="col-md-4 col-sm-12">
                                                <label class="form-label control-label">Andel av arbetet berättigat</label>
                                            </div>
                                            <div class="col-md-7 col-md-9">
                                                <input type="text" placeholder="" style="text-align:right;" class="form-control" id="rot_percent" name="rot_percent" value="<?php echo set_value('rot_percent', $model? $model->rot_percent :''); ?>">
                                            </div>
                                            <div class="col-md-1 col-md-3">
                                                <label class="form-label control-label">%</label>
                                            </div>
                                            <span style="color:red;"><?php ?></span>
                                    </div>
                                </div>
                                <div class="table_title fl" style = "font-size: 30px"> Betalningspåminnelser </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Avgift för försenad betalning</label>
                                        </div>
                                        <div class="col-md-7 col-md-9">
                                            <input type="text" placeholder="" style="text-align:right;" class="form-control" id="payment_fees" name="payment_fees" value="<?php echo set_value('payment_fees', $model? $model->payment_fees :''); ?>">
                                        </div>
                                        <div class="col-md-1 col-md-3">
                                            <label class="form-label control-label">SEK</label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12 form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="charge_reminder" name="charge_reminder" type="checkbox" <?php echo $model? $model->charge_reminder :''; ?>>
                                            <span style="font-weight: 400;">Första påminnelsen gratis</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="table_title fl" style = "font-size: 30px"> Leverantörsfakturor </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="edit_purchase_invoice" name="edit_purchase_invoice" type="checkbox" <?php echo $model? $model->edit_purchase_invoice :''; ?>>
                                            <span style="font-weight: 400;">Tillåt redigering av inköpsfakturor</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="use_outgoing_payment" name="use_outgoing_payment" type="checkbox" <?php echo $model? $model->use_outgoing_payment :''; ?>>
                                            <span style="font-weight: 400;">Använd betalningsfiler för utgående betalningar</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="debit_purchase_invoice" name="debit_purchase_invoice" type="checkbox" <?php echo $model? $model->debit_purchase_invoice :''; ?>>
                                            <span style="font-weight: 400;">Visa debet och kredit på inköpsfakturor</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="table_title fl" style = "font-size: 30px"> Nummerserier</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Nästa offertnr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="quote" name="quote" value="<?php echo set_value('quote', $model? $model->quote :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Nästa ordernr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="order" name="order" value="<?php echo set_value('order', $model? $model->order :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Nästa kundfakturanr</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="sale_invoice" name="sale_invoice" value="<?php echo set_value('sale_invoice', $model? $model->sale_invoice :''); ?>">
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
