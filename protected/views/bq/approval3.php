<?php

$this->pageTitle=Yii::app()->name . ' - Approval';
$this->breadcrumbs=array(
	'Approval',
);


?>

<h3>Penambahan Saldo : No. <?php echo $model->bqUploadNo ?></h3>


<h4>
    
    <?php   
        $status = $model->status == 1 ? "Disetujui" : "Tidak Disetujui" ;
        $tanggal = Utility::getLongDateParams($model->modifTime);//date("d-m-Y",strtotime($model->tanggal));
        $message =  "Status: ".$status."</br>Pada: ".$tanggal; 
        echo $message;
    
 ?>

</h4>
