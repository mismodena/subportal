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
        'id'=>'hris-contract-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
       // 'action' => Yii::app()->createUrl('formPP/execFinance'),  //<- your form action here
    )); ?>
    
    <div class="group">
        <?php echo Yii::t('ui', 'Data Karyawan'); ?>
    </div>
    <table width="100%">
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'idCard'); ?>
                    <?php echo $form->textField($model, 'userName', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan Bank', "readOnly"=>'true')); ?>
                    <?php echo $form->hiddenField($model, 'idCard', array('size' => 40, 'maxlength' => 50)); ?>
                    <?php echo $form->error($model, 'idCard'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'deptName'); ?>
                    <?php echo $form->textfield($model, 'deptName', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor cheque', "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'deptName'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'startDate'); ?>
                    <?php echo $form->textfield($model, 'dispStart', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor Voucher', "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'startDate'); ?>
                </div>                               
            </td>
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'endDate'); ?>
                    <?php echo $form->textfield($model, 'dispEnd', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Masukkan nomor Voucher', "readOnly"=>'true')); ?>
                    <?php echo $form->error($model, 'endDate'); ?>
                </div>                               
            </td>
        </tr>          
    </table>
    
    <div class="group">
        <?php echo Yii::t('ui', 'Tindak Lanjut'); ?>
    </div>
    <table width="100%">
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'contractAction'); ?>
                    <?php echo $form->dropDownList($model,'contractAction',array("stop"=>"Akhiri Kontrak", "cont-os"=>"Outsourcing", "permanent"=>"Permanen", "3"=>"Perpanjangan 3 Bulan", "6"=>"Perpanjangan 6 Bulan", "12"=>"Perpanjangan 12 Bulan")); ?>
                    <?php echo $form->error($model, 'contractAction'); ?>
                </div>                               
            </td>                        
        </tr>                           
        <tr>
            <td width="40%" align="center"> <br/>                
                <?php echo CHtml::submitButton('- simpan perubahan -',array('class'=>'')); ?>
            </td>
        </tr> 
    </table>

<?php $this->endWidget(); 


?>   

</div><!-- form -->
