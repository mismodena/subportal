<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'inv-header-form',
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); 
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScript('JQuery', " 
        
        $( document ).ready(function() {
            update_amounts(); 
            $('.datepicker').each(function() {
                $(this).removeClass('hasDatepicker').datepicker();
            });
        });
        
        $('.amount').blur('change', function() {            
            update_amounts();            
    	}); 
            
        function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
            num=String(num).replace(/,/gi,'')
            var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
        }
        
        function update_amounts()
        {
            var sum = 0;
            $('#tableAPD > tbody  > tr').each(function() {
            
                var amount = parseFloat($(this).find('.amount').val());
                var keperluan = $(this).find('.invoice').val();  
                               
                if(!isNaN(amount) && keperluan !== '')
                {   
                    sum += amount;                       
                    //$(this).val(formatNumber(amount, 0,',','','','','-',''));
                }
                
                
                $('.grandtotal').val(formatNumber(sum, 0,',','','','','-',''));                
                
            });
        }


        
    ", CClientScript::POS_END);

    ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Info Penerimaan'); ?>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'recNo'); ?>
                            <?php echo $form->textField($model, 'recNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'recNo'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>    
                    <td>
                         <div class="simple">
                            <?php echo $form->labelEx($model, 'recDate'); ?>
                            <?php echo $form->hiddenField($model, 'recDate'); ?>
                            <?php echo $form->textField($model, 'recDateLong', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Tanggal', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'recDate'); ?>
                        </div>                            
                    </td>              
                </tr>                               
                <tr>                  
                    <td >
                        <div class="simple">
                             <?php echo $form->labelEx($model, 'apDesc'); ?>
                            <?php echo $form->textArea($model, 'apDesc', array('cols'=>38,'rows'=>5, 'placeholder' => '-- Keterangan --', 'readonly' => false)); ?>
                            <?php echo $form->error($model, 'apDesc'); ?>
                        </div>                               
                    </td>                                                                    
                </tr>               
                 
            </table>
        </div>        
        <br/>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Daftar Penagihan'); ?>
        </div>
        
        
        <div>
        <?php 
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tableAPP',
                'models' => $model->details,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>                                
                                <th>Nomor Penagihan</th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularAPP',
                'inputUrl' => $this->createUrl('request/addTabAPP'),
                'addTemplate' => '<tbody><tr><td colspan="4">{link}</td></tr></tbody>',
                'addLabel' => Yii::t('ui', 'Tambah'),
                'addHtmlOptions' => array('class' => 'blue pill full-width'),
                'removeTemplate' => '<td>{link}</td>',
                'removeLabel' => Yii::t('ui', 'Hapus'),
                
                /*'removeHtmlOptions' => array('class' => 'red pill'),*/
            ));
        ?>
        </div>  
        <br/>
        <div class="group">
            <?php echo Yii::t('ui', 'Kelengkapan Dokumen'); ?>
        </div>           
        <br />
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'apInvCategory'); ?>
                            <?php
                                $this->widget('ext.widgets.select2.XSelect2', array(
                                    'model'=>$model,
                                    'attribute'=>'apInvCategory',
                                    'data'=>  Utility::getInvCategory(),
                                    'events'=>array(
                                        'change'=>"js:function (element) {
                                            var id=element.val;
                                            if (id!='') {
                                                $.ajax('".$this->createUrl('/request/DocList')."', {
                                                    data: {
                                                        id: id,
                                                        status: 1
                                                    }
                                                }).done(function(data) {
                                                    try{
                                                        var s;
                                                        if(data!==''){
                                                            s = '<table><tbody>';
                                                            s = s + data + '</tbody></table>' ;
                                                        }else{
                                                            s = 'Dokumen tidak ditemukan..!!<br>';
                                                        }
                                                        $('#name-list').html(String(s).replace(/\\\"/gi, '\"'));
                                                    }catch(e){alert(e);}
                                                });
                                            }
                                        }"
                                    ),
                                    'htmlOptions'=>array(
                                            'style'=>'width:295px',
                                            'empty'=>'',
                                            'placeholder'=>'-- Kategori --'
                                    ),
                                ));
                            ?>
                            <?php echo $form->error($model, 'salesAcc'); ?>
                        </div>                               
                    </td>                      
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo CHtml::label('Dokumen','Dokumen'); ?>
                            <div id="name-list"></div>    
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
<script type="text/javascript">

$( document ).ajaxComplete(function() {
    for(var j = 0; j < 100; j++){
        if(document.getElementById("APDetail_" + j + "_apInvNo")){
            var APDetail_new_apInvNo = document.getElementById("APDetail_" + j + "_apInvNo");
            var div_parent = APDetail_new_apInvNo.parentNode;
            var get_div = div_parent.getElementsByTagName("div");
            if(typeof get_div[0] === "undefined"){
                $("#APDetail_" + j + "_apInvNo").select2();
            }
        }
    }
});

</script>