<div class="form">
    
        
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'hris-contract-form',
        'enableAjaxValidation' => true,
    )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Data Karyawan'); ?>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'idCard'); ?>
                            <?php 
                                if ($model->isNewRecord){
                                    $this->widget('ext.widgets.select2.XSelect2', array(
                                        'model'=>$model,
                                        'attribute'=>'userName',
                                        'options'=>array(
                                                'minimumInputLength'=>2,
                                                'ajax' => array(
                                                        'url'=>$this->createUrl('/request/suggestEmployee2'),
                                                        'dataType'=>'json',
                                                        'data' => "js: function(term,page) {
                                                                return {q: term};
                                                        }",
                                                        'results' => "js: function(data,page){
                                                                return {results: data};
                                                        }",
                                                ),
                                                'initSelection' => "",
                                        ),
                                            'events'=>array(     
                                                'change'=>"js:function (element) {
                                                    var id=element.val;          
                                                    var s = id.split(',');       
                                                    $('#hrisPrmd_idCard').val(s[0]);                                                     
                                                    $('#hrisPrmd_jobGrade').val(s[1]); 
                                                    $('#hrisPrmd_idDiv').val(s[2]); 
                                                    $('#hrisPrmd_idDept').val(s[3]); 
                                                    $('#hrisPrmd_idBranch').val(s[4]);                                                     
                                                    $('#hrisPrmd_idPos').val(s[5]);  
                                                    $('#hrisPrmd_divName').val(s[2]); 
                                                    $('#hrisPrmd_deptName').val(s[3]); 
                                                    $('#hrisPrmd_branchName').val(s[4]);                                                     
                                                    $('#hrisPrmd_posName').val(s[5]);  
                                                    $('#hrisPrmd_newJobGrade').val(s[1]); 
                                                    $('#hrisPrmd_newIdDiv').val(s[2]); 
                                                    $('#hrisPrmd_newIdDept').val(s[3]); 
                                                    $('#hrisPrmd_newIdBranch').val(s[4]); 
                                                    $('#hrisPrmd_newIdPos').val(s[5]);  
                                                }"
                                            ),
                                            'htmlOptions'=>array(
                                                    'style'=>'width:400px;',
                                                'placeholder'=>'Nama karyawan..'
                                            ),
                                        ));                                    
                                }
                            echo $form->hiddenField($model, 'idCard');
                            ?>
                            
                            <?php echo $form->error($model, 'idCard'); ?>
                        </div>                               
                    </td>                        
                </tr>  
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'jobGrade'); ?>
                            <?php echo $form->textfield($model, 'jobGrade', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Grade', "readOnly"=>'true')); ?>
                            <?php echo $form->error($model, 'jobGrade'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'idDiv'); 
                                echo $form->hiddenField($model, 'idDiv');?>                            
                            <?php echo $form->dropDownList($model,'divName',CHtml::listData(Department::model()->findAll(array('select' => "idDiv, divName",'order' => 'divName ASC')),'idDiv', 'divName'),array('empty' => 'Pilih divisi...', "disabled"=>"disabled")); ?>
                            <?php echo $form->error($model, 'idDiv'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'idDept');
                               echo $form->hiddenField($model, 'idDept'); ?>
                            <?php echo $form->dropDownList($model,'deptName',CHtml::listData(Department::model()->findAll(array('order' => 'deptName ASC')),'idDept', 'deptName'),array('empty' => 'Pilih departemen...',"disabled"=>"disabled")); ?>
                            <?php echo $form->error($model, 'idDept'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'idPos'); 
                                echo $form->hiddenField($model, 'idPos')?>
                            <?php echo $form->dropDownList($model,'posName',CHtml::listData(Position::model()->findAll(array('order' => 'posName ASC')),'idPos', 'posName'),array('empty' => 'Pilih posisi...',"disabled"=>"disabled")); ?>
                            <?php echo $form->error($model, 'idPos'); ?>
                        </div>                               
                    </td>
                </tr>   
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'idBranch'); 
                                echo $form->hiddenField($model, 'idBranch')?>
                            <?php echo $form->dropDownList($model,'branchName',CHtml::listData(Branch::model()->findAll(array('order' => 'branchName ASC')),'idBranch', 'branchName'),array('empty' => 'Pilih cabang...',"disabled"=>"disabled")); ?>
                            <?php echo $form->error($model, 'idBranch'); ?>
                        </div>                               
                    </td>
                </tr>                
            </table>
        </div>
        
        <div class="group">
            <?php echo Yii::t('ui', 'Data PRMD'); ?>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'prmdCategory'); ?>
                            <?php echo $form->dropDownList($model,'prmdCategory',array("P"=>"Promosi","R"=>"Rolling","M"=>"Mutasi","D"=>"Demosi"),array('empty' => 'Pilih kategori...')) ; ?>
                            <?php echo $form->error($model, 'prmdCategory'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'newJobGrade'); ?>
                            <?php echo $form->textfield($model, 'newJobGrade', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Grade')); ?>
                            <?php echo $form->error($model, 'newJobGrade'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'newIdDiv'); ?>
                             <?php echo $form->dropDownList($model,'newIdDiv',CHtml::listData(Department::model()->findAll(array('select' => "idDiv, divName",'order' => 'divName ASC')),'idDiv', 'divName'),array('empty' => 'Pilih divisi...',
                                        'ajax' => array( 
                                            'type'=>'POST', 
                                            'url'=>CController::createUrl('HRIS/GetDepartment'), 
                                            'data'=>'js:"idDiv="+jQuery(this).val()',  
                                            'update'=>'#'.Chtml::activeId($model,'newIdDept'),
                                        )));?> 
                            <?php echo $form->error($model, 'newIdDiv'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'newIdDept'); ?>
                            <?php echo $form->dropDownList($model,'newIdDept',CHtml::listData(Department::model()->findAll(array('order' => 'deptName ASC')),'idDept', 'deptName'),array('empty' => 'Pilih departmen...')); ?>
                            <?php echo $form->error($model, 'newIdDept'); ?>
                        </div>                               
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'newIdPos'); ?>
                            <?php echo $form->dropDownList($model,'newIdPos',CHtml::listData(Position::model()->findAll(array('order' => 'posName ASC')),'idPos', 'posName'),array('empty' => 'Pilih posisi...')); ?>
                            <?php echo $form->error($model, 'newIdPos'); ?>
                        </div>                               
                    </td>
                </tr>  
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'newIdBranch'); ?>
                            <?php echo $form->dropDownList($model,'newIdBranch',CHtml::listData(Branch::model()->findAll(array('order' => 'branchName ASC')),'idBranch', 'branchName'),array('empty' => 'Pilih cabang...')); ?>
                            <?php echo $form->error($model, 'newIdBranch'); ?>
                        </div>                               
                    </td>
                </tr>  
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'startDate'); ?>
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'startDate',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'dateFormat' => 'yy-mm-dd', // save to db format
                                    'altField' => '#self_pointing_id',
                                    //'altFormat' => 'dd-mm-yy', // show to user format
                                    'showOtherMonths' => true,      // show dates in other months
                                    'selectOtherMonths' => true,    // can seelect dates in other months
                                    'changeYear' => true,           // can change year
                                    'changeMonth' => true,          // can change month
                                    //'yearRange' => '2000:2099',     // range of year   
                                ),
                                'htmlOptions' => array(
                                    'style' => 'height:20px;'
                                ),
                            ));?>
                            <?php echo $form->error($model, 'startDate'); ?>
                        </div>                               
                    </td>                        
                </tr>
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'endDate'); ?>
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => 'endDate',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'dateFormat' => 'yy-mm-dd', // save to db format
                                    'altField' => '#self_pointing_id',
                                    //'altFormat' => 'dd-mm-yy', // show to user format
                                    'showOtherMonths' => true,      // show dates in other months
                                    'selectOtherMonths' => true,    // can seelect dates in other months
                                    'changeYear' => true,           // can change year
                                    'changeMonth' => true,          // can change month
                                    //'yearRange' => '2000:2099',     // range of year   
                                ),
                                'htmlOptions' => array(
                                    'style' => 'height:20px;'
                                ),
                            ));?>
                            <?php echo $form->error($model, 'endDate'); ?>
                        </div>                               
                    </td>                        
                </tr>               
                <tr>
                    <td>
                        <div class="simple">
                            <?php echo $form->labelEx($model, 'prmdDesc'); ?>
                            <?php echo $form->textArea($model,'prmdDesc',array('cols'=>38,'rows'=>5)); ?>
                            <?php echo $form->error($model, 'prmdDesc'); ?>
                        </div>                               
                    </td>
                </tr> 
                
            </table>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '- Simpan -' : 'Simpan');                 ?>            
	</div>

<?php $this->endWidget();        

?>

</div><!-- form -->