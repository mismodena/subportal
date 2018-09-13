<?php

$this->breadcrumbs=array(
	'Daftar FPP'=>array('indexFPP'),
	$header->RQNNUMBER,
);

?>

<h1>RQN No. #<?php echo $header->RQNNUMBER; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$header,
	'attributes'=>array(	
                array(
                    'label'=>'RQN No.', 
                    'type'=>'raw', 
                    'value'=>$header->RQNNUMBER),
                array(
                    'label'=>'ID.', 
                    'type'=>'raw', 
                    'value'=>$header->REQRID),                    
                array(
                    'label'=>'Tanggal', 
                    'type'=>'raw', 
                    'value'=>date("d-m-Y", strtotime($header->REQDATE))),                     
                array(
                    'label'=>'Cost Center', 
                    'type'=>'raw', 
                    'value'=>$header->COSTCTR),
                array(
                    'label'=>'Workflow', 
                    'type'=>'raw', 
                    'value'=>$header->WORKFLOW),
                array(
                    'label'=>'Desc', 
                    'type'=>'raw', 
                    'value'=>$header->DESCRIPTIO),
                array(
                    'label'=>'Reff', 
                    'type'=>'raw', 
                    'value'=>$header->REFERENCE),
	),
)); ?>
<br/>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fpp-detail-grid',
	'dataProvider'=>$detail,
	//'filter'=>$model,
	'columns'=>array(
                array(                    
                    'header'=>'No.',
                    'value'=>'$row+1',
                    'headerHtmlOptions' => array('style'=>'width:5%;'),
                ),
                array(                    
                    'header'=>'Item',
                    'value'=>'$data->FMTITEMNO',                    
                ),
                array(
                   'name'=>'Tanggal',                   
                   'type'=>'raw',
                   'value'=>'date("d-m-Y", strtotime($data->RQRDDATE))',
                ),
                array(
                   'name'=>'Keperluan',                   
                   'type'=>'raw',
                   'value'=>'$data->ITEMDESC',
                ),
                array(
                   'header'=>'Acct No.',                   
                   'type'=>'raw',
                   'value'=>'$data->GLACCTFULL',
                ),
                array(
                   'header'=>'Total',                   
                   'type'=>'raw',
                   'value'=>'number_format($data->SCURRVAL)',
                   'htmlOptions' => array('style'=>'text-align:right;'),
                ),
	),
)); ?>

