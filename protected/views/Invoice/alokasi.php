<?php
$this->breadcrumbs = array(
    'Alokasi PKP+CN',
);
?>

<h1>Alokasi PKP</h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'pkp-form',
        'method' => 'post',
        'action' => $this->createUrl('invoice/alokasi'),
    ));
    
    $branch = Yii::app()->user->getState('branch');
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
 
    <div>            
        <div class="simple">
            <?php echo $form->labelEx($model, 'idCust'); ?>
            <?php
            $this->widget('ext.widgets.select2.XSelect2', array(
                'model' => $model,
                'attribute' => 'idCust',
                'data' => Utility::getCustGroup3($branch),
                'htmlOptions' => array(
                    'style' => 'width:295px',
                    'empty' => '',
                    'placeholder' => '-- Customer --'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'idCust'); ?>
        </div> 
        <div class="simple">
            <?php echo CHtml::label('&nbsp;', '&nbsp;') ?>
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Cari!' : 'Simpan'); ?>
        </div>
    </div>
    <?php
    $this->endWidget();
    ?>
</div><!-- form -->
<?php
if (!empty($pkp)) {
    ?><br/>
    <div class="group">
        <?php echo Yii::t('ui', 'PKP+CN Tersedia'); ?>
    </div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'invoice-grid',
        'dataProvider' => $pkp,
        'enableSorting' => false,
        //'filter'=>$model,
        'columns' => array(
            array(
                'name' => 'Dealer',
                'type' => 'raw',
                'value' => '$data->nameCust',
            ),
            array(
                'name' => 'Cabang',
                'type' => 'raw',
                'value' => '$data->branch',
            ),
            array(
                'name' => 'pkpValue',
                'type' => 'raw',
                'value' => 'number_format($data->pkpValue,0)',
            ),
        ),
    ));
}
?>
<br/>

<?php
if (!empty($order)) {
    ?>
    <div class="group">
        <?php echo Yii::t('ui', 'Order Tersedia'); ?>
    </div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'order-grid',
        'dataProvider' => $order,
        'enableSorting' => false,
        //'filter'=>$model,
        'columns' => array(
            array(
                'name' => 'No. Order',
                'type' => 'raw',
                'value' => '$data->ORDNUMBER',
            ),
            array(
                'name' => 'Tanggal',
                'type' => 'raw',
                'value' => 'date("d-m-Y", strtotime($data->INVDATE))',
            ),
            array(
                'name' => 'invTotal',
                'type' => 'raw',
                'value' => 'number_format($data->invTotal,0)',
            ),
            array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{alokasi}',
            'buttons' => array(
                'alokasi' => array(
                    'url' => '$this->grid->controller->createUrl("invoice/execalokasi",array("id"=>$data->ORDNUMBER))',
                    'click' => 'function() {if(!confirm("Alokasi PKP+CN?")) {return false;}}',
                    'imageUrl' => Yii::app()->baseUrl . '/images/check.png',                    
                ),
            ),
        ),
        ),
    ));
}
?>
