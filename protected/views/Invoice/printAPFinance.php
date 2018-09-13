<script type="text/javascript">
window.onload = function(){ window.print();}
</script>

<H3>PT. INDOMO MULIA</H3>
<table width="100%">
<tbody>
    <tr>
        <td style="text-align: center;" colspan="6" width="100%">
        <h3><strong>TANDA TERIMA TAGIHAN SUPPLIER</strong></h3>
        </td>
    </tr>

    <tr>
        <td width="15%">
            Supplier
        </td>
        <td width="30%">
            : <?php echo $model->apSupplier; ?>
        </td>
    </tr>
    <tr>
        <td width="15%">
            No. Penagihan
        </td>
        <td width="30%">
            : <?php echo $model->recNo; ?>
        </td>
    </tr>
    <tr>
        <td width="15%">
            Tanggal Penagihan
        </td>
        <td width="30%">
            : <?php echo date("d-m-Y", strtotime($model->recDate)); ?>  
        </td>
    </tr>
    <tr>
        <td width="15%">
            Total
        </td>
        <td width="30%">
            : <?php echo $model->apInvTotal; ?>
        </td>
    </tr>
</tbody>
</table>&nbsp;&nbsp;
<table border="1" width="100%">
    <thead>
        <tr>

            <td align="center" width="20%">
                <strong>Nomor Faktur</strong>
            </td>
            <td align="center">
                <strong>Tanggal Faktur</strong>
            </td>
            <td align="center">
                <strong>Tanggal Jatuh Tempo</strong>
            </td>
            <td align="center">
                <strong>No Po</strong>
            </td>
            <td align="center">
                <strong>Total Invoice</strong>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php 
            
            foreach ($detailInv as $line=>$item) {
                
                echo "<tr>
                        
                        <td>
                            ".$item['apInvNo']."
                        </td>
                        <td>
                            ".date("d-m-Y", strtotime($item->apInvDate))."
                        </td>
                        <td>
                            ".date("d-m-Y", strtotime($item->apDueDate))."
                        </td>
                        <td>
                            ".$item['poNo']."
                        </td>
                        <td>
                            ".$item['apInvTotal']."
                        </td>
                        

                    </tr>";
            }        
        ?>     
    </tbody>
</table>&nbsp;</br>
<table border="0" width="100%">
    <thead>
        <tr>
            <td align="left" width="5%">
                <strong>Check</strong>
            </td>
            <td align="left" width="20%">
                <strong>Kelengkapan Dokumen</strong>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php 
            
            foreach ($detail as $line=>$item) {
                
                echo "<tr>
                        <td>
                        <input type='checkbox'  value='checked' >
                        </td>
                        <td>
                           ".APDocumentName::model()->find("invDocID=:invDocID", array(":invDocID"=>$item->docID))->invDocName."
                        </td>


                    </tr>";
            }        
        ?>     
    </tbody>
</table>&nbsp;</br>&nbsp;</br></br>
<table border="0" width="100%">
    <tbody>
        <tr>
            <td>              
               <td align="right">Diserahkan Oleh,<br /><br /><br /><br /><br /><br /><br /><br /><br /><strong><u>Nama:</u></STRONG><br/>(Pihak eksternal)&nbsp;</td>
                <td align="right">Diterima Oleh,<br /><br /><?php 
                        echo CHtml::image(Yii::app()->baseUrl."/images/griffit.png","",array('width'=>100,'height'=>100)) ;
                    ?><br /><strong><u>Nama: Griffit Yoyner</u></STRONG><br/>(Finance - PT. Indomo Mulia)</td>
            </td>
        </tr>
    </tbody>
</table>
