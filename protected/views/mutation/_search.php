<div >

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="simple">		
		<?php 
				echo $form->textField($model,'keyWord',array('size'=>50,'maxlength'=>50)); ?>                
                <?php echo CHtml::submitButton('Cari'); ?>
	</div>
        <br/>

<?php $this->endWidget(); ?>

</div><!-- search-form -->