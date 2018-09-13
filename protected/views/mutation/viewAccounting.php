<?php

$this->breadcrumbs=array(
    'Daftar Disposal'=>array('indexDisposal'),
    $model->disposalNo,
);

?>

<h1>Disposal No. #<?php echo $model->disposalNo; ?></h1>

<?php 
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(        
        'disposalNo',
        array(                    
                'label'=>'Tanggal Pengajuan',
                'value'=>date("d-M-Y", strtotime($model->disposalDate)),
        ), 
        (array(
                    'name'=>'fromPICName',
                    'value'=> Employee::model()->find('idCard=:idCard', array(':idCard'=>$model->fromPIC)),
                )),
        (array(
                    'name'=>'fromDeptName',
                    'value'=> Department::model()->find('idDept=:idDept', array(':idDept'=>$model->fromDept)),
             )),
        
        
    ),
)); 
?>
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
                    'header'=>'Asset',
                    'value'=>'$data->assetID',
                    'headerHtmlOptions' => array('style'=>'width:25%;'),
                ),
                array(
                   'name'=>'Jumlah',                   
                   'type'=>'raw',
                   'value'=>'$data->qty',
                   //   'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'$data->disposalDesc',
                   //   'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                array(
                    'name'=>'Nilai Jurnal',
                    'type'=>'text',
                ),

                
                
    ),
)); 

?>
<br>
<?php 
   if($approval->pic=="1603.1943")
    {
        $this->renderPartial('_formAccounting', array('approval'=>$approval,));
    }
 ?>
