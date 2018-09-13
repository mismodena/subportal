<tr>
    <td>
        <?php echo CHtml::activeHiddenField($model, "[$index]docID"); ?>
        <?php echo CHtml::activeCheckbox($model,"[$index]docValue"); ?> <?php echo $model->docName?>                    
    </td>
<tr>    