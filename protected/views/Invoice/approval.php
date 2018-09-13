<?php

$this->pageTitle=Yii::app()->name . ' - Proforma Invoice';
$this->breadcrumbs=array(
	'Approval',
);
?>

<h2>Proforma Invoice Nomor <?php echo $model->invNo; ?></h2>


<h3>
    
    <?php   
        
        switch ($model->status) {
                case 0:
                    $status = "Entry";
                    break;
                case 1:
                    $status = "Verified";
                    break;
                case 2:
                    $status = "Signed";
                    break;
        }
                        
        $message =  "Status: ".$status; 
        echo $message;
    
 ?>

</h3>
