<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'inv-header-form',
        'enableAjaxValidation' => false,
    ));

    Yii::app()->clientScript->registerScript('JQuery', "      

        $( document ).ready(function() {
        $('#BQClaim_claimTotal').val(formatNumber(parseInt(0), 0,',','','','','-',''));
        $('#BQClaim_bqAvail').val(formatNumber(parseInt(0), 0,',','','','','-',''));
        $('#BQClaim_tqAvail').val(formatNumber(parseInt(0), 0,',','','','','-',''));
        $('#BQClaim_tqUsed').val(formatNumber(parseInt(0), 0,',','','','','-',''));
        $('#BQClaim_bqUsed').val(formatNumber(parseInt(0), 0,',','','','','-',''));
        $('#BQClaim_totalAll').val(formatNumber(parseInt(0), 0,',','','','','-',''));      
        $('#stat').text('');
            //updateTotal();
            //calcFooter();
        });
        
        $('.itemValue').live('blur', function() {            
            updateTotal();
            calcFooter();
    	});
        
        $('#BQClaim_branchID').live('change', function(){
            var idgrp = this.value;
            var branch = $('#BQClaim_voucher').val();
            console.log(idgrp);
            
            if(branch != 'PST' && idgrp.trim() == 'A1'){
                console.log('masuk');
                $('#BQClaim_bqAvail').hide();
                $('#BQClaim_tqAvail').hide();
                $('#BQClaim_bqUsed').hide();
                $('#BQClaim_tqUsed').hide();
                $('#BQClaim_totalAll').hide();
            }else{
                $('#BQClaim_bqAvail').show();
                $('#BQClaim_tqAvail').show();
                $('#BQClaim_bqUsed').show();
                $('#BQClaim_tqUsed').show();
                $('#BQClaim_totalAll').show();
            }
            
            var url = '" . Yii::app()->createUrl('/bq/getCustByGroups') . "';
            $.get(url, { idgrp: idgrp} )
                .done(function(data) {
                    var option = '';
                    var data = JSON.parse(data);
                    for(var key in data){
                        option = option + '<option value=\"'+key+'\">'+data[key]+'</option>';
                    }
                    $('#BQClaim_idCust').html(option);
                    $('#BQClaim_idCust').select2();
                });
            
            $('#BQClaim_idCust').trigger('change');
        });
          
        $('#BQClaim_tqUsed').live('blur', function() {            
            calcFooter();
        });
        
        $('#BQClaim_bqUsed').live('blur', function() {            
            calcFooter();
        });             

        $('#BQClaim_idCust').change(function() { 
            var dealerID = this.value;
            var branchID = $('#BQClaim_branchID').find(':selected').val();
            
            var url = '" . Yii::app()->createUrl('/bq/getBalance') . "';
            $.get(url, { dealerID: dealerID, branchID: branchID } )
                .done(function(data) {
                    var json = JSON.parse(data)                    
                    $('#BQClaim_bqAvail').val(formatNumber(parseInt(json[2]), 0,',','','','','-',''));
                    $('#BQClaim_tqAvail').val(formatNumber(parseInt(json[3]), 0,',','','','','-',''));
                    $('#BQClaim_tqUsed').val(formatNumber(parseInt(0), 0,',','','','','-',''));
                    $('#BQClaim_bqUsed').val(formatNumber(parseInt(0), 0,',','','','','-',''));
                    $('#BQClaim_totalAll').val(formatNumber(parseInt(0), 0,',','','','','-',''));
                });

        });

        function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
            num=String(num).replace(/,/gi,'');
            var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
        };

        $('.tabular-input-remove').live('click', function() {
            $(this).parent().parent().remove();
            updateTotal();            
    	});   
        
        function updateTotal()
        {
            var sum = 0;
            $('#nonItems > tbody  > tr').each(function() {
                var itemValue = $(this).find('.itemValue').val();
                var itemDesc = $(this).find('.itemDesc').val();
                
                if(itemValue != undefined){
                    itemValue = itemValue.replace(/,/gi,'');
                }
                if(itemDesc !== '')
                {var itemTotal = (itemValue);} else {var itemTotal = 0;}
                
                if(!isNaN(itemTotal))sum += parseFloat(itemTotal);   
                $(this).find('.itemTotal').val(formatNumber(itemTotal, 0,',','','','','-',''));
                $(this).find('.itemValue').val(formatNumber(itemValue, 0,',','','','','-',''));
                
            });
            
            $('#BQClaim_claimTotal').val(formatNumber(sum, 0,',','','','','-',''));  
            calcFooter();
        }

        function calcFooter(){
            var bqAvail = parseFloat($('#BQClaim_bqAvail').val().replace(/,/gi,''));
            var bqUsed = parseFloat($('#BQClaim_bqUsed').val().replace(/,/gi,''));
            var tqAvail = parseFloat($('#BQClaim_tqAvail').val().replace(/,/gi,''));
            var tqUsed = parseFloat($('#BQClaim_tqUsed').val().replace(/,/gi,''));
            var total = parseFloat($('#BQClaim_claimTotal').val().replace(/,/gi,''));
            var grandTotal = parseFloat($('#BQClaim_totalAll').val().replace(/,/gi,''));
            var check ;
            if(total > 0){
                if(tqUsed == 0) tqUsed = tqAvail;
                if(tqUsed > total) tqUsed = total;                
                if(tqUsed > tqAvail) tqUsed = tqAvail;
                 
                bqUsed = total - tqUsed;
                //check = bqUsed + tqUsed;
                bqUsed = bqUsed / 0.7 ;
                if(bqUsed > bqAvail)  bqUsed = bqAvail;  
            }      

            grandTotal = bqUsed  + tqUsed;
            
            $('#BQClaim_bqUsed').val(formatNumber(bqUsed, 0,',','','','','-',''));  
            $('#BQClaim_tqUsed').val(formatNumber(tqUsed, 0,',','','','','-','')); 
            $('#BQClaim_totalAll').val(formatNumber(grandTotal, 0,',','','','','-','')); 
            
            
        }
        
        
        function execForm(){            
            var bqUsed = parseFloat($('#BQClaim_bqUsed').val().replace(/,/gi,''));
            var tqUsed = parseFloat($('#BQClaim_tqUsed').val().replace(/,/gi,''));
            var total = parseFloat($('#BQClaim_claimTotal').val().replace(/,/gi,''));
            var grandTotal = parseFloat($('#BQClaim_totalAll').val().replace(/,/gi,''));
            
            
            if(grandTotal < total){
                alert('Budget tidak tersedia');
            }
            else{      
                var r = confirm('Kirim pengajuan klaim?');
                if (r == true) {
                   // document.getElementById('inv-header-form').submit();
                } else {
                    //return;
                }
                
            }            
        }

    ", CClientScript::POS_END);
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model);$branch = Yii::app()->user->getState('branch'); ?>

    <div class="group">
        <?php echo Yii::t('ui', 'Pemohon'); ?>
    </div>
    <div>
        <table>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'bqClaimNo'); ?>
                        <?php echo $form->textField($model, 'bqClaimNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($model,'voucher',array()); ?>
                        <?php echo $form->error($model, 'bqClaimNo'); ?>
                    </div>                               
                </td>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'claimDate'); ?>
                        <?php echo $form->hiddenField($model, 'claimDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->textField($model, 'fmtDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'claimDate'); ?>
                    </div>                               
                </td>
            </tr>                               
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'PIC'); ?>
                        <?php echo $form->hiddenField($model, 'PIC', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->textField($model, 'userName', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'PIC'); ?>
                    </div>                               
                </td>   
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'deptName'); ?>                        
                        <?php echo $form->textField($model, 'deptName', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'deptName'); ?>
                    </div>                               
                </td>
            </tr>   
            <tr>
                <td valign="top">
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'branchID'); ?>
                        <?php
                        $this->widget('ext.widgets.select2.XSelect2', array(
                            'model' => $model,
                            'attribute' => 'branchID',
                            'data' => Utility::getBranch(),
                            'htmlOptions' => array(
                                'style' => 'width:295px',
                                'empty' => '',
                                'placeholder' => '-- Budget Cabang --'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'idCust'); ?>
                    </div>                               
                </td>               
            </tr>   
            <tr>
                <td valign="top">
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'idCust'); ?>
                        <?php
                        $this->widget('ext.widgets.select2.XSelect2', array(
                            'model' => $model,
                            'attribute' => 'idCust',
                            'data' => Utility::getDealerBQTQ($branch),
                            'htmlOptions' => array(
                                'style' => 'width:295px',
                                'empty' => '',
                                'placeholder' => '-- Dealer --'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'idCust'); ?>
                    </div>                               
                </td> 
                <td >
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'claimDesc'); ?>
                        <?php echo $form->textArea($model, 'claimDesc', array('cols' => 40, 'rows' => 5, 'placeholder' => '-- Keterangan --', )); ?>
                        <?php echo $form->error($model, 'claimDesc'); ?>
                    </div>                               
                </td>                   
            </tr>              
        </table>
    </div>
    <br/>
    <div class="group">
        <?php echo Yii::t('ui', 'Pengajuan Non-Barang'); ?>
    </div>
    <div>
        <?php
        $this->widget('ext.widgets.tabularinput.XTabularInput', array(
            'id' => 'nonItems',
            'models' => $model->nonItems,
            'containerTagName' => 'table',
            'headerTagName' => 'thead',
            'header' => '
                            <tr>
                                <th>Keterangan</th>
                                <th>Nilai</th>
                                <th>Total</th>                                
                                <th></th>
                            </tr>
                ',
            'inputContainerTagName' => 'tbody',
            'inputTagName' => 'tr',
            'inputView' => '/site/extensions/_tabularBQNonItems',
            'inputUrl' => $this->createUrl('request/addTabBQNonItems'),
            'addTemplate' => '<tbody><tr></td><td colspan="3">{link}</td></tr></tbody>',
            'addLabel' => Yii::t('ui', 'Tambah'),
            'addHtmlOptions' => array('class' => 'blue pill full-width'),
            'removeTemplate' => '<td>{link}</td>',
            'removeLabel' => Yii::t('ui', 'Hapus'),
                /* 'removeHtmlOptions' => array('class' => 'red pill'), */
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
                        <?php echo $form->labelEx($model, 'claimTotal'); ?>
                        <?php echo $form->textField($model, 'claimTotal', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'class' => 'subTotal', 'style' => 'text-align: right', )); ?>
                        <?php echo $form->error($model, 'claimTotal'); ?>
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
                        <?php echo $form->labelEx($model, 'tqAvail'); ?>
                        <?php 
                            echo $form->textField($model, 'tqAvail', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'class' => 'tqavail','style' => 'text-align: right', ));?> - <?php
                            echo $form->textField($model, 'tqUsed', array('size' => 25, 'maxlength' => 30,  'class' => 'tqused','style' => 'text-align: right', ));
                            ?>
                        <?php echo $form->error($model, 'tqAvail'); ?>
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
                        <?php echo $form->labelEx($model, 'bqAvail'); ?>
                        <?php 
                            echo $form->textField($model, 'bqAvail', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'class' => 'bqavail', 'style' => 'text-align: right', )); ?> - <?php
                            echo $form->textField($model, 'bqUsed', array('size' => 25, 'maxlength' => 30,  'class' => 'bqused', 'style' => 'text-align: right', ));
                        ?>
                        <?php echo $form->error($model, 'bqAvail'); ?>
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
                        <?php echo $form->labelEx($model, 'totalAll'); ?>
                        <?php echo $form->textField($model, 'totalAll', array('size' => 25, 'maxlength' => 30, 'readonly' => true, 'class' => 'grandTotal', 'style' => 'text-align: right', )); ?>
                        <?php echo $form->error($model, 'totalAll'); ?>
                        <span id="stat">aaaa</span>
                    </div>                               
                </td>                      
            </tr> 
        </table>
    </div>
    <div class="row buttons">
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan',array('confirm'=>'Submit pengajuan?'));                 ?>    
        <?php echo CHtml::link('Simpan', "javascript:execForm();", array( 'class' => 'btn btn-sm',)); ?>  
    </div>

    <?php $this->endWidget();
    ?>

</div><!-- form -->


<script type="text/javascript">


</script>