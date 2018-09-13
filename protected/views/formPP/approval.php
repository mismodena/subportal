<?php

$this->pageTitle=Yii::app()->name . ' - Approval';
$this->breadcrumbs=array(
	'Approval',
);
?>

<h2>FPP Nomor <?php echo $model->fppID; ?></h2>


<h3>
    
    <?php   
        $status = $model->persetujuan ? "Disetujui" : "Tidak Disetujui" ;
        $tanggal = Utility::getLongDateParams($model->tanggal);//date("d-m-Y",strtotime($model->tanggal));
        $message =  "Status: ".$status."</br>Pada: ".$tanggal; 
        echo $message;
    
 ?>

</h3>
