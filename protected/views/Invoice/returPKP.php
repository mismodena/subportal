<style>
 .button1 {
  //background:url('<?php echo Yii::app()->baseUrl."/images/paid-icon.png"; ?>');
  width:80px;
  height:30px;
  cursor:pointer;
  border-radius: 12px;
  }
  
</style>
    
<div class=" form">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'pkp-retur-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,      
    )); ?>

    <table width="100%">
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'invNumber'); ?>
                    <?php echo $form->textField($model, 'invNumber', array('size' => 30, 'maxlength' => 30,  "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'invNumber'); ?>
                </div>                               
            </td>
        </tr>  
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'nameCust'); ?>
                    <?php echo $form->textField($model, 'nameCust', array('size' => 30, 'maxlength' => 30, "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'nameCust'); ?>
                </div>                               
            </td>
        </tr>  
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'value'); ?>
                    <?php echo $form->textField($model, 'value', array('size' => 30, 'maxlength' => 30, "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'value'); ?>
                </div>                               
            </td>
        </tr>
        
        <tr>
            <td width="40%" align="center"> <br/>                
                    <?php echo CHtml::submitButton('[retur]',array('class'=>'')); ?>
            </td>
        </tr>           
    </table>
                
<?php $this->endWidget(); 


?>  
</div><!-- form -->
