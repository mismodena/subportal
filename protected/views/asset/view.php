<?php

$this->breadcrumbs=array(
	'Asset'=>array('index'),
	$model->assetNumber,
);

?>

<h1>Detail Asset  #<?php echo $model->assetNumber; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			'assetNumber' ,
			'TipeAsset',
			'assetDesc' ,
			'Department',
			'modenaPIC',
			array(                    
                'label'=>'Tanggal Perolehan',
                'value'=> ($model->acquisitionDate !== NULL ? date("d-m-Y",strtotime($model->acquisitionDate)) : '-'),
            ), 
            //'ppbjNo',
            //'bapbNo',
			//'assetLocation',
            'lokasi',
            'assetCondition',
			'assetRemarks',
			
		
	),
)); ?>

<?php 
	echo "<br>";
	echo "<b>LOGBOOK Asset</b>";
   	$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'asset-grid',
    'dataProvider'=>$detail,
	'columns'=>array(
                array(                    
                    'header'=>'No.',
                    'value'=>'$row+1',
                    'headerHtmlOptions' => array('style'=>'width:5%;'),
                ),
                array(                    
                    'header'=>'Nomor MAT',
                    'value'=>'$data->mutationNo',
                    'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),
                array(                    
                    'header'=>'History Asset',
                    'value'=>'$data->assetNumber',
                    'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),
                array(                    
                    'header'=>'Description MAT',
                    'value'=>'$data->mutationDesc',
                    'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),    
		),
	)); 

?>
