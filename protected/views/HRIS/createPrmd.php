<?php
$this->breadcrumbs=array(
	'Daftar PRMD'=>array('indexPrmd'),
	'Form',
);

?>

<h1>Form PRMD</h1>

<?php $this->renderPartial('_formPrmd', array('model'=>$model)); ?>