<h1>Pengajuan Claim Trading Term</h1>
<?php

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        "claimNo",
        array(
            'label' => 'Customer',
            'value' => $model->claimGroup . " - " . $model->groupName,
        ),
        "claimDesc",
        array(
            'label' => 'Tanggal Claim',
            'value' => date("d-M-Y", strtotime($model->claimDate)),
        ),
        "claimStatus",
        "fileName"
    ),
));
?>
<br/>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'claim-trading-grid',
    'dataProvider' => $detail,
    'columns' => array(
        array(
            "name" => "Kode Trading",
            "value" => '$data->tradCode." - ".$data->tradDesc',
            "footer" => "TOTAL",
            "footerHtmlOptions" => array("style" => "text-align: right;")
        ),
        array(
            "name" => "Accpac x % Term",
            "value" => 'number_format($data->value)',
            "htmlOptions" => array("style" => "text-align: right;"),
            "footer" => number_format($sum->value, 0),
            "footerHtmlOptions" => array("style" => "text-align: right;")
        ),
        // array(
        // "name"=>"PO",
        // "value"=>'number_format($data->pocheck)',
        // "htmlOptions"=>array("style"=>"text-align: right;"),
        // "footer"=>number_format($sum->pocheck,0),
        // "footerHtmlOptions"=>array("style"=>"text-align: right;")
        // ),
        array(
            "name" => "Klaim",
            "value" => 'number_format($data->claim)',
            "htmlOptions" => array("style" => "text-align: right;"),
            "footer" => number_format($sum->claim, 0),
            "footerHtmlOptions" => array("style" => "text-align: right;")
        ),
        
    ),
));
?>