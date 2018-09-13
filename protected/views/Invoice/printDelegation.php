<h1>Daftar Serah Terima Faktur</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->delegation(),
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
           array(
                   'name'=>'Keterangan',                   
                   'type'=>'raw',
                   'value'=>'$data->recNo." - ".$data->apSupplier.'
                    . '"<br/>No. Faktur: ".$data->apInvNo.'                    
                    . '"<br/>Tanggal Faktur: ".date("d-m-Y", strtotime($data->apInvDate)).'
                    . '"<br/>Tanggal Terima: ".date("d-m-Y", strtotime($data->recDate))',
                    'headerHtmlOptions' => array('style'=>'width:55%;'),
                ),
            array(
                    'name'=>'Departemen',
                    'type'=>'raw',
                    'value'=>'$data->deptName',
                ),
            array(
                    'name'=>'Total',
                    'type'=>'raw',
                    'value'=>'number_format($data->apInvTotal,0)',
                ),                
            array(
                    'name'=>'Paraf',
                    'type'=>'raw',
                    'value'=>' ',
                ),  
	),
)); ?>
