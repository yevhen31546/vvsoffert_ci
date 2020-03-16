
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
                        <?php
                            $sub_page_title = "";
                            if($_GET['type'] == '1'){
                                $sub_page_title = "Gör offer";
                            }else if($_GET['type'] == '2'){
                                $sub_page_title = "Gör ÄTA";
                            }else if($_GET['type'] == '3'){
                                $sub_page_title = "Gör faktura";
                            }else{
                                $sub_page_title = "Gör";
                            }
                        ?>
                        <div class="col-md-8 col-sm-12">
                            <span id="invoice_type_state_title" style="float:left;"><?php echo $sub_page_title; ?></span>
                        </div>
                        <div class="col-md-4 col-md-12">
                        <!--<div style="float:left;" class="invoice_notify_icon">-->
                        <!--    <i class="fas fa-tachometer-alt" style = "font-size: 25px; margin-right: 10px;"></i>-->
                        <!--</div>-->
                            <div class="col-md-8 col-md-12">
                            </div>
                            <!-- <div class="col-md-4 col-md-12">
                                <button type="button" class="btn btn-success" style="align:left;">
                                    <a href="<?php echo site_url('list-only-invoice-form') . '?id=MTQz&type=3'; ?>" style = "font-size: 20px; color: white;">
                                        <i class="far fa-file" style = "margin-right: 5px;"></i>Gör faktura
                                    </a>
                                </button>
                            </div> -->
                        </div>
                    </div>
                    
                    <div class = "form-group col-sm-12 invoice_history_list_2">
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
                                    <!--<th>Action</th>-->
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
                </div>      
            </div>
        </div>    
    </div>
</div>
