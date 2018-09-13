<?php
$this->breadcrumbs=array(
	'Daftar Review FPP Finance',
);


 Yii::app()->clientScript->registerScript('cetak', "
 
$( document ).ready(function() {
    window.print();
});

");

?>

<h1>Daftar Review FPP Finance</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>

<?php //echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/print.png","Create",array("title"=>"Cetak halaman ini")), Yii::app()->createUrl("formPP/printFinance"), array("target"=>"_blank")); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fpp-header-grid',
	'dataProvider'=>$model->searchFinance(),
	//'filter'=>$model,
	'columns'=>array(
		//'fppID',
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   /*'value'=>'$data->print == 1 ? (CHtml::link($data->fppNo." - ".$data->fppUserName,Yii::app()->createUrl("formPP/view",array("id"=>$data->fppID))))  .'
                    . '"<br/>Dept-Div/Cabang: ".$data->fppUserDeptName."-".$data->nameDiv."/".$data->nameBranch.'
                    . '"<br/>Tanggal pengajuan: ".$data->fppUserDate : $data->fppNo." - ".$data->fppUserName .'
                    . '"<br/>Dept-Div/Cabang: ".$data->fppUserDeptName."-".$data->nameDiv."/".$data->nameBranch.'
                    . '"<br/>Tanggal pengajuan: ".$data->fppUserDate ',                    
                    */
                    'value'=>'(CHtml::link($data->fppNo." - ".$data->fppUserName,Yii::app()->createUrl("formPP/view",array("id"=>$data->fppID))))  .'
                            . '"<br/>Dept-Div/Cabang: ".$data->fppUserDeptName."-".$data->nameDiv."/".$data->nameBranch.'
                            . '"<br/>Tanggal pengajuan: ".$data->fppUserDate.'
                            . '"<br/>Nomor Batch: ".$data->batch',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                array(
                    'name'=>'Bank',
                    'type'=>'raw',
                    'value'=>'$data->fppToBank."<br/>".$data->fppToBankAcc',
                    'htmlOptions' => array('style'=>'text-align: right;'),
                ),
                array(
                    'name'=>'total',
                    'header'=>'Total',
                    'value'=>'"Rp. ".number_format($data->adjustmentValue)',
                    'htmlOptions' => array('style'=>'text-align: right;'),
                ),
		array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{print}{update}',
                    'buttons'=>array(
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("execFinance", array("id"=>$data->fppID,"asDialog"=>1,"gridId"=>$this->grid->id))',
                                'click'=>'function(){$("#cru-frame").attr("src",$(this).attr("href")); $("#cru-dialog").dialog("open");  return false;}',
                                'visible'=>'$data->approval'
                        ),
                     
                        'print' => array( 
                                'label' => 'Cetak FPP', 
                                'url' => '$this->grid->controller->createUrl("formPP/viewFinance",array("id"=>$data->fppID))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/print.png', 
                                'visible'=>'is_null($data->print) ? false : true'
                        ),
                    ),    
                ),
	),
)); ?>


<?php 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog',
    'options'=>array(
        'title'=>'Persiapan Pembayaran',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>300,
        'resizable' => false,
    ),
    ));
?>
<iframe id="cru-frame" width="100%" height="100%" scrolling="no"></iframe>
<?php $this->endWidget();?>


