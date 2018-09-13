<?php
$this->breadcrumbs=array(
	'Detail Referensi',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#master-trading-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Detail <?php echo $arr["name"]?> #<?php echo $arr["reff"]?></h1>

<div class="search-form">
<?php // $this->renderPartial('_searchOnly',array('model'=>$model,)); ?>
</div><!-- search-form -->

<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'master-trading-grid',
    	'dataProvider'=>$model,
        'enableSorting' => false,
    	//'filter'=>$model,
    	'columns'=>array(         
            array(
                "name"=>"Referensi",
                "value"=>'$data->fiscalPeriod',
                "type"=>"raw",
                
            ),   
            array(
                "name"=>"idCust",
                "value"=>'$data->idCust',
                "type"=>"raw",
                
            ), 
            array(
                "name"=>"nameCust",
                "value"=>'$data->nameCust',
                "type"=>"raw",
                
            ), 
            array(
                "name"=>"invTotal",
                "value"=>'"Rp. ".number_format($data->invTotal)',
                'htmlOptions' => array('style'=>'text-align:right;'),
            ),  
            array(
                "name"=>"bqValue",
                "value"=>'"Rp. ".number_format($data->bqValue)',
                'htmlOptions' => array('style'=>'text-align:right;'),
            ),   
            array(
                "name"=>"tqValue",
                "value"=>'"Rp. ".number_format($data->tqValueC)',
                'htmlOptions' => array('style'=>'text-align:right;'),
            ),  
            array(
                "name"=>"count37",
                "value"=>'number_format($data->count37)',
                'htmlOptions' => array('style'=>'text-align:right;'),
            ),  
            array(
                "name"=>"count44",
                "value"=>'number_format($data->count44)',
                'htmlOptions' => array('style'=>'text-align:right;'),
            ),  
            array(
                "name"=>"status",
                "value"=>'$data->status == 1 ? "OK" : "Not OK"',
            ),  
    	),
    )); 
?>
