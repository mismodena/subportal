<?php
$this->breadcrumbs=array(
	'Daftar FPP',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#fpp-header-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar FPP (AP)</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fpp-header-grid',
	'dataProvider'=>$model->searchFPP(),
	//'filter'=>$model,        
	'columns'=>array(
		//'fppID',
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->fppNo." - ".$data->fppUserName,Yii::app()->createUrl("formPP/viewFPP",array("id"=>$data->fppID)))).'
                    . '"<br/>Dept-Div/Cabang: ".$data->fppUserDeptName."-".$data->nameDiv."/".$data->nameBranch.'
                    . '"<br/>Tanggal pengajuan: ".$data->fppUserDate',
                    'headerHtmlOptions' => array('style'=>'width:60%;'),
                ),
                array(                    
                    'header'=>'Status',
                    'value'=>'Utility::getApInvoiceStatus($data->fppStatus)',                    
                    //'value'=>'$data->fppStatus',                    
                ), 
                array(
                    'name'=>'total',
                    'header'=>'Total',
                    'value'=>'"Rp. ".number_format($data->TOTAL)',
                    'htmlOptions' => array('style'=>'text-align: right;'),
                ),   
                array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update} {revisi} {print}',
                    'buttons'=>array(
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("execFPP", array("id"=>$data->fppID,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                        
                                'visible'=> $visible
                        ),                         
                        'revisi'=>array(
                                'url'=>'$this->grid->controller->createUrl("updateFPP", array("id"=>$data->fppID))',   
                                'visible'=>' $data->fppStatus == 1 || $data->fppStatus == 2 || $data->fppStatus == 9  ? true : false',
                                'imageUrl' => Yii::app()->baseUrl . '/images/update.png',                                 
                        ),                         
                        'print' => array( 
                                'label' => 'Cetak FPP', 
                                'url' => '$this->grid->controller->createUrl("formPP/viewFinanceFPP",array("id"=>$data->fppID))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/print.png',                                 
                                'options'=>array("target"=>"_blank"),                                
                        ),
                    ),    
                ),
	),
)); ?>

<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog',
    'options'=>array(
        'title'=>'Proses FPP',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>400,
        'resizable' => false,
    ),
    ));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget();?>

<style type="text/css">
    #cru-dialog {
        overflow: hidden;
    }
</style>