<?php
$this->breadcrumbs=array(
	'Daftar Kontrak'=>array('index'),
	'Form',
);

?>

<h1>Form Kontrak</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>