<?php

$this->breadcrumbs=array(
	'Notifikasi Jatuh Tempo Hutang'=>array('indexJT'),
	$model->utang_id,
);

?>

<h1>Disposal No. #<?php echo $model->utang_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'utang_id',
        'utang_dari',
        'utang_nilai',
        'utang_matauang',
        'utang_tanggalcair',
        'utang_outstanding',
        'utang_jatuhtempo',
        'utang_keterangan',
        
	),
)); ?>
<br/>


