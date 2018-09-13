<?php
/* @var $this MoaroleController */
/* @var $model Moarole */

$this->breadcrumbs=array(
	'Moaroles'=>array('index'),
	'Manage',
);
?>

<h1>MOA List</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'moarole-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'idcard',
		/*'appcode',*/
		'name',
		'initial',
		/*'divid',*/
		'branch',
		'email',
                'parent',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
