<?php
/* @var $this CampaignController */
/* @var $model Campaign */

$this->breadcrumbs=array(	
	'Daftar Promo',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#campaign-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Daftar Promo</h1>

<div class="search-form" style="display:block">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br />
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'campaign-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
                array(
                   'name'=>'Nomor',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->campaignNo." - ".$data->campaignName,Yii::app()->createUrl("campaign/view",array("id"=>$data->campaignID)))).'
                    . '"<br/>Periode: ".date("d-m-Y",strtotime($data->campaignFrom))." s/d ".date("d-m-Y",strtotime($data->campaignTo))',
                    'headerHtmlOptions' => array('style'=>'width:45%;'),
                ),
                'campaignDesc',
	),
)); ?>
