<div class="form">
    
        
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'cn-approval-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,
        //'action' => Yii::app()->createUrl('campaign/execApproval'),  //<- your form action here
    )); ?>

        <div class="group">
            <?php echo Yii::t('ui', 'Persetujuan'); ?>
        </div>
        <div>
            <table border="0" width="50%">
                <tr>
                    <td width="40%" align="center">                       
                            Setujui<br/>
                            <?php 
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/approve.png","Approve",array("title"=>"Setujui CN",'width'=>50,'height'=>50)),"#", array('onclick'=>'approve(1)')); 
                            ?>                                                                                                   
                    </td>
                    <td width="40%"  align="center">                           
                            Tidak Setujui<br/>
                            <?php 
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/reject.png","Reject",array("title"=>"Tidak Setujui CN",'width'=>50,'height'=>50)),"#", array('onclick'=>'approve(0)')); 
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
                            <?php echo $form->hiddenField($approval, 'campaignApproval', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                            <?php echo $form->hiddenField($approval, 'excelFiles', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                            <?php echo $form->hiddenField($approval, 'campaignID', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
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
    $("#Campaign_campaignApproval").val(nilai);   
    
    var data=$("#cn-approval-form").serialize();
    //alert(data);
    //document.forms[0].submit();
    
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createUrl('campaign/execApproval'); ?>',
        data:data,
        success:function(data){
            var message = 'CN Nomor '+data.cnID+' '+data.msg
            var redirect = '<?php echo Yii::app()->createUrl("campaign/approval"); ?>'            
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
