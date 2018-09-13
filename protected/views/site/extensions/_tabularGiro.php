<tr>
    <td valign="top">
        <?php echo CHtml::activeHiddenField($model, "[$index]retType", array('size' => 20, 'readOnly'=>true)); ?>  
        <?php
        echo CHtml::activeCheckbox($model, "[$index]check", array());
        ?>                   
    </td>
    <td valign="top">
        <?php echo CHtml::activeTextField($model, "[$index]docNumber", array('size' => 10, 'readOnly' => 'readOnly', "visible" => "[$index]invNumber == '' ? false : true")); ?>        
    </td>
    <td valign="top">
        <?php
        echo CHtml::activeTextField($model, "[$index]invDate", array('size' => 10, 'readOnly' => 'readOnly'));

        ?>        
    </td>       

    <td valign="top">
        <?php echo CHtml::activeTextArea($model, "[$index]customer", array('rows' => 4, 'cols' => 25, 'readOnly' => 'readOnly')); ?>        
    </td>
    <td valign="top">
        <?php echo CHtml::activeTextField($model, "[$index]invTotal", array('size' => 17, 'readOnly' => 'readOnly')); ?>        
    </td>
    <td>
        <?php echo CHtml::activeTextArea($model, "[$index]revNumber", array('rows' => 4, 'cols'=>25, 'readOnly' => 'readOnly')); ?>        
    </td>
    <td>
        <?php echo CHtml::activeTextArea($model, "[$index]revDesc", array('rows' => 4, 'cols'=>30)); ?>        
    </td>
<tr>    