<?php

$this->breadcrumbs=array(
	'Daftar PRMD'=>array('indexPrmd'),
	$model->userName,
);

?>

<h1>PRMD a/n #<?php echo $model->userName; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(				
                array(
                    'name'=>'Karyawan :',
                    'value'=>"",  
                ),
            	array(
                    'name'=>"Nama / NIK",                    
                    'type'=>"raw",
                    'value'=>$model->userName." / ".$model->idCard."",  
                ),
                "jobGrade",
		array(
                    'name'=>"Departemen / Cabang",                    
                    'value'=>$model->deptName." - ".$model->idDiv." / ".$model->branchName,  
                ),            
                "posName",                                                
	),
)); ?>
<br/><br/>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(				                                            
                array(
                    'name'=>'Keterangan PRMD :',
                    'value'=>"",  
                ),
                "prmdCategoryName",
                "newJobGrade",
		array(
                    'name'=>"Departemen / Cabang",                    
                    'value'=>$model->newDeptName." - ".$model->newIdDiv." / ".$model->newBranchName,  
                ),            
                "newPosName",                
                array(
                    'name'=>'startDate',
                    'value'=>Yii::app()->dateFormatter->format('dd-MM-yyyy',$model->startDate) ,  
                ),
                array(
                    'name'=>'endDate',
                    'value'=>Yii::app()->dateFormatter->format('dd-MM-yyyy',$model->endDate) ,  
                ),
                array(
                    'name'=>'Status PRMD',
                    'value'=>is_null($model->status) ? "-" : ($model->status ? "Disetujui" : "Tidak Disetujui"),  
                ),
                array(
                    'name'=>'Notifikasi',
                    'value'=>$model->isActive ? "Aktif" : "Non-Aktif",  
                ),
                "prmdDesc"
	),
)); 


 if(is_null($model->status))
{
    $this->renderPartial('_formApproval', array('approval'=>$model,));
}
?>
