
<td valign="top">
    <?php echo CHtml::activeTextField($model,"[$index]apInvNo",array('size'=>25,'class'=>'invoice', 'onchange'=>'js:kirim_data();', )); ?>            
    <?php echo CHtml::error($model,"[$index]apInvNo"); ?>
</td>
<td valign="top">    
    <?php 
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,            
            'attribute' => "[$index]apInvDate",
            'options' => array(
                'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                'showOn' => 'button', // 'focus', 'button', 'both'
                'buttonText' => Yii::t('ui', 'Select form calendar'),
                'buttonImage' => XHtml::imageUrl('calendar.png'),
                'buttonImageOnly' => true,
            ),
            'htmlOptions' => array(
                'style' => 'width:150px;vertical-align:top',                
                'readOnly'=>'true',
                'class'=>'datepicker'
                
            ),
        )); 
    ?>
    
    <?php echo CHtml::error($model, "[$index]apInvDate"); ?>                                  
</td> 
<!-- <td valign="top">    
    <?php
        /* $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,            
            'attribute' => "[$index]apDueDate",
            'options' => array(
                'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                'showOn' => 'button', // 'focus', 'button', 'both'
                'buttonText' => Yii::t('ui', 'Select form calendar'),
                'buttonImage' => XHtml::imageUrl('calendar.png'),
                'buttonImageOnly' => true,
            ),
            'htmlOptions' => array(
                'style' => 'width:150px;vertical-align:top',                
                'readOnly'=>'true',
                'class'=>'datepicker'
                
            ),
        )); 
    ?>
    
    <?php echo CHtml::error($model, "[$index]apDueDate");*/ ?>                                  
</td> --> 
<td valign="top">
    <div class="simple">              
         <?php
           /* $this->widget('ext.widgets.select2.XSelect2', array(
                'model'=>$model,
                'attribute'=>"[$index]poNo",
                'data'=>  Utility::getNoPo(),
                'htmlOptions'=>array(
                        'style'=>'width:300px',
                        'empty'=>'',
                        'placeholder'=>'-- No PO --',
                        //'class'=>'model',
                ),
            ));*/
            $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>"[$index]poNo",
                    'options'=>array(
                        'minimumInputLength'=>4,
                        'ajax' => array(
                            'url'=>$this->createUrl('/request/getNoPo'),
                            'dataType'=>'json',
                            'data' => "js: function(term,page) {
                                    return {q: term};
                            }",
                            'results' => "js: function(data,page){
                                    return {results: data};
                            }",
                        ),                                            
                ),                                            
                    'htmlOptions'=>array(
                            'style'=>'width:200px;',
                        'placeholder'=>'-- Nama Supplier --'
                    ),
                ));  
        ?>
        <?php echo CHtml::error($model, "[$index]poNo"); ?>
        <script type="text/javascript">
        <?php if(isset($_GET['index']) && is_numeric($_GET['index'])){ ?>
        $('#APDetail_<?php echo $_GET['index']; ?>_poNo').select2();
        <?php } ?>
        </script>
    </div>                               
</td> 
<td valign="top">
    <?php 
    echo CHtml::activeTextField($model,"[$index]apInvTotal",array('size'=>15,'class'=>'number', 'onchange'=>'js:update_amounts();', 'value' => $model->convert_dots($model->apInvTotal))); ?>            
    <?php echo CHtml::error($model,"[$index]apInvTotal"); ?>

</td>

<td valign="top">
    <?php echo CHtml::activeTextField($model,"[$index]apInvDetDesc",array('size'=>25,'class'=>'invoice' )); ?>            
    <?php echo CHtml::error($model,"[$index]apInvDetDesc"); ?>
</td>
<td valign="top">
<?php echo CHtml::activeCheckBox($model, "[$index]rejected", array('value' => '1', 'uncheckValue'=>'0')); ?> 
</td>
 <script type="text/javascript">
    for (var i = 0; i< 1000; i++)
    {
        if (document.getElementById("APDetail_"+i+"_apInvTotal"))
        {
            var input = document.getElementById("APDetail_"+i+"_apInvTotal");
            //console.log(input.value);
            if (input.value !== '' && input.value !== '0'){
                var temporary = input.value;
                var Filter = temporary.split(".")[0];
                input.value = Filter;
            } 
        }
        else
        {
            break;
        }
    }
</script>
<script>
       $('input.number').keyup(function(event) {
       // skip for arrow keys
       if(event.which >= 37 && event.which <= 40) return;
       // format number
       $(this).val(function(index, value) {
             return value
            .replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
       });

       //$('#APDetail_0_apInvTotal').val(formatNumber(sum, 0,',','','','','-','')); 
     });
</script> 
