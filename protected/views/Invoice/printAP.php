<table width="100%">
    <tbody>
        <tr>
            <td style="text-align: left;"><strong>PT. INDOMO MULIA</strong><br />
                <table width="100%">
                    <tbody>
                        <tr>
                            <td colspan="2" width="70%">&nbsp;&nbsp;</td>
                            <td style="text-align: left;" width="10%">No.</td>
                            <td style="text-align: left;">: <?php echo $model->recNo ;?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;&nbsp;</td>
                            <td style="text-align: left;">Tanggal&nbsp;</td>
                            <td style="text-align: left;">: <?php echo date("d-m-Y", strtotime($model->recDate)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            <p><strong>TANDA TERIMA TAGIHAN SUPPLIER</strong></p>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%">
                    <tbody>
                        <tr>
                            <td width="20%">Diterima dari</td>
                            <td>: <?php echo $model->apSupplier; ?></td>
                        </tr>
                        <tr>
                            <td>Faktur/ Invoice No</td>
                            <td>: <?php echo $invNo//$model->apInvNo; ?></td>
                        </tr>
                        <tr>
                            <td>Sejumlah</td>
                            <td>: Rp. <?php echo number_format($model->apInvTotal);?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td><br />
                <table border="1" width="100%" >
                    <thead>
                        <tr>
                            <td style="text-align: center; font-size: 10;" width="5%"><strong>NO</strong></td>
                            <td style="text-align: center;"><strong>Kelengkapan Dokumen</strong></td>
                            <td style="text-align: center;" width="10%"><strong>Pembelian Barang</strong></td>
                            <td style="text-align: center;" width="10%"><strong>Billboard/ Booth Baru</strong></td>
                            <td style="text-align: center;" width="10%"><strong>Pajak Billboard</strong></td>
                            <td style="text-align: center;" width="10%"><strong>&nbsp;Iklan</strong></td>
                            <td style="text-align: center;" width="10%"><strong>Ekspedisi Lokal</strong></td>
                            <td style="text-align: center;" width="10%"><strong>Ekspedisi Import</strong></td>
                            <td style="text-align: center;" width="10%"><strong>Jasa</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                                                        
                            foreach ($detail as $line=>$item) {

                                echo '<tr>
                                        <td style="text-align: center; font-size: 10;" width="5%">'.$item['nomor'].'</td>
                                        <td style="text-align: left;">'.$item['keterangan'].'</td>';
                                
                                if($item['pembelian'])
                                {
                                    echo '<td style="text-align: center;" width="10%">'.CHtml::checkBox("check",$item['pembelian'], array("disabled"=>"disabled")).'</td>';
                                }
                                else
                                {
                                    echo '<td style="text-align: center;" width="10%">&nbsp;</td>';
                                }
                                if($item['billboard'])
                                {
                                    echo '<td style="text-align: center;" width="10%">'.CHtml::checkBox("check",$item['billboard'], array("disabled"=>"disabled")).'</td>';
                                }
                                else
                                {
                                    echo '<td style="text-align: center;" width="10%">&nbsp;</td>';
                                }
                                if($item['pajak'])
                                {
                                    echo '<td style="text-align: center;" width="10%">'.CHtml::checkBox("check",$item['pajak'], array("disabled"=>"disabled")).'</td>';
                                }
                                else
                                {
                                    echo '<td style="text-align: center;" width="10%">&nbsp;</td>';
                                }   
                                  if($item['iklan'])
                                {
                                    echo '<td style="text-align: center;" width="10%">'.CHtml::checkBox("check",$item['iklan'], array("disabled"=>"disabled")).'</td>';
                                }
                                else
                                {
                                    echo '<td style="text-align: center;" width="10%">&nbsp;</td>';
                                }
                                if($item['eksLokal'])
                                {
                                    echo '<td style="text-align: center;" width="10%">'.CHtml::checkBox("check",$item['eksLokal'], array("disabled"=>"disabled")).'</td>';
                                }
                                else
                                {
                                    echo '<td style="text-align: center;" width="10%">&nbsp;</td>';
                                }
                                if($item['eksImport'])
                                {
                                    echo '<td style="text-align: center;" width="10%">'.CHtml::checkBox("check",$item['eksImport'], array("disabled"=>"disabled")).'</td>';
                                }
                                else
                                {
                                    echo '<td style="text-align: center;" width="10%">&nbsp;</td>';
                                }
                                if($item['jasa'])
                                {
                                    echo '<td style="text-align: center;" width="10%">'.CHtml::checkBox("check",$item['jasa'], array("disabled"=>"disabled")).'</td>';
                                }
                                else
                                {
                                    echo '<td style="text-align: center;" width="10%">&nbsp;</td>';
                                }
                                echo    '</tr>';
                            }        
                        ?>     
                        
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tbody>
                       <td align="left">Diserahkan Oleh,<br /><br /><br /><br /><br /><br /><br /><br /><br /><strong><u>Nama:</u></STRONG><br/>(Pihak eksternal)&nbsp;</td>
                        <td align="left">Diterima Oleh,<br /><br /><?php 
                                echo CHtml::image(Yii::app()->baseUrl."/images/griffit.png","",array('width'=>100,'height'=>100)) ;
                            ?><br /><strong><u>Nama: Griffit Yoyner</u></STRONG><br/>(Finance - PT. Indomo Mulia)</td>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
