<?php
$this->breadcrumbs=array(
	'Daftar Jatuh Tempo Hutang'=>array('indexJT'),
	'Form',
);

?>

<h1>Form Notifikasi Jatuh Tempo Hutang</h1>

<?php $this->renderPartial('_formJT', array('model'=>$model)); ?>