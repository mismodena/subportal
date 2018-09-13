<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'bqClaimNo',
        array(
            'label' => 'Tanggal',
            'type' => 'raw',
            'value' => date("d-m-Y", strtotime($model->claimDate))
        ),
        array(
            'label' => 'Pemohon',
            'type' => 'raw',
            'value' => $model->userName),
        array(
            'label' => 'Dealer',
            'type' => 'raw',
            'value' => $model->idCust),
    ),
));
?>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'bq-detail-grid',
    'dataProvider' => $detail,
    'enableSorting' => false,
    'columns' => array(
//                array(                    
//                    'header'=>'No.',
//                    'value'=>'$row+1'
//                ),
        array(
            'name' => 'Keterangan',
            'type' => 'raw',
            'value' => '$data->nonItemDesc',
        ),
        array(
            "name" => "Nilai",
            "value" => '"Rp. ".number_format($data->nonItemValue)'
        ),
    ),
));
?>
<br/>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Sub Total',
            'type' => 'raw',
            'value' => "Rp. " . number_format($model->totalNonItems),
        ),
        array(
            'label' => 'TQ',
            'type' => 'raw',
            'value' => "Rp. " . number_format($model->tqUsed),
        ),
        array(
            'label' => 'BQ',
            'type' => 'raw',
            'value' => "Rp. " . number_format($model->bqUsed),
        ),
        array(
            'label' => 'Total',
            'type' => 'raw',
            'value' => "Rp. " . number_format($model->claimTotal),
        ),
    ),
));
?>
<br/>