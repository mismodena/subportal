<?php

$this->breadcrumbs=array(
	'Daftar Disposal'=>array('indexDisposal'),
	$model->disposalNo,
);

?>

<h1>Disposal No. #<?php echo $model->disposalNo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'disposalNo',
        array(                    
                'label'=>'Tanggal Pengajuan',
                'value'=>date("d-M-Y", strtotime($model->disposalDate)),
        ), 
        'fromDeptName',
        'fromPICName',

        
	),
)); ?>
<br/>

<?php 
    echo "<b>Daftar Aktiva</b>";
   $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'disposal-detail-grid',
    'dataProvider'=>$detail,
	'columns'=>array(
                array(                    
                    'header'=>'No.',
                    'value'=>'$row+1',
                    'headerHtmlOptions' => array('style'=>'width:5%;'),
                ),
                array(                    
                    'header'=>'Asset Number',
                    'value'=> 'Asset::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->assetNumber',
                    'headerHtmlOptions' => array('style'=>'width:15%;'),
                ),
                array(                    
                    'header'=>'Asset Description',
                    'value'=>'Asset::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->assetDesc',
                    'headerHtmlOptions' => array('style'=>'width:35%;'),
                ),
                // array(
                //    'name'=>'Jumlah',                   
                //    'type'=>'raw',
                //    'value'=>'$data->qty',
                //    'headerHtmlOptions' => array('style'=>'width:5%;'),
                // ),
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'$data->disposalDesc',
                   'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),
                array(
                    
                    'name'=>'Nilai Buku',
                    'type'=>'raw',
                    'value'=>'$data->nilaiasset',
                    'headerHtmlOptions' => array('style'=>'width:15%;'),
                ),

                
                
	),
)); 
?>

