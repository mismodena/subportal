<?php
/* @var $this CampaignController */
/* @var $data Campaign */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaignID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->campaignID), array('view', 'id'=>$data->campaignID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaignNo')); ?>:</b>
	<?php echo CHtml::encode($data->campaignNo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaignName')); ?>:</b>
	<?php echo CHtml::encode($data->campaignName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaignFrom')); ?>:</b>
	<?php echo CHtml::encode($data->campaignFrom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaignTo')); ?>:</b>
	<?php echo CHtml::encode($data->campaignTo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaignDesc')); ?>:</b>
	<?php echo CHtml::encode($data->campaignDesc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inputUN')); ?>:</b>
	<?php echo CHtml::encode($data->inputUN); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('inputTime')); ?>:</b>
	<?php echo CHtml::encode($data->inputTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modifUN')); ?>:</b>
	<?php echo CHtml::encode($data->modifUN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modifTime')); ?>:</b>
	<?php echo CHtml::encode($data->modifTime); ?>
	<br />

	*/ ?>

</div>