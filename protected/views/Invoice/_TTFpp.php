<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fpp-header-grid',
	'dataProvider'=>$model->logbook(),
	//'filter'=>$model,        
	'columns'=>array(
		//'fppID',
                array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'(CHtml::link($data->fppNo." - ".$data->fppUserName,Yii::app()->createUrl("formPP/viewFPP",array("id"=>$data->fppID)))).'
                    . '"<br/>Dept-Div/Cabang: ".$data->fppUserDeptName."-".$data->nameDiv."/".$data->nameBranch.'
                    . '"<br/>Tanggal pengajuan: ".$data->fppUserDate',
                    'headerHtmlOptions' => array('style'=>'width:75%;'),
                ),
                array(
                    'name'=>'total',
                    'header'=>'Total',
                    'value'=>'"Rp. ".number_format($data->TOTAL)',
                    'htmlOptions' => array('style'=>'text-align: right;'),
                ),   
                array(
                    'class'=>'CButtonColumn',
                    //--------------------- begin added --------------------------
                    'template' => '{verified}',
                    'buttons'=>array(
                        'verified'=>array(
                            'url'=>'$this->grid->controller->createUrl("formPP/updateDelegation",array("id"=>$data->fppID))',
                            'click'=>'function() {if(!confirm("Konfirmasi terima FPP ?")) {return false;}}',
                            'imageUrl' => Yii::app()->baseUrl . '/images/check.png',                                                         
                        ),
                    ),    
                ),
	),
)); ?>
