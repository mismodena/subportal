<?php
$this->breadcrumbs = array(
    'Saldo' => array('balanceIndex'),
//	$model->fppNo,
);
?>

<h1>Saldo Cabang #<?php echo $name; ?></h1>

<br/><br/><br/>
<h3>Saldo BQ<?php // echo $model->fppNo;   ?></h3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'bq-detail-grid',
    'dataProvider' => $BQ,
    //'filter'=>$model,
    'columns' => array(
//                array(                    
//                    'header'=>'No.',
//                    'value'=>'$row+1'
//                ),
        array(
            'name' => 'Referensi',
            'type' => 'raw',
            'value' => '(CHtml::link($data->balanceReff,Yii::app()->createUrl("bq/sourceDetail",array("reff"=>trim($data->balanceReff), "id"=>"'.$id.'","name"=>"'.$name.'"))))',
        ),
        array(
            'header' => 'Debet',
            'value' => '"Rp. ".number_format($data->bqIn)',
            'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
        ),
        array(
            'header' => 'Kredit',
            'value' => '"Rp. ".number_format($data->bqOut)',
            'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
        ),
        array(
            'header' => 'Saldo',
            //'value' => '"Rp. ".number_format(abs($data->bqIn - $data->bqOut))',
            'value' => '"Rp. ".number_format($data->bqIn - $data->bqOut)',
            'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
        ),
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'url' => '$this->grid->controller->createUrl("bq/balanceDetail", array("type"=>"bq", "reff"=>trim($data->balanceReff), "idBranch"=>trim($data->idBranch), "idCust"=>trim($data->idCust)))',
                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                ),
            ),
        ),
    ),
));
?>
<br/><br/><br/>
<h3>Saldo TQ<?php // echo $model->fppNo;   ?></h3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'tq-detail-grid',
    'dataProvider' => $TQ,
    //'filter'=>$model,
    'columns' => array(
//                array(                    
//                    'header'=>'No.',
//                    'value'=>'$row+1'
//                ),
        array(
            'name' => 'Referensi',
            'type' => 'raw',
            'value' => '$data->balanceReff',
        ),
        array(
            'name' => 'Dealer',
            'type' => 'raw',
            'value' => '$data->idCust." - ".$data->nameCust',
        ),
        array(
            'header' => 'Debet',
            'value' => '"Rp. ".number_format($data->bqIn)',
            'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
        ),
        array(
            'header' => 'Kredit',
            'value' => '"Rp. ".number_format($data->bqOut)',
            'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
        ),
        array(
            'header' => 'Saldo',
            //'value' => '"Rp. ".number_format(abs($data->bqIn - $data->bqOut))',
            'value' => '"Rp. ".number_format($data->bqIn - $data->bqOut)',
            'htmlOptions' => array('style' => 'text-align:right;width:16%;'),
        ),
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'url' => '$this->grid->controller->createUrl("bq/balanceDetail", array("type"=>"tq", "reff"=>trim($data->balanceReff), "idBranch"=>trim($data->idBranch), "idCust"=>trim($data->idCust)))',
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
        'resizable' => false,
        "scrolling" => true
    ),
));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="yes"></iframe>
<?php $this->endWidget(); ?>