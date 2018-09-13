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
                    <?php echo $form->labelEx($approval, 'TOTAL'); ?>
                    <?php echo $form->textfield($approval, 'TOTAL', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor Voucher', "readOnly"=>'true')); ?>
                    <?php echo $form->error($approval, 'TOTAL'); ?>
                </div>                               
            </td>
        </tr>               
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($approval, 'optVeri'); ?>
                    <?php echo $form->dropDownList($approval,'optVeri',array("1"=>"Bayar", "2"=>"Revisi",)); ?>
                    <?php echo $form->error($approval, 'optVeri'); ?>
                </div>                               
            </td>
        </tr>         
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($approval, 'reason'); ?>
                    <?php echo $form->textArea($approval, 'reason', array('cols' => 40, 'rows' => 4, 'placeholder' => 'Masukkan alasan')); ?>
                    <?php echo $form->error($approval, 'reason'); ?>
                </div>                               
            </td>
        </tr> 
        <tr>
            <td width="40%" align="center"> <br/>                
                    <?php echo CHtml::submitButton('[confirm]',array('class'=>'')); ?>
            </td>
        </tr>           
    </table>
                

<?php $this->endWidget(); 


?>   

</div><!-- form -->
