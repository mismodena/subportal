<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>    

    <div class="simple">
        <?php
            $this->widget('ext.widgets.select2.XSelect2', array(
                'model'=>$model,
                'attribute'=>'keyWord',
                'data'=>  Utility::getPeriodeBQ(),
                'htmlOptions'=>array(
                        'style'=>'width:295px',
                        'empty'=>'',
                        'placeholder'=>'-- Periode --'
                ),
            ));
        ?>
        <?php echo $form->error($model, 'customer'); ?>
    </div>
    <br/>
    <div class="simple">
        <?php echo CHtml::submitButton('Cari', array('class' => 'btn btn-sm')); ?>
        <?php echo CHtml::link('Export', "javascript:exportAll();", array('class' => 'btn btn-sm', )); ?>
        <br/><br/>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->

<br/>
<script type="text/javascript">

    function exportAll()
    {
        //alert("yoooooo");
        var period = $("#BQBalance_keyWord").val();
        var url = '<?php echo Yii::app()->createUrl('/bq/expRealisasi'); ?>';
        url = url + '?period='+period;
        window.location = url;
    }

</script>