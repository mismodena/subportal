<?php
$this->breadcrumbs = array(
    'Linea',
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

<h1>Linea</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'master-trading-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    //'filter'=>$model,
    'columns' => array(
        array(
            "name" => "fiscalYear",
            "value" => '$data->fiscalYear',
        ),
        array(
            "name" => "fiscalPeriod",
            "value" => '$data->fiscalPeriod',
        ),
        array(
            "name" => "itemNo",
            "value" => '$data->itemNo',
            "type" => "raw",
        ),
        array(
            "name" => "itemName",
            "value" => '$data->itemName',
        ),
        array(
            "name" => "lineaValueHome",
            "value" => '"Rp. ".number_format($data->lineaValue)',
            'htmlOptions' => array('style' => 'text-align:right;'),),
        array(
            "name" => "qtyOrder",
            "value" => 'number_format($data->qtyOrder)." unit"',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            "name" => "lineaPerOrder",
            "value" => '"Rp. ". number_format($data->qtyOrder * $data->lineaValue)',
            'htmlOptions' => array('style' => 'text-align:right;'),
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
