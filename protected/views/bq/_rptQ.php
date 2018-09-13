<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>    
    <?php
        Yii::app()->clientScript->registerScript('JQuery', "      

        $( document ).ready(function() {
        
            $('#BQBalance_year').live('change', function(){
                var year = this.value;
                console.log(year);
                var url = '" . Yii::app()->createUrl('/bq/getQ') . "';
                $.get(url, { year: year} )
                    .done(function(data) {
                        var option = '';
                        var data = JSON.parse(data);
                        for(var key in data){
                            option = option + '<option value=\"'+key+'\">'+data[key]+'</option>';
                        }
                        $('#BQBalance_keyWord').html(option);
                        $('#BQBalance_keyWord').select2();
                    });
            });
        });

    ", CClientScript::POS_END);
    ?>

    <div class="simple">
        <?php
            $this->widget('ext.widgets.select2.XSelect2', array(
                'model'=>$model,
                'attribute'=>'year',
                'data'=>  Utility::getPeriodeBQ(),
                'htmlOptions'=>array(
                        'style'=>'width:295px',
                        'empty'=>'',
                        'placeholder'=>'-- Tahun --'
                ),
            ));
        ?>
        <?php echo $form->error($model, 'customer'); ?>
    </div>
    <br/>
    
    <div class="simple">
        <?php
            $this->widget('ext.widgets.select2.XSelect2', array(
                'model'=>$model,
                'attribute'=>'keyWord',
                'data'=>  array(),
                'htmlOptions'=>array(
                        'style'=>'width:295px',
                        'empty'=>'',
                        'placeholder'=>'-- Q --'
                ),
            ));
        ?>
        <?php echo $form->error($model, 'customer'); ?>
    </div>
    <br/>
    
    <div class="simple">
        <?php echo CHtml::submitButton('Cari', array('class' => 'btn btn-sm')); ?>
        <?php //echo CHtml::link('Export', "javascript:exportAll();", array('class' => 'btn btn-sm', )); ?>
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