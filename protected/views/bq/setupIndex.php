<?php
$this->breadcrumbs = array(
    'Pengaturan',
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

<h1>Pengaturan</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_searchOnly', array(
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
        'fiscalPeriod',

        array(
            "name" => "openTQ",
            "value" => '$data->openTQ == 1 ? "Ya" : "Tidak"'
        ),
//        array(
//            "name" => "openSource",
//            "value" => '$data->openSource == 1 ? "Ya" : "Tidak"'
//        ),

        array(
            'class'=>'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{update}',
            'buttons'=>array(                    
                'update'=>array(
                        'url'=>'$this->grid->controller->createUrl("bq/setupUpdate", array("fiscal"=>$data->fiscalPeriod))',                            
                ),
            ),    
        ),
    ),
));
?>
