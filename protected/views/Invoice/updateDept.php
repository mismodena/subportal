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
                    <?php echo $form->labelEx($model, 'deptID'); ?>
                    <?php echo $form->hiddenField($model, 'apDetailID', array('size' => 30, 'maxlength' => 30, 'placeholder' => 'Masukkan Bank', "readOnly"=>'true')); ?>
                    <?php
                        $this->widget('ext.widgets.select2.XSelect2', array(
                            'model'=>$model,
                            'attribute'=>'deptID',
                            'data'=>  Utility::getDepartment(),
                            'htmlOptions'=>array(
                                    'style'=>'width:295px',
                                    'empty'=>'',
                                    'placeholder'=>'-- Department --'
                            ),
                        ));
                    ?>
                    <?php echo $form->error($model, 'salesAcc'); ?>
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
