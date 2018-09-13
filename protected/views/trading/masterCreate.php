<?php
$this->breadcrumbs=array(
	'Term Item'=>array('masterIndex'),
	'New Term Item',
);

?>

<h1>New Term Item</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>