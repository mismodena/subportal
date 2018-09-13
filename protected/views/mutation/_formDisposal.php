<div class="form">
            
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'disposal-form',
        'enableAjaxValidation' => true,
         'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); 
    
    
    ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Disposal'); ?>
        </div>
         <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'disposalNo'); ?>
                            <?php echo $form->textField($model, 'disposalNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'disposalNo'); ?>
                        </div>                               
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'fromPIC'); ?>
                            <?php echo $form->hiddenField($model, 'fromPIC'); ?>
                            <?php echo $form->textField($model, 'fromPICName', array('size' => 40, 'maxlength' => 50,  'readonly' => true)); ?>
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
                                            var DisposalDetail_0_assetID = document.getElementById('DisposalDetail_0_assetID');
                                            DisposalDetail_0_assetID.innerHTML = data;
                                            $('#DisposalDetail_0_assetID').select2();
                                            var tableDisposal = document.getElementById('tableDisposal');
                                            var select_table = tableDisposal.getElementsByTagName('select');
                                            for(var i = 1; i < select_table.length; i++){
                                                var DisposalDetail_new_assetID = document.getElementById('DisposalDetail_'+i+'_assetID');
                                                DisposalDetail_new_assetID.innerHTML = data;
                                                $('DisposalDetail_'+i+'_assetID').select2();
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
                       <?php echo $form->labelEx($model, 'disposalDate'); ?>
                    <?php echo $form->hiddenField($model, 'disposalDate'); ?>
                    <?php echo $form->textField($model, 'disposalDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => 'Tanggal', 'readonly' => true)); ?>
                    <?php echo $form->error($model, 'disposalDate'); ?>
                    </div>
                </td>
            </tr> 
            </table>
        </div>

        <div class="group">
            <?php echo Yii::t('ui', 'Asset Disposal'); ?>
        </div>
        <div>
        <script type='text/javascript'>
        var countUpdate = 0;
        </script>
        <?php if (isset($cekSelect)&& $cekSelect) { ?>
        <div id="asset-form_es_" class="errorSummary"><p>Please fix the following input errors:</p>
            <ul>
            <li>Asset ID tidak boleh kosong.</li>
            </ul>
        </div>
        <?php }?>
        <?php
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tableDisposal',
                'models' => $model->items,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>
                                <th>Jenis Asset</th>                                
                                <th>Alasan</th>
                                <th>Nilai Buku</th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularDisposal',
                'inputUrl' => $this->createUrl('request/addTabDisposal'),
                'addTemplate' => '<tbody><tr></td><td colspan="4">{link}</td></tr></tbody>',
                'addLabel' => Yii::t('ui', 'Tambah'),
                'addHtmlOptions' => array('class' => 'blue pill full-width'),
                'removeTemplate' => '<td>{link}</td>',
                'removeLabel' => Yii::t('ui', 'Hapus'),
                /*'removeHtmlOptions' => array('class' => 'red pill'),*/
            ));
    
        ?>
        </div>
        <p class="note"><span class="required">Note :</span> Nilai Buku diisi oleh Accounting.</p>
        </br>
        <?php 
        if(!$model->isNewRecord){
        ?>
        <script type="text/javascript">
        var tableDisposal = document.getElementById("tableDisposal");
        var get_a = tableDisposal.getElementsByTagName("a");
        var get_select = tableDisposal.getElementsByTagName("select");
        for(var i = 0; i < get_a.length; i++){
            if(get_a[i].getAttribute('class') === "blue pill full-width tabular-input-add"){
                get_a[i].parentNode.removeChild(get_a[i]);
                break;
            }
        }
        var int_disabled = setInterval(function(){
            var get_disabled = false;
            for(var i = 0; i < get_select.length; i++){
                console.log(typeof get_select[i].getAttribute("disabled"));
                if(typeof get_select[i].getAttribute("disabled") === "string"){
                    get_select[i].removeAttribute("disabled");
                    get_disabled = true;
                }
            }
            if(get_disabled){
                clearInterval(int_disabled);
            }
        },1000);
        /*
        for(var i = 0; i < get_select.length; i++){

            get_select[i].removeAttribute("class");
            //console.log("Test Select.");
            //console.log(get_select[i]);
        }*/
        </script>
        <?php 
        }
        $label = "Image";
        if(!$model->isNewRecord){
            // echo $model->disposalNo . "<br />\n";
            /*
            echo "<pre>";
            print_r($model->getListFile($model->disposalNo));
            echo "</pre>"; */
            $label = "File";
            $listFile = $model->getListFile($model->disposalNo);
        }
        ?>
         <div class="group">
            <?php echo Yii::t('ui', $label); ?>
        </div>
        <div>
        <?php 
            if(!$model->isNewRecord){
                foreach($listFile as $file){
                    echo "<a href='/dev/fpp/upload\disposal\\".$file['filePath']."' target='file_tab'>" . $file['filePath'] . "</a><br />\n";
                }
            } else {
            $this->widget('ext.widgets.tabularinput.XTabularInput', array(
                'id'=>'tableDisposal',
                'models' => $model->image,
                'containerTagName' => 'table',
                'headerTagName' => 'thead',
                'header' => '
                            <tr>
                                <th>Image</th>
                                <th></th>
                            </tr>
                ',
                'inputContainerTagName' => 'tbody',
                'inputTagName' => 'tr',
                'inputView' => '/site/extensions/_tabularImage',
                'inputUrl' => $this->createUrl('request/addTabImage'),
                'addTemplate' => '<tbody><tr></td><td colspan="4">{link}</td></tr></tbody>',
                'addLabel' => Yii::t('ui', 'Tambah'),
                'addHtmlOptions' => array('class' => 'blue pill full-width'),
                'removeTemplate' => '<td>{link}</td>',
                'removeLabel' => Yii::t('ui', 'Hapus'),
                /*'removeHtmlOptions' => array('class' => 'red pill'),*/
            ));
            }
        ?>
        </div>
        <br/>
       
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Simpan' : 'Update');                 ?>           
	</div>

<?php $this->endWidget();        
    
?>

</div><!-- form -->

<script type="text/javascript">
window.onload = function(){
    var tableDisposal = document.getElementById("tableDisposal");
    var get_a_tableDisposal = tableDisposal.getElementsByTagName("a");
    for(var i = 0; i < get_a_tableDisposal.length; i++){
        if(get_a_tableDisposal[i].getAttribute("class") === "blue pill full-width tabular-input-add"){
            var a_active = get_a_tableDisposal[i];
            var counter = 1;
            a_active.onclick = function(){
                /* console.log("Test click"); */

                var ints = setInterval(function(){
                    if(document.getElementById("DisposalDetail_"+counter+"_assetID")){
                        var DisposalDetail_new_assetID = document.getElementById("DisposalDetail_"+counter+"_assetID");
                        var DisposalDetail_before_assetID = document.getElementById("DisposalDetail_"+(counter - 1)+"_assetID");
                        DisposalDetail_new_assetID.innerHTML = DisposalDetail_before_assetID.innerHTML;
                        
                        $("DisposalDetail_"+counter+"_assetID").select2();

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