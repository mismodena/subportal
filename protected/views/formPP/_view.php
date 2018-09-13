<?php
/* @var $this FormPPController */
/* @var $data FppHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fppID), array('view', 'id'=>$data->fppID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppNo')); ?>:</b>
	<?php echo CHtml::encode($data->fppNo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppUser')); ?>:</b>
	<?php echo CHtml::encode($data->fppUser); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppUserDept')); ?>:</b>
	<?php echo CHtml::encode($data->fppUserDept); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppUserDate')); ?>:</b>
	<?php echo CHtml::encode($data->fppUserDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppToName')); ?>:</b>
	<?php echo CHtml::encode($data->fppToName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppToBank')); ?>:</b>
	<?php echo CHtml::encode($data->fppToBank); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fppToBankAcc')); ?>:</b>
	<?php echo CHtml::encode($data->fppToBankAcc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppToDate')); ?>:</b>
	<?php echo CHtml::encode($data->fppToDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppFinBank')); ?>:</b>
	<?php echo CHtml::encode($data->fppFinBank); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppFinCheque')); ?>:</b>
	<?php echo CHtml::encode($data->fppFinCheque); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppFinVoucher')); ?>:</b>
	<?php echo CHtml::encode($data->fppFinVoucher); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppCategory')); ?>:</b>
	<?php echo CHtml::encode($data->fppCategory); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fppCategoryValue')); ?>:</b>
	<?php echo CHtml::encode($data->fppCategoryValue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inputUN')); ?>:</b>
	<?php echo CHtml::encode($data->inputUN); ?>
	<br />

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