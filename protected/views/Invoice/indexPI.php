<?php
$this->breadcrumbs=array(
	'Daftar PI',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar PI</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->search(),
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->invNo." - ".$data->poName,Yii::app()->createUrl("invoice/viewPI",array("id"=>$data->invID)))).'
                    . '"<br/>No. PO: ".$data->poNo.'
                    . '"<br/>Tanggal : ".date("d-m-Y", strtotime($data->invDate))',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
            array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'number_format($data->invTotalWtx,0)',
                ),
            array(
                    'name'=>'Status',
                    'type'=>'raw',
                    'value'=>' $data->status ',
                ),
            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update}  {print} ',
                    'buttons'=>array(
                        'print' => array( 
                                'label' => 'Cetak PI', 
                                'url' => '$this->grid->controller->createUrl("invoice/printPI",array("id"=>$data->invID))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/print.png', 
                                'options'=>array("target"=>"_blank"),
                                'visible' => '$data->status === "Signed" ? true : false',
                        ),
                        'update' => array( 
                                'label' => 'Update PI', 
                                'url' => '$this->grid->controller->createUrl("invoice/updatePI",array("id"=>$data->invID))',                                
                                'visible' => '$data->status === "Entry" ? true : false',
                        ),
//                        'verified' => array( 
//                                'label' => 'Verifikasi PI',                                 
//                                'imageUrl' => Yii::app()->baseUrl . '/images/verified2.png', 
//                                'url'=>'$this->grid->controller->createUrl("updateContract", array("id"=>$data->contractID,"asDialog"=>1,"gridId"=>$this->grid->id))',
//                                'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                
//                                'visible' => '$data->status === "Signed" ? true : false',
//                        ),
                    ),    
                ),
	),
)); ?>
<?php 

//    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//    'id'=>'cru-dialog',
//    'options'=>array(
//        'title'=>'Verifikasi Pengiriman PI',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>550,
//        'height'=>500,
//        'resizable' => false,
//    ),
//    ));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>


<style type="text/css">
    #cru-dialog {
        overflow: hidden;
    }
</style>
