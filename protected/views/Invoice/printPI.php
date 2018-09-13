<H3>PT. INDOMO MULIA</H3>
<table width="100%">
    <tbody>
        <tr>
            <td style="text-align: center;" colspan="4" width="100%">
            <h3><strong>PROFORMA INVOICE</strong></h3>
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td width="15%">
                Invoice No
            </td>
            <td width="30%">
                : <?php echo $model->invNo; ?>
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                Issue Date
            </td>
            <td>
                : <?php echo date("d-m-Y", strtotime($model->invDate)); ?>
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                PO No
            </td>
            <td>
                : <?php echo $model->poNo; ?>
            </td>
        </tr>
        <tr>
            <td width="30%" colspan="4">
                <?php echo $model->poName; ?>
            </td>
        </tr>
    </tbody>
</table>
<table border="1" width="100%">
    <thead>
        <tr>
            <td align="center" width="20%">
                <strong>Model</strong>
            </td>
            <td align="center">
                <strong>Description Of Goods</strong>
            </td>
            <td align="center" width="10%">
                <strong>Qty</strong>
            </td>
            <td align="center" width="20%">
                <strong>Amount / Pcs</strong>
            </td>
            <td align="center" width="20%">
                <strong>Total Amount</strong>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php 
            
            foreach ($detail as $line=>$item) {
                
                echo "<tr>
                        <td>
                            ".$item['itemModel']."
                        </td>
                        <td>
                            ".$item['itemDesc']."
                        </td>
                        <td align='center'>
                            ".number_format($item['unitQty'])."
                        </td>
                        <td align='right'>
                            ".number_format($item['unitPrice'])."
                        </td>
                        <td align='right'>
                            ".number_format($item['unitPrice']*$item['unitQty'])."
                        </td>
                    </tr>";
            }        
        ?>     
    </tbody>
</table>
<table border="0" width="100%">
    <tbody>
        <tr>
            <td style="text-align: right;">
                <strong>Selling Price</strong>
            </td>
            <td width="5%">
                &nbsp;
            </td>
            <td width="20%" style="text-align: right;">
                <strong><?php echo "Rp. ". number_format($model->grand); ?></strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <strong>Selling Discount</strong>
            </td>
            <td>
                &nbsp;
            </td>
            <td style="text-align: right;">
                <strong><?php echo "Rp. ". number_format($model->invDisc); ?></strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <strong>Down Payment</strong>
            </td>
            <td>
                &nbsp;
            </td>
            <td style="text-align: right;">
                <strong><?php echo "Rp. ". number_format($model->invDP); ?></strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <strong>Retention</strong>
            </td>
            <td>
                &nbsp;
            </td>
            <td style="text-align: right;">
                <strong><?php echo "Rp. ". number_format($model->invRetensi); ?></strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <strong>Value Before Tax</strong>
            </td>
            <td>
                &nbsp;
            </td>
            <td style="text-align: right;">
                <strong><?php echo "Rp. ". number_format($model->invTotal - $model->invDisc - $model->invDP - $model->invRetensi); ?></strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <strong>Value Added Tax</strong>
            </td>
            <td>
                &nbsp;
            </td>
            <td style="text-align: right;">
                <strong><?php echo "Rp. ". number_format(($model->invTotal - $model->invDisc - $model->invDP - $model->invRetensi) * 0.1); ?></strong>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <strong>TOTAL</strong>
            </td>
            <td>
                &nbsp;
            </td>
            <td style="text-align: right;">
                <strong><?php echo "Rp. ". number_format($model->invTotalWtx); ?></strong>
            </td>
        </tr>
        <?php
            if($model->invTempDP > 0){
                echo '<tr>
                        <td style="text-align: right">
                            <strong>DP '. number_format($model->invTempDP).' %</strong>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td style="text-align: right">
                            <strong id="subTotal">Rp. '. number_format(($model->invTempDP/100)*$model->invTotalWtx).'</strong>
                        </td>
                    </tr> ';
            }
        ?>
        <tr>
            <td style="text-align: left;" colspan="3"><?php echo "TOTAL: ".$model->textAmt." Rupiah"; ?></td>
        </tr>
        
    </tbody>
</table>
<table border="1" width="100%">
    <tbody>
    <tr>
        <td width="20%">
        Brand Name
        </td>
        <td>
        &nbsp;MODENA
        </td>
        <td>
        Supplier :
        </td>
    </tr>
    <tr>
        <td>
        Shipment From
        </td>
        <td>
        &nbsp;
        </td>
        <td>
        PT. INDOMO MULIA
        </td>
    </tr>
    <tr>
        <td>
        Destination
        </td>
        <td>
        &nbsp;
        </td>
        <td>
        JL. PROF DR SATRIO C4 NO 13, JAKARTA 12950
        </td>
    </tr>
    <tr>
        <td>
        &nbsp;
        </td>
        <td>
        &nbsp;
        </td>
        <td>
        SIUP : 4420002005317
        </td>
    </tr>
    <tr>
        <td>
        Payment Terms
        </td>
        <td>
        &nbsp;
        </td>
        <td>
        TEL&nbsp;: +(62)-21-29969500<br/>
        FAX&nbsp;: +(62)-21-29969583
        </td>
    </tr>
    <tr>
        <td>
        Delivery Time
        </td>
        <td>
        &nbsp;
        </td>
        <td>
        Contact :<br/>
        Email :
        </td>
    </tr>
    <tr>
        <td rowspan="4">
        Remarks
        </td>
        <td colspan="2">
        1. Payment are recognized when the funds have entered the Seller bank account.
        </td>
    </tr>
    <tr>
        <td colspan="2">
        2. The Seller does not guarantee the availability of stock until the payment are recognized.
        </td>
    </tr>
    <tr>
        <td colspan="2">
        3. Payment must be paid with transfer/cheque/giro method only. payment with cash are not recognize.
        </td>
    </tr>
    <tr>
        <td colspan="2">
        4. Payment must be paid directly to the Seller bank account.
        </td>
    </tr>
    <tr>
        <td colspan="3">
        Bank Detail
        </td>
    </tr>
    <tr>
        <td>
        Beneficiary Address
        </td>
        <td colspan="2">
        : PT. INDOMO MULIA, JL. PROF. DR. SATRIO C4 No 13, JAKARTA 12950
        </td>
    </tr>
    <tr>
        <td>
        Name Of Bank
        </td>
        <td colspan="2">
        : OCBC NISP, GUNUNG SAHARI BRANCH
        </td>
    </tr>
    <tr>
        <td>
        &nbsp;
        </td>
        <td colspan="2">
        &nbsp;&nbsp;JAKARTA - INDONESIA
        </td>
    </tr>
    <tr>
        <td>
        Account No
        </td>
        <td colspan="2">
        : <?php echo $model->salesAcc;?>
        </td>
    </tr>
    <tr>
        <td>
        Swift BIC
        </td>
        <td colspan="2">
        :
        </td>
    </tr>
    </tbody>
</table>
<br/><br/>
<table width="100%">
    <tbody>
        <tr>
            <td align="center">Authorized Signature Of Buyer<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />&nbsp;</td>
            <td align="center">Authorized Signature Of Supplier<br /><br /><?php 
                                echo CHtml::image(Yii::app()->baseUrl."/images/finDept.png","",array('width'=>100,'height'=>100)) ;
                            ?><br /><strong><u>Reynold Simbolon</u></STRONG></td>
        </tr>
        <tr>
            <td align="center">&nbsp;</td>
            <td align="center">Finance Manager</td>
        </tr>
    </tbody>
    
</table>