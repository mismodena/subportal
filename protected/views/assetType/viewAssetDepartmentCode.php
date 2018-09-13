<?php

$this->breadcrumbs=array(
	'Asset Number'=>array('indexviewAssetDepartmentCode'),
	$model->id,
);

?>

<h1>Detail Asset  #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'Department',
		'PICDept',
		'lokasi',
		(array(
			'name'=>'PICDept',
			//'value'=> Branch::model()->findByAttributes(array('branchID'=>$model->licenseArea))->branchName,
			'value'=>  Employee::model()->find('idCard=:idCard', array(':idCard'=>$model->PICDept))->userName,
			'type' =>'raw'
		)), 
	
		
	),
)); ?>
