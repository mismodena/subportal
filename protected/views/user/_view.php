<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('userid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->userid), array('view', 'id'=>$data->userid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usernik')); ?>:</b>
	<?php echo CHtml::encode($data->usernik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idcard')); ?>:</b>
	<?php echo CHtml::encode($data->idcard); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userpsw')); ?>:</b>
	<?php echo CHtml::encode($data->userpsw); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userlevel')); ?>:</b>
	<?php echo CHtml::encode($data->userlevel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('jobs')); ?>:</b>
	<?php echo CHtml::encode($data->jobs); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deptid')); ?>:</b>
	<?php echo CHtml::encode($data->deptid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logdate')); ?>:</b>
	<?php echo CHtml::encode($data->logdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logtime')); ?>:</b>
	<?php echo CHtml::encode($data->logtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logstatus')); ?>:</b>
	<?php echo CHtml::encode($data->logstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expired')); ?>:</b>
	<?php echo CHtml::encode($data->expired); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regu')); ?>:</b>
	<?php echo CHtml::encode($data->regu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nopolkend')); ?>:</b>
	<?php echo CHtml::encode($data->nopolkend); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipstatus')); ?>:</b>
	<?php echo CHtml::encode($data->shipstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch')); ?>:</b>
	<?php echo CHtml::encode($data->branch); ?>
	<br />

	*/ ?>

</div>