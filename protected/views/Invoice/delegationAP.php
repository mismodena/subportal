<?php
$this->breadcrumbs=array(
	'Daftar Serah Terima Faktur',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$level = Yii::app()->user->getState('level');
$visible = 'false';

if($level == "Admin" OR $level == "Finance"  )
{
    $visible = 'true';
}

?>

<h1>Daftar Serah Terima Faktur</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<br/>

<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/print.png","Cetak",array("title"=>"Cetak Bukti Serah Terima")), Yii::app()->createUrl("invoice/printDelegation"), array("target"=>"_blank")); ?>

</div><!-- search-form -->
<br/>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->delegation(),
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
           array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->apInvNo." - ".$data->apSupplier,Yii::app()->createUrl("invoice/viewAP",array("id"=>$data->apInvID)))).'
                    . '"<br/>No. Penerimaan: ".$data->recNo.'                    
                    . '"<br/>Tanggal Faktur: ".date("d-m-Y", strtotime($data->apInvDate)).'
                    . '"<br/>Tanggal Terima: ".date("d-m-Y", strtotime($data->recDate))',                    
                    'headerHtmlOptions' => array('style'=>'width:55%;'),
                ),
            array(
                    'name'=>'Departemen',
                    'type'=>'raw',
                    'value'=>'$data->deptName',
                    'headerHtmlOptions' => array('style'=>'width:10%;'),
                ),               
            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{Update Dept}',
                    'buttons'=>array(
                        'Update Dept'=>array(                                
                                'url'=>'$this->grid->controller->createUrl("invoice/updateDept", array("id"=>$data->apDetailID,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                
                                'imageUrl' => Yii::app()->baseUrl . '/images/update.png',  
                                'visible' => $visible,
                        ),
                    ),                    
                ),
            array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'number_format($data->apInvTotal,0)',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                ), 
            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{verified}',
                    'buttons'=>array(
                        'verified'=>array(
                            'url'=>'$this->grid->controller->createUrl("invoice/updateDelegation",array("id"=>$data->apInvID))',
                            'click'=>'function() {if(!confirm("Update serah terima dokumen?")) {return false;}}',
                            'imageUrl' => Yii::app()->baseUrl . '/images/check.png',    
                            'visible' => 'false'                            
                        ),
                    ),    
                ),
	),
)); ?>


<?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'cru-dialog',
        'options'=>array(
            'title'=>'Update Departemen',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>550,
            'height'=>370,
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