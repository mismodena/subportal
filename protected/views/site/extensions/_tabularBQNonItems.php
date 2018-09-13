
<td valign="top">       
    <?php echo CHtml::activeTextArea($model, "[$index]nonItemDesc", array('cols' => 60, 'rows' => 4,'class'=>'itemDesc', "style=")); ?>
</td>
<td valign="top">
    <?php echo CHtml::activeTextField($model, "[$index]nonItemValue", array('size' => 20, 'class'=>'itemValue',  'style' => 'text-align: right')); ?>        
</td>
<td valign="top">
    <?php echo CHtml::activeTextField($model, "[$index]nonItemTotal", array('size' => 25, 'class'=>'itemTotal',  'style' => 'text-align: right', 'readOnly'=>'readOnly')); ?>        
</td>

