<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'master-trading-form',
        'enableAjaxValidation' => true,
    )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">    
            <?php
                if ($model->isNewRecord){ 
                    echo Yii::t('ui', 'New Trading Term');
                }else{
                    echo Yii::t('ui', 'Update Trading Term');
                } 
            ?>
        </div>
        <div>
            <div class="simple">
                <?php echo $form->labelEx($model, 'tradCode'); ?>
                <?php echo $form->textField($model, 'tradCode', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Kode Trading --')); ?>
                <?php echo $form->error($model, 'tradCode'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'tradDesc'); ?>
                <?php echo $form->textField($model, 'tradDesc', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Deskripsi Trading --')); ?>
                <?php echo $form->error($model, 'tradDesc'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'tradSource'); ?>
                <?php echo $form->dropDownList($model,'tradSource',array("IN"=>"Selling In", "OUT"=>"Selling Out")); ; ?>
                <?php echo $form->error($model, 'tradSource'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'tradPeriod'); ?>
                <?php echo $form->dropDownList($model,'tradPeriod',array("M"=>"Monthly", "Y"=>"Yearly")); ; ?>
                <?php echo $form->error($model, 'tradPeriod'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'tradValueFrom'); ?>
                <?php echo $form->textField($model,'tradValueFrom',array('size' => 40, 'maxlength' => 50,)); ; ?> s/d
                <?php echo $form->textField($model,'tradValueTo',array('size' => 40, 'maxlength' => 50,)); ; ?>
                <?php echo $form->error($model, 'tradValueFrom'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'tradPercentage'); ?>
                <?php echo $form->textField($model,'tradPercentage',array('size' => 3, 'maxlength' => 25,)); ; ?>
                <?php echo $form->error($model, 'tradPercentage'); ?>
            </div> 

        </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save!' : 'Simpan');                 ?>
            
	</div>

<?php $this->endWidget();        

?>

</div><!-- form -->