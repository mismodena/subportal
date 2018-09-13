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
        'id'=>'update-dept-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,      
    )); ?>

    <table width="100%">  
         <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'fppUser'); ?>
                    <?php echo $form->textField($model, 'fppUser', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan Bank', "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'fppUser'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'fppUserDeptName'); ?>
                    <?php echo $form->textfield($model, 'fppUserDeptName', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor cheque', "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'fppUserDeptName'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'fppToBank'); ?>
                    <?php echo $form->textfield($model, 'fppToBank', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor Voucher', "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'fppToBank'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'TOTAL'); ?>
                    <?php echo $form->textfield($model, 'TOTAL', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor Voucher', "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'TOTAL'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'optVeri'); ?>
                    <?php echo $form->dropDownList($model,'optVeri',array("1"=>"Verifikasi", "2"=>"Revisi",)); ?>
                    <?php echo $form->error($model, 'optVeri'); ?>
                </div>                               
            </td>
        </tr>         
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'reason'); ?>
                    <?php echo $form->textArea($model, 'reason', array('cols' => 40, 'rows' => 4, 'placeholder' => 'Masukkan alasan')); ?>
                    <?php echo $form->error($model, 'reason'); ?>
                </div>                               
            </td>
        </tr> 
        <tr>
            <td width="40%" align="center"> <br/>                
                    <?php echo CHtml::submitButton('[simpan]',array('class'=>'')); ?>
            </td>
        </tr>           
    </table>
                
<?php $this->endWidget(); 


?>  
</div><!-- form -->
