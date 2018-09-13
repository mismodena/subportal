<?php
$this->breadcrumbs=array(
	'Daftar Penerimaan Invoice',
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

<h1>Daftar Penerimaan Invoice</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->search(),
    'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->recNo." - ".$data->apSupplier,Yii::app()->createUrl("invoice/viewAP",array("id"=>$data->apInvID)))).'                  
                    . '"<br/>Tanggal Penagihan: ".($data->recDate !== NULL ? date("d-m-Y", strtotime($data->recDate)) : "-").'
                    . '"<br/>Tanggal Terima: ".($data->recDateInvoice !== NULL ? date("d-m-Y", strtotime($data->recDateInvoice)) : "-")',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                    
                ),
            array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'number_format($data->apInvTotal,0)',
                ),
            array(
                    'name' =>'Keterangan',
                    'type' => 'raw',
                    'value' =>'$data->status == 1 ? "Invoice telah diterima" : "" ',
                ),

                /*array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' =>/*'{update}{verified} {print}',
                    'buttons'=>array(
                        'print' => array( 
                                'label' => 'Cetak Penerimaan', 
                                'url' => '$this->grid->controller->createUrl("invoice/printAP",array("id"=>$data->apInvID))',
                                'imageUrl' => Yii::app()->baseUrl . '/images/print.png', 
                                'visible' => '$data->status == 1 ? true : false',
                                'options'=>array("target"=>"_blank"),
                        ),
                        'update' => array( 
                                'label' => 'Update Penerimaan', 
                                'url' => '$this->grid->controller->createUrl("invoice/updateAP",array("id"=>$data->apInvID))',                                                                
                        ),
                        'verified'=>array(
                                'label' => 'Verifikasi',
                                'url'=>'$this->grid->controller->createUrl("invoice/verified",array("id"=>$data->apInvID))',
                                'click'=>'function() {if(!confirm("Konfirmasi penerimaan document?")) {return false;}}',
                                'imageUrl' => Yii::app()->baseUrl . '/images/check.png', 
                                'visible'=>'$data->status == 0 ? true : false',
                                'options'=>array("target"=>"_blank"),                                                        
                        ),
                    ),    
                ),*/
	),
)); ?>

