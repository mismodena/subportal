<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>    

    <div class="simple">		
        <?php echo $form->textField($model, 'keyWord', array('size' => 50, 'maxlength' => 50)); ?> 
        <br/>
        <br/>
    </div>
    
    <div class="simple">
        <?php echo CHtml::submitButton('Cari', array('class' => 'btn btn-sm')); ?>
        <br/><br/>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->