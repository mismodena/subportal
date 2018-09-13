<?php
$this->breadcrumbs = array(
    'Faktur List',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#document-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Faktur Tanda Terima</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_search2', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php //echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Generate Faktur")), Yii::app()->createUrl("document/create")); ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'document-grid',
    'dataProvider' => $model->searchtt(),
    //'filter'=>$model,
    'columns' => array(
        array(
            'name' => 'Invoice',
            'type' => 'raw',
            'value' => '(CHtml::link($data->docNumber." - ".$data->customer, Yii::app()->createUrl("document/view",array("id"=>$data->docNumber))))'
            . '."<br/>Tanggal Faktur: ".date("d-m-Y", strtotime($data->invDate))',
        ),
        array(
            "name" => "Collector",
            "type"=>"raw",
            "value" => '$data->collectorRcv ? "Diterima oleh: ".$data->collector.'
            . '"<br/> Tanggal: ".date("d-m-Y", strtotime($data->collectorRcvDate)) : ""',
        ),
        array(
            "name" => "Dealer",
            "value" => '$data->customerRcv ? date("d-m-Y", strtotime($data->collectorRcvDate)): ""',
        ),
        array(
            "name" => "tttfp",
            "value" => '$data->tttfp ',
        ),
//        array(
//            'name' => 'Total',
//            'type' => 'raw',
//            'value' => 'number_format($data->invTotal)',
//        ),
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{verified}',
            'buttons' => array(
                'verified' => array(
                    'url' => '$this->grid->controller->createUrl("document/complete",array("id"=>$data->docNumber))',
                    'click' => 'function() {if(!confirm("Dokumen sudah lengkap?")) {return false;}}',
                    'imageUrl' => Yii::app()->baseUrl . '/images/check.png',
                    'visible' => '$data->isComplete == 1 ? false : true',
                ),
            ),
        ),
    ),
));
?>
