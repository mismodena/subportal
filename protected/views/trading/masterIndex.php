<?php
$this->breadcrumbs=array(
	'Term Item',
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

<h1>Term Item</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Master Trading")), Yii::app()->createUrl("trading/masterCreate")); ?>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'master-trading-grid',
    	'dataProvider'=>$model->search(),
    	//'filter'=>$model,
    	'columns'=>array(
            array(
               'name'=>'Kode Trading',                   
               'type'=>'raw',
               'value'=>'(CHtml::link($data->tradCode, Yii::app()->createUrl("trading/masterView",array("id"=>$data->tradID))))',                
            ),            
            'tradDesc',
            'tradSource',
            'tradPeriod',            
            array(
                "name"=>"tradValueFrom",
                "value"=>'"Rp. ".number_format($data->tradValueFrom)'
            ),
            array(
                "name"=>"tradValueTo",
                "value"=>'"Rp. ".number_format($data->tradValueTo)'
            ),            
            array(
                "name"=>"tradPercentage",
                "value"=>'number_format($data->tradPercentage,2)." %"'
            ),            
            array(
                'class'=>'CButtonColumn',
                //--------------------- begin added --------------------------
                'template' => '{update}',
                'buttons'=>array(                    
                    'update'=>array(
                            'url'=>'$this->grid->controller->createUrl("trading/masterUpdate", array("id"=>$data->tradID))',                            
                    ),
                ),    
            ),
    	),
    )); 
?>
