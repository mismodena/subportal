<?php

$this->pageTitle=Yii::app()->name . ' - Approval';
$this->breadcrumbs=array(
	'ApprovalDisposal',
);
?>

<h2>Disposal Asset Nomor <?php echo $model->disposalNo; ?></h2>


<h3>
    
    <?php   
        $status = $model->persetujuan ? "Disetujui" : "Tidak Disetujui" ;
        $tanggal = Utility::getLongDateParams($model->tanggal);//date("d-m-Y",strtotime($model->tanggal));
        $message =  "Status: ".$status."</br>Pada: ".$tanggal; 
        echo $message;
    
 ?>

</h3>
