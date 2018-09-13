<?php
/* @var $this MoaroleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Moaroles',
);

$this->menu=array(
	array('label'=>'Create Moarole', 'url'=>array('create')),
	array('label'=>'Manage Moarole', 'url'=>array('admin')),
);
?>

<h1>Moaroles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
