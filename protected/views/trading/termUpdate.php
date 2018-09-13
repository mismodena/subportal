<?php
$this->breadcrumbs=array(
	'Term Customer'=>array('termIndex'),
	'Update Term Customer',
);

?>

<h1>Update Term Customer : <?php echo $model->termNo ;?></h1>

<?php $this->renderPartial('_formCustomer', array('model'=>$model)); ?>