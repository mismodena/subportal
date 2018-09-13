<?php
$this->breadcrumbs = array(
    'Follow up Giro / Transfer',
);


Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#document-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Follow Up Giro / Transfer</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_search2', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Follow up Giro")), Yii::app()->createUrl("document/giro")); ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'document-grid',
    'dataProvider' => $model->search(),
    //'filter'=>$model,
    'columns' => array(
        array(
            'name' => 'Faktur',
            'type' => 'raw',
            'value' => '$data->docNumber." - ".$data->bilName'
            . '."<br/>Tanggal Faktur: ".date("d-m-Y", strtotime($data->invDate))',
        ),
        array(
            "name" => "Tanggal",
            "type"=>"raw",
            "value" => 'date("d-m-Y", strtotime($data->inputTime))',
        ),
        array(
            "name" => "Giro / Transfer",
            "type"=>"raw",
            "value" => '$data->retNumber ',
        ),
        array(
            "name" => "Keterangan",
            "value" => '$data->logStatus ',
        ),
    ),
));
?>
