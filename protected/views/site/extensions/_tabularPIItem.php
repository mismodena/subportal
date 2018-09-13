    <td>
        <div class="simple">            
            <?php
                $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>"[$index]itemModel",
                    'data'=>  Utility::getItem(),
                    'htmlOptions'=>array(
                            'style'=>'width:400px',
                            'empty'=>'',
                            'placeholder'=>'-- Item --',
                            'class'=>'model',
                    ),
                ));
            ?>
            <?php echo CHtml::error($model, "[$index]fppInvNo"); ?>
        </div>
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
