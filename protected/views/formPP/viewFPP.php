<?php

$this->breadcrumbs=array(
	'Daftar FPP'=>array('indexFPP'),
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
                    'value'=>'$row+1',
                    'headerHtmlOptions' => array('style'=>'width:5%;'),
                ),
                array(                    
                    'header'=>'Faktur',
                    'value'=>'$data->fppInvNo',
                    'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),
                array(
                   'name'=>'Keperluan',                   
                   'type'=>'raw',
                   'value'=>'$data->fppDesc',
                   //   'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                array(                    
                    'header'=>'Jumlah',
                    'value'=>'"Rp. ".number_format($data->fppDetailValue)',
                    'headerHtmlOptions' => array('style'=>'width:15%;'),
                    'htmlOptions' => array('style'=>'text-align:right;'),
                ),
	),
)); ?>

<div style="display: block" id="containerTotal">
    <table width="100%" border="0">              
        <tr>
            <td style="text-align: right">
                <h3>Total Pengajuan</h3>
            </td>
            <td width="18%" style="text-align: right">
                <h3 id="subTotal"><?php echo "Rp. ". number_format($total); ?></h3>
            </td>
        </tr> 
    </table>
</div>

<?php 
    if($model->fppStatus==3)
    {
        $this->renderPartial('_formAccounting', array('approval'=>$approval,));
    }
 ?>
