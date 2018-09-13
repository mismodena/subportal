<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inv-detail-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
                array(
                   'name'=>'User',                   
                   'type'=>'raw',
                   'value'=>'$data->inputUN',                     
                ),
                array(
                   'name'=>'Waktu',                   
                   'type'=>'raw',
                   'value'=>'date("d-m-Y   G:i", strtotime($data->inputTime))',                   
                ),
                array(                    
                    'header'=>'Keterangan',
                    'value'=>'$data->apLogReason !== "" ? Utility::getApInvoiceStatus($data->apLogNo)." - ".$data->apLogReason : Utility::getApInvoiceStatus($data->apLogNo)',                    
                ),
	),
)); ?>