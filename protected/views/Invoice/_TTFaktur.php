
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->logbook(),
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
           array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->apInvNo." - ".$data->apSupplier,Yii::app()->createUrl("invoice/viewAP",array("id"=>$data->apInvID)))).'
                    . '"<br/>No. Penerimaan: ".$data->recNo.'                    
                    . '"<br/>Tanggal Faktur: ".date("d-m-Y", strtotime($data->apInvDate)).'
                    . '"<br/>Tanggal Terima: ".date("d-m-Y", strtotime($data->recDate))',                    
                    'headerHtmlOptions' => array('style'=>'width:55%;'),
                ),
            array(
                    'name'=>'Departemen',
                    'type'=>'raw',
                    'value'=>'$data->deptName',
                    'headerHtmlOptions' => array('style'=>'width:10%;'),
                ),                  
            array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'number_format($data->apInvTotal,0)',
                    'htmlOptions'=>array('style' => 'text-align: right;'),
                ), 
            array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{verified}',
                    'buttons'=>array(
                        'verified'=>array(
                            'url'=>'$this->grid->controller->createUrl("invoice/updateDelegation",array("id"=>$data->apDetailID))',
                            'click'=>'function() {if(!confirm("Konfirmasi penerimaan Faktur?")) {return false;}}',
                            'imageUrl' => Yii::app()->baseUrl . '/images/check.png',                                                         
                        ),
                    ),    
                ),
	),
)); ?>
