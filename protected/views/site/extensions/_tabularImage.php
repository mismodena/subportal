    <td>
            <?php echo CHtml::activeFileField($model,"[$index]filePath",array('size'=>8, 'class'=>'price', 'onchange'=>'js:update_amounts();')); ?>            
            <?php echo CHtml::error($model,"[$index]filePath"); ?>
    </td>
    
