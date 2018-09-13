<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'invoice-grid',
    'dataProvider'=>$model->invoice_tolak(),
        'enableSorting' => false,    
    //'filter'=>$model,
    'columns'=>array(               
            array(
               'name'=>'Keterangan',                   
               'type'=>'raw',
               //'value' => '(Chtml::link($data->dtApInvNo." - ".$data->apSupplier, Yii::app()->createUrl("invoice/viewAP",array("id"=>$data->apInvID)))).'
                'value'=>'"<b>".$data->dtApInvNo." - ".$data->apSupplier."</b>".' 
                . '"<br/> Tanggal Penagihan: ".date("d-m-Y", strtotime($data->recDate)).'
                . '"<br/>Tanggal Invoice: ".date("d-m-Y", strtotime($data->dtApInvDate))',
                //'headerHtmlOptions' => array('style'=>'width:55%;'),
            ),
            array(                    
                    'header'=>'No. Serah Terima',                    
                    'value'=>'$data->recNo',                    
                ),
            /*array(                    
                    'header'=>'No. FPP',                    
                    'value'=>'$data->fppID',                    
                ), */
            array(                    
                    'header'=>'Keterangan',
                    //'value'=>'"Dokumen tidak lengkap"',                    
                    'value'=>'$data->apInvDetDesc',                    
                ), 
            array(
                'name'=>'Total',
                'type'=>'raw',
                'value'=>'number_format($data->dtApInvTotal,0)',
            ),
            array(
                'class'=>'CButtonColumn',
                //--------------------- begin added --------------------------
                'template' => '{view}',
                'buttons'=>array(
                    'view'=>array(
                            'url'=>'$this->grid->controller->createUrl("viewLogbook", array("id"=>$data->dtApInvNo,"asDialog"=>1,"gridId"=>$this->grid->id))',
                            'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                                                 
                    ),         
                ),    
            ),
    ),
)); ?>
<style type="text/css">
    #cru-dialog {
        overflow: hidden;
    }
</style>
<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog',
    'options'=>array(
        'title'=>'Log Book',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>780,
        'height'=>400,
        'resizable' => false
    ),
    ));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget();?>