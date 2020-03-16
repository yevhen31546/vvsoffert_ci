<!DOCTYPE html>
<html lang="en">  
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            @page { margin: 0.2in;}
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
        </style>
    </head>
    <!--<body style="width: 60%; border:2px solid #36c6d3;align:center;margin-left:20%;" width="60%">-->
    <body class="main_body" style="position:relative;height:1200px; width: 60%; border:12px solid #070C13;align:center;margin-left:20%;">
    <div style=" border:5px solid #070C13;">
    <div style="">
        <!-- <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3 preview_pdf" style="padding-top:10px !important;">
                <? $send_id = $invoice_id? $invoice_id :''; ?>
                <a target="_blank" href="<?echo site_url('pdf-export-invoice-edited-new') . '?inv_id=' .$send_id ;  ?>" class="" style="color:white !important; padding-left:22px;">Ladda ner PDF</a>
        </div> -->
        <table style="padding: 10px 5px; border-radius: 3px !important; margin-top:0%;font-family: helvetica;" width="100%">
            <tr>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <p style="    margin-top: 0px;margin-bottom: 0%; !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 60px;color: #000000 !important; ">VVS</p>
                    <p style="    margin-top: 0px;margin-bottom: 3%; !important; font-weight: 700 !important; font-size: 40px;color: #000000 !important; ">Group ab.</p>
                </th>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <p style="    margin-top: 0px;margin-bottom: 3%; !important; text-transform: uppercase !important; font-size: 24px; color: #000000 !important; font-weight: 700;">Faktura </p>
                    <p style="    margin-top: 0px;margin-bottom: 3%; !important; text-transform: uppercase !important; font-size: 20px; color: #000000 !important; font-weight: 700;">Fakturanummer &nbsp;&nbsp;&nbsp;&nbsp;<?= !empty($invoice_id) ? $invoice_id + 1200 : ''; ?></p>
                </th>
            </tr>
            <tr style="">
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                </th>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <table style="margin-top: 15px;border: 1px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="80%">
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "><?= !empty($name) ? $name : ''; ?></p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="   margin-top:0px; margin-bottom: 2%; !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "><?= !empty($customer_postcode) ? $customer_postcode : ''; ?>&nbsp;&nbsp;<?= !empty($customer_city) ? $customer_city : ''; ?></p>
                            </th>
                        <tr>
                    </table>
                </th>
            </tr>
            <tr>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <table>
                        <tr>
                            <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; ">Kundnr </p>
                            </th>
                            <th width="70%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "><?= !empty($customer_num) ? $customer_num : ''; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; ">Fakturadatum</p>
                            </th>
                            <th width="70%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                            <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "><?= !empty($date_value) ? $date_value : ''; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; ">Leveransdatum</p>
                            </th>
                            <th width="70%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "><?= !empty($delivery_date) ? $delivery_date : ''; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; ">Er referens </p>
                            </th>
                            <th width="70%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "><?= !empty($your_ref) ? $your_ref : ''; ?></p>                            
                            </th>
                        </tr>
                        <tr>
                            <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; ">Vår referens </p>
                            </th>
                            <th width="70%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "><?= !empty($our_ref) ? $our_ref : ''; ?></p>
                            </th>
                        </tr>
                        <tr>
                            <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "> </p>
                            </th>
                            <th width="70%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "><?= !empty($custom_ref) ? $custom_ref : ''; ?></p>
                            </th>
                        </tr>
                        <!--<tr>-->
                        <!--    <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">-->
                        <!--        <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; ">Dröjsmålsränta </p>-->
                        <!--    </th>-->
                        <!--    <th width="70%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">-->
                        <!--        <p style="    margin-top: 5px;margin-bottom: 1%; !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 16px;color: #000000 !important; "><?= !empty($note) ? $note : ''; ?></p>-->
                        <!--    </th>-->
                        <!--</tr>-->
                    </table>
                </th>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <table style="margin-top: 15px;border: 0px solid #ddd; border-radius: 3px !important;font-family: helvetica;" width="100%">
                        <thead>
                            <tr>
                                <th width="20%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: left; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;">Art.nr</th>
                                <th width="35%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;  text-align: left; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;">Benämning</th>
                                <th width="10%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: left; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;">Antal</th>
                                <th width="10%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: left; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;">Enhet</th>
                                <th width="20%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: left; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;">Pris</th>
                                <th width="20%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: left; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;">Summa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            if (count($art_ids) > 0) :
                                ?>
                                <?php
                                foreach ($art_ids as $key => $art_id) :
                                    ?>
                                    <tr>
                                        <td style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;"><?= $art_id ?></td>
                                        <th style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;"><?= $art_names[$key] ?></th>
                                        <th style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;"><?= $art_quatities[$key] ?></th>
                                        <th style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;">ST</th>
                                        <td style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;"><?= $art_prices[$key] ?></td>
                                        <td style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 0px solid #ddd; border-right: 0px solid #ddd;"><?= $sum_prices[$key] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <th colspan="4" style="">Det finns ingen produkt att visa.</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </th>
            </tr>
        </table>
        </div>
        <div style="height:40%;">
            </div>
        <div style="position:absolute !important; bottom:0px;">
        <table style="padding: 10px 5px; border-radius: 3px !important; margin-top:0%;font-family: helvetica;" width="100%">
            <tr>
                <th width="30%" style="margin-top:10%">
                    <table  style="margin-top: 13%;border: 1px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="100%" height="25%">
                        <thead>
                                    <tr>
                                        <th width="40%"> 
                                            <p style="margin-top:3%">Totalpris ex moms:</p>
                                        <th>
                                        <th width="30%"> 
                                            <p style="margin-top:3%"> <?php echo $total_sum ? $total_sum : 0 ?></p>
                                        <th>
                                        <th width="30%"> 
                                        <th>
                                    </tr>
                                    <tr>
                                        <th width="40%"> 
                                            <p style="margin-top:3%">Moms (<?php if(!$reverse_tax) echo "25%"; else echo "0%";?>):</p>
                                        <th>
                                        <th width="30%"> 
                                            <p style="margin-top:3%"> <?php 
                                                if(!$reverse_tax)
                                                    echo $total_sum ? ($total_sum * 0.25) : 0 ;
                                                else
                                                    echo 0 ; 
                                            ?></p>
                                        <th>
                                        <th width="30%"> 
                                        <th>
                                    </tr>
                                    <tr>
                                        <th width="40%"> 
                                            <p style="margin-top:3%">Avrundning:</p>
                                        <th>
                                        <th width="30%"> 
                                            <p style="margin-top:3%"> 0.00</p>
                                        <th>
                                        <th width="30%"> 
                                        <th>
                                    </tr>
                        </thead>
                    </table>
                </th>
                <th width="30%">
                    <table  style="margin-top: 15px;border: 1px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="100%" height="25%">
                        <thead>
                            
                                    <tr>
                                        <th width="40%"> 
                                        <? echo '<img src="qrcodeoutput.php" />'; ?>
                                        <th>
                                        <th>
                                            <p style="margin-top:1%">Förfallodatum:</p>
                                        <th>
                                        <th width="30%"> 
                                            <p style="margin-top:1%"> <?= !empty($delivery_date) ? $delivery_date : ''; ?></p>
                                        <th>
                                    </tr>
                                    <tr>
                                        <th><th>
                                        <th width="40%"> 
                                            <p style="margin-top:-10%">Bankgiro:</p>
                                        <th>
                                        <th width="30%"> 
                                            <p style="margin-top:-10%"> 619-1662</p>
                                        <th>
                                    </tr>
                                    <tr>
                                        <th><th>
                                        <th width="40%"> 
                                            <!--<p style="margin-top:0%">Summa:</p>-->
                                            <p style="margin-top:0%"></p>
                                        <th>
                                        <th width="30%"> 
                                            <p style="margin-top:0%"></p>
                                        <th>
                                    </tr>
                                    <tr>
                                        <th><th>
                                        <th width="40%"> 
                                            <p style="margin-top:0%; font-size:25px;">Att betala:</p>
                                        <th>
                                        <th width="30%"> 
                                            <p style="margin-top:0%; font-size:25px;"> <?php 
                                                if(!$reverse_tax)
                                                    echo $total_sum ? ($total_sum * 1.25) : 0 ;
                                                else
                                                    echo $total_sum ? ($total_sum) : 0 ; 
                                            ?></p>
                                        <th>
                                    </tr>
                        </thead>
                    </table>
                </th>
                
            </tr>
            <?php if($reverse_tax){ ?>
                <tr>
                    <table  style="margin-top: 15px;border: 1px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="100%" height="25%">
                    </table>
                </tr>
                <tr>
                    <p>&nbsp;&nbsp;&nbsp;Denna faktura avser hunsarbete, där du som kund uppgett att du har rätt till en preliminär skattereduktion pä 2 686,00kr. För att vi ska kunna göra ansökan till Skatteverket, <br>&nbsp;&nbsp;ska du betala 8 668,00kr. Som köpare blir du bentalningsskyldig för icke godkänt belopp om Skatteverkets avslag beror på omständigheter som kan härledas till dig som köpare.</p>
                </tr>
                <? } ?>
            <tr>
                <table  style="margin-top: 15px;border: 1px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="100%" height="25%">
                </table>
            </tr>
        </table>
        <table>
            <tr style="">
                <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <table style="margin-top: 15px;border: 0px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="80%">
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">Address</p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "><?= !empty($name) ? $name : ''; ?></p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 0%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "><?= !empty($customer_email) ? $customer_email : ''; ?></p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="   margin-top:0px; margin-bottom: 2%; !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "><?= !empty($customer_postcode) ? $customer_postcode : ''; ?>&nbsp;&nbsp;<?= !empty($customer_city) ? $customer_city : ''; ?></p>
                            </th>
                        <tr>
                    </table>
                </th>
                <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <table style="margin-top: 15px;border: 0px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="80%">
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">Telefon</p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "><?= !empty($phone) ? $phone : ''; ?></p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">E-post/Webbplats</p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="   margin-top:0px; margin-bottom: 2%; !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "><?= !empty($web_plats) ? $web_plats : ''; ?></p>
                            </th>
                        <tr>
                    </table>
                    
                </th>
                <th width="30%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <table style="margin-top: 0px;border: 0px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="80%">
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">Organisationsnr</p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">556804-9802</p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">Godkänd för F-skatt</p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; "></p>
                            </th>
                        <tr>
                    </table>
                </th>
                <th width="10%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <table style="margin-top: -40px;border: 0px solid #000000; border-radius: 3px !important;font-family: helvetica;" width="80%">
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">Momsreg.nr</p>
                            </th>
                        <tr>
                        <tr>
                            <th width="100%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                                <p style="    margin-top: 2%;margin-bottom: 0px !important; font-weight: 500 !important; text-transform: uppercase !important; font-size: 14px;color: #000000 !important; ">SE556804980201</p>
                            </th>
                        <tr>
                    </table>
                </th>
            </tr>
        </table>
        </div>
        </div>
    </body>
</html>
