
<style>
    .edit_state td {
        background-color: #ffcf8a!important;
    }
    td:focus {
        outline-color: #109e4f;
        text-align: center;
        background-color: white!important;
        font-size: 21px;
    }
    .dt-button{
        border-radius: 10px!important;
        background-image:none!important;
        background-color: #5cb85c!important;
        color: #fafdff!important;
        margin-left:5px;
    }
    
    .invoice_notify_icon:hover svg{
        color:#23527c;
        cursor: pointer;
    }

    .invoice_history_list .row_hidden{
        display:none;
    }
    @media only screen and (max-device-width: 1025px) {
    /* styles for mobile browsers smaller than 480px; (iPhone) */
    #head_caption_offerter_edit {
        display: none !important;
    }
    }
    @media (max-width: 767px){
        .signup_screen .signup_form .reg-btn {
            padding: 10px 18px !important;
            width: 100% !important;
            margin-top: 10px !important;
        }
    }

    @media (max-width:1023px){
        .down_pdf{
            background-color: #337ab7;
            color: white !important;
            height: 50px;
            width : 200px;
            border-radius : 5px;.
            font-size:20px;
            margin-left : -85px !important;
            margin-top :41px;
            
        }
        .preview_pdf{
            background-color: #337ab7;
            color: white !important;
            height: 50px;
            width : 200px;
            border-radius : 5px;.
            font-size:20px;
            left : 115px;
            margin-top :-15px;
            
        }
        .btn_save{
            height : 50px;
            width : 200px;
            font-size : 20px;
            margin-left :30px;
            margin-top : 20px !important;
            margin-bottom:20px !important;
            margin-left:100px ! important;
            /* float : center !important; */
        }
    }

    @media (max-width:811px){
        .down_pdf{
            background-color: #337ab7;
            color: white !important;
            height: 50px;
            width : 200px;
            border-radius : 5px;.
            font-size:20px;
            margin-left : 115px !important;
            margin-top :5px;
            
        }
        .preview_pdf{
            background-color: #337ab7;
            color: white !important;
            height: 50px;
            width : 200px;
            border-radius : 5px;.
            font-size:20px;
            left : 115px;
            margin-top :-15px;
            
        }
        .btn_save{
            height : 50px;
            width : 200px;
            font-size : 20px;
            margin-left :30px;
            margin-top : 20px !important;
            margin-bottom:20px !important;
            margin-left:100px ! important;
            /* float : center !important; */
        }
    }

    @media (min-width:1025px){
        .down_pdf{
            background-color: #337ab7;
            color: white !important;
            height: 50px;
            width : 200px;
            border-radius : 5px;.
            text-align : center !important;
            font-size:20px;
            float : center !important;
            left : -15px;
            
        }
        .preview_pdf{
            background-color: #337ab7;
            color: white !important;
            height: 50px;
            width : 200px;
            border-radius : 5px;.
            text-align : center !important;
            font-size:20px;
            float : center !important;
            
        }
        .btn_save{
            height : 50px;
            width : 200px;
            font-size : 20px;
            margin-left :30px;
            float : right !important;
        }
    }
</style>

