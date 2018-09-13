<?php
$this->breadcrumbs=array(
	'Saldo',
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

<h1>Saldo</h1>

<div class="search-form">
<?php $this->renderPartial('_searchOnly',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'master-trading-grid',
    	'dataProvider'=>$model->search(),
        'enableSorting' => false,
    	//'filter'=>$model,
    	'columns'=>array(         
            array(
                "name"=>"Cabang",
                "value"=>'(CHtml::link($data->nameCust,Yii::app()->createUrl("bq/balanceView",array("id"=>trim($data->idBranch), "name"=>trim($data->nameCust)))))',
                "type"=>"raw",
                
            ),            
            array(
                "name"=>"bqValue",
                "value"=>'"Rp. ".number_format($data->bqValue)',
                'htmlOptions' => array('style'=>'text-align:right;'),
            ),   
            array(
                "name"=>"tqValue",
                "value"=>'"Rp. ".number_format($data->tqValue)',
                'htmlOptions' => array('style'=>'text-align:right;'),
            ),             
//            array(
//                'class'=>'CButtonColumn',
//                //--------------------- begin added --------------------------
//                'template' => '{update}',
//                'buttons'=>array(                    
//                    'update'=>array(
//                            'url'=>'$this->grid->controller->createUrl("bq/termUpdate", array("type"=>$data->termType, "classDealer"=>$data->classDealer))',                            
//                    ),
//                ),    
//            ),
    	),
    )); 
?>
