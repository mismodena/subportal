<?php

$this->breadcrumbs=array(
	'Term Item'=>array('masterIndex'),
	$model->tradCode,
);

?>

<h1>Term Item  #<?php echo $model->tradCode; ?></h1>

<?php 
    $this->widget('zii.widgets.CDetailView', array(
    	'data'=>$model,
    	'attributes'=>array(		
            "tradCode",             
            'tradDesc',
            'tradSource',
            'tradPeriod',            
            array(
                "label"=>"Penjualan",
                "type"=>"raw",
                "value"=>"Rp. ".number_format($model->tradValueFrom)." s/d ". " Rp.".number_format($model->tradValueTo)
            ),
            array(
                "label"=>"Persentase",
                "type"=>"raw",
                "value"=>number_format($model->tradPercentage)." % "
            ),            
	    ),
    )); 
?>

