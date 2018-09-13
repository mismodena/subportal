<?php

$this->pageTitle=Yii::app()->name . ' - Approval';
$this->breadcrumbs=array(
	'Approval',
);

    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScript('openFrame', "
        $( document ).ready(function() {
            var link = '".$this->createUrl('formPP/mail',array("id"=>$fppID))."'; 
            $('#frame').attr('src', link );
        });
    ", CClientScript::POS_END);
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

<div id="mydiv"  style="display: none"> <iframe id="frame" src=""> width="100%" height="300">  </iframe></div>