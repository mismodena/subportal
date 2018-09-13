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
                    echo Yii::t('ui', 'Generate Retur');
                }else{
                    echo Yii::t('ui', 'Update Trading Term');
                } 
            ?>
        </div>
        <div>
            <div class="simple">
                <?php echo $form->labelEx($model, 'groupCode'); ?>
                <?php
                    $this->widget('ext.widgets.select2.XSelect2', array(
                        'model'=>$model,
                        'attribute'=>'groupCode',
                        'data'=>  Utility::getCustGroup(),
                        'htmlOptions'=>array(
                                'style'=>'width:295px',
                                'empty'=>'',
                                'placeholder'=>'-- Customer Group Code --'
                        ),
                    ));
                ?>
                <?php echo $form->error($model, 'groupCode'); ?>
            </div> 
            <div class="simple">
                <?php echo CHtml::label("&nbsp;","&nbsp;"); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Generate!' : 'Simpan');                 ?>            
            </div>
        </div>
        


<?php $this->endWidget();        

?>

</div><!-- form -->