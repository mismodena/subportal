<div >

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="form">
        <div class="simple">
            <?php echo $form->labelEx($model, 'fromDate'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'fromDate',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd', // save to db format
                    'altField' => '#self_pointing_id',
                    //'altFormat' => 'dd-mm-yy', // show to user format
                    'showOtherMonths' => true, // show dates in other months
                    'selectOtherMonths' => true, // can seelect dates in other months
                    'changeYear' => true, // can change year
                    'changeMonth' => true, // can change month
                //'yearRange' => '2000:2099',     // range of year   
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'fromDate'); ?>
        </div> 

        <div class="simple">
            <?php echo $form->labelEx($model, 'toDate'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'toDate',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd', // save to db format
                    'altField' => '#self_pointing_id',
                    //'altFormat' => 'dd-mm-yy', // show to user format
                    'showOtherMonths' => true, // show dates in other months
                    'selectOtherMonths' => true, // can seelect dates in other months
                    'changeYear' => true, // can change year
                    'changeMonth' => true, // can change month
                //'yearRange' => '2000:2099',     // range of year   
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'toDate'); ?>
        </div>   

        <div class="simple">
            <?php echo $form->labelEx($model, 'type'); ?>
            <?php
                $this->widget('ext.widgets.select2.XSelect2', array(
                    'model'=>$model,
                    'attribute'=>'type',
                    'data'=>  array("ALL" => "ALL", "Y01" => "MODERN STORE KAM-1", "Y02" => "MODERN STORE KAM-2", "Y11" => "MODERN STORE NON TT KAM-1", "Y12" => "MODERN STORE NON TT KAM-2"),
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
    </div>
    <br/>
    <?php echo CHtml::submitButton('Cari', array('class' => 'btn btn-sm')); ?>  
    <?php echo CHtml::link('Export', "javascript:exportAll();", array('class' => 'btn btn-sm', )); 
    //echo CHtml::link("Export", "#", array('onclick'=>'approve(1)'));?>
    

    <?php $this->endWidget(); ?>
</div><!-- search-form -->
<br/>
<script type="text/javascript">

    function exportAll()
    {
        //alert("yoooooo");
        var fromDate = $("#DocumentHeader_fromDate").val();
        var toDate = $("#DocumentHeader_toDate").val();
        var type = $("#DocumentHeader_type").val();
        var customer = $("#DocumentHeader_customer").val();
        var url = '<?php echo Yii::app()->createUrl('/document/exportall'); ?>';
        url = url + '?fromDate='+fromDate+'&toDate='+toDate+'&type='+type+'&customer='+customer;
        window.location = url;
        //alert(data);
        //document.forms[0].submit();
//        $.ajax({
//            type: 'POST',
//            url: '<?php echo Yii::app()->createUrl('/document/exportall'); ?>',
//            data: {fromDate : fromDate, toDate : toDate, type : type},
//            success: function (data) {
////                var message = 'Persetujuan FPP Nomor ' + data.fppID + ' ' + ' berhasil dikirim';
////                var redirect = '<?php echo Yii::app()->createUrl("formPP/accounting"); ?>'
////                alert(message);
////                window.location = redirect;
//            },
//            error: function (data) { // if error occured
//                //alert(data.msg);
//            },
//            dataType: 'json'
//        });

    }

</script>