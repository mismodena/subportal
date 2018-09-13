<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'master-open-form',
        'enableAjaxValidation' => true,
    ));

    Yii::app()->clientScript->registerScript('JQuery', "        
        function execForm()
        { 
            document.getElementById('master-open-form').submit();           
        }
    ", CClientScript::POS_END);
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="group">    
        <?php
        if ($model->isNewRecord) {
            echo Yii::t('ui', 'New Open TQ');
        } else {
            echo Yii::t('ui', 'Setup Update');
        }
        ?>
    </div>
    <div>
        <div class="simple">
            <?php echo $form->labelEx($model, 'fiscalPeriod'); ?>
            <?php echo $form->textField($model, 'fiscalPeriod', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Fiscal Period --', 'readOnly' => "readOnly")); ?>
            <?php echo $form->error($model, 'fiscalPeriod'); ?>
        </div> 
        <div class="simple">
            <?php echo $form->labelEx($model, 'openTQ'); ?>
            <?php echo $form->checkbox($model, 'openTQ'); ?>  
            <?php echo $form->error($model, 'openTQ'); ?>
        </div>  
        <div class="simple">
            <?php // echo $form->labelEx($model, 'openSource'); ?>
            <?php // echo $form->checkbox($model, 'openSource'); ?>  
            <?php // echo $form->error($model, 'openSource'); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Save!' : 'Simpan', array('class' => 'btn btn-sm')); ?>
        <?php echo CHtml::link('Simpan', "javascript:execForm();", array('confirm' => 'Submit?', 'class' => 'btn btn-sm',)); ?>  
    </div>

    <?php $this->endWidget();
    ?>

</div><!-- form -->