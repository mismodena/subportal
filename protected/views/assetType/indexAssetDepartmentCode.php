<?php
$this->breadcrumbs=array(
	'Daftar Asset Number Departmentdan Cabang',
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
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Asset Code")), Yii::app()->createUrl("assetType/createAssetDepartmentCode")); ?>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'asset-grid',
    	'dataProvider'=>$model->search(),
    	//'filter'=>$model,
    	'columns'=>array(
	
    		'id',
            'Department',
            'kodeAsset',
            'lokasi',
    		
    		array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update} -- {view} ',
                    'buttons'=>array(                    
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("assetType/updateAssetNumber", array("id"=>$data["id"]))',                            
                        ),
                         'view'=>array(
                                'url'=>'$this->grid->controller->createUrl("assetType/viewAssetDepartmentCode", array("id"=>$data["id"]))',                            
                        ),
                        //  'delete'=>array(
                        //         'url'=>'$this->grid->controller->createUrl("assetType/delete", array("id"=>$data["id"]))',                            
                        // ),
                    ),    
                ),
	),
    )); 
?>


