<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'master-term-form',
        'enableAjaxValidation' => true,
    )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">    
            <?php
                if ($model->isNewRecord){ 
                    echo Yii::t('ui', 'New Percentage');
                }else{
                    echo Yii::t('ui', 'Update Percentage');
                } 
            ?>
        </div>
        <div>
            <div class="simple">
                <?php echo $form->labelEx($model, 'termType'); ?>
                <?php echo $form->dropDownList($model,'termType',array("BQ"=>"BQ", "TQ"=>"TQ", "BBT"=>"BBT")); ; ?>
                <?php echo $form->error($model, 'termType'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'classDealer'); ?>
                <?php echo $form->textField($model, 'classDealer', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Kelas Dealer --')); ?>
                <?php echo $form->error($model, 'classDealer'); ?>
            </div>       
            <div class="simple">
                <?php echo $form->labelEx($model, 'fromValue'); ?>
                <?php echo $form->textField($model,'fromValue',array('size' => 40, 'maxlength' => 50,)); ; ?> s/d
                <?php echo $form->textField($model,'toValue',array('size' => 40, 'maxlength' => 50,)); ; ?>
                <?php echo $form->error($model, 'fromValue'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'percentage'); ?>
                <?php echo $form->textField($model,'percentage',array('size' => 3, 'maxlength' => 25,)); ; ?>
                <?php echo $form->error($model, 'percentage'); ?>
            </div> 

        </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan',array('class' => 'btn btn-sm'));?>
            
	</div>

<?php $this->endWidget();        

?>

</div><!-- form -->