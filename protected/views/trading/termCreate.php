<?php
$this->breadcrumbs=array(
	'Term Customer'=>array('termIndex'),
	'New Term Customer',
);

?>

<h1>New Term Customer</h1>

<?php $this->renderPartial('_formCustomer', array('model'=>$model)); ?>