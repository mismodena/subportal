<?php
$this->breadcrumbs = array(
    'Daftar Faktur' => array('index'),
    $model->docNumber,
);
?>

<h1>Faktur No. #<?php echo $model->docNumber; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        "docNumber",
        array(
            "name" => "Tanggal",
            "value" => date("d-m-Y", strtotime($model->invDate)),
        ),
        "customer",
        array(
            "name" => "Total",
            "value" => "Rp. " . number_format($model->invTotal),
        ),
    ),
));
?>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$item,
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
               'name'=>'Model',                   
               'type'=>'raw',
               'value'=>'$data->ITEM',          
            ), 
            array(
               'name'=>'Deskripsi',                   
               'type'=>'raw',
               'value'=>'$data->DESC',          
            ), 
            array(
               'name'=>'Order',                   
               'type'=>'raw',
               'value'=>'number_format($data->QTYORDERED)',          
            ), 
            array(
               'name'=>'Shipment',                   
               'type'=>'raw',
               'value'=>'$data->QTYSHIP',          
            ), 
            
	),
)); ?>
<br/>
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs' => array(
        'Faktur' => $this->renderPartial("_logfaktur", array('model' => $faktur,), true, false),
        'eFaktur' => $this->renderPartial("_logefaktur", array('model' => $efaktur,), true, false),
        'SJ' => $this->renderPartial("_logsj", array('model' => $sj,), true, false),
    ),
    // additional javascript options for the tabs plugin
    'options' => array('collapsible' => false,),
));
?>
