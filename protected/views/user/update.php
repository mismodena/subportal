<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Daftar User'=>array('Admin'),
	'Perubahan Data',
);

?>

<h1>Perubahan Data :: <?php echo $model->username; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>