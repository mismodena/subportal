<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'master-open-form',
        'enableAjaxValidation' => true,
    ));

    Yii::app()->clientScript->registerScript('JQuery', "        

        $( document ).ready(function() {
            calcTotal();
        });
        
        $('#BQOpen_idCust').change(function() { 
            var dealerID = this.value;
            
            var url = '" . Yii::app()->createUrl('/bq/getLastQ') . "';
            $.get(url, { dealerID: dealerID} )
                .done(function(data) {
                    var json = JSON.parse(data)  
                    console.log(json[0]);
                    $('#lastQ').text(formatNumber(parseInt(json[0]), 0,',','','','','-',''));
                });

        });

        $('#BQOpen_salesTarget').live('change', function() {            
            var value = this.value.replace(/,/g, '');
            var url = '" . Yii::app()->createUrl('/bq/getMaxValue') . "';
            $.get(url, { value: value } )
                .done(function(data) {
                    $('#maxValue').text(formatNumber(data, 0,',','','','','-',''));
                    $('#BQOpen_salesTarget').val(formatNumber(value, 0,',','','','','-',''));
                });
           calcTotal();
    	});  
        
        $('#BQOpen_salesTarget').live('change', function() {            
            var value = this.value.replace(/,/g, '');
            var url = '" . Yii::app()->createUrl('/bq/getMaxValue') . "';
            $.get(url, { value: value } )
                .done(function(data) {
                    $('#maxValue').text(formatNumber(data, 0,',','','','','-',''));
                    $('#BQOpen_salesTarget').val(formatNumber(value, 0,',','','','','-',''));
                });
           calcTotal();
    	}); 
        
        $('#BQOpen_openTarget').live('change', function() {            
            var value = parseInt(this.value.replace(/,/g, ''));
            var maxValue = parseInt($('#maxValue').text().replace(/,/g, ''));
            if(value > maxValue){
                value = maxValue
            }
            $('#BQOpen_openTarget').val(formatNumber(value, 0,',','','','','-',''));
            calcTotal();
    	}); 
        
        $('#BQOpen_openBonus').live('change', function() {            
            var value = parseInt(this.value.replace(/,/g, ''));            
            $('#BQOpen_openBonus').val(formatNumber(value, 0,',','','','','-',''));
            calcTotal();
    	}); 
        
        function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
            num=String(num).replace(/,/gi,'')
            var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
        };
        
        function calcTotal()
        {
            var openTQ = $('#BQOpen_openTarget').val().replace(/,/g, '');
            var bonusTQ = $('#BQOpen_openBonus').val().replace(/,/g, '');
            var total = 0;
            
            total = parseInt(openTQ) + parseInt(bonusTQ);
           
            $('#BQOpen_total').val(formatNumber(total, 0,',','','','','-',''));    
             
        }
        
        function execForm()
        { 
            var total = parseInt($('#BQOpen_total').val().replace(/,/g, ''));
            
            if(total == 0){
                alert('Open TQ tidak boleh 0');
            }else {
                document.getElementById('master-open-form').submit();
            }        
        }

    ", CClientScript::POS_END);
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php
        $branch = Yii::app()->user->getState('branch');
        echo $form->errorSummary($model); ?>

    <div class="group">    
        <?php
        if ($model->isNewRecord) {
            echo Yii::t('ui', 'New Open TQ');
        } else {
            echo Yii::t('ui', 'Update Open TQ');
        }
        ?>
    </div>
    <div>
        <div class="simple">
            <?php echo $form->labelEx($model, 'fiscalPeriod'); ?>
            <?php echo $form->textField($model, 'fiscalPeriod', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Fiscal Period --', 'readOnly' => "readOnly")); ?>
            <?php echo $form->error($model, 'fiscalPeriod'); ?>
        </div> 
        <div class="simple">
            <?php echo $form->labelEx($model, 'idCust'); ?>
            <?php
            $this->widget('ext.widgets.select2.XSelect2', array(
                'model' => $model,
                'attribute' => 'idCust',
                'data' => Utility::getDealerBQTQ($branch),
                'htmlOptions' => array(
                    'style' => 'width:295px',
                    'empty' => '',
                    'placeholder' => '-- Customer Group Code --'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'idCust'); ?>
        </div>       
        <div class="simple">
            <?php echo $form->labelEx($model, 'salesTarget'); ?>
            <?php echo $form->textField($model, 'salesTarget', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Sales Target --', 'style' => 'text-align: right')); ?>  &nbsp; penjualan tahun sebelumnya: <span id="lastQ"></span>
            <?php echo $form->error($model, 'salesTarget'); ?>
        </div> 
        <div class="simple">
            <?php echo $form->labelEx($model, 'openTarget'); ?>
            <?php
            echo $form->textField($model, 'openTarget', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Open TQ --', 'style' => 'text-align: right'));?> &nbsp; nilai maksimum: <span id="maxValue"></span>
            <?php echo $form->error($model, 'openTarget'); ?>
        </div> 
        <div class="simple">
            <?php echo $form->labelEx($model, 'openBonus'); ?>
            <?php
            echo $form->textField($model, 'openBonus', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Bonus TQ --', 'style' => 'text-align: right'));?> 
            <?php echo $form->error($model, 'openBonus'); ?>
        </div> 
        <div class="simple">
            <?php echo $form->labelEx($model, 'total'); ?>
            <?php echo $form->textField($model, 'total', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Total --', 'style' => 'text-align: right', 'readOnly'=>'readOnly'));?> 
            <?php echo $form->error($model, 'total'); ?>
        </div> 
    </div>

    <div class="row buttons">
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Save!' : 'Simpan', array('class' => 'btn btn-sm')); ?>
        <?php echo CHtml::link('Simpan', "javascript:execForm();", array('confirm'=>'Submit pengajuan?', 'class' => 'btn btn-sm', ));  ?>  
    </div>

<?php $this->endWidget();
?>

</div><!-- form -->