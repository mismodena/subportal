<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'inv-header-form',
        'enableAjaxValidation' => true,
    )); 
    
    Yii::app()->clientScript->registerScript('JQuery', "
        
        $( document ).ready(function() {
            update_amounts();
            calcFooter();
        });

        $('.invDisc').live('blur', function() {            
           calcFooter();
    	});
        
        $('.invDP').live('blur', function() {            
            calcFooter();
    	});
        
        $('.invRetensi').live('blur', function() {            
            calcFooter();
    	});
        
        $('.qty').live('change', function() {            
            update_amounts();
            calcFooter();
    	});                 
        
        $('.price').live('change', function() {            
            update_amounts();
            calcFooter();
    	});   
        
        $('.tabular-input-remove').live('click', function() {
            $(this).parent().parent().remove();
            update_amounts();
            calcFooter();
    	});     
                
        function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
            num=String(num).replace(/,/gi,'')
            var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
        }
        
        var ubah = [];
        
        function update_amounts()
        {
            var sum = 0;
            var addr = 0;
            $('#tablePI > tbody.tabular-input-container > tr').each(function() {
                var qty = $(this).find('.qty').val();
                var model = $(this).find('.model');
                var price = $(this).find('.price').val();
                model.attr('alamat',addr);
                var amount = 0;
                if(typeof ubah[addr] === 'undefined'){
                    ubah[addr] = 1;
                } else {
                    ubah[addr] = ubah[addr];
                }
                /*console.log(ubah);*/

                $(model).change(function(){
                    var alamat = this.getAttribute('alamat');
                    ubah[alamat] = 1;
                    if(this.value !== '' && this.value !== '0'){
                        ubah[alamat] = 2;
                    }
                    /*console.log(ubah[alamat]);*/
                });
                
                if(ubah[addr] === 2)
                {amount = (qty*price);} else {var amount = 0;}
                console.log(amount);
                if(!isNaN(amount))sum += amount;   
                
                $(this).find('.amount').val((amount) ? formatNumber(amount, 0,',','','','','-','') : '');
                addr++;
            });
            //just update the total to sum  
            
            $('#ProformaInvoice_grandTotal').val(formatNumber(sum, 0,',','','','','-',''));            
        }
        
    function calcFooter()
        {
            var grandTotal = $('.grandTotal').val().replace(/,/g, '') ;
            var invDisc = $('.invDisc').val().replace(/,/g, '');
            var invDP = $('.invDP').val().replace(/,/g, '');
            var invRetensi = $('.invRetensi').val().replace(/,/g, '');
            
            if(isNaN(grandTotal))grandTotal = 0;   
            if(isNaN(invDisc))invDisc = 0;   
            if(isNaN(invDP))invDP = 0;   
            if(isNaN(invRetensi))invRetensi = 0;   
            
            var beforeTax = grandTotal - invDisc - invDP - invRetensi ;            
            var vat = beforeTax * 0.1 ;
            var grand = beforeTax + vat
            
            $('#ProformaInvoice_beforeTax').val(formatNumber(beforeTax, 0,',','','','','-',''));
            $('#ProformaInvoice_vat').val(formatNumber(vat, 0,',','','','','-',''));
            $('#ProformaInvoice_grand').val(formatNumber(grand, 0,',','','','','-',''));
            $('#ProformaInvoice_invDisc').val(formatNumber(invDisc, 0,',','','','','-',''));
            $('#ProformaInvoice_invDP').val(formatNumber(invDP, 0,',','','','','-',''));
            $('#ProformaInvoice_invRetensi').val(formatNumber(invRetensi, 0,',','','','','-',''));
        }
        
    ", CClientScript::POS_END);

    ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Info PI'); ?>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'invNo'); ?>
                            <?php echo $form->textField($model, 'invNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'invNo'); ?>
                        </div>                               
                    </td>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'invDate'); ?>
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'name' => 'invDate',
                                'attribute' => 'invDate',
                                'options' => array(
                                    'showAnim' => 'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                                    'showOn' => 'button', // 'focus', 'button', 'both'
                                    'buttonText' => Yii::t('ui', 'Select form calendar'),
                                    'buttonImage' => XHtml::imageUrl('calendar.png'),
                                    'buttonImageOnly' => true,
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width:150px;vertical-align:top',
                                    'placeholder'=>'-- Tanggal Invoice --',
                                    'readOnly'=>'true',                                    
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'invNo'); ?>
                        </div>                               
                    </td>
                </tr>                               
                <tr>
                    <td>
                        <div class="simple">
                             <?php echo $form->labelEx($model, 'poNo'); ?>
                            <?php echo $form->textField($model, 'poNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- No. PO --', 'readonly' => false)); ?>
                            <?php echo $form->error($model, 'poNo'); ?>
                        </div>                               
                    </td>                                       
                    <td>
                        <div class="simple">
                             <?php echo $form->labelEx($model, 'poName'); ?>
                            <?php echo $form->textField($model, 'poName', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Buyer --', 'readonly' => false)); ?>
                            <?php echo $form->error($model, 'poName'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'salesAcc'); ?>
                            <?php
                                $this->widget('ext.widgets.select2.XSelect2', array(
                                    'model'=>$model,
                                    'attribute'=>'salesAcc',
                                    'data'=>  Utility::getSalesAcc(),
                                    'htmlOptions'=>array(
                                            'style'=>'width:295px',
                                            'empty'=>'',
                                            'placeholder'=>'-- Sales Acc --'
                                    ),
                                ));
                            ?>
                            <?php echo $form->error($model, 'salesAcc'); ?>
                        </div>                               
                    </td>                      
                </tr>
            </table>
        </div>
        <div class="group">
            <?php echo Yii::t('ui', 'Detail PI'); ?>
        </div>
        <div>
        <?php 
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tablePI',
                'models' => $model->items,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>
                                <th>Model</th>                                
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularPIItem',
                'inputUrl' => $this->createUrl('request/addTabProforma2'),
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
                            <?php echo $form->labelEx($model, 'grandTotal'); ?>
                            <?php echo $form->textField($model, 'grandTotal', array('size' => 40, 'maxlength' => 50, 'readonly' => true, 'class'=>'grandTotal')); ?>
                            <?php echo $form->error($model, 'grandTotal'); ?>
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
                            <?php echo $form->labelEx($model, 'invDisc'); ?>
                            <?php echo $form->textField($model, 'invDisc', array('size' => 40, 'maxlength' => 50, 'class'=>'invDisc')); ?>
                            <?php echo $form->error($model, 'invDisc'); ?>
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
                            <?php echo $form->labelEx($model, 'invDP'); ?>
                            <?php echo $form->textField($model, 'invDP', array('size' => 40, 'maxlength' => 50, 'class'=>'invDP')); ?>
                            <?php echo $form->error($model, 'invDP'); ?>
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
                            <?php echo $form->labelEx($model, 'invRetensi'); ?>
                            <?php echo $form->textField($model, 'invRetensi', array('size' => 40, 'maxlength' => 50, 'class'=>'invRetensi')); ?>
                            <?php echo $form->error($model, 'invRetensi'); ?>
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
                            <?php echo $form->labelEx($model, 'beforeTax'); ?>
                            <?php echo $form->textField($model, 'beforeTax', array('size' => 40, 'maxlength' => 50, 'class'=>'beforeTax', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'beforeTax'); ?>
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
                            <?php echo $form->labelEx($model, 'vat'); ?>
                            <?php echo $form->textField($model, 'vat', array('size' => 40, 'maxlength' => 50, 'class'=>'vat', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'vat'); ?>
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
                            <?php echo $form->labelEx($model, 'grand'); ?>
                            <?php echo $form->textField($model, 'grand', array('size' => 40, 'maxlength' => 50,  'readonly' => true)); ?>
                            <?php echo $form->error($model, 'grand'); ?>
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
                            <?php echo $form->labelEx($model, 'invTempDP'); ?>
                            <?php echo $form->textField($model, 'invTempDP', array('size' => 10, 'maxlength' => 50, 'class'=>'grand', 'readonly' => false))." %"; ?>
                            <?php echo $form->error($model, 'invTempDP'); ?>
                        </div>                               
                    </td>                      
                </tr>
            </table>
        </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan');                 ?>
            
	</div>

<?php $this->endWidget();        
    
?>

</div><!-- form -->