<script type="text/javascript">
</script>
<div class="col-xs-12 col-sm-9 col-xl-10 table_content">
    <div class="overall_content">
                <div class="table_header">
                
                <div class="row signup_screen" style = "width: 100%!important; margin-top: -20px; border-top: 5px none; padding-left: 10px; max-width:initial;">
                    <?php

                    $array = $this->session->flashdata('message');
                    if (!empty($array)) {
                        ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Framgång!</strong> <?php echo $array['content']; ?>
                        </div> 
                        <?php
                        $this->session->unset_userdata('message');
                    }
                    ?>
                    <div class="signup_form" >
                        <div id="invoice_type_state" class = "col-sm-12" style = "font-size: 35px;font-weight:700;margin-bottom:15px; color:#1E9F2E ">
                            <span id="invoice_type_state_title" style="float:left;color:green;"><?php echo "Gör Offert"; ?></span>
                        </div>
                        <div class = "invoice_history_list_1 form-group col-sm-12" style = "display:none;">
                            
                        </div>

                    <div class="clearfix"></div>
                    <hr style="border-top: 3px solid #ff9310;">
                        

                    <form id="make_offerter_form" name="make_offerter_form" method="post" action="<?php echo site_url('user/pdf_export_only_offerter_edited'); ?>" enctype="multipart/form-data">
                    <div class="form-group col-sm-12" style = "margin-bottom: 30px; padding:0;">
                    <div class="col-md-4 col-lg-4 col-sm-12" style="height:60px;">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-lg-4 col-sm-12">
                                    <label class="form-label control-label">Kund:</label>
                                </div>
                                <div class="col-md-8 col-lg-8 col-sm-12 input-group">
                                    <select style="line-height:28px; padding-left:5px; height: 40px;" class="form-control store_id" id="customer_sel" name="customer_sel" >
                                        <?php foreach ($customers as $customer) { 
                                            if ($customer->id == $offerter_info[0]->customer_sel){?>
                                                <option value="<?php echo $customer->id; ?>" selected><?php echo $customer->first_name . "  " . $customer->last_name; ?></option>  
                                            <? }else{ ?>
                                                <option value="<?php echo $customer->id; ?>"><?php echo $customer->first_name . "  " . $customer->last_name; ?></option>  
                                            <? } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="quote_date" rel="tooltip" title="Order Date">Datum:</label>
                                </div>
                                <div class="col-md-8 col-lg-8 col-sm-12 input-group date datetimepicker" id='invoice_date_value'>
                                    <input type='text' id="quote_date" name="quote_date" class="form-control"  style = "height: 40px;" value="<?php echo set_value('quote_date', $offerter_info[0]? $offerter_info[0]->quote_date :''); ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar" style = "padding-top: 5px;"></span>
                                    </span>
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="valid_date" rel="tooltip" title="Planned Delivery Date">Gäller tom:</label>
                                </div>
                                <div class="col-md-8 col-lg-8 col-sm-12 input-group date datetimepicker" id='due_date_value'>
                                    <input type='text' id="valid_date" name="valid_date" class="form-control"  style = "height: 40px;" value="<?php echo set_value('valid_date', $offerter_info[0]? $offerter_info[0]->valid_date :''); ?>"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar" style = "padding-top: 5px;"></span>
                                    </span>
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group col-sm-12" style = "margin-bottom: 0px; padding:0;">
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-lg-4 col-sm-12">
                                    <label class="form-label control-label">Er referens</label>
                                </div>
                                <div class="col-md-8 col-lg-8 col-sm-12 input-group">
                                    <input type="text" placeholder="" style="height:40px" class="form-control" id="your_ref" name="your_ref" value="<?php echo set_value('your_ref', $offerter_info[0]? $offerter_info[0]->your_ref :''); ?>">
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-lg-4 col-sm-12">
                                    <label class="form-label control-label">Vår referens:</label>
                                </div>
                                <div class="col-md-8 col-lg-8 col-sm-12 input-group">
                                    <input type="text" placeholder="" style="height:40px" class="form-control" id="our_ref" name="our_ref" value="<?php echo set_value('our_ref', $offerter_info[0]? $offerter_info[0]->our_ref :''); ?>">
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="icon-addon col-sm-4">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="store" rel="tooltip" title="Slect Store">Välj Butik:</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12 input-group">
                                <select style="line-height:28px; padding-left:5px; height: 40px;font-size:20px;" class="form-control store_id" id="store_name_inv" name="store_name_inv">
                                    <?php  
                                        $sel_store = explode ("-", $offerter_info[0]->store_name_inv);
                                        foreach ($estoreAllList as $estore) {
                                        ?>
                                        <option value="<?php echo $estore->name . '-' . $estore->id; ?>" <?php if($estore->name == $sel_store[0]) {?> selected="selected"<? } ?>><?php echo $estore->name; ?></option>                                
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                        <div class="col-md-4 col-lg-4 col-sm-12" style="display:none;">
                            <div class="col-xs-12 col-sm-12" style="height:auto;">
                                    <div class="col-md-4 col-lg-4 col-sm-12">
                                        <label class="form-label control-label">Invoice ID</label>
                                    </div>
                                    <div class="col-md-8 col-lg-8 col-sm-12">
                                        <input type="text" placeholder="" style="height:40px;" class="form-control" id="id" name="id" value="<?php echo set_value('id', $offerter_info[0]? $offerter_info[0]->id :''); ?>">
                                    </div>
                                    <span style="color:red;"><?php ?></span>
                            </div>
                        </div>
                                              
                        <div class="clearfix"></div>
                        <hr style="border-top: 3px solid #ff9310;">
                        <div class = "col-sm-12" id="add-article-area" style = "min-height: 50px; margin-top:20px">
                            
                            <div class="col-sm-12 row head_caption" id="head_caption_offerter_edit">
                                <div class="col-md-2  col-sm-12">
                                    <label>Artikel</label>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label>Artikelnamn</label>
                                </div>
                                <div class="col-md-1 col-sm-12" style="margin-left:12px;">
                                    <label>Kvantitet</label>
                                </div>
                                <div class="col-md-2 col-sm-12" style="margin-left:6px;">
                                    <label>Enhet</label>
                                </div>
                                <div class="col-md-1 col-sm-12" style="margin-left:12px;">
                                    <label>Pris</label>
                                </div>
                                <div class="col-md-1 col-sm-12" style="margin-left:6px;">
                                    <label>Rabatt</label>
                                </div>
                                <div class="col-md-1 col-sm-12" style="margin-left:6px;">
                                    <label>Summa</label>
                                </div>
                            </div>
                            <?php 
                                $article_numstr = '';
                                foreach ($articles as $article) { 
                                    $article_numstr .= $article->art_num.',';
                                }
                            ?>
                            <input style='font-size:18px;display:none;' type='text' placeholder='' class='form-control ' id='article_nums' value='<? echo $article_numstr;?>'> 
                           <? 
                           
                            $art_idarys = json_decode($offerter_info[0]->art_id,true);
                            $art_namearys = json_decode($offerter_info[0]->art_name,true);
                            $art_quantityarys = json_decode($offerter_info[0]->art_quantity,true);
                            $unitarys = json_decode($offerter_info[0]->unit,true);
                            $price_exclarys = json_decode($offerter_info[0]->sale_price_excl,true);
                            $discountarys = json_decode($offerter_info[0]->discount,true);
                            $sum_excl = json_decode($offerter_info[0]->sum_excl,true);
                            $price_list = json_decode($offerter_info[0]->price_list,true);
                            
                            foreach($art_idarys as $key => $art_idary){ 
                                ?>
                                <div class='add-article-row row' style='margin-bottom:5px;' id='added-row-<? echo $key;?>'>
                                <div class='col-md-2 col-sm-12'>
                                    <!-- <select style='line-height:28px; padding-left:5px; height: 34px;font-size:18px;' class='form-control artclass' attr-id='added-row-<? echo $key;?>' name='art_id[]'>
                                        <option value='0'>Select Article Num</option>
                                        <?php foreach ($articles as $article) { 
                                            ?>
                                            <option class='<?php echo $article->art_num;?>' value='<?php echo $article->art_num ?>' <?php if($article->art_num == $art_idary) {?> selected="selected"<? } ?>><? echo $article->art_num; ?></option>                                
                                        <?php } ?>
                                    </select> -->
                                    <input style='width:100%;font-size:18px;' type='text' placeholder='' class='form-control artclass' attr-id='added-row-<? echo $key;?>' name='art_id[]' value='<? echo $art_idary; ?>'>
                                    <i class='fa fa-search find-product-info'  style=' position: absolute; top: 9px;  right: 12%;'></i>
                                </div>
                                <div class='col-md-3 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='art_name[]' value='<? echo $art_namearys[$key]; ?>'> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:16px;' type='text' placeholder='' class='form-control ' name='art_quantity[]' value='<? echo $art_quantityarys[$key]; ?>'> 
                                </div>
                                <div class='col-md-2 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='unit[]' value='<? echo $unitarys[$key]; ?>'> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='sale_price_excl[]' value='<? echo $price_exclarys[$key]; ?>'> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='discount[]' value='0.00%'> 
                                </div>
                                <div class='col-md-1 col-sm-12'>
                                    <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='sum_excl[]' value='<? echo $sum_excl[$key]; ?>'>
                                </div>
                                <div class='col-md-1 col-sm-12' style="margin-top:0px">
                                    <i class='fa fa-plus-circle add-article-row-btn' style='font-size:30px;color:green;' ></i>
                                    <i class='fa fa-minus-circle remove-article-row-btn' attr-id='added-row-<? echo $key;?>' style='font-size:30px;color:red;' ></i>
                                </div>
                            </div>
                            <?

                            }
                                    
                           ?>
                            
                        </div>


                        <?php
                        $productlist_arr = json_decode(json_encode($selectedproductList), True);
                        $product_ids = array_column($productlist_arr, 'product_id');
                        // var_dump($product_ids);
                        ?>
                        <input type="hidden" class="selected_products" name="selected_products" id = "selected_products" value="" />
                        <input type="hidden" class="customer_info" id = "customer_info" value='<?php echo json_encode($customers);?>' />
                        <input type="hidden" class="offerter_info" id = "offerter_info" value='<?php echo json_encode($invoiceHistoryList);?>' />
                        <!-- <input type="hidden" class="customer_id" id = "customer_id" name="customer_id" value="" /> -->

                        <div class="col-sm-12" style="margin-top:30px">
                            <div class="col-md-4 col-lg-4"></div>
                            <div class="col-md-4 col-lg-4"></div>
                            <div class="col-md-4 col-lg-4">
                                    <div class="col-md-4 col-lg-4">
                                        <label>Totalsumma</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" style="font-size:20px;" placeholder="" style="height:40px;" class="form-control" id="total_sum" name="total_sum" value="<?php echo set_value('total_sum', $offerter_info[0]? $offerter_info[0]->total_sum :''); ?>">
                                    </div>
                                    <div class="col-md-3"></div>
                            </div>
                        </div>                      
  
                        <div class="col-md-12" style = "margin-top:30px;">
                            <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 btn_save_cls">
                                <button type="submit" class="btn btn-primary btn_save" style = "" id = "sbmt_saves">Spara</button>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3 preview_pdf" style="padding-top:10px !important;">
                                <? $send_id = $offerter_info[0]? $offerter_info[0]->id :''; ?>
                                <a target="_blank" href="<?echo site_url('pdf-export-offerter-preview-new') . '?inv_id=' .$send_id ;  ?>" class="" style="color:white !important; padding-left:47px;">Förhand</a>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3 down_pdf" style="padding-top:10px !important;margin-left:30px;">
                                <? $send_id = $offerter_info[0]? $offerter_info[0]->id :''; ?>
                                <a target="_blank" href="<?echo site_url('pdf-export-offerter-edited-new') . '?inv_id=' .$send_id ;  ?>" class="" style="color:white !important; padding-left:22px;">Ladda ner PDF</a>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                    </form>
                        
                        <div class = "form-group col-sm-12" style = "display: none" id = "template1"></div>
                        <div class="pre-loader">
                            <img src="<?php echo base_url() ?>/assets/img/loader.gif">
                        </div>
                    </div>      
                </div>
            </div>    
    </div>
</div>
<!-- <div class="modal fade" id="addProdut" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
      <div class="modal-dialog modal-dialog-slideout modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" style = "padding-left: 15px;" id="addProductLabel">Add Product</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style = "margin-top: -40px; font-size: 35px;">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" style = "min-height: 140px;">
                    <div class="form-group col-md-12 col-sm-12">
                        <div class="alert alert-danger" style = "display:none;" id = "add_product_alarm">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>Klart!</strong> Don't found the product!
                        </div> 
                        <div class="icon-addon">
                             <input type="hidden" name="id" id = "id" value="">
                            
                            <label for="rsk_no" class="" rel="tooltip" style = "font-size: 20px; padding:5px 15px;">Input RSK:</label>
                            <input type="text" placeholder="Input RSK Number" class="form-control" style = "padding-left: 15px; font-size:20px; height:45px;" id="rsk_no" name="rsk_no" >
                            <span style="color:red; display: none;" id = "check_field">This field must contain 7 digits!</span>
                        </div>
                    </div>
                
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" style = "font-size:18px;" id ="add_product_btn">Add</button>
            <button type="button" class="btn btn-secondary" style = "font-size:18px" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
</div>
<div class="clearfix"></div> -->


</div>
