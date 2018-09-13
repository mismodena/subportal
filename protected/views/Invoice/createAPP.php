<?php
$this->breadcrumbs=array(
	'Daftar Penerimaan Penagihan'=>array('indexAP'),
	'Form',
);

?>

<h1>Form Penerimaan Penagihan</h1>

<?php $this->renderPartial('_formAPP', array('model'=>$model)); ?>