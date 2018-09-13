<div class="form">
    
        
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'hris-contract-form',
        'enableAjaxValidation' => true,
    )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Pengajuan Kontrak'); ?>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'idCard'); ?>
                            <?php 
                                if ($model->isNewRecord){
                                    $this->widget('ext.widgets.select2.XSelect2', array(
                                        'model'=>$model,
                                        'attribute'=>'userName',
                                        'options'=>array(
                                                'minimumInputLength'=>2,
                                                'ajax' => array(
                                                        'url'=>$this->createUrl('/request/suggestEmployee'),
                                                        'dataType'=>'json',
                                                        'data' => "js: function(term,page) {
                                                                return {q: term};
                                                        }",
                                                        'results' => "js: function(data,page){
                                                                return {results: data};
                                                        }",
                                                ),
                                                'initSelection' => "",
                                        ),
                                            'events'=>array(     
                                                'change'=>"js:function (element) {
                                                    var id=element.val;                                                    
                                                    var s = id.split(',');                                                    
                                                    $('#hrisContract_idCard').val(s[0]);                                                     
                                                }"
                                            ),
                                            'htmlOptions'=>array(
                                                    'style'=>'width:400px;',
                                                'placeholder'=>'Nama karyawan..'
                                            ),
                                        ));                                    
                                }
                            echo $form->hiddenField($model, 'idCard');
                            ?>
                            
                            <?php echo $form->error($model, 'idCard'); ?>
                        </div>                               
                    </td>                        
                </tr>               
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
                <!--<tr>
                    <td>
                        <div class="simple">
                            <?php //echo $form->labelEx($model, 'endDate'); ?>
                            <?php //$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                //'model' => $model,
                                //'attribute' => 'endDate',
                                //'options' => array(
                                //    'showAnim' => 'fold',
                                //    'dateFormat' => 'yy-mm-dd', // save to db format
                                //    'altField' => '#self_pointing_id',
                                //    //'altFormat' => 'dd-mm-yy', // show to user format
                                //    'showOtherMonths' => true,      // show dates in other months
                                //    'selectOtherMonths' => true,    // can seelect dates in other months
                                //    'changeYear' => true,           // can change year
                                //    'changeMonth' => true,          // can change month
                                //    //'yearRange' => '2000:2099',     // range of year   
                                //),
                                //'htmlOptions' => array(
                                //    'style' => 'height:20px;'
                                //),
                            //));?>
                            <?php //echo $form->error($model, 'endDate'); ?>
                        </div>                               
                    </td>                        
                </tr> -->
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'period'); ?>
                            <?php echo $form->dropDownList($model,'period',array("3"=>"3 Bulan","6"=>"6 Bulan","12"=>"12 Bulan")); ; ?>
                            <?php echo $form->error($model, 'period'); ?>
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
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'contractReplacement'); ?>
                            <?php echo $form->textArea($model, 'contractReplacement', array('cols'=>38,'rows'=>5, 'placeholder' => 'Keterangan..', )); ?>
                            <?php echo $form->error($model, 'contractReplacement'); ?>
                        </div>                               
                    </td>
                </tr>       
            </table>
        </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Simpan Kontrak' : 'Simpan');                 ?>
            
	</div>

<?php $this->endWidget();        

?>

</div><!-- form -->