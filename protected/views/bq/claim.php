<?php
$this->breadcrumbs = array(
    'Pengajuan Klaim',
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

<h1>Pengajuan Klaim</h1>

<div class="search-form">
    <?php
//    $this->renderPartial('_search2', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->
    <?php echo CHtml::link('Non-barang', Yii::app()->createUrl("bq/claimCreate"), array('class' => 'btn btn-sm', )); ?>
    <?php //echo CHtml::link('Barang', Yii::app()->createUrl("bq/claimCreateItem"), array('class' => 'btn btn-sm', )); ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'document-grid',
    'dataProvider' => $model->search(),
    //'filter'=>$model,
    'enableSorting' => false,
    'columns' => array(
        array(
            'name' => 'Keterangan',
            'type' => 'raw',
            'value' => '$data->bqClaimNo'
            . '."<br/>Tanggal: ".date("d-m-Y", strtotime($data->claimDate))'
            . '."<br/>Pemohon: ".$data->userName',
        ),
        array(
            "name" => "Dealer",
            "type"=>"raw",
            "value" => '$data->idCust',
        ),        
        array(
            "name" => "Pengajuan",
            "type"=>"raw",
            "value" => '"BQ : ".number_format($data->bqUsed)'
                        .'."<br/>TQ : ".number_format($data->tqUsed)'
                        .'."<br/>Total : ".number_format($data->claimTotal)',
        ),
        array(
            "name" => "Realisasi",
            "type"=>"raw",
            "value" => '"BQ : ".number_format($data->realisasiBQ)'
                        .'."<br/>TQ : ".number_format($data->realisasiTQ)'
                        .'."<br/>Total : ".number_format($data->realisasiTotal)',
        ),
        array(
            "type" => "raw",
            "name" => "Status",
            "value" => '$data->stat'
        ),
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'url' => '$this->grid->controller->createUrl("bq/claimDetail", array("id"=>$data->bqClaimID))',
                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                ),
//                'update' => array(
//                    'url' => '$this->grid->controller->createUrl("bq/verifyClaim", array("id"=>$data->bqClaimID))',
//                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                       
//                    'visible' => '$data->flag != 3 && $data->flag != 5 ? true : false',
//                ),
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
        'height' => 600,
        'resizable' => true
    ),
));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="yes"></iframe>
<?php $this->endWidget(); ?>