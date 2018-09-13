<?php
/* @var $this MoaroleController */
/* @var $model Moarole */

$this->breadcrumbs=array(
	'Moaroles'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Moarole', 'url'=>array('index')),
	array('label'=>'Create Moarole', 'url'=>array('create')),
	array('label'=>'Update Moarole', 'url'=>array('update', 'id'=>$model->idcard)),
	array('label'=>'Delete Moarole', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idcard),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Moarole', 'url'=>array('admin')),
);
?>

<h1>View Moarole #<?php echo $model->idcard; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idcard',
		'appcode',
		'name',
		'initial',
		'divid',
		'branch',
		'email',
		'parent',
		'inpdate',
		'inppic',
		'upddate',
		'updpic',
	),
)); ?>
