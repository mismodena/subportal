<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'document-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="group">    
        <?php
        if ($model->isNewRecord) {
            echo Yii::t('ui', 'Log Book');
        } else {
            //echo Yii::t('ui', 'Update Customer Term');
        }
        ?>
    </div>
    <div>            
        <div class="simple">
            <?php echo $form->labelEx($model, 'type'); ?>
            <?php
                $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>'type',
                    'data'=>  array("IN" => "Tanda Terima Finance", "EX" => "Tanda Terima Dealer"),
                    'htmlOptions'=>array(
                            'style'=>'width:295px',
                            'empty'=>'',
                            'placeholder'=>'-- Customer Type --'
                    ),
                ));
            ?>           
            <?php echo $form->error($model, 'type'); ?>
        </div> 
        <div class="simple">
            <?php echo $form->labelEx($model, 'customer'); ?>
            <?php
                $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>'customer',
                    'data'=>  Utility::getCustGroup2(),
                    'htmlOptions'=>array(
                            'style'=>'width:295px',
                            'empty'=>'',
                            'placeholder'=>'-- Customer Group Code --'
                    ),
                ));
            ?>
            <?php echo $form->error($model, 'customer'); ?>
        </div> 
        <div class="simple">
            <?php echo CHtml::label('&nbsp;', '&nbsp;') ?>
            <?php echo CHtml::button('Cari', array('onClick' => 'generateDocFollow();')); ?>
        </div>
    </div>
    <div id="ajaxresponse">

    </div>
    <div id="name-list" style="margin-top: 10px;"></div>	   
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Save!' : 'Simpan'); ?>

    </div>

    <?php
    $this->endWidget();
    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScript('list', "
            
            
            function generateDocFollow(){
                console.log('masuk');
                var type = $('#DocumentHeader_type').val();
		var customer = $('#DocumentHeader_customer').val();
                $.ajax('" . $this->createUrl('/request/docfollow') . "', {
                    data: {
                        type: type,                        
                        customer: customer,
                    }
                }).done(function(data) {
                    try{
                    var s;
                    if(data!==''){
                            s = '<table widht=\"80%\"><thead><tr><th>Check</th><th>Doc. Number</th><th>Tanggal</th><th>Terima</th><th>Customer</th><th>Total</th></tr></thead><tbody>';
                            s = s + data + '</tbody></table>' ;                                                                
                    }else{
                            s = 'tidak ditemukan..!!<br>';
                    }
                    $('#name-list').html(String(s).replace(/\\\"/gi, '\"'));
                    $('.datepicker').each(function() {
                        $(this).removeClass('hasDatepicker').datepicker();
                    });
                    }catch(e){alert(e);}                                                            
                });
            }
            
            
        ", CClientScript::POS_END);
    ?>

</div><!-- form -->

