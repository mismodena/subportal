<?php
$this->breadcrumbs = array(
    'Verifikasi Klaim',
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
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'document-grid',
    'dataProvider' => $model->verify(),
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
            "name" => "bqUsed",
            "type"=>"raw",
            "value" => '"Rp. ".number_format($data->bqUsed)',
        ),
        array(
            "name" => "tqUsed",
            "type"=>"raw",
            "value" => '"Rp. ".number_format($data->tqUsed)',
        ),
        array(
            "name" => "Total Pengajuan",
            "type"=>"raw",
            "value" => '"Rp. ".number_format($data->claimTotal)',
        ),
        array(
            "type" => "raw",
            "name" => "Status",
            "value" => '$data->status'
        ),
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{view}{update}',
            'buttons' => array(
                'view' => array(
                    'url' => '$this->grid->controller->createUrl("bq/claimDetail", array("id"=>$data->bqClaimID))',
                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                ),'update' => array(
                    'url' => '$this->grid->controller->createUrl("bq/verifyClaim", array("id"=>$data->bqClaimID))',
                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                       
                    'visible' => '$data->status != 5 ? true : false',
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
        'resizable' => true
    ),
));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget(); ?>