<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>    
<div class="form">
    <div class="simple">
        <?php echo $form->labelEx($model, 'itemNo'); ?>
        <?php
        $this->widget('ext.widgets.select2.XSelect2', array(
            'model' => $model,
            'attribute' => 'itemNo',
            'data' => Utility::getLineaItems(),
            'htmlOptions' => array(
                'style' => 'width:305px',
                'empty' => '',
                'placeholder' => '-- Item No --'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'itemNo'); ?>
    </div>
    <br/>
    <div class="simple">
        <?php echo $form->labelEx($model, 'fiscalYear'); ?>
        <?php
        $this->widget('ext.widgets.select2.XSelect2', array(
            'model' => $model,
            'attribute' => 'fiscalYear',
            'data' => Utility::getLineaYear(),
            'htmlOptions' => array(
                'style' => 'width:305px',
                'empty' => '',
                'placeholder' => '-- Tahun --'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'fiscalYear'); ?>
    </div>
    
    <br/>
    <div class="simple">
        <?php echo $form->labelEx($model, 'fiscalPeriod'); ?>
        <?php
        $this->widget('ext.widgets.select2.XSelect2', array(
            'model' => $model,
            'attribute' => 'fiscalPeriod',
            'data' => array("ALL"=>"ALL", "1"=>"Januari", "2"=>"Februari", "3"=>"Maret", "4"=>"April", "5"=>"Mei", "6"=>"Juni",
                            "7"=>"Juni", "8"=>"Agustus", "9"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Desember"),
            'htmlOptions' => array(
                'style' => 'width:305px',
                'empty' => '',
                'placeholder' => '-- Periode --'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'fiscalPeriod'); ?>
    </div>

    <div class="simple">
        <?php echo CHtml::submitButton('Cari', array('class' => 'btn btn-sm')); ?>  
        <?php echo CHtml::link('Export', "javascript:exportAll();", array('class' => 'btn btn-sm', ));  ?>       
    </div>

    <?php $this->endWidget(); ?>
</div>
</div><!-- search-form -->
    <br/>    <br/>
    
<script type="text/javascript">
    function exportAll()
    {
        //alert("yoooooo");
        var itemNo = $("#Linea_itemNo").val();
        var fiscalYear = $("#Linea_fiscalYear").val();
        var url = '<?php echo Yii::app()->createUrl('/linea/export'); ?>';
        url = url + '?itemNo='+itemNo+'&fiscalYear='+fiscalYear;
        window.location = url;
    }

</script>