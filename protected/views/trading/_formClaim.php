<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'claim-trading-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true, 
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">    
            <?php
                if ($model->isNewRecord){ 
                    echo Yii::t('ui', 'New Customer Term');
                }else{
                    echo Yii::t('ui', 'Update Customer Term');
                } 
            ?>
        </div>
        <div>
            <div class="simple">
                <?php echo $form->labelEx($model, 'claimGroup'); ?>
                <?php
                    $this->widget('ext.widgets.select2.XSelect2', array(
                        'model'=>$model,
                        'attribute'=>'claimGroup',
                        'data'=>  Utility::getCustGroup2(),
                        'htmlOptions'=>array(
                                'style'=>'width:295px',
                                'empty'=>'',
                                'placeholder'=>'-- Customer Group Code --'
                        ),
                    ));
                ?>
                <?php echo $form->error($model, 'claimGroup'); ?>
            </div> 
            <div class="simple">
                <?php echo $form->labelEx($model, 'claimDate'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'claimDate',
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
                <?php echo $form->error($model, 'claimDate'); ?>
            </div> 
            
            <div class="simple">
                <?php echo $form->labelEx($model, 'claimDesc'); ?>
                <?php echo $form->textArea($model, 'claimDesc', array('cols' => 40, 'rows' => 6, 'placeholder' => '-- Deskripsi --')); ?>
                <?php echo $form->error($model, 'claimDesc'); ?>
            </div> 
			
            <div class="simple">
                <?php echo CHtml::label('Revisi','Revisi;'); ?>
                <?php echo $form->checkbox($model, 'isRevise'); ?>  
                <?php echo $form->error($model, 'isRevise'); ?>
            </div>
				
            <div class="simple">
                <?php echo $form->labelEx($model,'fileName'); ?>
                <?php echo $form->fileField($model,'fileName',array('size'=>50,'maxlength'=>50, 'accept'=>'application/vnd.ms-excel')); ?>
                <?php echo $form->error($model,'fileName'); ?>
            </div> 
            
            <div class="simple">
                <?php echo CHtml::label('Claim','Claim'); ?>
                <?php 
                    $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                        'id'=>'tableTrading',
                        'models' => $model->details,
                        'containerTagName' => 'table',
                        'headerTagName' => 'thead',
                        'header' => '

                        ',
                        'inputContainerTagName' => 'tbody',
                        'inputTagName' => 'tr',
                        'inputView' => '/site/extensions/_tabularTradingDetail',
                        'inputUrl' => $this->createUrl('request/addTabTradingDetail'),
                        'isAddOk' => false,
                        'isRemoveOk' => false,
                        //'addTemplate' => '<tbody><tr><td colspan="2">{link}</td></tr></tbody>',
                        //'addLabel' => Yii::t('ui', 'Tambah'),
                        //'addHtmlOptions' => array('class' => 'blue pill full-width'),
                        //'removeTemplate' => '<td>{link}</td>',
                        //'removeLabel' => Yii::t('ui', 'Hapus'),

                    ));
                ?>
        </div>
                   
            
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save!' : 'Simpan');                 ?>
            
	</div>

<?php $this->endWidget();        

?>

</div><!-- form -->

