<?php
$this->breadcrumbs = array(
    'AR Modern Review',
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

<h1>AR Modern Review</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_review', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php //echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Generate Faktur")), Yii::app()->createUrl("document/create")); ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'document-grid',
    'dataProvider' => $model->financeReview(),
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
            "name" => "Store",
            "type"=>"raw",
            "value" => '$data->customer."<br/>".$data->nameCust',
        ),
        array(
            'name' => 'Nilai',
            'type' => 'raw',
            'value' => 'number_format($data->invTotal)',
        ),
        array(
            'name' => 'SJ',
            'type' => 'raw',
            'value' => 'is_null($data->suratJalan) ? " - " : number_format($data->suratJalan)',
        ),
        array(
            'name' => 'FK',
            'type' => 'raw',
            'value' => 'is_null($data->faktur) ? " - " : number_format($data->faktur)',
        ),
        array(
            'name' => 'EF',
            'type' => 'raw',
            'value' => 'is_null($data->eFaktur) ? " - " : number_format($data->eFaktur)',
        ),
        array(
            'name' => 'Complete',
            'type' => 'raw',
            'value' => 'is_null($data->isComplete) ? " - " : number_format($data->isComplete)',
        ),
        array(
            'name' => 'Collector',
            'type' => 'raw',
            'value' => 'is_null($data->collector) ? " - " : number_format($data->collector)',
        ),
        array(
            'name' => 'Dealer',
            'type' => 'raw',
            'value' => 'is_null($data->dealer) ? " - " : number_format($data->dealer)',
        ),
        array(
            'name' => 'Tg Bayar',
            'type' => 'raw',
            'value' => 'is_null($data->payDate) ? " - " :  date("d-m-Y", strtotime($data->payDate))',
        ),
        array(
            'name' => 'Lm Bayar',
            'type' => 'raw',
            'value' => 'is_null($data->payDate) ? " - " :   number_format($data->payment)',
        ),
        array(
            'name' => 'Lm Faktur',
            'type' => 'raw',
            'value' => 'is_null($data->payment2) ? " - " :   number_format($data->payment2)',
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
