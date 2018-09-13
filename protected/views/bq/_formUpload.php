<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'master-open-form',
        'enableAjaxValidation' => true,
    ));

    Yii::app()->clientScript->registerScript('JQuery', "        
        
        function execForm()
        { 
            document.getElementById('master-open-form').submit();                   
        }

    ", CClientScript::POS_END);
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php
        $branch = Yii::app()->user->getState('branch');
        echo $form->errorSummary($model); ?>

    <div class="group">    
        <?php
        if ($model->isNewRecord) {
            echo Yii::t('ui', 'Pengajuan Saldo');
        } else {
            echo Yii::t('ui', 'Pengajuan Saldo');
        }
        ?>
    </div>
    <div>
        <table>
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'bqUploadNo'); ?>
                        <?php echo $form->textField($model, 'bqUploadNo', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'bqUploadNo'); ?>
                    </div>                               
                </td>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'uploadDate'); ?>
                        <?php echo $form->hiddenField($model, 'uploadDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->textField($model, 'fmtDate', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'uploadDate'); ?>
                    </div>                               
                </td>
            </tr>                               
            <tr>
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'PIC'); ?>
                        <?php echo $form->hiddenField($model, 'PIC', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->textField($model, 'userName', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'PIC'); ?>
                    </div>                               
                </td>   
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'deptName'); ?>                        
                        <?php echo $form->textField($model, 'deptName', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Running Number --', 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'deptName'); ?>
                    </div>                               
                </td>
            </tr>   
            <tr>
                <td >
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'uploadDesc'); ?>
                        <?php echo $form->textArea($model, 'uploadDesc', array('cols' => 40, 'rows' => 5, 'placeholder' => '-- Keterangan --',)); ?>
                        <?php echo $form->error($model, 'uploadDesc'); ?>
                    </div>                               
                </td>   

            </tr>  
            <tr>
                <td valign="top">
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'uploadBranch'); ?>
                        <?php
                        $this->widget('ext.widgets.select2.XSelect2', array(
                            'model' => $model,
                            'attribute' => 'uploadBranch',
                            'data' => Utility::getBranch(),
                            'htmlOptions' => array(
                                'style' => 'width:295px',
                                'empty' => '',
                                'placeholder' => '-- Budget Cabang --'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'uploadBranch'); ?>
                    </div>                               
                </td>    
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'bqValue'); ?>                        
                        <?php echo $form->textField($model, 'bqValue', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Nilai BQ --')); ?>
                        <?php echo $form->error($model, 'bqValue'); ?>
                    </div>                               
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'idCust'); ?>
                        <?php
                        $this->widget('ext.widgets.select2.XSelect2', array(
                            'model' => $model,
                            'attribute' => 'idCust',
                            'data' =>  Utility::getDealerBQTQ($branch),
                            'htmlOptions' => array(
                                'style' => 'width:295px',
                                'empty' => '',
                                'placeholder' => '-- Dealer --'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'idCust'); ?>
                    </div>                               
                </td> 
                <td>
                    <div class="simple">
                        <?php echo $form->labelEx($model, 'tqValue'); ?>                        
                        <?php echo $form->textField($model, 'tqValue', array('size' => 40, 'maxlength' => 50, 'placeholder' => '-- Nilai TQ --')); ?>
                        <?php echo $form->error($model, 'tqValue'); ?>
                    </div>                               
                </td>
            </tr>        

        </table> 
    </div>

    <div class="row buttons">
        <?php //echo CHtml::submitButton($model->isNewRecord ? 'Save!' : 'Simpan', array('class' => 'btn btn-sm')); ?>
        <?php echo CHtml::link('Simpan', "javascript:execForm();", array('confirm' => 'Submit pengajuan?', 'class' => 'btn btn-sm',)); ?>  
    </div>

    <?php $this->endWidget();
    ?>

</div><!-- form -->