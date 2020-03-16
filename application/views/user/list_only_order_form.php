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
    #head_caption_order {
        display: none !important;
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
                <div id="invoice_type_state" class = "col-sm-12" style = "font-size: 35px;font-weight:700;margin-bottom:15px; ">
                    <span id="invoice_type_state_title" style="float:left;"><?php echo "Gör order"; ?></span>
                </div>
                <div class = "invoice_history_list_1 form-group col-sm-12" style = "display:none;">
                    <table id="invoice_history_list_sub_table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="margin:0px;">
                        <thead>
                            <tr>
                                <th colspan='12' style="text-align:center;">Histories: </th>
                            </tr>
                        </thead>
                        <tbody id="invoice_table1">

                        <?php
                        
                        $max_show_count = 5;
                        if (count($invoiceHistoryList) > 0) {
                            $k=0;
                            $row_class = "";
                            foreach ($invoiceHistoryList as $v) {
                                if($k >= $max_show_count)
                                    $row_class="row_hidden";
                                else
                                    $row_class="";
                                
                        ?>
                                <tr id="invoice_id_<?php echo $v->id ?>" class="<?php echo $row_class; ?>">
                                    <td id = "customer_sel_<?php echo $k ?>" contenteditable="false">
                                        <?php 
                                        foreach ($customers as $customer) { 
                                            if( $v->customer_sel == $customer->id ){
                                                echo $customer->first_name . "  " . $customer->last_name;
                                                break;
                                            }
                                        } 
                                        ?>
                                    </td>

                                    <td id = "email_<?php echo $k ?>" contenteditable="false"><?= $v->email ?></td>
                                    <td id = "address_<?php echo $k ?>" contenteditable="false"><?= $v->address ?></td>
                                    <td id = "city_<?php echo $k ?>" contenteditable="false"><?= $v->city ?></td>
                                    <td id = "date_value_<?php echo $k ?>" contenteditable="false"><?= $v->date_value ?></td>
                                    <td id = "special_comments_<?php echo $k ?>" contenteditable="false"><?= $v->special_comments ?></td>
                                    <td id = "invoice_number_<?php echo $k ?>" contenteditable="false"><?= $v->invoice_number ?></td>
                                    <td id = "store_name_<?php echo $k ?>" contenteditable="false"><?= $v->store_name ?></td>
                                    <td id = "invoice_type_<?php echo $k ?>" contenteditable="false"><?= $v->updated_at ?></td>
                                </tr>
                        <?php
                                $k=$k+1;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    if(count($invoiceHistoryList) > $max_show_count){
                    ?>
                    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <tbody>
                            <tr id="invoice_id_0">
                                <td contenteditable="false" style="text-align:center;" colspan="12" ><a class="btn invoice_history_list_sub_table_view_more">View More +</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    }
                    ?>
                </div>

                <div class="clearfix"></div>
                <hr style="border-top: 3px solid #ff9310;">

                <div class = "form-group col-sm-12 invoice_history_list_2" style = "display:none;">
                    <table id="invoice_history_table_all" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kundnamn: </th>
                                <th>Email</th>
                                <th>Adress:</th>
                                <th>Postnumberoch ort</th>
                                <th>Invoice Date</th>
                                <th>Comments</th>
                                <th>InvoiceNumber</th>
                                <th>Välj Butik</th>
                                <th>DateTime</th>
                            </tr>
                        </thead>
                        <tbody id="invoice_table2">
                        <?php
                
                        if (count($invoiceHistoryList) > 0) {
                            $k=0;
                            foreach ($invoiceHistoryList as $v) {
                                ?>
                                <tr id="invoice_id_<?php echo $v->id ?>">
                                    <td><?php echo ($k+1);?></td>
                                    <td id = "customer_sel_<?php echo $k ?>" contenteditable="false">
                                        <?php 
                                        foreach ($customers as $customer) { 
                                            if( $v->customer_sel == $customer->id ){
                                                echo $customer->first_name . "  " . $customer->last_name;
                                                break;
                                            }
                                        } 
                                        ?>
                                    </td>

                                    <td id = "email_<?php echo $k ?>" contenteditable="false"><?= $v->email ?></td>
                                    <td id = "address_<?php echo $k ?>" contenteditable="false"><?= $v->address ?></td>
                                    <td id = "city_<?php echo $k ?>" contenteditable="false"><?= $v->city ?></td>
                                    <td id = "date_value_<?php echo $k ?>" contenteditable="false"><?= $v->date_value ?></td>
                                    <td id = "special_comments_<?php echo $k ?>" contenteditable="false"><?= $v->special_comments ?></td>
                                    <td id = "invoice_number_<?php echo $k ?>" contenteditable="false"><?= $v->invoice_number ?></td>
                                    <td id = "store_name_<?php echo $k ?>" contenteditable="false"><?= $v->store_name ?></td>
                                    <td id = "updated_at_<?php echo $k ?>" contenteditable="false"><?= $v->updated_at ?></td>
                                </tr>
                        <?php
                                $k=$k+1;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            <form id="make_order_form" name="make_order_form" method="post" action="<?php echo site_url('user/pdf_export_only_order_edited'); ?>" enctype="multipart/form-data">
                <div class="form-group col-sm-12" style = "margin-bottom: 30px; padding:0;">
                    <div class="col-md-4 col-sm-12" style="height:60px;">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-sm-12">
                                    <label class="form-label control-label">Kund:</label>
                                </div>
                                <div class="col-md-8 col-sm-12 input-group">
                                    <select style="line-height:28px; padding-left:5px; height: 40px;" class="form-control store_id" id="customer_sel" name="customer_sel" >
                                        <option 0>Please select Customer</option>
                                        <?php foreach ($customers as $customer) { ?>
                                            <option value="<?php echo $customer->id; ?>"><?php echo $customer->first_name . "  " . $customer->last_name; ?></option>  
                                        <?php } ?>
                                    </select>
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-sm-12">
                                <label for="order_date" rel="tooltip" title="Order Date">Orderdatum</label>
                                </div>
                                <div class="col-md-8 col-sm-12 input-group date datetimepicker" id='invoice_date_value'>
                                    <input type='text' id="order_date" name="order_date" class="form-control"  style = "height: 40px;"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar" style = "padding-top: 5px;"></span>
                                    </span>
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-sm-12">
                                <label for="plan_delivery_date" rel="tooltip" title="Planned Delivery Date">Planerat lev datum:</label>
                                </div>
                                <div class="col-md-8 col-sm-12 input-group date datetimepicker" id='due_date_value'>
                                    <input type='text' id="plan_delivery_date" name="plan_delivery_date" class="form-control"  style = "height: 40px;"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar" style = "padding-top: 5px;"></span>
                                    </span>
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group col-sm-12" style = "margin-bottom: 0px; padding:0;">
                    <div class="col-md-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-sm-12">
                                    <label class="form-label control-label">Er referens:</label>
                                </div>
                                <div class="col-md-8 col-sm-12 input-group">
                                    <input type="text" placeholder="" style="height:40px" class="form-control" id="your_ref" name="your_ref" value="<?php //echo set_value('id', $model? $model->id :''); ?>">
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                                <div class="col-md-4 col-sm-12">
                                    <label class="form-label control-label">Our <br> reference:</label>
                                </div>
                                <div class="col-md-8 col-sm-12 input-group">
                                    <input type="text" placeholder="" style="height:40px" class="form-control" id="our_ref" name="our_ref" value="<?php //echo set_value('id', $model? $model->id :''); ?>">
                                </div>
                                <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                            <div class="col-md-4 col-sm-12">
                                <label for="store" rel="tooltip" title="Slect Store">Vår referens:</label>
                            </div>
                            <div class="col-md-8 col-sm-12 input-group">
                                <select style="line-height:28px; height: 40px;font-size:20px;" class="form-control store_id" id="store_name_inv" name="store_name_inv">

                                    <?php foreach ($estoreAllList as $estore) { ?>
                                        <option value="<?php echo $estore->name . '-' . $estore->id; ?>" <?php if($estore->name == "Dahl") {?> selected="selected"<? } ?>><?php echo $estore->name; ?></option>                                
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="col-md-12 col-sm-12" style = "margin-bottom: 0px; padding:0;">
                    

                    <div class="col-md-4 col-sm-12" style="display:none;">
                        <div class="col-xs-12 col-sm-12" style="height:auto;">
                            <div class="col-md-4 col-sm-12">
                                <label class="form-label control-label">Invoice ID</label>
                            </div>
                            <div class="col-md-8 col-sm-12 input-group">
                                <input type="text" placeholder="" style="height:40px;" class="form-control" id="id" name="id" value="">
                            </div>
                            <span style="color:red;"><?php ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12" style="display:none;"><>
                </div>
                
                
                                        
                <div class="clearfix"></div>
                <hr style="border-top: 3px solid #ff9310;">
                <div class = "col-sm-12" id="add-article-area" style = "min-height: 50px; margin-top:20px">
                    
                    <div class="col-sm-12 row head_caption" id="head_caption_order">
                        <div class="col-md-2 col-sm-12">
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


                    <div class='add-article-row row' style='margin-bottom:5px;' id="added-row-0">
                        <div class='col-md-2 col-sm-12'>
                            <input style='width:100%;font-size:18px;' type='text' placeholder='' class='form-control artclass' attr-id='added-row-0' name='art_id[]' value=''>
                            <!-- <select style='line-height:28px; padding-left:5px; height: 34px;font-size:18px;' class='form-control artclass' attr-id='added-row-0' name='art_id[]'>
                                <option value='0'>Select Article Num</option>
                                <?php foreach ($articles as $article) { 
                                    ?>
                                    <option class='<?php echo $article->art_num ?>' value='<?php echo $article->art_num ?>'><? echo $article->art_num; ?></option>                                
                                <?php } ?>
                            </select> -->
                            <i class='fa fa-search find-product-info'  style=' position: absolute; top: 9px;  right: 12%;'></i>
                    
                        </div>
                        <div class='col-md-3 col-sm-12'>
                            <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='art_name[]' value=''> 
                        </div>
                        <div class='col-md-1 col-sm-12'>
                            <input style='font-size:16px;' type='text' placeholder='' class='form-control ' name='art_quantity[]' value=''> 
                        </div>
                        <div class='col-md-2 col-sm-12'>
                            <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='unit[]' value=''> 
                        </div>
                        <div class='col-md-1 col-sm-12'>
                            <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='sale_price_excl[]' value=''> 
                        </div>
                        <div class='col-md-1 col-sm-12'>
                            <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='discount[]' value=''> 
                        </div>
                        <div class='col-md-1 col-sm-12'>
                            <input style='font-size:18px;' type='text' placeholder='' class='form-control ' name='sum_excl[]' value=''>
                        </div>
                        
                        <div class='col-md-1 col-sm-12' style="margin-top:0px">
                            <i class='fa fa-plus-circle add-article-row-btn' style='font-size:30px;color:green;' ></i>
                            <i class='fa fa-minus-circle' attr-id='added-row-0' style='font-size:30px;color:red;' ></i>
                        </div>
                    </div>

                </div>
                                        
                
                <div class = "col-sm-12" style = "min-height: 50px;">
                    
                </div>
                <div class = "form-group col-sm-12" style = "margin-bottom: 40px;" id = "template">
                    
                </div>
                
                

                <?php
                $productlist_arr = json_decode(json_encode($selectedproductList), True);
                $product_ids = array_column($productlist_arr, 'product_id');
                ?>
                <input type="hidden" class="selected_products" name="selected_products" id = "selected_products" value="" />
                <input type="hidden" class="customer_info" id = "customer_info" value='<?php echo json_encode($customers);?>' />
                <input type="hidden" class="invoice_info" id = "invoice_info" value='<?php echo json_encode($invoiceHistoryList);?>' />
                
                <div class="col-sm-12" style="margin-top:30px">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                            <div class="col-md-4">
                                <label>Totalsumma</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" style="font-size:20px;" placeholder="" style="height:40px;" class="form-control" id="total_sum" name="total_sum" value="">
                            </div>
                            <div class="col-md-3"></div>
                    </div>
                </div> 

                <div class=" text-center account_btn rtl" style = "float: right">
                    <button type="submit" class="btn btn-primary" style = "height: 50px; width: 200px; font-size: 20px;" id = "sbmt_saves">Spara</button>
                    <!-- <button type="button" class="btn btn-primary" style = "height: 50px; width: 200px; font-size: 20px;" id = "sbmt_pdf">Convert to PDF</button>
                    <button type="button" id="sbmt_email" class = "btn btn-primary" style = "height: 50px; width: 200px; font-size: 20px;">Send to Email</button> -->
                    
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
<div class="modal fade" id="addProdut" tabindex="-1" role="dialog" aria-labelledby="addProduct" aria-hidden="true">
      <div class="modal-dialog modal-dialog-slideout modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" style = "padding-left: 15px;" id="addProductLabel">Add Product</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style = "margin-top: -40px; font-size: 35px;">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" style = "min-height: 140px;">
                <div class="form-group col-xs-12 col-sm-12">
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
<div class="clearfix"></div>


</div>
