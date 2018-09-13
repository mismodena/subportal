<?php
$this->breadcrumbs=array(
	'Verifikasi PI',
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

<h1>Verifikasi PI</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->verify(),
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
                    'value'=>'$data->status',
                ),
            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update}  {print}',
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
                    ),    
                ),
	),
)); ?>

