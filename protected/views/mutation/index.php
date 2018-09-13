<?php
$this->breadcrumbs=array(
	'Daftar MAT',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#mutation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar Mutasi Aktiva</h1>


<div class="search-form">
<?php 
    $this->renderPartial('_search',array(
    	'model'=>$model,
    )); 
?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New MAT")), Yii::app()->createUrl("mutation/create")); ?>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'mutation-grid',
	'dataProvider'=>$model->search(),
    'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->mutationNo." | Tanggal Pengajuan : ".date("d-m-Y", strtotime($data->mutationDate)), Yii::app()->createUrl("mutation/view",array("id"=>$data->mutationNo)))).' 
                        .'"<br/>From : ".$data->fromDeptName." - ".$data->fromPICName.'
                        .'"<br/>To   : ".$data->toDeptName." - ".$data->toPIC', 
                    'headerHtmlOptions' => array('style'=>'width:40%;'),

                ),
            array(
                    'name'=>'From',
                    'type'=>'raw',
                    'value'=>'$data->fromDeptName',
                ),
            array(
                    'name'=>'To',
                    'type'=>'raw',
                    'value'=>'$data->toDeptName',

                ),
            array(
                    'name'=>'Status',
                    'type'=>'raw',
                    'value'=>'$data->keterangan',
                    'headerHtmlOptions' => array('style'=>'width:35%;'),
                ),

            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{print}  {verified}',
                    'buttons'=>array(
                        'print' => array( 
                                'label' => 'Cetak MAT', 
                                'url' => '$this->grid->controller->createUrl("mutation/viewPrint",array("id"=>$data->mutationNo))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/print.png', 
                                'visible'=>'is_null($data->print) ? false : true',
                                'options'=>array("target"=>"_blank"),
                        ),
                        'verified'=>array(
                                'label' => 'Verifikasi MAT',
                                'url'=>'$this->grid->controller->createUrl("mutation/VerifiedMAT",array("id"=>$data->mutationNo))',
                                'click'=>'function() {if(!confirm("Konfirmasi penerimaan Asset?")) {return false;}}',
                                'imageUrl' => Yii::app()->baseUrl . '/images/check.png', 
                                'visible'=>'is_null($data->verified) ? false : true',
                                'options'=>array("target"=>"_blank"),                                                        
                        ),
                    ),   
                ),
	),
)); ?>

