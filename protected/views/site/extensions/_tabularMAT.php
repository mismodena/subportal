    <td>
        <div class="simple">              
             <?php
                $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>"[$index]assetID",
                    'data'=>  Utility::getAsset(),
                    'htmlOptions'=>array(
                            'style'=>'width:400px',
                            'empty'=>'',
                            'placeholder'=>'-- Asset --',
                            //'class'=>'model',
                    ),
                ));
            ?>
            <?php echo CHtml::error($model, "[$index]mutationNo"); ?>
        </div>                               
    </td> 
        
    <td>
        <?php echo CHtml::activeTextArea($model,"[$index]mutationDesc",array('rows'=>3, 'cols'=>60,'class'=>'Asset', )); ?>            
        <?php echo CHtml::error($model,"[$index]mutationDesc"); ?>
    </td>
     

   