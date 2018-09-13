<tr>
    <td>
        <?php
        // if($model['invNumber'] != "" ){
        echo CHtml::activeCheckbox($model, "[$index]check", array());
//            } else {
//                echo CHtml::activeCheckbox($model, "[$index]check", array("disabled" => "disabled"));
//            }
        ?>                   
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, "[$index]docNumber", array('size' => 10, 'readOnly' => 'readOnly', "visible" => "[$index]invNumber == '' ? false : true")); ?>        
    </td>
    <td>
        <?php
        echo CHtml::activeTextField($model, "[$index]invDate", array('size' => 10, 'readOnly' => 'readOnly'));

//            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                'model' => $model,
//                'attribute' => "[$index]invDate",
//                'options' => array(
//                    'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
//                    'showOn' => 'button', // 'focus', 'button', 'both'
//                    'buttonText' => Yii::t('ui', 'Select form calendar'),
//                    'buttonImage' => XHtml::imageUrl('calendar.png'),
//                    'buttonImageOnly' => true,
//                ),
//                'htmlOptions' => array(
//                    'style' => 'width:150px;vertical-align:top',
//                    'readOnly' => 'true',
//                    'class' => 'datepicker'
//                ),
//            ));
        ?>        
    </td>
    
        <td>
        <?php
//        echo CHtml::activeTextField($model, "[$index]invDate", array('size' => 10, 'readOnly' => 'readOnly'));

            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => "[$index]fromDate",
                'options' => array(
                    'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                    'showOn' => 'button', // 'focus', 'button', 'both'
                    'buttonText' => Yii::t('ui', 'Select form calendar'),
                    'buttonImage' => XHtml::imageUrl('calendar.png'),
                    'buttonImageOnly' => true,
                ),
                'htmlOptions' => array(
                    'style' => 'width:150px;vertical-align:top',
                    'readOnly' => 'true',
                    'class' => 'datepicker'
                ),
            ));
        ?>        
    </td>

    <td>
        <?php echo CHtml::activeTextField($model, "[$index]customer", array('size' => 35, 'readOnly' => 'readOnly')); ?>        
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, "[$index]invTotal", array('size' => 25, 'readOnly' => 'readOnly')); ?>        
    </td>
<tr>    