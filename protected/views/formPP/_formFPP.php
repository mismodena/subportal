<div class="form">
    
        
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'fpp-header-form',
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
    )); 

    Yii::app()->clientScript->registerScript('JQuery', "
        
        $( document ).ready(function() {
            update_amounts();            
        });
        
        $('.amount').blur('change', function() {            
            update_amounts();            
    	});                 
        
        $('.tabular-input-remove').live('click', function() {
            $(this).parent().parent().remove();
            update_amounts();            
    	});     
                
        function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
            num=String(num).replace(/,/gi,'')
            var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
        }
        
        function update_amounts()
        {
            var sum = 0;
            $('#tableFPP > tbody  > tr').each(function() {
            
                var amount = parseFloat($(this).find('.amount').val());
                var keperluan = $(this).find('.keperluan').val();  
                               
                if(!isNaN(amount) && keperluan !== '')
                {   
                    sum += amount;                       
                }
                
                
                $('#FppHeader_TOTAL').val(formatNumber(sum, 0,',','','','','-',''));                
                
            });
        }
        
    ", CClientScript::POS_END);

    ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="group">
            <?php echo Yii::t('ui', 'Pemohon'); ?>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fppNo'); ?>
                            <?php echo $form->textField($model, 'fppNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'fppNo'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fppUser'); ?>
                            <?php echo $form->hiddenField($model, 'fppUser'); ?>
                            <?php echo $form->textField($model, 'fppUserName', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Permohon', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'fppUser'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fppUserDept'); ?>
                            <?php echo $form->hiddenField($model, 'fppUserDept'); ?>
                            <?php echo $form->textField($model, 'fppUserDeptName', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Departemen', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'fppUserDept'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fppUserDate'); ?>
                            <?php echo $form->hiddenField($model, 'fppUserDate'); ?>
                            <?php echo $form->textField($model, 'fppUserDateLong', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Tanggal', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'fppUserDate'); ?>
                        </div>                               
                    </td>                        
                </tr>
            </table>
        </div>
        <div class="group">
            <?php echo Yii::t('ui', 'Penerima'); ?>
        </div>
        <div>            
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppToName'); ?>
                            <?php echo $form->textField($model,'fppToName',array('size'=>40,'maxlength'=>50,'placeholder' => 'Penerima')); ?>
                            <?php echo $form->error($model,'fppToName'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppToBank'); ?>
                            <?php echo $form->textField($model,'fppToBank',array('size'=>40,'maxlength'=>50,'placeholder' => 'Bank Penerima')); ?>
                            <?php echo $form->error($model,'fppToBank'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppToBankAcc'); ?>
                            <?php echo $form->textField($model,'fppToBankAcc',array('size'=>40,'maxlength'=>50,'placeholder' => 'No. Rekening')); ?>
                            <?php echo $form->error($model,'fppToBankAcc'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fppToDate'); ?>
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'name' => 'fppToDate',
                                'attribute' => 'fppToDate',
                                'options' => array(
                                    'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                                    'showOn' => 'button', // 'focus', 'button', 'both'
                                    'buttonText' => Yii::t('ui', 'Select form calendar'),
                                    'buttonImage' => XHtml::imageUrl('calendar.png'),
                                    'buttonImageOnly' => true,
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width:150px;vertical-align:top',
                                    'placeholder'=>'tanggal pembayaran..',
                                    'readOnly'=>'true',                                    
                                ),
                            ));
                            ?>

                            <?php echo $form->error($model, 'fppToDate'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fppCategory'); ?>
                            <?php echo $form->textField($model, 'fppCategoryDesc', array('size' => 40, 'maxlength' => 50, 'readonly'=>true));
                                echo $form->hiddenField($model, 'fppCategory', array('size' => 40, 'maxlength' => 50, 'readonly'=>true));                               
                            ?>
                            <?php echo $form->error($model, 'fppCategory'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php //echo CHtml::label('No. Penerimaan','No. Penerimaan'); ?>
                            <?php 
                                /* $this->widget('ext.widgets.select2.XSelect2', array(
                                    'model'=>$model,
                                    'attribute'=>'fppCategoryValue',
                                    'options'=>array(
                                        'minimumInputLength'=>4,
                                        'ajax' => array(
                                            'url'=>$this->createUrl('/request/suggestTT'),
                                            'dataType'=>'json',
                                            'data' => "js: function(term,page) {
                                                    return {q: term};
                                            }",
                                            'results' => "js: function(data,page){
                                                    return {results: data};
                                            }",
                                        ),                                            
                                ),                                            
                                    'htmlOptions'=>array(
                                            'style'=>'width:200px;',
                                        'placeholder'=>'-- Nomor TT  --'
                                    ),
                                ));  */                                                                  
                            ?>                            
                            <?php //echo $form->error($model, 'fppCategoryValue'); ?>
                        </div>                               
                    </td>                        
                </tr>

            </table>
        </div>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Keperluan'); ?>
        </div>
        
        <div>
        <?php 
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tableFPP',
                'models' => $model->items,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>
                                <th>Faktur</th>
                                <th>Keperluan</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularFPP',
                'inputUrl' => $this->createUrl('request/addTabFPP'),
                'addTemplate' => '<tbody><tr><td colspan="2">{link}</td></tr></tbody>',
                'addLabel' => Yii::t('ui', 'Tambah'),
                'addHtmlOptions' => array('class' => 'blue pill full-width'),
                'removeTemplate' => '<td>{link}</td>',
                'removeLabel' => Yii::t('ui', 'Hapus'),
                /*'removeHtmlOptions' => array('class' => 'red pill'),*/
            ));
        ?>
        </div>
        <br/>
        
        <table width="90%" border="0"> 
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model,'TOTAL'); ?>                                                                                
                        <?php echo $form->textField($model,'TOTAL',array('size'=>40,'maxlength'=>50,'placeholder' => 'Total','readonly' => true)); ?>
                        <?php echo $form->error($model,'TOTAL'); ?>
                    </div>                               
                </td>                        
            </tr>
        </table>        
        
	<div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Buat FPP' : 'Simpan');                 ?>            
	</div>

<?php $this->endWidget(); 


?>

</div><!-- form -->