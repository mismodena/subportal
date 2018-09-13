<?php
$this->breadcrumbs=array(
	'Daftar Kontrak',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#hris-contract-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar Kontrak</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hris-contract-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		/*array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'$data->isActive ? (CHtml::link($data->idCard." - ".$data->userName,Yii::app()->createUrl("HRIS/view",array("id"=>$data->contractID)))).'
                    . '"<br/>Dept-Div/Cabang: ".$data->deptName." - ".$data->idDiv." / ".$data->branchName.'
                    . '"<br/>Posisi: ".$data->posName : $data->idCard." - ".$data->userName.'
                    . '"<br/>Dept-Div/Cabang: ".$data->deptName." - ".$data->idDiv." / ".$data->branchName.'
                    . '"<br/>Posisi: ".$data->posName',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),*/
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->idCard." - ".$data->userName,Yii::app()->createUrl("HRIS/view",array("id"=>$data->contractID)))).'
                    . '"<br/>Dept-Div/Cabang: ".$data->deptName." - ".$data->idDiv." / ".$data->branchName.'
                    . '"<br/>Posisi: ".$data->posName',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                array(                    
                    'header'=>'Tgl Mulai',
                    'value'=>' date("d-M-Y", strtotime($data->startDate))',                    
                ),
                array(                    
                    'header'=>'Tgl Akhir',
                    'value'=>' date("d-M-Y", strtotime($data->endDate))',                    
                ),
                array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{change} -- {update}',
                    'buttons'=>array(
                        'change' => array( 
                                'url' => '$this->grid->controller->createUrl("update", array("id"=>$data->contractID,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/refresh.png', 
                                'click'=>'function(){$("#cru-change").attr("src",$(this).attr("href")); $("#cru-dlg").dialog("open");  return false;}',                                                                
                        ),
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("updateContract", array("id"=>$data->contractID,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',                                
                                'visible'=>'$data->isActive'
                        ),
                    ),    
                ),
                
	),
)); ?>

<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog',
    'options'=>array(
        'title'=>'Tindak Lanjut Kontrak',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>500,
        'resizable' => false,
    ),
    ));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget();?>

<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dlg',
    'options'=>array(
        'title'=>'Perubahan Data',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>530,
        'resizable' => false,
    ),
    ));
?>
<iframe id="cru-change" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget();?>


<style type="text/css">
    #cru-dialog {
        overflow: hidden;
    }
    #cru-dlg {
        overflow: hidden;
    }
</style>