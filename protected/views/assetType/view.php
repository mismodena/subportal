<?php

$this->breadcrumbs=array(
	'Asset Type'=>array('index'),
	$model->TypeID,
);

?>

<h1>Detail Asset  #<?php echo $model->TypeID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			'TypeID',
			'TypeName',
			'TypeDesc',
			
		
	),
)); ?>
