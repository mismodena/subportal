<?php
$this->breadcrumbs=array(
	'Inkuiri',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
    console.log($(this).serialize());
    //bawah di comment
     console.log(document.getElementById('APInvoice_keyWord'));
    document.getElementById('APInvoice_keyWord2').value = $(this).serialize().split('=')[1];
    //document.getElementById('APInvoice_apInvDate').value = $(this).serialize().split('=')[1];
	return false;
});
");
 
?>

<h1>Inkuiri</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->inkuiri(),
    'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
               'name'=>'Keterangan',                   
               'type'=>'raw',
               //'value'=>'(CHtml::link($data->dtApInvNo." - ".$data->apSupplier,Yii::app()->createUrl("invoice/viewAP",array("id"=>$data->apInvID)))).'                    '
                'value'=>'"<b>".$data->dtApInvNo." - ".$data->apSupplier."</b>".'                   
                . '"<br/>Tanggal Terima: ".date("d-m-Y", strtotime($data->recDateInvoice)).'
                . '"<br/>Tanggal Invoice: ".date("d-m-Y", strtotime($data->dtApInvDate))',
                //'headerHtmlOptions' => array('style'=>'width:55%;'),
            ),
            array(                    
                    'header'=>'No. Serah Terima',                    
                    'value'=>'$data->recNo',                    
                ),
            array(                    
                    'header'=>'No. FPP',                    
                    'value'=>'$data->fppID',                    
                ), 
            array(                    
                    'header'=>'Status',
                    //'value'=>'Utility::getApInvoiceStatus($data->fppStatus)',
                    'value'=>'$data->rejected == 1  ? Utility::getApInvoiceStatus($data->fppStatus) : "DITOLAK -- " .$data->apInvDetDesc ',                    
                    //'value'=>'$data->fppStatus',                    
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

<?php echo CHtml::beginForm(array('invoice/exportExcel'));  ?>
<input name="APInvoice[keyWord]" id="APInvoice_keyWord2" maxlength="50" value="" type="hidden">
<input name="APInvoice[apInvDate]" id="APInvoice_apInvDate" maxlength="50" value="" type="hidden">
<input type="submit" value="Export" id="exportExcel" />
<?php echo CHtml::endForm(); ?>

<script type="text/javascript">
    $( document ).ajaxComplete(function() {
        var invoice_grid = document.getElementById("invoice-grid");
        var input_grid = invoice_grid.getElementsByTagName("input");
        for(var i = 0; i < input_grid.length; i++){
            var name_input = input_grid[i].getAttribute("name");
            
            if(name_input !== ""){
                var explode = name_input.split("APInvoice[");
                console.log(explode[1].substr(0,(explode[1].length - 1)));
                var id_input = explode[1].substr(0,(explode[1].length - 1));
                console.log(input_grid[i].value);
                document.getElementById(id_input).value = input_grid[i].value;
                document.getElementById("exportExcel").removeAttribute("style");
            }
        }
    });
</script>