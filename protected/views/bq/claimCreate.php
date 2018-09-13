<?php
$this->breadcrumbs=array(
	'Daftar Klaim'=>array('claim'),
	'Pengajuan Klaim',
);

?>

<h1>Pengajuan Klaim</h1>

<?php $this->renderPartial('_create', array('model'=>$model)); ?>