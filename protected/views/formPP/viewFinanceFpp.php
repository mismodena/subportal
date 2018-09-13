<style>
 .boks {
    width: 11em; 
    border: 1px solid #000000;
    word-wrap: break-word;
  }
  
</style>

<style type="text/css">
.submenu, .submenu:link, .submenu:visited { font-family: Verdana, Arial, Tahoma; font-size: 10px; color: #FF6600; text-decoration: none; }
.submenu:hover { color: darkblue; text-decoration: none }
.content_small, .content_small:link, .content_small:visited { font-family: Verdana, Arial, Tahoma; font-size: 12px; color: #0066FF; text-decoration: none; }
.content_small:hover {
 font-family:Verdana, Arial, Tahoma;
 font-size: 12px;
 color: #FF6600;
 text-decoration: none;
}
.footer_small, .footer_small:link, .footer_small:visited { font-family: Verdana, Arial, Tahoma; font-size: 10px; color: #0066FF; text-decoration: none; }
.footer_small:hover {
 font-family: Verdana, Arial, Tahoma;
 font-size: 10px;
 color: #FF6600;
 text-decoration: none;
}

</style>
<table width="80%" align="center" border= 0 style="font-family: Verdana, Arial, Tahoma; font-size: 10px; text-decoration: none; ">
	<tr>
		<td align="center">
                    <strong>FORM PERMINTAAN PEMBAYARAN</strong>
		</td>
	</tr>
	<tr>
		<td align="right">
			Nomor : <?php echo $model->fppNo?>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" width="100%" style="font-family: Verdana, Arial, Tahoma; font-size: 9px; text-decoration: none; ">
				<tr>
					<td width="20%">
						Nama Penerima	
					</td>
					<td>
					: <?php echo $model->fppToName?>	
					</td>
					<td>
					&nbsp;	
					</td>
					<td width="20%">
						Tanggal
					</td>
					<td width="25%">
					: <?php echo $model->fppUserDate?>	
					</td>
				</tr>
				<tr>
					<td width="20%">
						Bank	
					</td>
					<td>
					: <?php echo $model->fppToBank?>		
					</td>
					<td>
					&nbsp;	
					</td>
					<td width="20%">
						Kas / Bank* 
					</td>
					<td width="20%">
					: 
					</td>
				</tr>
				<tr>
					<td width="20%">
						&nbsp;	
					</td>
					<td>
					&nbsp;
					</td>
					<td>
					&nbsp;	
					</td>
					<td width="20%">
						Cheque / Giro No.
					</td>
					<td width="20%">
					: 
					</td>
				</tr>
				<tr>
					<td width="20%">
						No. Rekening	
					</td>
					<td>
						: <?php echo $model->fppToBankAcc?>	
					</td>
					<td>
					&nbsp;	
					</td>
					<td width="20%">
						Nama Pemohon
					</td>
					<td width="20%">
					: <?php echo $model->fppUserName?>	
					</td>
				</tr>
				<tr>
					<td width="20%">
						Tanggal Pembayaran	
					</td>
					<td>
						: <?php echo $model->fppToDate?>	
					</td>
					<td>
					&nbsp;	
					</td>
					<td width="20%">
						Div / Dept / Cabang
					</td>
					<td width="20%">
					: <?php echo $model->fppUserDeptName?>	
					</td>
				</tr>
				<tr>
					<td width="20%">
						&nbsp;	
					</td>
					<td>
					&nbsp;
					</td>
					<td>
					&nbsp;	
					</td>
					<td width="20%">
						Voucher No.
					</td>
					<td width="20%">
					: 
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
        <tr><td><br/>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'fpp-detail-grid',
                    'dataProvider'=>$detail,
                    //'filter'=>$model,
                    'columns'=>array(
                            array(                    
                                'header'=>'No.',
                                'value'=>'$row+1'
                            ),
                            array(
                               'name'=>'Keperluan',                   
                               'type'=>'raw',
                               'value'=>'$data->fppDesc',
                               'headerHtmlOptions' => array('style'=>'width:75%;'),
                            ),
                            array(                    
                                'header'=>'Jumlah',
                                'value'=>'"Rp. ".number_format($data->fppDetailValue)',
                                'htmlOptions' => array('style'=>'text-align:right;'),
                            ),
                    ),
            )); ?></td></tr>
            <tr><td>
            <table width="100%" border="0">                  
               <tr>
                   <td style="text-align: right">
                       <strong>Total Pengajuan</strong>
                   </td>
                   <td width="18%" style="text-align: right">
                       <strong id="subTotal"><?php echo "Rp. ". number_format($total); ?></strong>
                   </td>
               </tr>                 
            </table>                
        </td></tr>        
        <tr><td>&nbsp;</td></tr>
	<tr>
		<td>
			<table width="100%" border="1">
				<tr align="center">
					<td>Pemohon</td>
					<td>Ka. Dept / BM</td>
					<td>Finance</td>
					<td>Accounting</td>
					<td>Ka. Div</td>
					<td>Direktur</td>	
				</tr>
				<tr align="center">
					<td>Dibuat Oleh,<br/><br/><br/><br/><br/><br/><?php echo "&nbsp;"//date("d-m-Y", strtotime($approval['userDate'])); ?><br/><?php echo $approval['userName']; ?></td>
					<td><?php echo "&nbsp;"//date("d-m-Y", strtotime($approval['deptHeadDate'])); ?><br/><?php echo $approval['deptHeadName']; ?></td>
                                        <?php
                                        
                                        //if(!is_null($approval['financeDate']))
                                        //{
                                        //    echo '<td><p class="boks">SIGNED</p>'.date("d-m-Y", strtotime($approval["financeDate"])).'<br/>'.$approval["financeName"].'</td>';
                                        //} 
                                        //else
                                        //{
                                            echo '<td>&nbsp;</td>';
                                        //}
                                        
                                        if(!is_null($approval['accountingDate']))
                                        {
                                            echo '<td><p class="boks">SIGNED</p>'.date("d-m-Y", strtotime($approval["accountingDate"])).'<br/>'.$approval["accountingName"].'</td>';
                                        } 
                                        else
                                        {
                                           echo '<td>&nbsp;</td>';
                                        }
                                        
                                        if(!is_null($approval['divHeadDate']))
                                        {
                                            echo '<td><p class="boks">SIGNED</p>'.date("d-m-Y", strtotime($approval["divHeadDate"])).'<br/>'.$approval["divHeadName"].'</td>';
                                        } 
                                        else
                                        {
                                           echo '<td>&nbsp;</td>';
                                        }
                                        ?>					
					                                        
					<td>&nbsp;</td>	
				</tr>
			</table>
		</td>
	</tr>
</table>

