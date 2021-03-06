<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'inv-header-form',
        'enableAjaxValidation' => true,
    )); 
    
    Yii::app()->clientScript->registerScript('JQuery', "        

        $( document ).ready(function() {
            calcTotal();
        });

        $('.amount').live('change', function() {            
           calcTotal();
    	});
        
        function setColumn(value,object){
            var arr = value.split('||');
            var parent_td = object.parentNode;
            
            var parent_tr = parent_td.parentNode;
            console.log(parent_tr);
            var get_td = parent_tr.getElementsByTagName('td');
            
            /* Delaer */
            var get_input = get_td[1].getElementsByTagName('input');
            get_input[0].value = arr[3];           
            
            /* Tanggal */
            var get_input = get_td[2].getElementsByTagName('input');
            get_input[0].value = arr[1];
            
            /* Nilai */
            var get_input = get_td[3].getElementsByTagName('input');
            get_input[0].value = arr[2];
            calcTotal()

        };
        
        function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
            num=String(num).replace(/,/gi,'')
            var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
        };
        
        $('.tabular-input-remove').live('click', function() {
            $(this).parent().parent().remove();            
            calcTotal();
        });   

        function calcTotal()
        {
            var sum = 0;
            var count = 0
            var amount = 0;
            $('.amount').each(function () {
                val = $(this).val().replace(/,/g, '');
                if(val !== ''){
                    val = val.replace(/,/g, '') | 0;
                    sum += val;
                    count += 1;
                };

            });
           
            $('#DocumentRequest_invValue').val(formatNumber(sum, 0,',','','','','-',''));    
            $('#DocumentRequest_invCount').val(formatNumber(count, 0,',','','','','-',''));
            
            /* $('#tableInv > tbody  > tr').each(function() {                
                var amount = $(this).find('.amount').val();   
                if (typeof amount != 'undefined')
                {
                    amount = amount.replace(/,/g, '');
                    if(amount !== '')
                    {   
                        sum +=  parseFloat(amount);   
                        count += 1;                    
                    }  
                }
                              
            });*/
            
        }
        
        function execForm()
        { 
            var invCount = parseInt($('#DocumentRequest_invCount').val());
            var invValue = parseInt($('#DocumentRequest_invValue').val());
      
            if(invCount == 0){
                alert('Faktur harus diisi');
            }else if(invValue == 0) {
                alert('Faktur harus diisi');
            } else {
                document.getElementById('inv-header-form').submit();
            }        
        }

    ", CClientScript::POS_END);

    ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Pemohon'); ?>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'reqNumber'); ?>
                            <?php echo $form->textField($model, 'reqNumber', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'reqNumber'); ?>
                        </div>                               
                    </td>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'reqDate'); ?>
                            <?php echo $form->hiddenField($model, 'reqDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->textField($model, 'fmtDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'reqDate'); ?>
                        </div>                               
                    </td>
                </tr>                               
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'reqSales'); ?>
                            <?php echo $form->hiddenField($model, 'reqSales', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->textField($model, 'salesName', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'reqSales'); ?>
                        </div>                               
                    </td>                                                                              
                </tr>                
            </table>
        </div>
        <br/>
        <div class="group">
            <?php echo Yii::t('ui', 'List Faktur'); ?>
        </div>
        <div>
        <?php 
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tableInv2',
                'models' => $model->unpaid,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>
                                <th>Faktur</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Nilai</th>
                                
                                <th></th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularInvDetail',
                'isRemoveOk' => FALSE,
                'isAddOk' => false,/*'removeHtmlOptions' => array('class' => 'red pill'),*/
            ));
        ?>
        </div>
        <br/>
        
        <div>
        <?php 
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tableInv',
                'models' => $model->items,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>
                                <th>Faktur</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Nilai</th>
                                
                                <th></th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularTTTDetail',
                'inputUrl' => $this->createUrl('request/addTabTTTDetail'),
                'addTemplate' => '<tbody><tr></td><td colspan="4">{link}</td></tr></tbody>',
                'addLabel' => Yii::t('ui', 'Tambah'),
                'addHtmlOptions' => array('class' => 'blue pill full-width'),
                'removeTemplate' => '<td>{link}</td>',
                'removeLabel' => Yii::t('ui', 'Hapus'),
                /*'removeHtmlOptions' => array('class' => 'red pill'),*/
            ));
        ?>
        </div>
        <br/>
        <div>            
            <table>               
                <tr>
                    <td>
                        <div class="simple">
                            &nbsp;
                        </div>                               
                    </td>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'invValue'); ?>
                            <?php echo $form->textField($model, 'invValue', array('size' => 40, 'maxlength' => 50, 'readonly' => true, 'class'=>'grandTotal')); ?>
                            <?php echo $form->error($model, 'invValue'); ?>
                        </div>                               
                    </td>                      
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            &nbsp;
                        </div>                               
                    </td>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'invCount'); ?>
                            <?php echo $form->textField($model, 'invCount', array('size' => 40, 'maxlength' => 50, 'class'=>'invDisc')); ?>
                            <?php echo $form->error($model, 'invCount'); ?>
                        </div>                               
                    </td>                      
                </tr>
                
            </table>
        </div>
	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan',array('confirm'=>'Submit pengajuan?'));                 ?>    
                <?php echo CHtml::link('Simpan', "javascript:execForm();", array('confirm'=>'Submit pengajuan?', 'class' => 'btn btn-sm', ));  ?>  
	</div>

<?php $this->endWidget();        
    
?>
        
</div><!-- form -->


<script type="text/javascript">


</script>