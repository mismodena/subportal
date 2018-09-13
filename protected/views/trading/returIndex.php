<?php
$this->breadcrumbs=array(
	'Retur',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#retur-trading-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Term Retur</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Claim Trading")), Yii::app()->createUrl("trading/returCreate")); ?>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'retur-trading-grid',
    	'dataProvider'=>$model->search(),
    	//'filter'=>$model,
    	'columns'=>array(            
            array(
                "name"=>"No",
                "value"=>'$data->returNo'
            ), 
            array(
                "name"=>"Group",
                "value"=>'$data->nameAcct'
            ),  
            array(
                "name"=>"PO",
                "value"=>'$data->poNo'
            ),
            array(
                "name"=>"Kode Trading",
                "value"=>'$data->tradCode." - ".$data->tradDesc'
            ),
            array(
                "name"=>"Nilai",
                "value"=>'"Rp. ".number_format($data->value)'
            ),           
//            array(
//                'class'=>'CButtonColumn',
//                //--------------------- begin added --------------------------
//                'template' => '{update}',
//                'buttons'=>array(                    
//                    'update'=>array(
//                            'url'=>'$this->grid->controller->createUrl("trading/termUpdate", array("id"=>$data->termID))',                            
//                    ),
//                ),    
//            ),
    	),
    )); 
?>
