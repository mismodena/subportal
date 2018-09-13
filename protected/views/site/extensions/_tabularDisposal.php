
    <td>
        <div class="simple">            
            <?php
                //echo var_dump($model->isNewRecord);
                //echo $model->assetID . "<br />\n";
                if($model->assetID)
                {
                    $html_options = array(
                         'style'=>'width:300px',
                         'empty'=>'',
                         'placeholder'=>'-- Asset --',
                         'class'=>'model',
                         'readonly'=>'readonly'
                     );
                } 
                else {
                    $html_options = array(
                         'style'=>'width:300px',
                         'empty'=>'',
                         'placeholder'=>'-- Asset --',
                         'class'=>'model'
                     );
                }
                 $this->widget('ext.widgets.select2.XSelect2', array(
                     'model'=>$model,
                     'attribute'=>"[$index]assetID",
                     'data'=>  Utility::getAsset(),
                     'htmlOptions'=> $html_options
                 ));
                 
            ?>
            <?php echo CHtml::error($model, "[$index]disposalNo"); ?>
            <?php 
            if($model->assetID){
            ?>
            <script type="text/javascript">
            function loadAjax(id_select){
                //console.log(id_select);
                if(document.getElementById(id_select)){
                    console.log(document.getElementById(id_select));
                    console.log(jQuery("#" + id_select).val());
                    //console.log("Test Select" + countUpdate);
                    jQuery.ajax({
                        'type':'POST',
                        'url':'/dev/fpp/index.php/en/Asset/getassetdept',
                        'data':"kodeAsset="+jQuery("#" + id_select).val(),
                        'success':function(data){
                            //console.log("Test Select Complete" + countUpdate);
                            console.log(data);
                            var DisposalDetail_0_assetID = document.getElementById('DisposalDetail_'+ countUpdate +'_assetID');
                            DisposalDetail_0_assetID.innerHTML = data;
                            // DisposalDetail_0_assetID.removeAttribute("disabled");
                            console.log(DisposalDetail_0_assetID);
                            $('#DisposalDetail_'+ countUpdate +'_assetID').val('<?php echo $model->assetID; ?>')
                            $('#DisposalDetail_'+ countUpdate +'_assetID').select2();
                            countUpdate++;  
                        }
                    });
                                      
                }
            }
            loadAjax("Disposal_fromDept");
            </script>
            <?php 
            }
            ?>
        </div>
    </td>
    <td>
        <?php 
        if($model->assetID)
        {
            $text = array('size'=>5,'class'=>'Asset','readonly'=> 'readonly', 'onchange'=>'js:update_amounts();', 'style'=>'display : none');
            $text_area = array('rows'=>3,'readonly'=> 'readonly', 'cols'=>58,'class'=>'Asset' );
            $nilaiasset= array('cols'=>30,'class'=>'Asset' );
        } else {
            $text = array('size'=>5,'class'=>'Asset', 'style'=>'display : none');
            $text_area = array('rows'=>3,'cols'=>58,'class'=>'Asset' );
             $nilaiasset= array('cols'=>30,'readonly'=> 'readonly','class'=>'Asset' );
        }
        ?>
        <?php echo CHtml::activeTextArea($model,"[$index]disposalDesc",$text_area); ?>            
        <?php echo CHtml::error($model,"[$index]disposalDesc"); ?>
    </td>
     <td>
        
        <?php echo CHtml::activeTextArea($model,"[$index]nilaiasset", $nilaiasset); ?>            
        <?php echo CHtml::error($model,"[$index]nilaiasset"); ?>
    </td>
    <td> 
        <?php echo CHtml::activeTextField($model,"[$index]qty",$text); ?>            
        <?php echo CHtml::error($model,"[$index]qty"); ?>
    </td>
    
