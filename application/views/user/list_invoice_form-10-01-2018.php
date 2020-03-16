<div class="col-xs-12 col-sm-9 table_content">
    <div class="overall_content">
        <div class="section_content">
            <div class="table_header">
                <div class="table_title fl"><i class="fa fa-user-circle"></i> Customer Information</div>
                <div class="clearfix"></div>


                <div class="signup_screen">
                    <?php
                    $array = $this->session->flashdata('message');
                    if (count($array) > 0) {
                        ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Framgång!</strong> <?php echo $array['content']; ?>
                        </div> 

                        <?php
                        $this->session->unset_userdata('message');
                    }
                    ?>

                    <div class="signup_form">
                        <?php echo form_open(site_url('list-invoice') . '?id=' . $_GET['id']); ?>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="First name" class="form-control" id="name" name="name" value="">
                                <label for="name" class="fa fa-user-circle" rel="tooltip" title="name"></label>

                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Last Name" class="form-control" id="last_name" name="last_name" value="">
                                <label for="last_name" class="fa fa-user-circle" rel="tooltip" title="last_name"></label>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Telefon siffra" class="form-control" id="contact" name="contact" value="">
                                <label for="contact" class="fa fa-phone" rel="tooltip" title="contact"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            
                            <div class="icon-addon">
                                <input type="email" placeholder="E-post" class="form-control" id="email" name="email" value="">
                                <label for="email" class="fa fa-envelope" rel="tooltip" title="email"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 ">
                            <div class="icon-addon">
                                <input type="text" placeholder="Adrress" class="form-control" id="address" name="address" autocomplete="off" value="">
                                <label for="Address" class="fa fa-address-card-o" rel="tooltip" title="Cutomer's Address"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="City" class="form-control" id="city" name="city" autocomplete="off" value="">
                                <label for="city" class="fa fa-building" rel="tooltip" title="Cutomer's City"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Zip" class="form-control" id="zip" name="zip" autocomplete="off" value="">
                                <label for="zip" class="fa fa-map-marker" rel="tooltip" title="Cutomer's Zip Code"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="State" class="form-control" id="state" name="state" autocomplete="off" value="">
                                <label for="state" class="fa fa-flag-o" rel="tooltip" title="Cutomer's State"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Country" class="form-control" id="coutry" name="country" autocomplete="off" value="">
                                <label for="coutry" class="fa fa-globe" rel="tooltip" title="Cutomer's Country"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <select class="form-control" id="store_name" name="store_name">
                                    <option value="John Fredrik-17">John Fredrik</option>
                                    <option value="Onninen-19">Onninen</option>
                                    <option value="Lundagrossisten-26">Lundagrossisten</option>
                                    <option value="Ahlsell-27">Ahlsell</option>
                                    <option value="Dahls-28">Dahls</option>
                                    <option value="Rinkaby rör-35">Rinkaby rör</option>
                                    <option value="Carping-38">Carping</option>
                                </select>
                                <label for="store" class="fa fa-industry" rel="tooltip" title="Slect Store"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <select class="form-control" id="invoice_type" name="invoice_type">
                                    <option value="faktura">faktura</option>
                                    <option value="offert">offert</option>
                                    <option value="ÄTA">ÄTA</option>
                                </select>
                                <label for="store" class="fa fa-industry" rel="tooltip" title="Slect Store"></label>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <textarea type="text" placeholder="Special Comments" class="form-control" id="special_comments" name="special_comments" autocomplete="off" value="" ></textarea>
                                <label for="special_comments" class="fa fa-sticky-note" rel="tooltip" title="Special Country"></label>
                            </div>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="icon-addon">
                                <input type="text" placeholder="Find & select products from here" class="form-control" id="search_products" name="search_products" value="" />
                                <div class="searchContainer customSearchContainer"></div>
                                <label for="search_products" class="fa fa-search" rel="tooltip" title="Search Products"></label>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12">
                            <label class="lblProducts">Selected Products</label>
                            <div class="icon-addon">
                                <ul id="selected_pros">
                                    <?php
                                    if(!empty($productlist)){
                                        foreach ($productlist as $key => $pro) { ?>
                                            <li id="pro_<?php echo $pro->product_id ?>"><?php echo $pro->pro_name ?>
                                                <p class="fa fa-trash" onclick="removeProduct(<?php echo $pro->product_id ?>)"></p>
                                            </li>
                                    <?php } } ?>
                                </ul>
                            </div>
                        </div>
                        
                        <?php
                            $productlist_arr = json_decode(json_encode($productlist), True);
                            $product_ids = array_column($productlist_arr, 'product_id');
                        ?>

                        <input type="hidden" class="selected_products" name="selected_products[]" value="<?php echo implode(",", $product_ids); ?>" />
                        <?php /* ?>
                        <div class="form-group col-xs-12 col-sm-12">
                            <div class="">
                                <select class="form-control" id="multiDropdown" name="selected_products[]" multiple>
                                    <?php
                                    if(!empty($productlist)){
                                        foreach ($productlist as $key => $pro) { ?>
                                            <option value="<?php echo $pro->product_id ?>" selected><?php echo $pro->pro_name ?></option>
                                    <?php } }
                                    if(!empty($productalllist)){
                                        foreach ($productalllist as $key2 => $pro2) { ?>
                                            <option value="<?php echo $pro2->id ?>"><?php echo $pro2->pro_name ?></option>
                                    <?php } 
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php */ ?>
                        
                        <div class="form-group text-center account_btn">
                            <!--<a href="#" class="reg-btn">Create an Account</a>-->
                            <input type="submit" name="submit" id="sbmt" class="reg-btn" value="Genrate Invoice">
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