<!DOCTYPE html>
<html lang="en">  
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            @page { margin: 0.2in;}
        </style>
    </head>
    <body style="width: 100%; border:2px solid #36c6d3;">
        <table style="padding: 10px 5px; border-radius: 3px !important;" width="100%">
            <tr>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <p style="    margin-top: -50px;margin-bottom: 0px !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 15px;color: #9E9E9E; "><span style="color: #9E9E9E;font-size: 16px;"><?= ($post['company_name']) ? $post['company_name'] : '' ?></span></p>
                    <p style="margin-bottom: 0px !important; text-transform: uppercase !important; font-size: 15px; color: #9E9E9E; font-weight: 500;"><span style="color: #9E9E9E; font-size: 16px;"><?= ($post['company_contact']) ? $post['company_contact'] : '' ?></span>&nbsp;&nbsp;</p>
<!--                    <p style=" font-weight: 300 !important; font-size: 11px;">Här kan du jämföra vvsartiklar, pris, lagersaldo från grossister.</p>-->
                </th>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
<!--                    <span style="color: #9E9E9E; font-size: 18px; font-style: italic;">><?php echo isset($post['invoice_type']) ? $post['invoice_type'] : ''; ?></span>-->
                    <span style="color: #9E9E9E; font-size: 40px; font-style: italic; text-align: center;"><?php echo isset($post['invoice_type']) ? $post['invoice_type'] : ''; ?></span>
                    <p style="margin-bottom: 0px !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 15px;color: #9E9E9E; "><span style="color: #9E9E9E;font-size: 16px;"><?php echo isset($post['invoice_type']) ? $post['invoice_type'] : ''; ?> Nummer:</span>&nbsp;&nbsp;<?= $post['invoice_number']; ?></p>
                    <p style="margin-bottom: 0px !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 15px;color: #9E9E9E; "><span style="color: #9E9E9E; font-size: 16px;">Datum:</span>&nbsp;&nbsp;<?= date("M d, Y") ?></p>
                </th>
            </tr>

            <tr>
                <th  style="text-align:left;padding: 0px 0px 0px 15px;">

                </th>
            </tr>
            <tr>
                <th width="50%" style="text-align:left; vertical-align: middle; padding: 0px 0px 0px 15px;">
                    <p style="margin-bottom: 0px !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 15px;color: #9E9E9E; "><span style="color: #9E9E9E;font-size: 16xp;">Kundnamn:</span>&nbsp;&nbsp;<?= !empty($post['customer_name']) ? $post['customer_name'] : ''; ?></p>
                    <p style="margin-bottom: 0px !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 15px;color: #9E9E9E; "><span style="color: #9E9E9E;font-size: 16px;">E-post:</span>&nbsp;&nbsp;<?= $post['email']; ?></p>
                </th>
            </tr>
            <tr>
                <th width="50%" style="text-align:left; padding: 0px 0px 0px 15px;">
                    <p style="margin-bottom: 0px !important; font-weight: 300 !important; text-transform: uppercase !important; font-size: 15px;color: #9E9E9E; "><span style="color: #9E9E9E; font-size: 16px;">Kommentarer:</span>&nbsp;&nbsp;<?= $post['special_comments']; ?></p>
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <table style="margin-top: 15px;border: 1px solid #ddd; border-radius: 3px !important;font-family: helvetica;" width="100%">
                        <thead>
                            <tr>
                                <th width="20%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: center; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">RSK-Nr</th>
                                <th width="35%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;  text-align: center; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Produktnamn</th>
                                <th width="10%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: center; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Antal</th>
                                <th width="20%" style="height: 30px !important; vertical-align: middle !important; text-transform: uppercase!important; font-size: 15px;text-align: center; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Pris</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            if (count($post['products']) > 0) :
                                ?>
                                <?php
                                foreach ($post['products'] as $k => $v) :
                                    if (isset($post['products'][$k]) && isset($post['products'][$k]['total'])) {
                                        $integeralValue = floatval(str_replace(',', '', $post['products'][$k]['total'])) * floatval(str_replace(',', '', $post['products'][$k]['quantity']));
                                    } else {
                                        $integeralValue = 0;
                                    }
                                    $grandTotal += $integeralValue;
                                    $totalValueRow = number_format("$integeralValue", 2, ".", "");
                                    ?>
                                    <tr>
                                        <td style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;"><?= $v['rsk_number'] ?></td>
                                        <th style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;"><?= $v['productname'] ?></th>
                                        <th style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;"><?= $v['quantity'] ?></th>
                                        <td style="padding: 5px 0 !important; min-height: 30px !important; vertical-align: middle !important; font-size: 15px; font-weight: 300 !important; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;"><?= $totalValueRow ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <th colspan="4" style="">Det finns ingen produkt att visa.</th>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th colspan="3" style="text-align:right">
                                    <b>Totalpris ex moms:</b>
                                </th>
                                <th><b>
                                        <?= number_format($grandTotal, 2, ".", "") ?></b>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </th>
            </tr>
        </table>
    </body>
</html>