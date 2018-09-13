<?php
$this->breadcrumbs=array(
	'Notifikasi Jatuh Tempo',
);


 Yii::app()->clientScript->registerScript('search', "
 
$('.search-form form').submit(function(){
	$('#invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
 
?>

<h1>Daftar Jatuh Tempo Hutang</h1>


<br/>
<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl."/images/create.png","Add New",array("title"=>"Add New Asset Type")), Yii::app()->createUrl("invoice/createJT")); ?>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'invoice-grid',
        'dataProvider'=>$model->search(),
        //'filter'=>$model,
        'columns'=>array(

            //'utang_id',
            'utang_dari',
            array(
                    'name'=>'Nilai',
                    'type'=>'raw',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                    'value'=>'number_format($data->utang_nilai,0,",",".")',
                ),
            array(
                    'name'=>'Mata Uang',
                    'type'=>'raw',
                    'value'=>'$data->utang_matauang',
                ),
            array(
                    'name'=>'Tgl Cair',
                    'type'=>'raw',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                    'value' =>'date("d-m-Y", strtotime($data->utang_tanggalcair))',
                ),
            array(
                    'name'=>'Outstanding',
                    'type'=>'raw',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                    'value'=>'number_format($data->utang_outstanding,0,",",".")',
                ),
            array(
                    'name'=>'Jatuh Tempo',
                    'type'=>'raw',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                    'value' =>'date("d-m-Y", strtotime($data->utang_jatuhtempo))',
                ),
            array(
                    'name'=>'Keterangan',
                    'type'=>'raw',
                    'value'=>'$data->utang_keterangan',
                ),


            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{update} {view} {delete}',
                    'buttons'=>array(                    
                        'update'=>array(
                                'url'=>'$this->grid->controller->createUrl("invoice/updateJT", array("id"=>$data["utang_id"]))',                            
                        ),
                        'view'=>array(
                                'url'=>'$this->grid->controller->createUrl("invoice/viewJT", array("id"=>$data["utang_id"]))',                            
                        ),
                         'delete'=>array(
                                'url'=>'$this->grid->controller->createUrl("invoice/delete", array("id"=>$data["utang_id"]))',                            
                        ),
                    ),    
                ),
    ),
    )); 
?>
<br><br>
<h3>Jumlah Nilai dan Outstanding</h3>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'invoice-grid',
        'dataProvider'=>$model->searchGroupBy(),
        //'filter'=>$model,
        'columns'=>array(

            //'utang_id',
            array(
                    'name'=>'Nama Bank',
                    'type'=>'raw',
                    'value'=>'$data->utang_dari',
                ),
            array(
                    'name'=>'Jumlah Nilai',
                    'type'=>'raw',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                    'value'=>'number_format($data->utang_nilai,0,",",".")',
                ),
            array(
                    'name'=>'Jumlah Outstanding',
                    'type'=>'raw',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                    'value'=>'number_format($data->utang_outstanding,0,",",".")',
                ),


    ),
    )); 
?>



