
<td valign="top">
    <?php echo CHtml::activeHiddenField($model, "[$index]detID", array('size' => 20, 'readOnly'=>true)); ?>  
    <?php echo CHtml::activeTextArea($model, "[$index]customer", array('cols' => 30, 'rows' => 4, 'readOnly'=>true)); ?>
</td>
<td valign="top">
    <?php echo CHtml::activeTextArea($model, "[$index]customer2", array('cols' => 30, 'rows' => 4, 'readOnly'=>true)); ?>
</td>
<td valign="top">
    <?php echo CHtml::activeTextField($model, "[$index]fmtAmount", array('size' => 12, "style"=>"text-align: right", 'readOnly'=>true)); ?>
</td>
<td valign="top">
    <?php echo CHtml::activeTextField($model, "[$index]fmt2Amount", array('size' => 12, "style"=>"text-align: right", 'readOnly'=>true,)); ?>
</td> 
<td valign="top">
    <?php 
//    if ($model['retValue'] == 0) {
//            echo CHtml::activeTextField($model, "[$index]revValue", array('size' => 12, "style"=>"text-align: right", "readOnly"=> true , "class" => "amount"));
//        } else {
            echo CHtml::activeTextField($model, "[$index]revValue", array('size' => 12, "style"=>"text-align: right", "class" => "amount"));
//        }	
         ?>
</td> 
<td valign="top">
     <?php echo CHtml::activeTextField($model, "[$index]retNumber", array('size' => 20, 'placeholder'=>'Giro/TTTFP/Cek')); ?>    
     <?php echo CHtml::activeTextArea($model, "[$index]finance", array('cols' => 30, 'rows' => 4, 'placeholder'=>'Keterangan')); ?>
</td> 
