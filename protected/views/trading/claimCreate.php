<?php
$this->breadcrumbs=array(
	'Term Claim'=>array('claimIndex'),
	'New Claim',
);

?>

<h1>New Claim</h1>

<?php $this->renderPartial('_formClaim', array('model'=>$model)); ?>