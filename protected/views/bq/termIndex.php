<?php
$this->breadcrumbs=array(
	'Persentase',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#master-trading-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Persentase</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'master-trading-grid',
    	'dataProvider'=>$model->search(),
    	//'filter'=>$model,
    	'columns'=>array(          
            'termType',
            'classDealer',
            array(
                "name"=>"fromValue",
                "value"=>'"Rp. ".number_format($data->fromValue)'
            ),
            array(
                "name"=>"toValue",
                "value"=>'"Rp. ".number_format($data->toValue)'
            ),            
            array(
                "name"=>"percentage",
                "value"=>'number_format($data->percentage,2)." %"'
            ),            
            array(
                'class'=>'CButtonColumn',
                //--------------------- begin added --------------------------
                'template' => '{update}',
                'buttons'=>array(                    
                    'update'=>array(
                            'url'=>'$this->grid->controller->createUrl("bq/termUpdate", array("type"=>$data->termType, "classDealer"=>$data->classDealer))',                            
                    ),
                ),    
            ),
    	),
    )); 
?>
