
<td>
    <?php echo CHtml::activeHiddenField($model, "[$index]detID", array('size' => 20, 'readOnly'=>true)); ?>  
    <?php echo CHtml::activeTextArea($model, "[$index]customer", array('cols' => 20, 'rows' => 5, 'readOnly'=>true)); ?>
</td>
<td valign="top">
    <?php
        $this->widget('ext.widgets.select2.XSelect2', array(
            'model' => $model,
            'attribute' => "[$index]retType",
            'data'=>  array("TT" => "TTTFP", "TR" => "Transfer", "GR" => "Giro", "CK" => "Cek", "FL" => "Gagal Tertagih"),
            'htmlOptions'=>array(
                    'style' => 'width:100px;vertical-align:top',
                    'empty'=>'',
                    'placeholder'=>'Status'
            ),
        ));
    ?>       
</td>
<td valign="top">
    <?php 
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => "[$index]retDate",
            'options' => array(
                'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                'showOn' => 'button', // 'focus', 'button', 'both'
                'buttonText' => Yii::t('ui', 'Select form calendar'),
                'buttonImage' => XHtml::imageUrl('calendar.png'),
                'buttonImageOnly' => true,
            ),
            'htmlOptions' => array(
                'style' => 'width:100px;vertical-align:top',
                'readOnly' => 'true',
                'class' => 'datepicker',
                 'placeholder'=>'Tanggal'
            ),
        ));
    ?>
</td>
<td valign="top">
     <?php echo CHtml::activeTextField($model, "[$index]retNumber", array('size' => 20, 'placeholder'=>' Giro/TTTFP/Cek')); ?>
</td> 
<td valign="top">
     <?php echo CHtml::activeTextArea($model, "[$index]retDesc", array('cols' => 30, 'rows' => 4, 'placeholder'=>'Keterangan')); ?>
</td> 
<td valign="top">
    <?php echo CHtml::activeTextField($model, "[$index]fmtAmount", array('size' => 12, "style"=>"text-align: right", 'readOnly'=>true,  'placeholder'=>'Nilai')); ?>
</td>
<td valign="top">
    <?php echo CHtml::activeTextField($model, "[$index]retValue", array('size' => 12, "style"=>"text-align: right", "class" => "amount",  'placeholder'=>'Tertagih')); ?>
</td> 

