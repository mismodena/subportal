<?php

$this->breadcrumbs=array(
	'Daftar FPP'=>array('index'),
	$model->fppNo,
);

?>

<h1>FPP No. #<?php echo $model->fppNo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'fppNo',
		'fppUserName',
		'fppUserDeptName',
		'fppUserDate',
		'fppToName',
		'fppToBank',
		'fppToBankAcc',
		'fppToDate',
		'fppCategoryDesc',
		//'fppCategoryValue',
                array(
                    'label'=>'RQN', 
                    'type'=>'raw', 
                    'value'=>CHtml::link($model->fppCategoryValue, array('viewDetail','id'=>$model->fppID))),

	),
)); ?>
<br/>
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
)); ?>

<div style="display: block" id="containerTotal">
    <table width="100%" border="0">      
        <tr>
            <td style="text-align: right">
                <h3>Limit</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppLimit); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>Saldo</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppSaldo); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>Fisik</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppCash); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>Bon Gantung</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppOutstanding); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>Pengajuan</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($total); ?></h3>
            </td>
        </tr> 
        <?php if($model->adjType !== "+-")
               {
                echo '<tr>
                   <td style="text-align: right">
                       <h3>Koreksi* ('.$model->adjustmentType.')</h3>
                   </td>
                   <td width="18%" style="text-align: right">
                       <h3 id="subTotal"> Rp. '. number_format($model->adjValue).'</h3>
                   </td>
               </tr>  ';
                echo '<tr>
                   <td style="text-align: right">
                       <h3>Setelah Koreksi </h3>
                   </td>
                   <td width="18%" style="text-align: right">
                       <h3 id="subTotal"> Rp. '. number_format($model->adjustmentValue).'</h3>
                   </td>
               </tr>  ';
               
                }?>
<?php if($model->adjustmentType !== "+/")
{
    echo '<tr><td>'.$model->adjustmentDesc.' (Rp. '. number_format($model->adjValue).')</td></tr>';
}?>
    </table>
</div>

<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fpp-approval-grid',
	'dataProvider'=>$approval,
	//'filter'=>$model,
	'columns'=>array(
            array(
               'name'=>'Persetujuan',                   
               'type'=>'raw',
               'value'=>'$data->keterangan2',
            ),
            array(
               'name'=>'PIC',                   
               'type'=>'raw',
               'value'=>'!is_null($data->tanggal) ? $data->userName." - ".$data->persetujuan." (".date("d-m-Y", strtotime($data->tanggal)).")" : "--"',
               'headerHtmlOptions' => array('style'=>'width:75%;'),
            ),
	),
)); ?>
