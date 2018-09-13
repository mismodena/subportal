<?php
$this->breadcrumbs = array(
    'Pengajuan Saldo',
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

<h1>Pengajuan Saldo</h1>

<div class="search-form">
    <?php
//    $this->renderPartial('_search2', array(
//        'model' => $model,
//    ));
    ?>
</div><!-- search-form -->
 <?php echo CHtml::link('Pengajuan', Yii::app()->createUrl("bq/uploadCreate"), array('class' => 'btn btn-sm', )); ?><br/><br/>
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
            'value' => '$data->bqUploadNo'
            . '."<br/>Tanggal: ".date("d-m-Y", strtotime($data->uploadDate))'
            . '."<br/>Pemohon: ".$data->userName',
        ),
        array(
            "name" => "Cabang",
            "type"=>"raw",
            "value" => '$data->branchName',
        ), 
        array(
            "name" => "Dealer",
            "type"=>"raw",
            "value" => '$data->idCust." - ".$data->nameCust',
        ),        
        array(
            "name" => "Nilai BQ",
            "type"=>"raw",
            "value" => '"Rp. ".number_format($data->bqValue)',
        ),
        array(
            "name" => "Nilai TQ",
            "type"=>"raw",
            "value" => '"Rp. ".number_format($data->tqValue)',
        ),
        array(
            "name" => "Total Pengajuan",
            "type"=>"raw",
            "value" => '"Rp. ".number_format($data->uploadTotal)',
        ),
        array(
            "type" => "raw",
            "name" => "Status",
            "value" => '$data->status'
        ),
//        array(
//            'class' => 'CButtonColumn',
//            //--------------------- begin added --------------------------
//            'template' => '{view}{update}',
//            'buttons' => array(
//                'view' => array(
//                    'url' => '$this->grid->controller->createUrl("bq/claimDetail", array("id"=>$data->bqClaimID))',
//                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
//                ),
//                'update' => array(
//                    'url' => '$this->grid->controller->createUrl("bq/verifyClaim", array("id"=>$data->bqClaimID))',
//                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                       
//                    'visible' => '$data->flag != 3 && $data->flag != 5 ? true : false',
//                ),
//            ),
//        ),
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