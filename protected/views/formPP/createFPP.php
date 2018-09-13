<?php
$this->breadcrumbs=array(
	'Daftar FPP'=>array('index'),
	'Pengajuan',
);

?>

<h1>Pengajuan FPP (AP)</h1>

<?php $this->renderPartial('_formFPP', array('model'=>$model,)); ?>