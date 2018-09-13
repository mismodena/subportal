<div >

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="simple">		
		<?php echo $form->textField($model,'keyWord',array('size'=>50,'maxlength'=>50)); ?>                
                <?php echo CHtml::submitButton('Cari'); ?>
	</div>
        <br/>
        <div class="simple">
            <?php            
                echo $form->radioButtonList($model, 'isActive', array('1'=>'Aktif', '0'=>'Non-aktif')); ; 
                ?>
        </div>
        <br/>

<?php $this->endWidget(); ?>

</div><!-- search-form -->