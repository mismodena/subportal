<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-form',
    'enableClientValidation' => true,
    'enableAjaxValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange'=>false,
        'afterValidate'=>'js:$.yii.fix.ajaxSubmit.afterValidate',
),
));

Yii::app()->clientScript->registerCoreScript('my'); 

?>

    <div class="group">
        <?php echo Yii::t('ui', 'Jatuh Tempo Hutang'); ?>
    </div>
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'utang_dari'); ?>
                            <?php //echo $form->textField($model,'utang_matauang',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->dropDownList($model,'utang_dari',array("OCBC NISP"=>"OCBC NISP",
                                    "Standard Chartered Bank"=>"Standard Chartered Bank",
                                    "BNI" => "BNI",
                                    "CIMB NIAGA" => "CIMB NIAGA",
                                    "BRI"=>"BRI",
                                    "Mandiri" =>"Mandiri",
                                    "BCA" => "BCA",
                                    "BRI" => "BRI") ,array('empty' => '-- BANK --')); ; ?>
                            <?php echo $form->error($model,'utang_dari'); ?>
                        </div>                               
                    </td>
                </tr>                
                <tr>
                    <td>
                        <div class="simple">
                           <?php echo $form->labelEx($model,'utang_nilai'); ?>
                           <?php echo $form->textField($model,'utang_nilai',array(
                                  'class'=>'number',
                                  'size'=>50,
                                  'maxlength'=>50,
                            )); ?>
                           <?php echo $form->error($model,'utang_nilai'); ?>
                        </div>
                        <script>
                               $('input.number').keyup(function(event) {
                               // skip for arrow keys
                               if(event.which >= 37 && event.which <= 40) return;
                               // format number
                               $(this).val(function(index, value) {
                                     return value
                                    .replace(/\D/g, '')
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                                    ;
                               });
                             });
                        </script>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'utang_matauang'); ?>
                            <?php //echo $form->textField($model,'utang_matauang',array('size'=>50,'maxlength'=>50)); ?>
                            <?php echo $form->dropDownList($model,'utang_matauang',array("IDR"=>"IDR","USD"=>"USD", "EUR"=>"EUR") ,array('empty' => 'Mata Uang...')); ; ?>
                            <?php echo $form->error($model,'utang_matauang'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'utang_tanggalcair'); ?>
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'name' => 'utang_tanggalcair',
                                'attribute' => 'utang_tanggalcair',
                                'options' => array(
                                    'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                                    'showOn' => 'button', // 'focus', 'button', 'both'
                                    'buttonText' => Yii::t('ui', 'Select form calendar'),
                                    'buttonImage' => XHtml::imageUrl('calendar.png'),
                                    'buttonImageOnly' => true,
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width:150px;vertical-align:top',
                                    'placeholder'=>'Tanggal cair..',
                                    'readOnly'=>'true',                                    
                                ),
                            ));
                            ?>

                            <?php echo $form->error($model, 'utang_tanggalcair'); ?>
                        </div>                               
                    </td>                        
                </tr

                <tr>
                    <td>
                        <div class="simple">
                           <?php echo $form->labelEx($model,'utang_outstanding'); ?>
                           <?php echo $form->textField($model,'utang_outstanding',array(
                                  'class'=>'number',
                                  'size'=>50,
                                  'maxlength'=>50,
                            )); ?>
                           <?php echo $form->error($model,'utang_outstanding'); ?>
                        </div>
                        <script>
                               $('input.number').keyup(function(event) {
                               // skip for arrow keys
                               if(event.which >= 37 && event.which <= 40) return;
                               // format number
                               $(this).val(function(index, value) {
                                     return value
                                    .replace(/\D/g, '')
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                                    ;
                               });
                        });
                        </script>                               
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'utang_jatuhtempo'); ?>
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'name' => 'utang_jatuhtempo',
                                'attribute' => 'utang_jatuhtempo',
                                'options' => array(
                                    'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                                    'showOn' => 'button', // 'focus', 'button', 'both'
                                    'buttonText' => Yii::t('ui', 'Select form calendar'),
                                    'buttonImage' => XHtml::imageUrl('calendar.png'),
                                    'buttonImageOnly' => true,
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width:150px;vertical-align:top',
                                    'placeholder'=>'Jatuh tempo..',
                                    'readOnly'=>'true',                                    
                                ),
                            ));
                            ?>

                            <?php echo $form->error($model, 'utang_jatuhtempo'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'utang_keterangan'); ?>
                            <?php echo $form->textArea($model,'utang_keterangan',array('rows'=>5,'cols'=>37)); ?>
                            <?php echo $form->error($model,'utang_keterangan'); ?>
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