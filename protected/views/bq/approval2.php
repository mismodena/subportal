<?php

$this->pageTitle=Yii::app()->name . ' - Approval';
$this->breadcrumbs=array(
	'Approval',
);


?>

<h3>Pengajuan Claim : No. <?php echo $model->bqClaimNo ?></h3>


<h4>
    
    <?php   
        $status = $model->status == 1 ? "Disetujui" : "Tidak Disetujui" ;
        $tanggal = Utility::getLongDateParams($model->modifTime);//date("d-m-Y",strtotime($model->tanggal));
        $message =  "Dealer: ".$dealer."<br/>Status: ".$status."</br>Pada: ".$tanggal; 
        echo $message;
    
 ?>

</h4>
