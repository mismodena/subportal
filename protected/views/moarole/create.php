<?php
/* @var $this MoaroleController */
/* @var $model Moarole */

$this->breadcrumbs=array(
	'Moaroles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Moarole', 'url'=>array('index')),
	array('label'=>'Manage Moarole', 'url'=>array('admin')),
);
?>

<h1>Create Moarole</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>