<?php

$this->breadcrumbs=array(
	'Daftar Kontrak'=>array('index'),
	$model->userName,
);

Yii::app()->clientScript->registerScript('update', "
 


");
?>

<h1>Kontrak an. #<?php echo $model->userName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		array(
                    'name'=>"Nama / NIK",                    
                    'type'=>"raw",
                    'value'=>$model->userName." / ".$model->idCard."",  
                ),
		array(
                    'name'=>"Departemen / Cabang",                    
                    'value'=>$model->deptName." - ".$model->idDiv." / ".$model->branchName,  
                ),
                "posName",
                array(
                    'name'=>'startDate',
                    'value'=>Yii::app()->dateFormatter->format('dd-MMM-yyyy',$model->startDate) ,  
                ),
                array(
                    'name'=>'endDate',
                    'value'=>Yii::app()->dateFormatter->format('dd-MMM-yyyy',$model->endDate) ,  
                ),
                "contractType",
                array(
                    'name'=>'Action',
                    'value'=>$model->contractAction,  
                ),
                array(
                    'name'=>'Keterangan',
                    'value'=>trim($model->contractReplacement) === "" ? "-" : $model->contractReplacement,  
                ),
                array(
                    'name'=>'Status Notifikasi',
                    'value'=>$model->isActive ? "Aktif" : "Non-Aktif",  
                ),
	),
)); 
?>
<br />

<strong>Riwayat Kontrak</strong>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hris-contract-grid',
	'dataProvider'=>$history->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'$data->idCard." - ".$data->userName.'
                    . '"<br/>Dept-Div/Cabang: ".$data->deptName." - ".$data->idDiv." / ".$data->branchName.'
                    . '"<br/>Posisi: ".$data->posName',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                //array(                    
                //    'header'=>'Tipe Kontrak',
                //    'value'=>'$data->contractType',                    
                //    'htmlOptions' => array('style'=>'text-align:center;'),
                //),
                array(                    
                    'header'=>'Tgl Mulai',
                    'value'=>' date("d-M-Y", strtotime($data->startDate))',                    
                ),
                array(                    
                    'header'=>'Tgl Akhir',
                    'value'=>' date("d-M-Y", strtotime($data->endDate))',                    
                ),
                
	),
)); ?>

