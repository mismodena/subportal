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
        'id'=>'fpp-finance-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,
       // 'action' => Yii::app()->createUrl('formPP/execFinance'),  //<- your form action here
    )); ?>

    <table width="100%">
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($approval, 'fppUser'); ?>
                    <?php echo $form->textField($approval, 'fppUser', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan Bank', "readOnly"=>'true')); ?>
                    <?php echo $form->error($approval, 'fppUser'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($approval, 'fppUserDeptName'); ?>
                    <?php echo $form->textfield($approval, 'fppUserDeptName', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor cheque', "readOnly"=>'true')); ?>
                    <?php echo $form->error($approval, 'fppUserDeptName'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($approval, 'fppToBank'); ?>
                    <?php echo $form->textfield($approval, 'fppToBank', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor Voucher', "readOnly"=>'true')); ?>
                    <?php echo $form->error($approval, 'fppToBank'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($approval, 'adjustmentValue'); ?>
                    <?php echo $form->textfield($approval, 'adjustmentValue', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor Voucher', "readOnly"=>'true')); ?>
                    <?php echo $form->error($approval, 'adjustmentValue'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td width="40%" align="center"> <br/>                
                    <?php echo CHtml::submitButton('[Bayar]',array('class'=>'')); ?>
            </td>
        </tr>           
    </table>
                

<?php $this->endWidget(); 


?>   

</div><!-- form -->
