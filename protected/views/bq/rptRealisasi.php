<?php
$this->breadcrumbs = array(
    'Laporan Realisasi',
);
echo "<h1>Under development</h1>";
goto Skip_All;


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#master-trading-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Laporan Realisasi</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_rptRealisasi', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'master-trading-grid',
    'dataProvider' => $model->rptRealisasi(),
    'enableSorting' => false,
    //'filter'=>$model,
    'columns' => array(
        array(
            "name" => "Cabang",
            "value" => '$data["nameCust"]',
            "type" => "raw",
        ),
        array(
            "name" => "Q1",
            "value" => '"BQ: Rp. ".number_format($data["BQ1"])'
            . '."<br/>TQ: Rp. ".number_format($data["TQ1"])',
            'htmlOptions' => array('style' => 'text-align:right;'),
            "type" => "raw",
        ),
        array(
            "name" => "Q2",
            "value" => '"BQ: Rp. ".number_format($data["BQ2"])'
            . '."<br/>TQ: Rp. ".number_format($data["TQ2"])',
            'htmlOptions' => array('style' => 'text-align:right;'),
            "type" => "raw",
        ),
        array(
             "name" => "Q3",
            "value" => '"BQ: Rp. ".number_format($data["BQ3"])'
            . '."<br/>TQ: Rp. ".number_format($data["TQ3"])',
            'htmlOptions' => array('style' => 'text-align:right;'),
            "type" => "raw",
        ),
        array(
             "name" => "Q4",
            "value" => '"BQ: Rp. ".number_format($data["BQ4"])'
            . '."<br/>TQ: Rp. ".number_format($data["TQ4"])',
            'htmlOptions' => array('style' => 'text-align:right;'),
            "type" => "raw",
        ),
       
    ),
));
Skip_All:
?>
