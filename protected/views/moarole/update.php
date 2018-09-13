<?php
/* @var $this MoaroleController */
/* @var $model Moarole */

$this->breadcrumbs=array(
	'Moaroles'=>array('index'),
	$model->name=>array('view','id'=>$model->idcard),
	'Update',
);

$this->menu=array(
	array('label'=>'List Moarole', 'url'=>array('index')),
	array('label'=>'Create Moarole', 'url'=>array('create')),
	array('label'=>'View Moarole', 'url'=>array('view', 'id'=>$model->idcard)),
	array('label'=>'Manage Moarole', 'url'=>array('admin')),
);
?>

<h1>Update Moarole <?php echo $model->idcard; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>