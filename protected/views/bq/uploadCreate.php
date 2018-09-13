<?php
$this->breadcrumbs=array(
	'Pengajuan Saldo'=>array('uploadIndex'),
	'Pengajuan',
);

?>

<h1>Pengajuan Saldo</h1>

<?php $this->renderPartial('_formUpload', array('model'=>$model)); ?>