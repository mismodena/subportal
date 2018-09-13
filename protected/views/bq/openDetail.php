
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'bq-detail-grid',
    'dataProvider' => $model,
    'enableSorting' => false,
    'columns' => array(
//                array(                    
//                    'header'=>'No.',
//                    'value'=>'$row+1'
//                ),
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
            "type" => "raw",
            "name" => "Status",
            "value" => '$data->status'
        ),
    ),
));
?>