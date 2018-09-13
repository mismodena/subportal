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
            <?php echo Yii::t('ui', 'Asset Code'); ?>
        </div>
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

        <div>
            <table>
                
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'Department'); ?>
                            <?php echo $form->textField($model,'Department',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'Department'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'kodeAsset'); ?>
                            <?php echo $form->textField($model,'kodeAsset',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'kodeAsset'); ?>
                        </div>                               
                    </td>
                </tr>
                 <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'PICDept'); ?>
                            <?php echo $form->textField($model,'PICDept',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'PICDept'); ?>
                        </div>                               
                    </td>
                </tr>                       
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'lokasi'); ?>
                            <?php echo $form->textField($model,'lokasi',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->error($model,'lokasi'); ?>
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