<tr>
    <td>
        <?php echo CHtml::activeHiddenField($model,"[$index]tradCode",array('size'=>10, 'readOnly'=>'readOnly')); ?>        
        <?php echo CHtml::activeTextField($model,"[$index]tradDesc",array('size'=>30, 'readOnly'=>'readOnly')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,"[$index]value",array('size'=>15)); ?>        
    </td>
</tr>
