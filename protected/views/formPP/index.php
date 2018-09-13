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

<h1>Daftar FPP</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fpp-header-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,        
	'columns'=>array(
		//'fppID',
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->fppNo." - ".$data->fppUserName,Yii::app()->createUrl("formPP/view",array("id"=>$data->fppID)))).'
                    . '"<br/>Dept-Div/Cabang: ".$data->fppUserDeptName."-".$data->nameDiv."/".$data->nameBranch.'
                    . '"<br/>Tanggal pengajuan: ".$data->fppUserDate',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
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
                    'template' => '{print}',
                    'buttons'=>array(
                        'print' => array( 
                                'label' => 'Cetak FPP', 
                                'url' => '$this->grid->controller->createUrl("formPP/viewFinance",array("id"=>$data->fppID))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/print.png', 
                                'visible'=>'is_null($data->printCabang) ? false : true',
                                'options'=>array("target"=>"_blank"),
                        ),
                    ),    
                ),
	),
)); ?>
