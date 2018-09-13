<?php
$this->breadcrumbs=array(
	'Daftar FPP'=>array('index'),
	'Pengajuan',
);

?>

<h1>Pengajuan FPP</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'detail'=>$detail)); ?>