
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
            float:right;
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
                    <div id="invoice_type_state" class = "col-md-12 col-sm-12">
                       
                        <div class="col-md-4 col-md-12">
                            <label style = "font-size: 35px;color:#1E9F2E ">Alla offerter</label>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <button type="button" class="btn btn-success add-button">
                                <a href="<?php echo site_url('list-only-offerter-form') . '?id=MTQz&type=3'; ?>" style = "font-size: 20px; color: white;">
                                    <i class="far fa-file" style = "margin-right: 5px;"></i>Ny offert
                                </a>
                            </button>
                        </div>
                        
                    </div>
                    
                    <div class = "form-group col-sm-12 invoice_history_list_2">
                        <table id="invoice_history_table_all" class="table table-striped table-bordered display responsive responsive-table no-wrap" cellspacing="0" style="overflow-x: scroll">
                            <thead>
                                <tr>
                                    <th scope="col">Offertnr</th>
                                    <th scope="col">Kundnr </th>
                                    <th scope="col">Kundnamn</th>
                                    <th scope="col">Belopp</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Offertdatum</th>
                                    <th scope="col">Giltig t o m</th>
                                    <th scope="col">Visa</th>
                                </tr>
                            </thead>
                            <tbody id="invoice_table2">
                            <?php
                    
                            // var_dump($invoiceHistoryList);
                            // exit();
                            if (count($offerterHistoryList) > 0) {
                                $k=0;
                                foreach ($offerterHistoryList as $v) {
                                    ?>
                                    <tr id="invoice_id_<?php echo $v->id ?>">
                                        
                                        <td data-label="Citat Num" id = "order_num_<?php echo $k ?>" contenteditable="false"><?= $v->id+1200; ?></td>
                                        <td data-label="Kundnummer" id = "customer_num_<?php echo $k ?>" contenteditable="false">
                                            <?php 
                                            foreach ($customers as $customer) { 
                                                if( $v->customer_sel == $customer->id ){
                                                    echo $customer->id+50;
                                                    break;
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td data-label="Köparens namn" id = "customer_name_<?php echo $k ?>" contenteditable="false">
                                            <?php 
                                            foreach ($customers as $customer) { 
                                                if( $v->customer_sel == $customer->id ){
                                                    echo $customer->first_name . "  " . $customer->last_name;
                                                    break;
                                                }
                                            } 
                                            ?>
                                        </td>
                                        <td data-label="Belopp" id = "total_sum_<?php echo $k ?>" contenteditable="false"><?= $v->total_sum ?></td>
                                        <td data-label="Status" id = "order_date_<?php echo $k ?>" contenteditable="false"><?= $v->state ?></td>
                                        <td data-label="Datum" id = "order_date_<?php echo $k ?>" contenteditable="false"><?= $v->quote_date ?></td>
                                        <td data-label="Giltig genom datum" id = "delivery_num_<?php echo $k ?>" contenteditable="false"><?= $v->valid_date ?></td>
                                        <td data-label="Verkan">
                                            <div class="option_btn" style="margin-left:25%;">
                                                <div class= "col-sm-12"><a class="" href="<?php echo site_url('edit-offerter'). '?&id='.$v->id;?>" id="<?=$v->id?>"><i class="fa fa-edit fl"></i></a></div>
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
