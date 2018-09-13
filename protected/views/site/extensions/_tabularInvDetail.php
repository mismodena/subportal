<td>
   <?php echo CHtml::activeTextField($model, "[$index]docNumber", array('size' => 20, 'readOnly'=>true)); ?>    
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]customer", array('size' => 60, 'readOnly'=>true)); ?>    
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]unDate", array('size' => 20, 'readOnly'=>true)); ?>
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]unAmount", array('size' => 20, 'class'=>'amount', "style"=>"text-align:right", 'readOnly'=>true)); ?>  
</td>