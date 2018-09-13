<?php
$this->breadcrumbs = array(
    'Faktur List' => array('index'),
    'Generate Excel',
);
?>

<h1>Export Excel</h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'excel-form',
        'enableAjaxValidation' => true,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="group">    
        <?php
        if ($model->isNewRecord) {
            echo Yii::t('ui', 'Export Document');
        } else {
            echo Yii::t('ui', 'Update Trading Term');
        }
        ?>
    </div>
    <div>
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
            <?php echo $form->dropDownList($model, 'type', array("ALL" => "ALL", "SJ" => "Surat Jalan", "FK" => "Faktur", "EF" => "eFaktur")); ?>              
            <?php echo $form->error($model, 'type'); ?>
        </div> 

    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Export!' : 'Simpan'); ?>

    </div>

    <?php $this->endWidget();
    ?>

</div><!-- form -->