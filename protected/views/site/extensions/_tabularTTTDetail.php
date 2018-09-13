<td>
    <?php
    $this->widget('ext.widgets.select2.XSelect2', array(
        'model' => $model,
        'attribute' => "[$index]docNumber",
        'data' => Utility::getInvSalesTT(),
        'htmlOptions' => array(
            'style' => 'width:200px',
            'empty' => '',
            'placeholder' => '-- Faktur --',
            'onchange'=>"setColumn(this.value,this)",
        ),
    ));
        ?>
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]customer", array('size' => 60, 'readOnly'=>true)); ?>
    <?php echo CHtml::error($model, "[$index]customer"); ?>
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]invDate", array('size' => 20, 'readOnly'=>true)); ?>
    <?php echo CHtml::error($model, "[$index]invDate"); ?>
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]invTotal", array('size' => 20, "style"=>"text-align:right", 'class'=>'amount', 'readOnly'=>true)); ?>
    <?php echo CHtml::error($model, "[$index]invTotal"); ?>
</td>