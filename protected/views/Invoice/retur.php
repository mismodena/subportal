<?php
$this->breadcrumbs=array(
	'Retur PKP',
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

<h1>Retur PKP</h1>

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
                array(
                    'header'=>'Ord. Number',
                    'type'=>'raw',
                    'value'=>'$data->invNumber',
                ),
                'idCust',
                'nameCust',                
                array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'number_format($data->value,0)',
                ),
                array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update}',
                    'buttons'=>array(
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("returPKP", array("id"=>$data->invNumber,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                
                        ),
                    ),    
                ),
	),
)); ?>

<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog',
    'options'=>array(
        'title'=>'Proses Retur PKP',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>300,
        'resizable' => false,
    ),
    ));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget();?>
