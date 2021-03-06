
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'faktur-grid',
	'dataProvider'=>$model,
        'enableSorting' => false,    
	//'filter'=>$model,
	'columns'=>array(               
            array(
               'name'=>'Faktur',                   
               'type'=>'raw',
               'value'=>'$data->docNumber',          
            ), 
            array(
               'name'=>'Desc',                   
               'type'=>'raw',
               'value'=>'$data->logDesc',          
            ), 
            array(
               'name'=>'User',                   
               'type'=>'raw',
               'value'=>'$data->inputUN',          
            ), 
            array(
               'name'=>'Time',                   
               'type'=>'raw',
               'value'=>'date("d-m-Y G:i", strtotime($data->inputTime))',          
            ), 
	),
)); ?>
