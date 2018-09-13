<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
        'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
/*'clientOptions' => array(
    'validateOnSubmit' => true,
    'validateOnChange'=>false,
    'afterValidate'=>'js:$.yii.fix.ajaxSubmit.afterValidate',
),*/
)); 

?>

        <div class="group">
            <?php echo Yii::t('ui', 'User'); ?>
        </div>
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'username'); ?>
                            <?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'username'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'idcard'); ?>
                            <?php echo $form->textField($model,'idcard',array('size'=>10,'maxlength'=>10)); ?>
                            <?php echo $form->error($model,'idcard'); ?>
                        </div>                               
                    </td>
                </tr>                
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'userpsw'); ?>
                            <?php echo $form->textField($model,'userpsw',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'userpsw'); ?>
                        </div>                               
                    </td>
                </tr>                                
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'userlevel'); ?>
                            <?php echo $form->textField($model,'userlevel',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'userlevel'); ?>                     
                        </div>                               
                    </td>
                </tr>                 
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'active'); ?>
                            <?php echo $form->checkBox($model,'active'); ?>
                            <?php echo $form->error($model,'active'); ?>
                        </div>                               
                    </td>
                </tr>
            </table>
        </div>
       
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
               ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->