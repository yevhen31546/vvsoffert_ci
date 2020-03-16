
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
                        <div id="invoice_type_state" class = "col-sm-12" style = "font-size: 30px; ">
                            
                        </div>
                        <div class = "invoice_history_list_1 form-group col-sm-12" style = "display:none;">
                            <table id="invoice_history_list_sub_table" class="table table-striped table-bordered" cellspacing="0" width="100%" style="margin:0px;">
                                <!--<thead>-->
                                <!--    <tr>-->
                                <!--        <th>Kundnamn: </th>-->
                                <!--        <th>Email</th>-->
                                <!--        <th>Adress:</th>-->
                                <!--        <th>Postnumberoch ort</th>-->
                                <!--        <th>Invoice Date</th>-->
                                <!--        <th>Comments</th>-->
                                <!--        <th>InvoiceNumber</th>-->
                                <!--        <th>Välj Butik</th>-->
                                <!--        <th>Fakturatyp</th>-->
                                <!--        <th>DateTime</th>-->
                                <!--        <th>Verkan</th>-->
                                <!--    </tr>-->
                                <!--</thead>-->
                                <thead>
                                    <tr>
                                        <th colspan='12' style="text-align:center;">Histories: </th>
                                    </tr>
                                </thead>
                                <tbody id="invoice_table1">

                                <?php
                                // var_dump($invoiceHistoryList);
                                // exit();
                                
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
                                            <!--<td><?php echo ($k+1);?></td>-->
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
                                            <!--<td id = "invoice_type_<?php echo $k ?>" contenteditable="false"><?= $v->invoice_type ?></td>-->
                                            <td id = "invoice_type_<?php echo $k ?>" contenteditable="false"><?= $v->updated_at ?></td>
                                            <!--<td id = "edit_<?php echo $k ?>" contenteditable="false"><a class="btn">Edit</a></td>-->
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
                                        <!--<th>Fakturatyp</th>-->
                                        <th>DateTime</th>
                                        <!--<th>Verkan</th>-->
                                    </tr>
                                </thead>
                                <tbody id="invoice_table2">
                                <?php
                        
                                // var_dump($invoiceHistoryList);
                                // exit();
                                if (count($invoiceHistoryList) > 0) {
                                    $k=0;
                                    foreach ($invoiceHistoryList as $v) {
                                        // $customer_sel = $v['customer_sel'];
                                        // $email = $v['email'];
                                        // $address = $v['address'];
                                        // $city = $v['city'];
                                        // $special_comments = $v['special_comments'];
                                        // $invoice_number = $v['invoice_number'];
                                        // $store_name = $v['store_name'];
                                        // $invoice_type = $v['invoice_type'];
                                        // $date_value = $v['date_value'];
                                        // $create_at = $v['create_at'];
                                        // $updated_at = $v['updated_at'];
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
                                            <!--<td id = "invoice_type_<?php echo $k ?>" contenteditable="false"><?= $v->invoice_type ?></td>-->
                                            <td id = "updated_at_<?php echo $k ?>" contenteditable="false"><?= $v->updated_at ?></td>
                                            <!--<td id = "edit_<?php echo $k ?>" contenteditable="false"><a class="btn">Edit</a></td>-->
                                        </tr>
                                <?php
                                        $k=$k+1;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <?php echo form_open(site_url('pdf-export-invoice-edited')  . '?id=' . $_GET['id'] . '&action=pdf_export', 'target="#" id="product"');?>
                        <div class="form-group col-sm-12" style = "margin-bottom: 30px; padding:0;">
                            <div class = "col-sm-9" style = "padding:0;">
                                <div style="padding-left: 0px; padding-right: 0px; margin-bottom: 20px;" class = "col-sm-12">
                                    <div style="padding-left: 0px; padding-right: 0px;" class="form-group col-sm-7">
                                        <div class="icon-addon col-sm-5">
                                            <label for="name" rel="tooltip" title="name">Kundnamn:</label>
                                            <select style="line-height:28px; padding-left:5px; height: 40px;" class="form-control store_id" id="customer_sel" name="customer_sel" >
                                                <?php foreach ($customers as $customer) { ?>
                                                    <option value="<?php echo $customer->id; ?>"><?php echo $customer->first_name . "  " . $customer->last_name; ?></option>  
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="icon-addon col-sm-7">
                                            <label for="email" rel="tooltip" title="email">Email:</label>
                                            <input type="email" placeholder="E-post" class="form-control" style = "padding-left: inherit; height: 40px;" id="email" name="email" value=''>
                                        </div>
                                        <div class = "col-sm-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-sm-3">
                        </div>
                            
                        </div>
                       
                        <div style="padding-left: 0px; padding-right: 0px; margin-bottom: 40px;" class="form-group col-sm-12 ">
                            <div class="icon-addon col-sm-4">
                                <label for="Address" rel="tooltip" title="Cutomer's Address">Adress:</label>
                                <input type="text" placeholder="Adress" class="form-control" style = "padding-left: inherit; height: 40px;" id="address" name="address" autocomplete="off" value=''>
                            </div>
                            <div class="icon-addon col-sm-2">
                                <label for="city" rel="tooltip" title="Cutomer's City">Postnummer och ort</label>
                                <input type="text" placeholder="Postnummer och ort" class="form-control" style = "padding-left: inherit; height: 40px;" id="city" name="city" autocomplete="off" value="">
                            </div>
                            <div class="icon-addon col-sm-4">
                                <label for="date_value" rel="tooltip" title="Invoice Date">Invoice Date:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type='text' id="date_value" name="date_value" class="form-control"  style = "height: 40px;"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar" style = "padding-top: 5px;"></span>
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div style="padding-left: 0px; padding-right: 0px;" class="form-group col-sm-12">
                            <div class="icon-addon col-sm-4">
                                <label for="special_comments" rel="tooltip" title="Special Country">Projektkommentarer:</label>
                                <textarea type="text" placeholder="Kommentarer" class="form-control" style = "padding-left: inherit; min-height: 100px;" id="special_comments" name="special_comments" autocomplete="off" ></textarea>
                            </div>
                            <div class="icon-addon col-sm-2">
                                <label for="city"  rel="tooltip">Projektnummer:</label>
                                <input type="text" placeholder="Projektnummer" class="form-control" style = "padding-left: inherit; height: 40px;" id="invoice_number" name="invoice_number" value="" autocomplete="off" value="">
                            </div>
                            <div class="icon-addon col-sm-4">
                                <label for="store" rel="tooltip" title="Slect Store">Välj Butik:</label>
                                <select style="line-height:28px; padding-left:5px; height: 40px;" class="form-control store_id" id="store_name" name="store_name">

                                    <?php foreach ($estoreAllList as $estore) { ?>
                                        <option value="<?php echo $estore->name . '-' . $estore->id; ?>" <?php if($estore->name == "Dahl") {?> selected="selected"<? } ?>><?php echo $estore->name; ?></option>                                
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="hidden" name="invoice_type" value="<?php echo $_GET['type']; ?>"/>
                            <!--<div class="icon-addon col-sm-2">-->
                            <!--    <label for="invoice_type" rel="tooltip" title="Invoice Type">Fakturatyp:</label>-->
                            <!--    <select style="line-height:28px; padding-left:5px; height: 40px;" class="form-control" id="invoice_type" name="invoice_type" onchange="change_invoice_type()">-->
                            <!--        <option value="1">offer</option>-->
                            <!--        <option value="2">ÄTA</option>-->
                            <!--        <option value="3">faktura</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                        </div>                       
                        
                        <div class = "col-sm-12" style = "min-height: 50px;">
                            
                        </div>
                        <div class = "form-group col-sm-12" style = "margin-bottom: 40px;" id = "template">
                            <table id="invoice_datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <!--<th>No</th>-->
                                        <th>Produktnamn</th>
                                        <th>RSK NUMMER</th>
                                        <th>Antal</th>
                                        <th>Enhetspris</th>
                                        <th>Pris</th>
                                        <th>Radera</th>
                                    </tr>
                                </thead>
                                <tbody id="invoice_table">
                                    <?php
                                        $grandTotal = 0;
                                        if (count($productlist) > 0) {
                                            foreach ($productlist as $k => $v) {
                                                $price = json_decode($v['PRICE']);
                                                $tmp_key;
                                                $tmp_val;
                                                foreach( $price as $row){
                                                    foreach($row as $key=>$val){
                                                        // print_r($key);
                                                        if($key == $defaultEstore){
                                                            $tmp_val=$val;
                                                            $tmp_key = $key;
                                                        }
                                                    }
                                                }
                                                $integeralValue = floatval(str_replace(',', '', $tmp_val));
                                                $grandTotal += $integeralValue;
                                                $totalValueRow = number_format("$integeralValue", 2, ".", "");
                                                
                                                ?>
                                                <tr>
                                                    <!--<td><?php echo ($k+1);?></td>-->
                                                    <td id = "pro_name_<?php echo $k ?>" contenteditable="false"><?= $v['PRO_NAME'] ?></td>                                  
                                                    <td id = "rsk_no_<?php echo $k ?>" contenteditable="false"><?= $v['RSK_NO'] ?></td>
                                                    <td id = "quantity_<?php echo $k ?>" contenteditable="false"><?= $v['QUANTITY'] ?></td>
                                                    <td id = "unit_<?php echo $k ?>" data = '
                                                    <?php
                                                        echo $v['PRICE'];
                                                    ?>
                                                    ' contenteditable="false"><?= $totalValueRow ?></td>
                                                    <td id = "subtotal_<?php echo $k ?>"></td>
                                                    <td style = "text-align: center;" id = "action_<?php echo $k ?>">
                                                        <a href="#" onclick="editProduct(<?php echo $k ?>)" style = "color: white; width: 50px; height: 30px; background-color: #f0ad4e; padding:5px 10px; box-shadow: 5px 3px lightgrey; border-radius: 8px; margin-right: 15px;" class="fa fa-edit" id = "edit"></a>
                                                        <a href="#" onclick="saveProduct(<?php echo $k ?>)" style = "color: white; width: 50px; height: 30px; background-color: green; padding:5px 10px; box-shadow: 5px 3px lightgrey; border-radius: 8px; margin-right: 15px; display: none" class="fa fa-save" id = "save"></a>
                                                        <a href="#" onclick="removeProduct(<?php echo $k ?>)" style = "color: white; width: 50px; height: 30px; background-color: #d9534f; padding: 5px 10px;; box-shadow: 5px 3px lightgrey; border-radius: 8px;" class="fa fa-trash"></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="11">
                                                    Ingen produkt hittades !!
                                                </td>
                                            </tr>
                                    <?php } ?>
                                            <tfoot> 
                                                <tr>
                                                    <th colspan="4" style="text-align:right; font-size: 22px;">Total:</th>
                                                    <th colspan="2"style="font-size: 22px;"></th>
                                                </tr>
                                            </tfoot>
                                </tbody>
                            </table>
                        </div>
                        
                        

                        <?php
                        $productlist_arr = json_decode(json_encode($selectedproductList), True);
                        $product_ids = array_column($productlist_arr, 'product_id');
                        // var_dump($product_ids);
                        ?>

                        <input type="hidden" class="selected_products" name="selected_products" id = "selected_products" value="" />
                        <input type="hidden" class="customer_info" name="customer_info" id = "customer_info" value='<?php echo json_encode($customers);?>' />
                        
  
                        <div class=" text-center account_btn rtl" style = "float: right">
                            <!--<a href="#" styel = "color: white;" class="reg-btn">Convert to PDF</a>-->
                            <button type="button" class="btn btn-primary" style = "height: 50px; width: 200px; font-size: 20px;" id = "sbmt_save">Save</button>
                            <button type="button" class="btn btn-primary" style = "height: 50px; width: 200px; font-size: 20px;" id = "sbmt_pdf">Convert to PDF</button>
                            <button type="button" id="sbmt_email" class = "btn btn-primary" style = "height: 50px; width: 200px; font-size: 20px;">Send to Email</button>
                            <!--<a target="_blank" href="<?echo site_url('pdf-export-invoice-edited') . '?action=pdf_export&' . http_build_query($_POST); ?>" class="reg-btn" style="padding: 10px 15px; font-size:16px;">Download as PDF</a>-->
                           
                        </div>
                        
                        <div class="clearfix"></div>
                        <?php echo form_close(); ?>
                        
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
