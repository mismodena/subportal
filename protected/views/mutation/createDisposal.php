<?php
$this->breadcrumbs=array(
	'Pengajuan'=>array('createDisposal'),
	'Disposal',
);

?>

<h1>Pengajuan Disposal Asset</h1>

<?php $this->renderPartial('_formDisposal', array('model'=>$model,'cekSelect'=>$cekSelect,)); ?>