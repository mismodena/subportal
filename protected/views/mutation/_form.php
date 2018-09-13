<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'mutation-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    
)); 
    
    

?>
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="group">
        <?php echo Yii::t('ui', 'Mutasi Aktiva Tetap'); ?>
    </div>
    <div>
       <table>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'mutationNo'); ?>
                        <?php echo $form->textField($model, 'mutationNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'mutationNo'); ?>
                    </div>                               
                </td>
            </tr>

            <tr>
                <td>
                <div class="simple">
                    <?php echo $form->labelEx($model, 'mutationDate'); ?>
                    <?php echo $form->hiddenField($model, 'mutationDate'); ?>
                    <?php echo $form->textField($model, 'mutationDateLong', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Tanggal', 'readonly' => true)); ?>
                    <?php echo $form->error($model, 'mutationDate'); ?>
                </div>
                </td>
           </tr> 

            <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fromPIC'); ?>
                            <?php echo $form->hiddenField($model, 'fromPIC'); ?>
                            <?php echo $form->textField($model, 'fromPICName', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Departemen', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'fromPIC'); ?>
                        </div>                               
                    </td>
            </tr>
            <tr> 
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fromDept'); ?>
                            <?php echo $form->hiddenField($model, 'fromDept'); ?>
                            <?php //echo $form->dropDownList($model,'fromDept', LookupView::getUserAsset(), array('empty'=>'-Select-'));?> 
                            <?php echo $form->dropDownList($model,'fromDept', LookupView::getUserAsset(), array('empty' => 'Select from department...',
                                        'ajax' => array( 
                                        'type'=>'POST', 
                                        'url'=>CController::createUrl('Asset/getassetdept'), 
                                        'data'=>'js:"kodeAsset="+jQuery(this).val()',
                                        'success' => "function(data){
                                            /* console.log(data); */
                                            var MutationDetail_0_assetID = document.getElementById('MutationDetail_0_assetID');
                                            MutationDetail_0_assetID.innerHTML = data;
                                            $('#MutationDetail_0_assetID').select2();
                                            var tableMAT = document.getElementById('tableMAT');
                                            var select_table = tableMAT.getElementsByTagName('select');
                                            for(var i = 1; i < select_table.length; i++){
                                                var MutationDetail_new_assetID = document.getElementById('MutationDetail_'+i+'_assetID');
                                                MutationDetail_new_assetID.innerHTML = data;
                                                $('MutationDetail_'+i+'_assetID').select2();
                                            }
                                        }",  
                                        //'update'=>'#subCategory', 
                                        //'update'=>'#'.Chtml::activeId($model,'toPIC'),
                                        )));?>
                            <?php echo $form->error($model, 'fromDept'); ?>
                        </div>                               
                    </td>                        
            </tr>

            <tr>
                <td>    
                     <div class="simple">
                        <?php echo $form->labelEx($model,'toDept'); ?>
                        <?php echo $form->dropDownList($model,'toDept', LookupView::getDeptAsset(), array('empty' => 'Pilih departemen...',
                            ));
                            ?> 
                            
                        <?php echo $form->error($model,'toDept'); ?>
                    </div>                        
                </td>
         
                <td>    
                        <div class="simple">
                        <?php echo $form->labelEx($model,'toPIC'); ?>
                         <?php echo $form->textField($model,'toPIC',array('rows'=>5,'cols'=>37)); ?>
                        <?php echo $form->error($model,'toPIC'); ?>
                    </div>                            
                </td>
            </tr> 
            <tr>
                 
                
      
          
            <!-- <tr>
                <td>
                <div class="simple">
                    <?php /*echo $form->labelEx($model,'toDept'); ?>
                    <?php echo $form->dropDownList($model,'toDept', LookupView::getDepartment(), array('empty' => 'Select from department...',
                                        'ajax' => array( 
                                        'type'=>'POST', 
                                        'url'=>CController::createUrl('Asset/getpicactive'), 
                                        'data'=>'js:"idDept="+jQuery(this).val()',  
                                        //'update'=>'#subCategory', 
                                        'update'=>'#'.Chtml::activeId($model,'toPIC'),
                                        )));?>
                            <?php echo $form->dropDownList($model,'toPIC',CHtml::listData(LookupView::getpicactive($model->toDept),'idCard', 'userName'),array());?>
                    <?php echo $form->error($model,'toDept'); ?>
                            <?php echo $form->error($model,'toPIC'); */?>
                </div>
                </td>
           </tr>  --> 
          
       </table>
   </div>

    <div class="group">
        <?php echo Yii::t('ui', 'Asset'); ?>
    </div>
    
    <div>
        <?php 
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tableMAT',
                'models' => $model->items,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>
                                <th>Asset</th>
                                <th>Description</th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularMAT',
                'inputUrl' => $this->createUrl('request/addTabMAT'),
                'addTemplate' => '<tbody><tr><td colspan="2">{link}</td></tr></tbody>',
                'addLabel' => Yii::t('ui', 'Tambah'),
                'addHtmlOptions' => array('class' => 'blue pill full-width'),
                'removeTemplate' => '<td>{link}</td>',
                'removeLabel' => Yii::t('ui', 'Hapus'),
                /*'removeHtmlOptions' => array('class' => 'red pill'),*/
            ));
        ?>
    </div>
        <br/>
        <p class="note"><span class="required">Note:</span> Pastikan Nomor Asset Sama.</p>
        
    <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Buat MAT' : 'Simpan');                 ?>            
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
window.onload = function(){
    var tableMAT = document.getElementById("tableMAT");
    var get_a_tableMAT = tableMAT.getElementsByTagName("a");
    for(var i = 0; i < get_a_tableMAT.length; i++){
        if(get_a_tableMAT[i].getAttribute("class") === "blue pill full-width tabular-input-add"){
            var a_active = get_a_tableMAT[i];
            var counter = 1;
            a_active.onclick = function(){
                /* console.log("Test click"); */
                var ints = setInterval(function(){
                    if(document.getElementById("MutationDetail_"+counter+"_assetID")){
                        var MutationDetail_new_assetID = document.getElementById("MutationDetail_"+counter+"_assetID");
                        var MutationDetail_before_assetID = document.getElementById("MutationDetail_"+(counter - 1)+"_assetID");
                        MutationDetail_new_assetID.innerHTML = MutationDetail_before_assetID.innerHTML;
                        $("MutationDetail_"+counter+"_assetID").select2();
                        /* console.log("Test Interval"); */
                        counter++;
                        clearInterval(ints);
                    }
                },100)
                
            };
            break;
        }
    }
};
</script>