<?php
$this->breadcrumbs = array(
    'Target Dealer',
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

<h1>Target Dealer</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_search2', array(
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
            'name' => 'Revisi',
            'type' => 'raw',
            'value' => '$data->revNo',
        ),
        array(
            "name" => "Dealer",
            "value" => '$data->idCust." - ".$data->nameCust',
            "type" => "raw",
        ),
        array(
            "name" => "salesTarget",
            "value" => '"Rp. ".number_format($data->salesTarget)'
        ),
        array(
            "name" => "openTarget",
            "value" => '"Rp. ".number_format($data->openTarget)'
        ),
        array(
            "name" => "openBonus",
            "value" => '"Rp. ".number_format($data->openBonus)'
        ),
        array(
            "name" => "Keterangan",
            "value" => '$data->openDesc',
            "type" => "raw",
        ),
        array(
            "type" => "raw",
            "name" => "Status",
            "value" => '$data->status'
        ),
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'url' => '$this->grid->controller->createUrl("bq/openDetail", array("id"=>$data->openID))',
                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                ),
            ),
        ),
    ),
));
?>

<style type="text/css">
    #cru-dialog {
        overflow: hidden;
    }
</style>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cru-dialog',
    'options' => array(
        'title' => 'Detail',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false
    ),
));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget(); ?>