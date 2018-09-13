<?php
$this->breadcrumbs=array(
	'Daftar Disposal',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#disposal-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar Disposal Asset</h1>


<div class="search-form">
<?php 
    $this->renderPartial('_search',array(
    	'model'=>$model,
    )); 
?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Disposal")), Yii::app()->createUrl("mutation/createDisposal")); ?>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'disposal-grid',
	'dataProvider'=>$model->search(),
    'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->disposalNo." | Tanggal Pengajuan : ".date("d-m-Y", strtotime($data->disposalDate)), Yii::app()->createUrl("mutation/viewDisposal",array("id"=>$data->disposalNo)))).'
                        .'"<br/>Dept./Bagian/Cabang  : ".$data->fromDeptName." - ".$data->fromPICName', 
                    'headerHtmlOptions' => array('style'=>'width:75%;'),

                ),
            array(
                    'name'=>'Status',
                    'type'=>'raw',
                    'value'=>'$data->keterangan',
                ),
            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{print} ',
                    'buttons'=>array(
                        'print' => array( 
                                'label' => 'Print Disposal', 
                                'url' => '$this->grid->controller->createUrl("mutation/viewPrintDisposal",array("id"=>$data->disposalNo))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/print.png', 
                                //'visible'=>'is_null($data->print) ? false : true',
                                'options'=>array("target"=>"_blank"),
                        ),
                    ),   
               ),
	),
)); ?>

