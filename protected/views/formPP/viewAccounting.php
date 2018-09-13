<?php

$this->breadcrumbs=array(
	'Daftar Persetujuan FPP'=>array('approval'),
	$model->fppNo,
);

foreach(Yii::app()->user->getFlashes() as $key => $message) {
echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}

Yii::app()->clientScript->registerScript(
'myHideEffect',
'$(".flash-success").animate({opacity: 1.0}, 1000).fadeOut("slow");',
CClientScript::POS_READY
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
		'fppCategoryValue',
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
                <h3>LIMIT</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppLimit); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>SALDO</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppSaldo); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>FISIK</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppCash); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>BON GANTUNG</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($model->fppOutstanding); ?></h3>
            </td>
        </tr>  
        <tr>
            <td style="text-align: right">
                <h3>TOTAL PENGAJUAN</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($total); ?></h3>
            </td>
        </tr>   

    </table>
</div>

<?php 
    if($approval->pic==="")
    {
        $this->renderPartial('_formAccounting', array('approval'=>$approval,));
    }
 ?>
