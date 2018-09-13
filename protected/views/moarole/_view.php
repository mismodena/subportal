<?php
/* @var $this MoaroleController */
/* @var $data Moarole */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcard')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idcard), array('view', 'id'=>$data->idcard)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('appcode')); ?>:</b>
	<?php echo CHtml::encode($data->appcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('initial')); ?>:</b>
	<?php echo CHtml::encode($data->initial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('divid')); ?>:</b>
	<?php echo CHtml::encode($data->divid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch')); ?>:</b>
	<?php echo CHtml::encode($data->branch); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('parent')); ?>:</b>
	<?php echo CHtml::encode($data->parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inpdate')); ?>:</b>
	<?php echo CHtml::encode($data->inpdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inppic')); ?>:</b>
	<?php echo CHtml::encode($data->inppic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('upddate')); ?>:</b>
	<?php echo CHtml::encode($data->upddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updpic')); ?>:</b>
	<?php echo CHtml::encode($data->updpic); ?>
	<br />

	*/ ?>

</div>