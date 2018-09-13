<?php
$this->breadcrumbs=array(
	'Term Claim',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#claim-trading-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Term Claim</h1>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Claim Trading")), Yii::app()->createUrl("trading/claimCreate")); ?>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'claim-trading-grid',
    	'dataProvider'=>$model->search(),
    	//'filter'=>$model,
    	'columns'=>array(            
            array(
               'name'=>'Deskripsi',                   
               'type'=>'raw',
               'value'=>'(CHtml::link($data->claimNo." - ".$data->groupName, Yii::app()->createUrl("trading/claimView",array("id"=>$data->claimNo)))).'                    
                    . '"<br/> Tanggal : ".date("d-m-Y", strtotime($data->claimDate))',
            ),                                     
            array(
                "name"=>"claimStatus",
                "value"=>'$data->claimStatus'
            ),           
//            array(
//                'class'=>'CButtonColumn',
//                //--------------------- begin added --------------------------
//                'template' => '{update}',
//                'buttons'=>array(                    
//                    'update'=>array(
//                            'url'=>'$this->grid->controller->createUrl("trading/termUpdate", array("id"=>$data->termID))',                            
//                    ),
//                ),    
//            ),
    	),
    )); 
?>
