<?php
$this->breadcrumbs=array(
	'Daftar Penerimaan Faktur'=>array('indexAP'),
	'Form',
);

?>

<h1>Form Penerimaan Invoice</h1>

<?php $this->renderPartial('_formAP', array('model'=>$model)); ?>