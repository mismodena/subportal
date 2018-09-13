
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sj-grid',
	'dataProvider'=>$model->sj(),
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
               'name'=>'Surat Jalan',                   
               'type'=>'raw',
               'value'=>'$data->docNumber." - ".$data->customer.'
                . '"<br/>Tanggal : ".date("d-m-Y", strtotime($data->invDate))',          
            ), 
//            array(
//                    'name'=>'Departemen',
//                    'type'=>'raw',
//                    'value'=>'$data->deptName',
//                    'headerHtmlOptions' => array('style'=>'width:10%;'),
//                ),                  
//            array(
//                    'name'=>'Total',
//                    'type'=>'raw',
//                    'value'=>'number_format($data->apInvTotal,0)',
//                    'htmlOptions'=>array('style' => 'text-align: right;'),
//                ), 
            array(
                'class'=>'CButtonColumn',
                //--------------------- begin added --------------------------
                'template' => '{verified}',
                'buttons'=>array(
                    'verified'=>array(
                        'url'=>'$this->grid->controller->createUrl("document/updatelogbook",array("id"=>$data->detailID, "cat"=>"SJ"))',
                        'click'=>'function() {if(!confirm("Konfirmasi penerimaan Faktur?")) {return false;}}',
                        'imageUrl' => Yii::app()->baseUrl . '/images/check.png',                                                         
                    ),
                ),    
            ),
	),
)); ?>
