<?php
$this->breadcrumbs = array(
    'Term Customer' => array('termIndex'),
    $model->idCust,
);
?>

<h1>Term Customer  #<?php echo $model->idCust; ?></h1>
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/create.png", "Add New", array("title" => "Update Customer Trading")), Yii::app()->createUrl("trading/termUpdate", array("id" => $model->termID))); ?>

<br/>
<br/>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Customer',
            'value' => $model->idCust . " - " . $model->nameAcct,
        ),
        array(
            'label' => 'Tipe',
            'value' => $model->isTT == 1 ? "Modern TT" : "Modern Non-TT" ,
        ),
        "termDesc",
        array(
            'label' => 'Periode',
            'value' => date("d-M-Y", strtotime($model->periodStart)) . " s/d " . date("d-M-Y", strtotime($model->periodEnd)),
        ),
        "payTermExisting",
        "payTermNew",
        array(
            "name" => "sellingTarget",
            "value" => "Rp. " . number_format($model->sellingTarget),
        ),
    ),
));
?>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'trading-term-grid',
    'dataProvider' => $detail,
    'enableSorting' => false,
    //'filter'=>$model,
    'columns' => array(
        array(
            'name' => 'Kode Trading',
            'type' => 'raw',
            'value' => '($data->tradCode)',
        ),
        'tradDesc',
        'tradSource',
        'tradPeriod',
        array(
            "name" => "tradValueFrom",
            "value" => '"Rp. ".number_format($data->tradValueFrom)'
        ),
        array(
            "name" => "tradValueTo",
            "value" => '"Rp. ".number_format($data->tradValueTo)'
        ),
        array(
            "name" => "tradPercentage",
            "value" => 'number_format($data->tradPercentage,2)." %"'
        ),
        array(
            "name" => "Pricelist?",
            "value" => '$data->isPL  == 1 ? "Ya" : ""'
        ),
    ),
));
?>