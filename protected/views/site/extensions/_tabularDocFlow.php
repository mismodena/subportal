<tr>
    <td>
        <?php
            echo CHtml::activeHiddenField($model, "[$index]docID");
        if ($model['invNumber'] != "") {
            echo CHtml::activeCheckbox($model, "[$index]check", array());
        } else {
            echo CHtml::activeCheckbox($model, "[$index]check", array("disabled" => "disabled"));
        }
        ?>                   
    </td>
    <td>
        <?php
        if ($model['invNumber'] != "") {
            echo CHtml::activeCheckbox($model, "[$index]rcvNote", array());
        } else {
            echo CHtml::activeCheckbox($model, "[$index]rcvNote", array("disabled" => "disabled"));
        }
        ?>                 
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, "[$index]invNumber", array('size' => 13, 'readOnly' => 'readOnly', "visible" => "[$index]invNumber == '' ? false : true")); ?>        
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, "[$index]invDate", array('size' => 10, 'readOnly' => 'readOnly')); ?>        
    </td>

    <td>
        <?php echo CHtml::activeTextField($model, "[$index]customer", array('size' => 35, 'readOnly' => 'readOnly')); ?>        
    </td>

    <td>
        <?php echo CHtml::activeTextField($model, "[$index]itemName", array('size' => 40, 'readOnly' => 'readOnly')); ?>        
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, "[$index]qtyShipment", array('size' => 3, 'readOnly' => 'readOnly')); ?>        
    </td>
    <td>
        <?php
        if ($model['invNumber'] != "") {
           echo CHtml::activeTextField($model, "[$index]adds", array('size' => 23)); 
        } else {
            echo CHtml::activeTextField($model, "[$index]adds", array('size' => 23, 'readOnly' => 'readOnly')); 
        }
        ?>                 
    </td>
<tr>    