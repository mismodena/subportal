<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'userid'); ?>
		<?php echo $form->textField($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usernik'); ?>
		<?php echo $form->textField($model,'usernik',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idcard'); ?>
		<?php echo $form->textField($model,'idcard',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userpsw'); ?>
		<?php echo $form->textField($model,'userpsw',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userlevel'); ?>
		<?php echo $form->textField($model,'userlevel',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jobs'); ?>
		<?php echo $form->textField($model,'jobs',array('size'=>24,'maxlength'=>24)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deptid'); ?>
		<?php echo $form->textField($model,'deptid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'logdate'); ?>
		<?php echo $form->textField($model,'logdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'logtime'); ?>
		<?php echo $form->textField($model,'logtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'logstatus'); ?>
		<?php echo $form->textField($model,'logstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'expired'); ?>
		<?php echo $form->textField($model,'expired'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active'); ?>
		<?php echo $form->checkBox($model,'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'regu'); ?>
		<?php echo $form->textField($model,'regu',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nopolkend'); ?>
		<?php echo $form->textField($model,'nopolkend',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shipstatus'); ?>
		<?php echo $form->textField($model,'shipstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'branch'); ?>
		<?php echo $form->textField($model,'branch',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->