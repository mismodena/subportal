<?php
$this->breadcrumbs=array(
	'Cek Pembayaran',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Cek Pembayaran</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->search(),
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(
                'NAMECUST',
                'INVNUMBER',
                'CNTBTCH',
                'IDRMIT',
                array(
                    'name'=>'INVDATE',
                    'type'=>'raw',
                    'value'=>'date("d-m-Y", strtotime($data->INVDATE))',
                ),
                array(
                    'name'=>'DATERMIT',
                    'type'=>'raw',
                    'value'=>'!is_null($data->DATERMIT) ? date("d-m-Y", strtotime($data->DATERMIT)) : "--"',
                ),
                array(
                    'name'=>'DATEBTCH',
                    'type'=>'raw',
                    'value'=>'!is_null($data->DATEBTCH) ? date("d-m-Y", strtotime($data->DATEBTCH)) : "--"',
                ),
                array(
                    'name'=>'INVNETWTX',
                    'type'=>'raw',
                    'value'=>'number_format($data->INVNETWTX,0)',
                ),
                array(
                    'name'=>'AMTPAYM',
                    'type'=>'raw',
                    'value'=>'!is_null($data->AMTPAYM) ? number_format($data->AMTPAYM,0) : "--"',
                ),
                array(
                    'name'=>'pkpAge',
                    'type'=>'raw',
                    'value'=>'$data->pkpAge. " hari"',
                ),
	),
)); ?>

