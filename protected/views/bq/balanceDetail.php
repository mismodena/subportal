
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'bq-detail-grid',
    'dataProvider' => $model,
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
            'name' => 'Tanggal',
            'type' => 'raw',
            'value' => 'date("d-m-Y", strtotime($data->balanceDate))',
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
            'header' => 'Deskripsi',
            'value' => '$data->balanceDesc." nomor ".$data->linkReff    ',
            'type' => 'raw'
        ),
    ),
));
?>