<?php

$this->breadcrumbs=array(
	'Daftar User',
);

?>

<h1>Manage Users</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'htmlOptions'=>array('style'=>'width:740px'),
	'pager'=>array(
		'maxButtonCount'=>'7',
	),
	'columns'=>array(
		//'userid',
		'username',
                /*array(
                    'name' => 'username',
                    'type' => 'raw',
                    'value' => 'CHtml::link($data->username, $this->grid->controller->createReturnableUrl("view",array("username"=>$data->username)))',
                    'filter'=>$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model'=>$model,
                            'attribute'=>'username',
                            'source'=>$this->createUrl('request/suggestUsername'),
                            'options'=>array(
                                    'focus'=>"js:function(event, ui) {
                                            $('#".CHtml::activeId($model,'username')."').val(ui.item.value);
                                    }",
                                    'select'=>"js:function(event, ui) {
                                            $.fn.yiiGridView.update('user-grid', {
                                                    data: $('#user-grid .filters input, #user-grid .filters select').serialize()
                                            });
                                    }"
                            ),
                    ),true),
                ),*/
		'usernik',
		'idcard',
		'email',
		'active',
		'branch',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
