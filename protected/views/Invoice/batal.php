<?php
$this->breadcrumbs=array(
	'Pembatalan PKP',
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

<h1>Pembatalan PKP</h1>

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
                'idCust',
                array(
                    'name'=>'Nama Dealer',
                    'type'=>'raw',
                    'value'=>'$data->nameCust',
                ),
                'invNumber',            
                array(
                    'name'=>'invDate',
                    'type'=>'raw',
                    'value'=>'date("d-m-Y", strtotime($data->invDate))',
                ),
                array(
                    'name'=>'payDate',
                    'type'=>'raw',
                    'value'=>'date("d-m-Y", strtotime($data->payDate))',
                ),
                array(
                    'name'=>'Nilai PKP',
                    'type'=>'raw',
                    'value'=>'number_format($data->pkpValue,0)',
                ),
                array(
                    'name'=>'Nilai PKP + PPn',
                    'type'=>'raw',
                    'value'=>'number_format($data->pkpValueWtx,0)',
                ),
                array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update}',
                    'buttons'=>array(
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("cancelPKP", array("id"=>$data->id,"asDialog"=>1,"gridId"=>$this->grid->id))',
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
        'title'=>'Proses Pembatalan PKP',
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