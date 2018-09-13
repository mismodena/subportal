<?php
$this->breadcrumbs = array(
    'Term Claim' => array('claimIndex'),
    $model->claimNo,
);
?>

<h1>Term Claim #<?php echo $model->claimNo; ?></h1>
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/print2.png", "Cetak", array("title" => "Cetak Claim")), Yii::app()->createUrl("trading/printClaim", array("id" => $model->claimNo    )), array("target"=>"_blank")); ?>
<br/>
<br/>

<?php
$level = Yii::app()->user->getState('level');

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
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{view} {print}',
            'buttons' => array(
                'view' => array(
                    'url' => '$this->grid->controller->createUrl("ClaimDetail", array("id"=>$data->claimNo, "tradCode"=>$data->tradCode))',
                    'click' => 'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                ),
                'print' => array( 
                            'label' => 'Export', 
                            'url' => '$this->grid->controller->createUrl("trading/exportexcel",array("id"=>$data->claimNo, "tradCode"=>$data->tradCode))',
                            'imageUrl' => Yii::app()->baseUrl . '/images/print.png',                                
                        ),
            ),
        ),
    ),
));
?>
<br />
<div class="group">
    <?php echo Yii::t('ui', 'Action'); ?>
</div>
<table>
    <tr>
        <td width="40%" align="center">                                                   
            <?php
            if (abs($sum->value - $sum->claim) <= 50 ) {
                if ($model->claimStatus !== 'approved') {
                    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/ok.png", "Approve", array("title" => "Approve", 'width' => 50, 'height' => 50)), Yii::app()->createUrl("trading/approval", array("id" => $model->claimNo, "appr" => 1)));
                }
            } else {
                if ($level == 'Admin' || $level == 'AM') {
                    if ($model->claimStatus !== 'approved') {
                        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/ok.png", "Approve", array("title" => "Approve", 'width' => 50, 'height' => 50)), Yii::app()->createUrl("trading/approval", array("id" => $model->claimNo, "appr" => 1)));
                    }
                }
            }
            ?>                                                                                                   
        </td>
        <td width="40%" align="center">                                                   
<?php
if ($model->claimStatus !== 'approved') {
    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . "/images/notok.png", "Reject", array("title" => "Reject", 'width' => 50, 'height' => 50)), Yii::app()->createUrl("trading/approval", array("id" => $model->claimNo, "appr" => 0)));
}
?>                                                                                                   

        </td>                        
    </tr>
</table>         
<style type="text/css">
    #cru-dialog {
        overflow: hidden;
    }
</style>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cru-dialog',
    'options' => array(
        'title' => 'Detail PO',
        'autoOpen' => false,
        'modal' => true,
        'width' => 780,
        'height' => 400,
        'resizable' => false
    ),
));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget(); ?>