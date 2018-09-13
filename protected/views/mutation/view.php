<?php

$this->breadcrumbs=array(
    'Daftar MAT'=>array('index'),
    $model->mutationNo,
);

?>

<h1>MAT No. #<?php echo $model->mutationNo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(        
        'mutationNo',
        array(                    
                'label'=>'Tanggal Pengajuan',
                'value'=>date("d-M-Y", strtotime($model->mutationDate)),
        ), 
        (array(
                    'name'=>'fromPICName',
                    'value'=> Employee::model()->find('idCard=:idCard', array(':idCard'=>$model->fromPIC)),
                )),
        (array(
                    'name'=>'fromDeptName',
                    'value'=> Department::model()->find('idDept=:idDept', array(':idDept'=>$model->fromDept)),
             )),
        (array(
                    'name'=>'toPICName',
                    'value'=>Employee::model()->find('idCard=:idCard', array(':idCard'=>$model->toPIC)),
                )),
        (array(
                    'name'=>'toDeptName',
                    'value'=> Department::model()->find('idDept=:idDept', array(':idDept'=>$model->toDept)),
             )),
    ),
)); ?>
<br/>

<?php 
    echo "<b>Daftar Aktiva</b>";
   $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'mutation-detail-grid',
    'dataProvider'=>$detail,
    'columns'=>array(
                array(                    
                    'header'=>'No.',
                    'value'=>'$row+1',
                    'headerHtmlOptions' => array('style'=>'width:5%;'),
                ),
                array(                    
                    'header'=>'Asset',
                    'value'=>'$data->assetNumber',
                    'headerHtmlOptions' => array('style'=>'width:10%;'),
                ),
                array(                    
                    'header'=>'Asset Description',
                    'value'=>'Asset::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->assetDesc',
                    'headerHtmlOptions' => array('style'=>'width:35%;'),
                ),
                array(                    
                    'header'=>'PIC',
                    'value'=>'Asset::model()->find("assetID=:assetID", array(":assetID"=>$data->assetID))->modenaPIC',
                    'headerHtmlOptions' => array('style'=>'width:10%;'),
                ),
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'$data->mutationDesc',
                    'headerHtmlOptions' => array('style'=>'width:30%;'),
                ),
             
                
    ),
)); 
?>



