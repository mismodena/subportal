<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>    

    <div class="simple">		
        <?php echo $form->textField($model, 'keyWord', array('size' => 50, 'maxlength' => 50)); ?> 
        <br/>
        <br/>
    </div>
    <div class="simple">
        <?php
        
//        echo $form->radioButtonList($model, 'option', array("All" => "All", "BQ" => "BQ", "BQ+" => "BQ +", "BQPROF" => "BQ PROF", "TQ" => "TQ", "TQ+" => "TQ +",  "TQPROF" => "TQ PROF", "BBT" => "BBT", "BBTPROF" => "BBT PROF"), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ',
//        ));
        ?>
         <?php
            $this->widget('ext.widgets.select2.XSelect2', array(
                'model' => $model,
                'attribute' => 'option',
                'data' =>array("All" => "All", 
                            "BQ" => "BQ", "BQ+" => "BQ +", "BQPROF" => "BQ PROF", 
                            "TQ" => "TQ", "TQ+" => "TQ +",  "TQPROF" => "TQ PROF",
                            "BBT" => "BBT", "BBTPROF" => "BBT PROF",
                            "TT"=>"TT", "TT+"=>"TT +", "TTPROF"=>"TTPROF",  ),
                'htmlOptions' => array(
                    'style' => 'width:295px',
                    'empty' => '',
                    'placeholder' => '-- Type --'
                ),
            ));
            ?>
        <br/><br/>
    </div>
    <div class="simple">
        <?php echo CHtml::submitButton('Cari', array('class' => 'btn btn-sm')); ?>  
        <?php echo CHtml::link('Buat Baru', Yii::app()->createUrl("bq/termCreate"), array('class' => 'btn btn-sm', )); ?>
       
        <br/><br/>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->