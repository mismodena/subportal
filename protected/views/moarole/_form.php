<?php
/* @var $this MoaroleController */
/* @var $model Moarole */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'moarole-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="simple">
		<?php echo $form->labelEx($model,'appcode'); ?>
		<?php $this->widget('ext.widgets.select2.XSelect2', array(
                        'model'=>$model,
                        'attribute'=>'appcode',
                        'data'=>  Utility::getAppicationArray(),
                        'htmlOptions'=>array(
                                'style'=>'width:385px',
                                'empty'=>'',
                        ),
                    )); ?>
		<?php echo $form->error($model,'appcode'); ?>
	</div>
	<div class="simple">
		<?php echo $form->labelEx($model,'idcard'); ?>
		<?php $this->widget('ext.widgets.select2.XSelect2', array(
                        'model'=>$model,
                        'attribute'=>'idcard',
                        'data'=>User::model()->options,
                        'options'=>array(
                            'maximumSelectionSize'=>5,
                        ),
                        'htmlOptions'=>array(
                                'style'=>'width:385px',
                                'empty'=>'',
                                'class'=>'countries-select'
                        ),
                        'events'=>array(
                            'change'=>"js:function (element) {
                                var id=element.val;
                                if (id!='') {
                                    $.ajax('".$this->createUrl('/moarole/userIdentity')."', {
                                        data: {
                                            id: id
                                        }
                                    }).done(function(data) {
                                        var x = data.split(',');
                                        $('#Moarole_name').val(x[0]);
                                        $('#Moarole_initial').val(x[1]);
                                        $('#Moarole_divid').val(x[2]);
                                        $('#Moarole_branch').val(x[3]);
                                        $('#Moarole_email').val(x[4]);
                                    });
                                }
                            }"
                       ),
                    )); ?>
		<?php echo $form->error($model,'idcard'); ?>
	</div>
        
        <div class="simple">
		<?php echo $form->labelEx($model,'moastatus'); ?>
		<?php $this->widget('ext.widgets.select2.XSelect2', array(
                        'model'=>$model,
                        'attribute'=>'moastatus',
                        'data'=>Utility::getMoaApprovalArray(),
                        'htmlOptions'=>array(
                                'style'=>'width:385px',
                                'empty'=>'',
                        ),
                    )); ?>
		<?php echo $form->error($model,'moastatus'); ?>
	</div>
        
        <div class="simple">
		<?php echo $form->labelEx($model,'parent'); ?>
		<?php $this->widget('ext.widgets.select2.XSelect2', array(
                        'model'=>$model,
                        'attribute'=>'parent',
                        'data'=>User::model()->options,
                        'htmlOptions'=>array(
                                'style'=>'width:385px',
                                'empty'=>'',
                        ),
                    )); ?>
		<?php echo $form->error($model,'parent'); ?>
	</div>
        
	<div class="simple">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>50,'readonly' => true)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'initial'); ?>
		<?php echo $form->textField($model,'initial',array('size'=>60,'maxlength'=>5,'readonly' => true)); ?>
		<?php echo $form->error($model,'initial'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'divid'); ?>
		<?php echo $form->textField($model,'divid',array('size'=>60,'readonly' => true)); ?>
		<?php echo $form->error($model,'divid'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'branch'); ?>
		<?php echo $form->textField($model,'branch',array('size'=>60,'maxlength'=>60,'readonly' => true)); ?>
		<?php echo $form->error($model,'branch'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>60,'readonly' => true)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
        
	<div class="simple buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->