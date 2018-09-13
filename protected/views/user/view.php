<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Daftar User'=>array('admin'),
	'Detail User',
);

?>

<h1>Detail User :: #<?php echo $model->username; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'userid',
		'username',
		'idcard',
		'userlevel',
		'email',
		'jobs',
		'logdate',
		'logtime',
		'logstatus',
		'expired',
		'active',
		
	),
)); ?>
