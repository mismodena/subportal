<div class="form">
         
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'fpp-accounting-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,
        'action' => Yii::app()->createUrl('formPP/execAccounting'),  //<- your form action here
    )); ?>

        <div class="group">
            <?php echo Yii::t('ui', 'Persetujuan'); ?>
        </div>
        <div>
        <table>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($approval, 'adjType'); ?>
                        <?php echo $form->dropDownList($approval,'adjType',array("+-"=>"Tidak ada koreksi", "++"=>"(+) Koreksi penambahan","--"=>"(-)Koreksi pengurangan")); ; ?>
                        <?php echo $form->error($approval, 'adjType'); ?>
                    </div>                               
                </td>                        
            </tr>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($approval, 'adjustmentValue'); ?>
                        <?php echo $form->textField($approval, 'adjustmentValue', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Nilai total koreksi')); ?>
                        <?php echo $form->error($approval, 'adjustmentValue'); ?>
                    </div>                               
                </td>
            </tr>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($approval, 'adjustmentDesc'); ?>
                        <?php echo $form->textArea($approval, 'adjustmentDesc', array('cols'=>40,'rows'=>5, 'placeholder' => 'Alasan koreksi')); ?>
                        <?php echo $form->error($approval, 'adjustmentDesc'); ?>
                    </div>                               
                </td>
            </tr>
        </table>
        </div>
        <br/>
        <div>
            <table border="0" width="50%">
                <tr>
                    <td width="40%" align="center">                       
                            Kirim Persetujuan<br/>
                            <?php 
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/email2.png","Approve",array("title"=>"Kirim Persetujuan",'width'=>50,'height'=>50)),"#", array('onclick'=>'approve(1)')); 
                            ?>                                                                                                   
                    </td>                    
                </tr>   
            </table>
        </div>

        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->hiddenField($approval, 'fppID', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->hiddenField($approval, 'pic', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->hiddenField($approval, 'tanggal', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                        </div>                               
                    </td>
                </tr> 
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->hiddenField($approval, 'total', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->hiddenField($approval, 'persetujuan', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                        </div>                               
                    </td>
                </tr>                
                <tr>
                    <td>
                        <div class="simple">                            
                            <?php echo $form->hiddenField($approval, 'aktif', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                        </div>                               
                    </td>
                </tr>                
                <tr>
                    <td>
                        <div class="simple">                            
                            <?php echo $form->hiddenField($approval, 'keterangan', array('size' => 40, 'maxlength' => 50,'readonly' => true)); 
                            ?>                            
                        </div>                               
                    </td>
                </tr>     
                
            </table>
        </div>                  

<?php $this->endWidget(); 


?>
    
<script type="text/javascript">
 
function approve(nilai)
{
    $("#FppApproval_persetujuan").val(nilai);   
    
    var data=$("#fpp-accounting-form").serialize();
    //alert(data);
    //document.forms[0].submit();
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createUrl('formPP/execAccounting'); ?>',
        data:data,
        success:function(data){
            var message = 'Persetujuan FPP Nomor '+data.fppID+' '+' berhasil dikirim';
            var redirect = '<?php echo Yii::app()->createUrl("formPP/accounting"); ?>'
            alert(message); 
            window.location = redirect;
        },
        error: function(data) { // if error occured
            alert(data.msg); 
        },
        dataType:'json'
    });
    
}
 
</script>

</div><!-- form -->

<div id="mydiv"  style="display: none "> <iframe id="frame" src="" width="100%" height="300">  </iframe></div>
