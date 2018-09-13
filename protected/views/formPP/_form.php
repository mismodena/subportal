<div class="form">
    
        
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'fpp-header-form',
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
    )); ?>

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
                                /*if ($model->isNewRecord){
                                    $this->widget('ext.widgets.select2.XSelect2', array(
                                        'model'=>$model,
                                        'attribute'=>'fppCategory',
                                        'options'=>array(
                                                'minimumInputLength'=>2,
                                                'ajax' => array(
                                                        'url'=>$this->createUrl('/request/suggestCategory'),
                                                        'dataType'=>'json',
                                                        'data' => "js: function(term,page) {
                                                                return {q: term};
                                                        }",
                                                        'results' => "js: function(data,page){
                                                                return {results: data};
                                                        }",
                                                ),
                                                'initSelection' => "js:function (element, callback) {
                                                        var id=$(element).val();
                                                        if (id!=='') {
                                                                $.ajax('".$this->createUrl('/request/initCategory')."', {
                                                                        dataType: 'json',
                                                                        data: {
                                                                                id: id
                                                                        }
                                                                }).done(function(data) {callback(data);});
                                                        }
                                                }",
                                        ),                                        
                                            'htmlOptions'=>array(
                                                    'style'=>'width:200px;',
                                                'placeholder'=>'Kategori FPP ..'
                                            ),
                                        ));
                                }else{
                                    echo $form->textField($model, 'fppCategory', array('size' => 40, 'maxlength' => 50, 'readonly'=>true));
                                }
                                 
                                */
                            ?>
                            <?php echo $form->error($model, 'fppCategory'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fppCategoryValue'); ?>
                            <?php 
                                if ($model->isNewRecord){
                                    $this->widget('ext.widgets.select2.XSelect2', array(
                                        'model'=>$model,
                                        'attribute'=>'fppCategoryValueDesc',
                                        'options'=>array(
                                                'minimumInputLength'=>2,
                                                'ajax' => array(
                                                        'url'=>$this->createUrl('/request/suggestBatchKK'),
                                                        'dataType'=>'json',
                                                        'data' => "js: function(term,page) {
                                                                return {q: term};
                                                        }",
                                                        'results' => "js: function(data,page){
                                                                return {results: data};
                                                        }",
                                                ),
                                                'initSelection' => "js:function (element, callback) {
                                                        var id=$(element).val();
                                                        if (id!=='') {
                                                                $.ajax('".$this->createUrl('/request/initBatchKK')."', {
                                                                        dataType: 'json',
                                                                        data: {
                                                                                id: id
                                                                        }
                                                                }).done(function(data) {callback(data);});
                                                        }
                                                }",
                                        ),
                                            'events'=>array(
                                                'change'=>"js:function (element) {
                                                    var id=element.val;                                                    
                                                    var s = id.split(',');
                                                    var kategori = $('#FppHeader_fppCategory').val(); 
                                                    $('#FppHeader_fppCategoryValue').val(s[0]); 
                                                    if (id!='') {
                                                        $.ajax('".$this->createUrl('/request/batchkklist')."', {
                                                            data: {
                                                                    id: s[0],                        
                                                                    kategori: kategori,
                                                            }
                                                        }).done(function(data) {
                                                            try{
                                                            var s;
                                                            if(data!==''){
                                                                s = '<table widht=\"80%\"><thead><tr><th>No.</th><th>Keperluan</th><th>Jumlah</th></tr></thead><tbody>';
                                                                s = s + data + '</tbody></table>' ;                                                                
                                                            }else{
                                                                s = 'Batch tidak ditemukan..!!<br>';
                                                            }
                                                            $('#name-list').html(String(s).replace(/\\\"/gi, '\"'));
                                                            hitungTotal();
                                                            }catch(e){alert(e);}                                                            
                                                        });
                                                    }
                                                }"
                                            ),
                                            'htmlOptions'=>array(
                                                    'style'=>'width:200px;',
                                                'placeholder'=>'Nomor Batch..'
                                            ),
                                        ));
                                    echo $form->hiddenField($model, 'fppCategoryValue');
                                }else{
                                    echo $form->textField($model, 'fppCategoryValue', array('size' => 40, 'maxlength' => 50, 'readonly'=>true));
                                }
                            ?>
                            <?php echo $form->error($model, 'fppCategoryValue'); ?>
                        </div>                               
                    </td>                        
                </tr>

            </table>
        </div>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Keperluan'); ?>
        </div>
        
        <div id="ajaxresponse">
            
        </div>
        
        <div id="name-list" style="margin-top: 10px;"></div>	   
        
        <div style="display: none " id="containerTotal">
            <table width="90%" border="0"> 
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppLimit'); ?>                                                        
                            <?php echo $form->hiddenField($model,'fppLimit',array('size'=>40,'maxlength'=>50,'placeholder' => 'Limit Credit','readonly' => true)); ?>
                            <?php echo $form->textField($model,'limit',array('size'=>40,'maxlength'=>50,'placeholder' => 'Limit Credit','readonly' => true)); ?>
                            <?php echo $form->error($model,'fppLimit'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppTotal'); ?>
                            <?php echo $form->hiddenField($model,'fppTotal'); ?>
                            <?php echo $form->textField($model,'TOTAL',array('size'=>40,'maxlength'=>50,'placeholder' => 'Total','readonly' => true)); ?>
                            <?php echo $form->error($model,'fppTotal'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppSaldo'); ?>
                            <?php echo $form->textField($model,'fppSaldo',array('size'=>40,'maxlength'=>50,'placeholder' => 'Saldo')); ?>
                            <?php echo $form->error($model,'fppSaldo'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppCash'); ?>
                            <?php echo $form->textField($model,'fppCash',array('size'=>40,'maxlength'=>50,'placeholder' => 'Saldo Fisik')); ?>
                            <?php echo $form->error($model,'fppCash'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model,'fppOutstanding'); ?>
                            <?php echo $form->textField($model,'fppOutstanding',array('size'=>40,'maxlength'=>50,'placeholder' => 'Bon Gantung')); ?>
                            <?php echo $form->error($model,'fppOutstanding'); ?>
                        </div>                               
                    </td>                        
                </tr>
            </table>
        </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Buat FPP' : 'Simpan');                 ?>
            
	</div>

<?php $this->endWidget(); 
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScript('JQuery', "
            function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
                num=String(num).replace(/,/gi,'')
                var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
                }

            function hitungTotal(){
                var total;
                total = 0;
                $('.hitung').each(function () {                    
                    val = parseFloat($(this).val()) | 0;
                    total = val ? (parseFloat(total + val)) : total;
                });
                $('#FppHeader_TOTAL').val(formatNumber(Math.abs(total), 0,',','','','','-',''));
                $('#FppHeader_fppTotal').val(Math.abs(total));
                $('#containerTotal').attr('style','display:block')
            }
        ", CClientScript::POS_END);

?>

</div><!-- form -->