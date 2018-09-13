<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Daftar User'=>array('admin'),
	'User Baru',
);

?>

<h1>User Baru</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>