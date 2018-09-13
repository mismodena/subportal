<td>
    <?php
    $this->widget('ext.widgets.select2.XSelect2', array(
        'model' => $model,
        'attribute' => "[$index]itemNo",
        'data' => Utility::getProducts(),
        'htmlOptions' => array(
            'style' => 'width:375px',
            'empty' => '',
            'placeholder' => '-- Barang --',
            //'onchange'=>"setColumn(this.value,this)",
        ),
    ));
        ?>
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]itemPrice", array('size' => 25,  "style"=>"text-align:right", 'class'=>'qty')); ?>
    <?php echo CHtml::error($model, "[$index]itemPrice"); ?>
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]itemQty", array('size' => 15,  "style"=>"text-align:right", 'class'=>'price', 'readOnly'=>true)); ?>
    <?php echo CHtml::error($model, "[$index]itemQty"); ?>
</td>
<td>
    <?php echo CHtml::activeTextField($model, "[$index]itemTotal", array('size' => 30, "style"=>"text-align:right", 'class'=>'amount', 'readOnly'=>true)); ?>
    <?php echo CHtml::error($model, "[$index]invTotal"); ?>
</td>