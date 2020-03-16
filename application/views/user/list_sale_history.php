
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

    @media (min-width: 1025px){
        .add-button{
            float : right;
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
                    <div id="invoice_type_state" class = "col-md-12 col-sm-12" style = "font-size: 30px; ">
                        <div class="col-md-11 col-md-12">
                            <label style = "font-size: 35px;color:#1E9F2E">Alla fakturor</label>
                        </div>
                        <div class="col-md-1 col-sm-12 add-button">
                            <button type="button" class="btn btn-success">
                                <a href="<?php echo site_url('list-only-invoice-form') . '?id=MTQz&type=3'; ?>" style = "font-size: 20px; color: white;">
                                    <i class="far fa-file" style = "margin-right: 5px;"></i>Ny faktura
                                </a>
                            </button>
                        </div>
                        
                    </div>
                    
                    <div class = "form-group col-sm-12 invoice_history_list_2">
                        <table id="invoice_history_table_all" class="table table-striped table-bordered" cellspacing="0" style="font-size:18px;" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">Ver.nr</th>
                                    <th scope="col">Fakt.nr </th>
                                    <th scope="col">Kundnr</th>
                                    <th scope="col">Kundnamn</th>
                                    <th scope="col">Typ</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Fakturadatum</th>
                                    <th scope="col">Förfallodatum</th>
                                    <th scope="col">Totalbelopp</th>
                                    <th scope="col">Visa</th>
                                </tr>
                            </thead>
                            <tbody id="invoice_table2">
                            <?php
                    
                            // var_dump($invoiceHistoryList);
                            // exit();
                            if (count($invoiceHistoryList) > 0) {
                                $k=0;
                                foreach ($invoiceHistoryList as $v) {
                                    ?>
                                    <tr id="invoice_id_<?php echo $v->id ?>">
                                        <!-- <td><?php echo ($k+1);?></td> -->
                                        <td data-label="Ver.nr" id = "customer_id_<?php echo $k ?>" contenteditable="false">
                                            <?php 
                                            foreach ($customers as $customer) { 
                                                if( $v->customer_sel == $customer->id ){
                                                    echo $customer->id_number;
                                                    break;
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td data-label="Fakt.nr" id = "invoice_num_<?php echo $k ?>" contenteditable="false"><?= $v->id + 1200; ?></td>
                                        <td data-label="Kundnr" id = "customer_num_<?php echo $k ?>" contenteditable="false">
                                            <?php 
                                            foreach ($customers as $customer) { 
                                                if( $v->customer_sel == $customer->id ){
                                                    echo $customer->id+50;
                                                    break;
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td data-label="Kundnamn" id = "customer_name_<?php echo $k ?>" contenteditable="false">
                                            <?php 
                                            foreach ($customers as $customer) { 
                                                if( $v->customer_sel == $customer->id ){
                                                    echo $customer->first_name . "  " . $customer->last_name;
                                                    break;
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td data-label="Typ" id = "customer_type_<?php echo $k ?>" contenteditable="false">
                                            <?php 
                                            foreach ($customers as $customer) { 
                                                if( $v->customer_sel == $customer->id ){
                                                    echo $customer->customer_type;
                                                    break;
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td data-label="Kategori" id = "delivery_method_<?php echo $k ?>" contenteditable="false">
                                            <?php 
                                            foreach ($customers as $customer) { 
                                                if( $v->customer_sel == $customer->id ){
                                                    echo $customer->delivery_method;
                                                    break;
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td data-label="Fakturadatum" id = "invoice_date_<?php echo $k ?>" contenteditable="false"><?= $v->invoice_date_value ?></td>
                                        <td data-label="Förfallodatum" id = "due_date_<?php echo $k ?>" contenteditable="false"><?= $v->due_date_value ?></td>
                                        <td data-label="Totalbelopp" id = "total_sum_<?php echo $k ?>" contenteditable="false"><?= $v->total_sum ?></td>
                                        <td data-label="Verkan">
                                            <div class="option_btn" style="margin-left:25%;">
                                                <div class= "col-sm-12"><a class="" href="<?php echo site_url('edit-invoice'). '?&id='.$v->id;?>" id="<?=$v->id?>"><i class="fa fa-edit fl"></i></a></div>
                                                <!-- <div class= "col-sm-6"><a id="<?=$customer->id?>" class="" href="javascript:;" onclick="deleteCustomer(this)" data-targetSlug="<?=$customer->id?>"><i class="fa fa-trash fr" style = "color:#d9534f"></i></a></div> -->
                                                <div class="clearfix"></div>
                                            </div>
                                        </td>
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
