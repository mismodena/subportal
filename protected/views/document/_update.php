<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'inv-header-form',
        'enableAjaxValidation' => true,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); 
    
    Yii::app()->clientScript->registerScript('JQuery', "        
        $( document ).ready(function() {
            calcTotal();
        });

        $('.amount').live('blur', function() {            
           calcTotal();
    	});      
        
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
            $('#tableInv > tbody  > tr').each(function() {                
                var amount = $(this).find('.amount').val(); 
                console.log($(this).find('.amount'));
                if (typeof amount != 'undefined')
                {                
                    if(amount != '')
                    {   
                    $(this).find('.amount').val(formatNumber(amount, 0,',','','','','-','')); 
                    amount = amount.replace(/,/g, '') ;
                    console.log(amount);
                        sum +=  parseFloat(amount);   
                        count += 1;                    
                    }  
                }                              
            });
            
            $('#DocumentRequest_retValue').val(formatNumber(sum, 0,',','','','','-',''));    
            $('#DocumentRequest_retCount').val(formatNumber(count, 0,',','','','','-',''));
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
                            <?php echo $form->labelEx($model, 'reqSales'); ?>
                            <?php echo $form->hiddenField($model, 'reqSales', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->textField($model, 'salesName', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'reqSales'); ?>
                        </div>                                                                               
                    </td>
                </tr>                               
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'reqDate'); ?>
                            <?php echo $form->hiddenField($model, 'returnDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->textField($model, 'fmtDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'reqDate'); ?>
                        </div>      
                    </td>
                    <td>
                    <div class="simple">
                            <?php echo Chtml::label("Tanggal Penagihan","Tanggal Penagihan"); ?>
                            <?php echo $form->hiddenField($model, 'reqDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->textField($model, 'fmt2Date', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'reqDate'); ?>
                        </div>      
                    </td>
                </tr>                
            </table>
        </div>
        <div class="group">
            <?php echo Yii::t('ui', 'Detail'); ?>
        </div>
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
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Nomor</th>
                                <th>Keterangan</th>
                                 <th>Tagihan</th>
                                <th>Tertagih</th>
                                <th></th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularRetDetail',
                'inputUrl' => $this->createUrl('request/addTabRetDetail'),
                //'removeTemplate' => '<td valign="top">{link}</td>',
                'isRemoveOk' => FALSE,
                'isAddOk' => false,
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
                            <?php echo $form->labelEx($model, 'invCount'); ?>
                            <?php echo $form->textField($model, 'invCount', array('size' => 5, 'maxlength' => 5, 'readonly' => true, "style"=>"text-align: right")); ?>
                            <?php echo $form->error($model, 'invCount'); ?>
                        </div>                               
                    </td>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'invValue'); ?>
                            <?php echo $form->textField($model, 'fmtAmount', array('size' => 15, 'maxlength' => 15, 'readonly' => true, "style"=>"text-align: right")); ?>
                            <?php echo $form->error($model, 'invValue'); ?>
                        </div>                               
                    </td>                      
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'retCount'); ?>
                            <?php echo $form->textField($model, 'retCount', array('size' => 5, 'maxlength' => 15,'readonly' => true, "style"=>"text-align: right")); ?>
                            <?php echo $form->error($model, 'retCount'); ?>
                        </div>                               
                    </td>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'retValue'); ?>
                            <?php echo $form->textField($model, 'retValue', array('size' => 15, 'maxlength' => 15,"style"=>"text-align: right", 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'retValue'); ?>
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
                          
                    </td>                      
                </tr>
                
            </table>
        </div>
        <div class="group">
            <?php echo Yii::t('ui', 'Lampiran'); ?>
        </div>
        <div>
            <?php
                 $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                    'id'=>'tableAttachment',
                    'models' => $model->attachment,
                    'containerTagName' => 'table',
                    'headerTagName' => 'thead',
                    'header' => '
                                <tr>
                                    <th>Lampiran</th> 
                                    <th></th>
                                </tr>
                    ',
                    'inputContainerTagName' => 'tbody',
                    'inputTagName' => 'tr',
                    'inputView' => '/site/extensions/_tabularReqFile',
                    'inputUrl' => $this->createUrl('request/addTabReqFile'),
                    'addTemplate' => '<tbody><tr></td><td colspan="4">{link}</td></tr></tbody>',
                    'addLabel' => Yii::t('ui', 'Tambah'),
                    'addHtmlOptions' => array('class' => 'blue pill full-width'),
                    'removeTemplate' => '<td>{link}</td>',
                    'removeLabel' => Yii::t('ui', 'Hapus'),
                ));       
            ?>            
        </div>
        <br/>
        <div class="group">
            <?php echo Yii::t('ui', 'Action'); ?>
        </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan',array('confirm'=>'Submit realisasi?'));?>
            
	</div>

<?php $this->endWidget();        
    
?>

</div><!-- form -->