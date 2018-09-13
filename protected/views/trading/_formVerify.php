<div class="form">
         
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'inv-header-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,
        //'action' => Yii::app()->createUrl('invoice/execVerify'),  //<- your form action here
    )); ?>

        <div class="group">
            <?php echo Yii::t('ui', 'Verifikasi'); ?>
        </div>           
        <div>
            <table border="0" width="50%">
                <tr>
                    <td>
                        <div class="simple">                            
                            <?php echo $form->hiddenField($model, 'claimNo', array('size' => 40, 'maxlength' => 50,)); ?>                            
                            <?php echo $form->hiddenField($model, 'fileName', array('size' => 40, 'maxlength' => 50,)); ?>                            
                        </div>                               
                    </td>                        
                </tr>            
                <tr>
                    <td width="40%" align="center">                                                   
                            <?php 
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/verified.png","Verifikasi",array("title"=>"Verifikasi",'width'=>50,'height'=>50)),"#", array('onclick'=>'verified()')); 
                            ?>                                                                                                   
                    </td>                        
                </tr>   
            </table>
        </div>

<?php $this->endWidget(); 


?>
    
<script type="text/javascript">
 
function verified()
{    
    var data=$("#inv-header-form").serialize();
    //alert(data);
    //document.forms[0].submit();
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createUrl('trading/claimVerify'); ?>',
        data:data,
        success:function(data){
            var message = 'Proforma Invoice Nomor '+data.invNo+' '+' telah diverifikasi';
            var redirect = '<?php echo Yii::app()->createUrl("trading/verifyResult"); ?>'
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
