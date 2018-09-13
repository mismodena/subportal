    <td td style='vertical-align:top'>
        <div class="simple">            
            <?php
                $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>"[$index]fppInvNo",
                    'data'=>  Utility::getAPInv(),
                    'htmlOptions'=>array(
                            'style'=>'width:200px',
                            'empty'=>'',
                            'placeholder'=>'-- faktur --',
                          //  'class'=>'oncom',
                    ),
                ));
            ?>
            <?php echo CHtml::error($model, "[$index]fppInvNo"); ?>
        </div>                               
    </td>                                
    <td>
            <?php echo CHtml::activeTextArea($model,"[$index]fppDesc",array('rows'=>3, 'cols'=>60,'class'=>'keperluan', )); ?>            
            <?php echo CHtml::error($model,"[$index]fppDesc"); ?>
    </td>
    <td style='vertical-align:top'>
            <?php echo CHtml::activeTextField($model,"[$index]fppDetailValue",array('size'=>20,'class'=>'amount', 'onchange'=>'js:update_amounts();')); ?>            
            <?php echo CHtml::error($model,"[$index]fppDetailValue"); ?>
    </td> 