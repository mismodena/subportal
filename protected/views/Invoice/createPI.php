<?php
$this->breadcrumbs=array(
	'Daftar PI'=>array('indexPI'),
	'Form',
);

?>

<h1>Form PI</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>