   <td>
        <div class="simple">              
             <?php
                $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>"[$index]apInvNo",
                    'data'=>  Utility::getPenagihan(),
                    'htmlOptions'=>array(
                            'style'=>'width:400px',
                            'empty'=>'',
                            'placeholder'=>'-- No Penagihan --',
                            //'class'=>'model',
                    ),
                ));
            ?>
            <?php echo CHtml::error($model, "[$index]apInvNo"); ?>
        </div>                               
    </td> 
        
    