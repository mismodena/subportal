<?php
$this->breadcrumbs = array(
    'Nota Penagihan',
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

<h1>Nota Penagihan</h1>

<div class="search-form">
    <?php
    $this->renderPartial('_search2', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php 
    if($check == 0){
        echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Buat Nota Penagihan", 'width' => 32, 'height' => 32)), Yii::app()->createUrl("document/reqcreate"));
//        echo "&nbsp;&nbsp;&nbsp;";
//        echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/up.png","Add New",array("title"=>"Buat Nota Penagihan TTT", 'width' => 32, 'height' => 32)), Yii::app()->createUrl("document/reqcreateTTT"));
    }   
//        echo "&nbsp;&nbsp;&nbsp;";
//        echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/up.png","Add New",array("title"=>"Buat Nota Penagihan TTT", 'width' => 32, 'height' => 32)), Yii::app()->createUrl("document/reqcreateTTT"));
     
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'document-grid',
    'dataProvider' => $model->search(),
    //'filter'=>$model,
    'columns' => array(
        array(
            'name' => 'Keterangan',
            'type' => 'raw',
            'value' => '(CHtml::link($data->reqNumber, Yii::app()->createUrl("document/reqview",array("id"=>$data->reqID))))'
            . '."<br/>Tanggal: ".date("d-m-Y", strtotime($data->reqDate))'
            . '."<br/>Pemohon: ".$data->salesName',
        ),
        array(
            "name" => "Pengajuan",
            "type"=>"raw",
            "value" => '"Jumlah faktur : ".number_format($data->invCount)." Lembar  <br />Senilai : Rp. ".number_format($data->invValue)',
        ),
        array(
            "name" => "Realisasi",
            "type"=>"raw",
            "value" => '"Jumlah faktur : ".number_format($data->retCount)." Lembar  <br />Senilai : Rp. ".number_format($data->retValue)',
        ),
        array(
            "name" => "Verifikasi",
            "type"=>"raw",
            "value" => '"Jumlah faktur : ".number_format($data->revCount)." Lembar  <br />Senilai : Rp. ".number_format($data->revValue)',
        ),
//        array(
//            'name' => 'Total',
//            'type' => 'raw',
//            'value' => 'number_format($data->invTotal)',
//        ),
        array(
            'class' => 'CButtonColumn',
            //--------------------- begin added --------------------------
            'template' => '{update}',
            'buttons' => array(
                'update' => array(
                    'label' => 'Realisasi', 
                    'url' => '$this->grid->controller->createUrl("document/retcreate",array("id"=>$data->reqID))',                                        
                    'visible' => '$data->realisasi == 0 && $data->finRcv != ""? true : false',
                ),
            ),
        ),
    ),
));
?>
