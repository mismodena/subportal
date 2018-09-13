<?php
$this->breadcrumbs=array(
	'Daftar Mutasi'=>array('index'),
	'MAT',
);

?>

<h1>Pengajuan Mutasi Aktiva Tetap (MAT)</h1>

<?php $this->renderPartial('_form', array('model'=>$model,)); ?>