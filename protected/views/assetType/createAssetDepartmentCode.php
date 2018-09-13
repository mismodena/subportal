<?php
$this->breadcrumbs=array(
	'Daftar Tipe Asset'=>array('indexAssetDepartmentCode'),
	'Form Tipe Asset',
);

?>

<h1>Form Tipe Asset</h1>

<?php $this->renderPartial('_formAssetDepartmentCode', array('model'=>$model)); ?>