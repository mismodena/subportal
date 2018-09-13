<?php
$this->breadcrumbs=array(
	'Term Customer',
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

<h1>Term Customer</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Master Trading")), Yii::app()->createUrl("trading/termCreate")); ?>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'master-trading-grid',
    	'dataProvider'=>$model->search(),
    	//'filter'=>$model,
    	'columns'=>array(            
            array(
               'name'=>'Group',                   
               'type'=>'raw',
               'value'=>'(CHtml::link($data->idCust." - ".$data->nameAcct, Yii::app()->createUrl("trading/termView",array("id"=>$data->termID))))',                
            ), 
            "termNo",
            "termDesc", 
            array(                    
                'name'=>'periodStart',
                'value'=>' date("d-M-Y", strtotime($data->periodStart))',                    
            ),
            array(                    
                'name'=>'periodEnd',
                'value'=>' date("d-M-Y", strtotime($data->periodEnd))',                    
            ),            
            array(
                "name"=>"payTermExisting",
                "value"=>'number_format($data->payTermExisting)'
            ),           
            array(
                "name"=>"payTermNew",
                "value"=>'number_format($data->payTermNew)'
            ),           
            array(
                "name"=>"sellingTarget",
                "value"=>'"Rp. ".number_format($data->sellingTarget)'
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
