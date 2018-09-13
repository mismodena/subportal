
    <td>
            <?php echo CHtml::activeTextField($model,"[$index]itemModel",array('size'=>20,'class'=>'model')); ?>            
            <?php echo CHtml::error($model,"[$index]itemModel"); ?>
    </td>
    <td>
            <?php echo CHtml::activeTextField($model,"[$index]itemDesc",array('size'=>40,)); ?>            
            <?php echo CHtml::error($model,"[$index]itemDesc"); ?>
    </td>
    <td>
            <?php echo CHtml::activeTextField($model,"[$index]unitPrice",array('size'=>20,'class'=>'price', 'onchange'=>'js:update_amounts();')); ?>            
            <?php echo CHtml::error($model,"[$index]unitPrice"); ?>
    </td>
    <td>
            <?php echo CHtml::activeTextField($model,"[$index]unitQty",array('size'=>20,'class'=>'qty', 'onchange'=>'js:update_amounts();')); ?>            
            <?php echo CHtml::error($model,"[$index]unitQty"); ?>
    </td>
    <td>
            <?php echo CHtml::activeTextField($model,"[$index]total",array('size'=>20,'class'=>'amount', 'readOnly'=>true)); ?>            
            <?php echo CHtml::error($model,"[$index]total"); ?>
    </td>      
