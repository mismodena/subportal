<?php
$this->breadcrumbs=array(
	'Daftar PRMD',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#hris-prmd-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar PRMD</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hris-prmd-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
                   'name'=>'Karyawan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->idCard." - ".$data->userName,Yii::app()->createUrl("HRIS/viewPrmd",array("id"=>$data->prmdID)))).'
                    . '"<br/>Dept-Div/Cabang: ".$data->deptName." - ".$data->idDiv." / ".$data->branchName.'
                    . '"<br/>Posisi: ".$data->posName ',
                    
                ),
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'$data->prmdCategoryName.'
                    . '"<br/>Dept-Div/Cabang: ".$data->newDeptName." - ".$data->newIdDiv." / ".$data->branchName.'
                    . '"<br/>Posisi: ".$data->newPosName',
                    
                ),
                array(                    
                    'header'=>'Tgl Mulai',
                    'value'=>' date("d-m-Y", strtotime($data->startDate))',                    
                ),
                array(                    
                    'header'=>'Tgl Akhir',
                    'value'=>' date("d-m-Y", strtotime($data->endDate))',                    
                ),                               
	),
)); ?>
