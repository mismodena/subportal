<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'inv-detail-grid',
    'dataProvider' => $model,
    'columns' => array(
        array(
            "name" => "Kode Trading",
            "value" => '$data->tradCode." - ".$data->tradDesc',
            "footer" => "TOTAL",
            "footerHtmlOptions" => array("style" => "text-align: right;")
        ),
        array(
            "name" => "No. PO",
            "value" => '$data->poNo',
        ),
        array(
            "name" => "Accpac",
            "value" => 'number_format($data->value)',
            "htmlOptions" => array("style" => "text-align: right;"),
            "footer" => number_format($sum->value, 0),
            "footerHtmlOptions" => array("style" => "text-align: right;")
        ),
        array(
            "name" => "Klaim",
            "value" => 'number_format($data->claim)',
            "htmlOptions" => array("style" => "text-align: right;"),
            "footer" => number_format($sum->claim, 0),
            "footerHtmlOptions" => array("style" => "text-align: right;")
        ),
        array(
            "name" => "Deskripsi",
            "value" => '$data->description',
        ),
    ),
));
?>