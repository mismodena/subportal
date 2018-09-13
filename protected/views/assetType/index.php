<?php
$this->breadcrumbs=array(
	'Daftar Tipe Asset',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#asset-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar Tipe Asset</h1>

<div class="search-form">
<?php
 $this->renderPartial('_search',array(
	'model'=>$model,
)); 
?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Asset Type")), Yii::app()->createUrl("assetType/create")); ?>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'asset-grid',
    	'dataProvider'=>$model->search(),
    	//'filter'=>$model,
    	'columns'=>array(
	
    		'TypeID',
            'TypeName',
            'TypeDesc',
    		
    		array(
    			'class'=>'CButtonColumn',
                
               
    		),
	),
    )); 
?>


