<tr>
    <td style=" text-align: center">
            <?php echo $index + 1; ?>
    </td>
    <td>
            <?php echo CHtml::activeTextField($model,"[$index]fppDesc",array('size'=>90, 'readonly'=>true)); ?>            
            <?php echo CHtml::error($model,"[$index]fppDesc"); ?>
    </td>
    <td>
            <?php echo CHtml::activeTextField($model,"[$index]formatedAmount",array('size'=>30, 'readonly'=>true, 'style'=>'text-align: right')); ?>
            <?php echo CHtml::activeHiddenField($model,"[$index]fppDetailValue", array( 'class'=>'hitung')); ?>
            <?php echo CHtml::error($model,"[$index]fppDetailValue"); ?>
    </td>
  
</tr>