<?php
$this->breadcrumbs=array(
	'Daftar Review FPP Accounting',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#fpp-header-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar Review FPP Accounting</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fpp-header-grid',
	'dataProvider'=>$model->searchAccounting(),
	'columns'=>array(
		//'fppID',
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->fppNo." - ".$data->fppUserName,Yii::app()->createUrl("formPP/viewAccounting",array("id"=>$data->fppID)))).'
                    . '"<br/>Dept-Div/Cabang: ".$data->fppUserDeptName."-".$data->nameDiv."/".$data->nameBranch.'
                    . '"<br/>Tanggal pengajuan: ".$data->fppUserDate',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                array(
                    'name'=>'total',
                    'header'=>'Total',
                    'value'=>'"Rp. ".number_format($data->TOTAL)',
                    'htmlOptions' => array('style'=>'text-align: right;'),
                ),
                array(
                    'name'=>'persetujuan',
                    'header'=>'Status',
                    'value'=>'$data->approval',
                    'htmlOptions' => array('style'=>'text-align: left;'),
                ),
	),
)); ?>
