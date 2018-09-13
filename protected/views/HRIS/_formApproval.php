<div class="form">
         
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'hris-prmd-form',
        'enableAjaxValidation' => false,
        'enableClientValidation'=>true,
        //'action' => Yii::app()->createUrl('HRIS/approval'),  //<- your form action here
    )); ?>

        <div class="group">
            <?php echo Yii::t('ui', 'Persetujuan'); ?>
        </div>
        <br/>
        <div>
            <table border="0" width="50%">
                 <tr>
                    <td width="40%" align="right">   
                        <?php echo "Action"; ?>
                        
                        <?php echo $form->error($approval, 'prmdAction'); ?>                        
                    </td> 
                    <td>
                        <?php echo $form->dropDownList($approval,'prmdAction',array("ok"=>"Disetujui","3"=>"Perpanjangan 3 bulan", "6"=>"Perpanjangan 6 bulan")); ; ?>
                    </td>
                </tr>
                <tr><td>&nbsp</td><td>&nbsp</td></tr>
                <tr>
                    <td width="40%" align="right">                       
                            Setujui<br/>
                            <?php 
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/approve.png","Setujui",array("title"=>"Setujui",'width'=>50,'height'=>50)),"#", array('onclick'=>'approve(1)'));                                 
                            ?>                                                                                                   
                    </td>   
                            <td width="40%" align="center">                       
                            Tidak Setujui<br/>
                            <?php 
                                echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/reject.png","Tidak Setujui",array("title"=>"Tidak Setujui",'width'=>50,'height'=>50)),"#", array('onclick'=>'approve(0)')); 
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
                            <?php echo $form->hiddenField($approval, 'prmdID', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
                            <?php echo $form->hiddenField($approval, 'status', array('size' => 40, 'maxlength' => 50,'readonly' => true)); ?>                            
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
    $("#hrisPrmd_status").val(nilai);   
    
    var data=$("#hris-prmd-form").serialize();
    //alert(data);
    //document.forms[0].submit();
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createUrl('HRIS/approval'); ?>',
        data:data,
        success:function(data){
            var message = 'Pengajuan berhasil diproses';
            var redirect = '<?php echo Yii::app()->createUrl("HRIS/indexPrmd"); ?>'
            alert(message); 
            window.location = redirect;
            //location.reload();
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
