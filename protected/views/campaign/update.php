<?php
/* @var $this CampaignController */
/* @var $model Campaign */

$this->breadcrumbs=array(
	'Campaigns'=>array('index'),
	$model->campaignID=>array('view','id'=>$model->campaignID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Campaign', 'url'=>array('index')),
	array('label'=>'Create Campaign', 'url'=>array('create')),
	array('label'=>'View Campaign', 'url'=>array('view', 'id'=>$model->campaignID)),
	array('label'=>'Manage Campaign', 'url'=>array('admin')),
);
?>

<h1>Update Campaign <?php echo $model->campaignID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>