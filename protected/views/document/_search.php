<div >

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="simple">		
        <?php echo $form->textField($model, 'keyWord', array('size' => 50, 'maxlength' => 50)); ?>                           
    </div>
    <br/>
    <div class="simple">		
        <?php echo $form->checkbox($model, 'pending'); ?> Document pending                       
    </div>
    <br/>
    <?php echo CHtml::submitButton('Cari'); ?>  

<?php $this->endWidget(); ?>

</div><!-- search-form -->