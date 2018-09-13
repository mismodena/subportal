<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-form',
	
        'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange'=>false,
            'afterValidate'=>'js:$.yii.fix.ajaxSubmit.afterValidate',
),
)); 

?>

        <div class="group">
            <?php echo Yii::t('ui', 'Asset'); ?>
        </div>
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

        <div>
            <table>
                
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'TypeName'); ?>
                            <?php echo $form->textField($model,'TypeName',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'TypeName'); ?>
                        </div>                               
                    </td>
                </tr>                
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'TypeDesc'); ?>
                            <?php echo $form->textField($model,'TypeDesc',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'TypeDesc'); ?>
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