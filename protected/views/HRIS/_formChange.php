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
        <?php echo Yii::t('ui', 'Perubahan'); ?>
    </div>
    <table width="100%">
        
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'startDate'); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'startDate',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'yy-mm-dd', // save to db format
                            'altField' => '#self_pointing_id',
                            //'altFormat' => 'dd-mm-yy', // show to user format
                            'showOtherMonths' => true,      // show dates in other months
                            'selectOtherMonths' => true,    // can seelect dates in other months
                            'changeYear' => true,           // can change year
                            'changeMonth' => true,          // can change month
                            //'yearRange' => '2000:2099',     // range of year   
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;'
                        ),
                    ));?>
                    <?php echo $form->error($model, 'startDate'); ?>
                </div>                               
            </td>                        
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'endDate'); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'endDate',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'yy-mm-dd', // save to db format
                            'altField' => '#self_pointing_id',
                            //'altFormat' => 'dd-mm-yy', // show to user format
                            'showOtherMonths' => true,      // show dates in other months
                            'selectOtherMonths' => true,    // can seelect dates in other months
                            'changeYear' => true,           // can change year
                            'changeMonth' => true,          // can change month
                            //'yearRange' => '2000:2099',     // range of year   
                        ),
                        'htmlOptions' => array(
                            'style' => 'height:20px;'
                        ),
                    ));?>
                    <?php echo $form->error($model, 'endDate'); ?>
                </div>                               
            </td>                        
        </tr>
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'contractReplacement'); ?>
                    <?php echo $form->textArea($model, 'contractReplacement', array('cols'=>38,'rows'=>5, 'placeholder' => 'Keterangan..', )); ?>
                    <?php echo $form->error($model, 'contractReplacement'); ?>
                </div>                               
            </td>
        </tr> 
        <tr>
            <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'contractType'); ?>
                    <?php echo $form->dropDownList($model,'contractType',array("I"=>"Kontrak Pertama","II"=>"Kontrak Kedua",)); ; ?>
                    <?php echo $form->error($model, 'contractType'); ?>
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
