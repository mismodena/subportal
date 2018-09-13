<?php
$this->breadcrumbs=array(
	'Pengaturan'=>array('setupIndex'),
	'Perubahan',
);

?>

<h1>Perubahan Pengaturan</h1>

<?php $this->renderPartial('_formSetup', array('model'=>$model)); ?>