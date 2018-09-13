<?php
$this->breadcrumbs = array(
    'Faktur Gagal Tertagih',
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

<h1>Faktur Gagal Tertagih</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_failed', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php //echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Generate Faktur")), Yii::app()->createUrl("document/create")); ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'document-grid',
    'dataProvider' => $model->failedDoc(),
    //'filter'=>$model,
    'columns' => array(
        array(
            'name' => 'Tanggal',
            'type' => 'raw',
            'value' => 'date("d-m-Y", strtotime($data->invDate))',
        ),
        array(
            "name" => "Invoice",
            "type"=>"raw",
            "value" => '$data->docNumber',
        ),
        array(
            "name" => "PO",
            "value" => '$data->poNumber',
        ),
        array(
            "name" => "Dealer",
            "type"=>"raw",
            "value" => '$data->customer."<br/>".$data->nameCust',
        ),
        array(
            'name' => 'Nilai',
            'type' => 'raw',
            'value' => 'number_format($data->invTotal)',
        ),
        array(
            'name' => 'Keterangan',
            'type' => 'raw',
            'value' => '$data->retNumber',
        ),
//        array(
//            'class' => 'CButtonColumn',
//            //--------------------- begin added --------------------------
//            'template' => '{verified}',
//            'buttons' => array(
//                'verified' => array(
//                    'url' => '$this->grid->controller->createUrl("document/complete",array("id"=>$data->docNumber))',
//                    'click' => 'function() {if(!confirm("Dokumen sudah lengkap?")) {return false;}}',
//                    'imageUrl' => Yii::app()->baseUrl . '/images/check.png',
//                    'visible' => '$data->isComplete == 1 ? false : true',
//                ),
//            ),
//        ),
    ),
));
?>
