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
                        <form action="<?php echo base_url('/user/add_new_article_update');?>" method="post" id="set_company" accept-charset="utf-8">
                            <div class="col-md-6">
                                <div class="table_title fl" style = "font-size: 30px"> Ny artikel </div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">

                                <div class="form-group checkbox-form">
                                    <div class="checkbox">
                                        <label>
                                            <input id="active" name="status" type="checkbox" <?php echo $model? $model->status :''; ?>>
                                            <span style="font-weight: 700;">Aktiva</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;display:none;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Article id</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="id" name="id" value="<?php echo set_value('id', $model? $model->id :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;display:none;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Price List</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="price_list" name="price_list" value="">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Artikel nummer</label>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <input type="text" placeholder="Ange produktnummer och klicka på Sök-knappen!" class="form-control" id="art_num" name="art_num" value="<?php echo set_value('art_num', $model? $model->art_num :''); ?>">
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <input type="button" placeholder="" class="form-control" id="find_rsknum" name="find_rsknum" value="Hitta">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Artikelnamn</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="art_name" name="art_name" value="<?php echo set_value('art_name', $model? $model->art_name :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Artikelnamn på engelska</label>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <input type="text" placeholder="" class="form-control" id="art_name_en" name="art_name_en" value="<?php echo set_value('art_name_en',$model? $model->art_name_en :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>

                                <div class="table_title fl" style = "font-size: 30px"> Försäljningsinformation</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Artikelkontering</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                        <select class="form-control" name="sale_category" required="">
                                                <?php
                                                    if($model->payment_term)
                                                        echo '<option value="'.$model->sale_category.'">'.$model->sale_category.'</option>';
                                                ?>
                                                <option value="Goods 0% VAT">Expeditionsavgift 12 %</option>
                                                <option value="Goods 6% VAT">Expeditionsavgift 25 %</option>
                                                <option value="Goods 12% VAT">Expeditionsavgift 6 %</option>
                                                <option value="Handling charge 6%">Tjänster 0 %</option>
                                                <option value="Handling charge 12%">Tjänster 12%</option>
                                                <option value="Handling charge 25%">Tjänster 25%</option>
                                                <option value="Services 0% VAT">Varor 0 %</option>
                                                <option value="Services 6% VAT">Varor 6 %</option>
                                                <option value="Services 12% VAT">Varor 12% </option>
                                                <option value="Services 25% VAT">Varor 25%</option>
                                            </select>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                               <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Enhet</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <select class="form-control" name="unit" required="">
                                            <?php
                                                    if($model->currency)
                                                        echo '<option value="'.$model->unit.'">'.$model->unit.'</option>';
                                                ?>
                                                <option value="ST">ST</option>
                                                <!-- <option value="Bale(bale)">Bale(bale)</option>
                                                <option value="Tin(tin)">Tin(tin)</option>
                                                <option value="Metre(m)">Metre(m)</option> -->
                                            </select>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Försäljningspris exkl. MOMS</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="0.00" class="form-control" id="sale_price_excl" name="sale_price_excl" value="<?php echo set_value('sale_price_excl', $model? $model->sale_price_excl :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Försäljningspris inkl. MOMS</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="0.00" class="form-control" id="sale_price_incl" name="sale_price_incl" value="<?php echo set_value('sale_price_incl', $model? $model->sale_price_incl :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>

                                <div class="table_title fl" style = "font-size: 30px"> Beräkning av täckningsbidrag</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Inköpspris, exkl. MOMS</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="0.00" class="form-control" id="pur_price_excl" name="pur_price_excl" value="<?php echo set_value('pur_price_excl', $model? $model->pur_price_excl :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Senast ändrad</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <label id = "last_change" name="last_change" value=""></label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Bidragsmarginal</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <label id="contribution" name="contribution">0.00</label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Bidragsmarginal%</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <label id="contribution_pro" name="contribution_pro"></label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="table_title fl" style = "font-size: 30px"> Lager</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Aktiebalans</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="0.00" class="form-control" id="stock_bal" name="stock_bal" value="<?php echo set_value('stock_bal', $model? $model->stock_bal :''); ?>">
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Manuellt justerad</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <label id="manual_adjust" name="manual_adjust"></label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Enhet reserverad</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <label id="unit_reserve" name="unit_reserve">0.00</label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div> 
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Enhet tillgänglig</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <label id="unit_avail" name="unit_avail">0.00</label>
                                        </div>
                                        <span style="color:red;"><?php ?></span>
                                </div>                                

                                <div class="table_title fl" style = "font-size: 30px"> Artikel etiketter</div>
                                <div class="clearfix"></div>
                                <hr style="border-top: 3px solid #ff9310;">
                                <div class="col-xs-12 col-sm-12" style="height:auto;">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="form-label control-label">Artikel taggad med</label>
                                        </div>
                                        <div class="col-md-8 col-md-12">
                                            <input type="text" placeholder="" class="form-control" id="article_tagged" name="article_tagged" value="<?php echo set_value('article_tagged', $model? $model->article_tagged :''); ?>">
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
                                <input type="submit" id="cancel" class="reg-btn btn btn-second" value="Annullera">
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
