<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-form',
	
        'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange'=>false,
            'afterValidate'=>'js:$.yii.fix.ajaxSubmit.afterValidate',
),
)); 

?>

        <div class="group">
            <?php echo Yii::t('ui', 'Asset'); ?>
        </div>
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <div>
            <table>
              
                <tr>
                    <td>
 
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'assetNumber'); ?>
                            <?php echo $form->textField($model, 'assetNumber', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --','readonly' => true)); ?>
                            <?php echo $form->error($model, 'assetNumber'); ?>
                        </div>                             
                    </td>
                </tr> 
                <tr>
                    <td>    
                         <div class="simple">
                            <?php echo $form->labelEx($model,'idDept'); ?>
                            <?php echo $form->dropDownList($model,'idDept', LookupView::getDeptAsset(), array('empty' => 'Pilih departemen...',
                                ));
                                ?> 
                                
                            <?php echo $form->error($model,'idDept'); ?>
                        </div>                        
                    </td>
                </tr> 
                 <tr>
                    <td>    
                            <div class="simple">
                            <?php echo $form->labelEx($model,'modenaPIC'); ?>
                             <?php echo $form->textField($model,'modenaPIC',array('rows'=>5,'cols'=>37)); ?>
                            <?php echo $form->error($model,'modenaPIC'); ?>
                        </div>                            
                    </td>
                </tr> 
                <tr>
                    <td>  
                         <div class="simple">
                          <?php echo $form->labelEx($model, 'assetType'); ?>
                            <?php echo $form->dropDownList($model,'assetType',CHtml::listData(AssetType::model()->findAll(array('order' => 'TypeName ASC')),'TypeID', 'TypeName'),array('empty' => 'Pilih tipe...')); ?>
                            <?php echo $form->error($model,'assetType'); ?>
                        </div>                             
                    </td>
                </tr>            
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'assetDesc'); ?>
                            <?php echo $form->textArea($model,'assetDesc',array('rows'=>5,'cols'=>37)); ?>
                            <?php echo $form->error($model,'assetDesc'); ?>
                        </div>                               
                    </td>
                </tr>  
              

            <tr>
                <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'acquisitionDate'); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'acquisitionDate',
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
                    <?php echo $form->error($model, 'acquisitionDate'); ?>
                </div>
                </td>
            </tr> 

            <tr>
                <td>
                    <div class="simple"><?php /*
                        <?php echo $form->labelEx($model, 'ppbjNo'); ?>
                        <?php echo $form->textField($model, 'ppbjNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- No PPBJ --')); ?>
                        <?php echo $form->error($model, 'ppbjNo'); ?>
                    </div>                                    
                </td>
            </tr>
             <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'bapbNo'); ?>
                        <?php echo $form->textField($model, 'bapbNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- No BAPB --')); ?>
                        <?php echo $form->error($model, 'bapbNo'); ?>
                  */?>  </div>                                    
                </td>
            </tr>

           <!--  <tr>
                    <td>
                         <div class="simple">
                            <?php /*echo $form->labelEx($model, 'assetLocation'); ?>
                            <?php echo $form->textField($model, 'assetLocation', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Lokasi --')); ?>
                            <?php echo $form->error($model, 'assetLocation'); */?>
                        </div>
                                                    
                    </td>
                </tr>
            <tr> -->
                    <td>    
                          <div class="simple">
                            <?php echo $form->labelEx($model, 'assetCondition'); ?>
                            <?php echo $form->dropDownList($model,'assetCondition',array("Baik"=>"Baik","Hilang"=>"Hilang","Rusak"=>"Rusak")); ; ?>
                            <?php echo $form->error($model, 'assetCondition'); ?>
                        </div>                           
                    </td>
            </tr>
             <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'assetRemarks'); ?>
                            <?php echo $form->textArea($model,'assetRemarks',array('rows'=>5,'cols'=>37)); ?>
                            <?php echo $form->error($model,'assetRemarks'); ?>
                        </div>                               
                    </td>
                </tr>                                            
                
            </table>
        </div>
       
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
               ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->