<td>
	<?php echo CHtml::activeTextField($model_detail,"[$index]lineno"); ?>
	<?php echo CHtml::error($model_detail,"[$index]lineno"); ?>
</td>
<td>
	<?php $this->widget('ext.widgets.autocomplete.XJuiAutoComplete', array(
		'model'=>$model_detail,
		'attribute'=>"[$index]itemno",
		'source'=>$this->createUrl('request/suggestLastname'),

	)); ?>
	<?php echo CHtml::error($model_detail,"[$index]itemno"); ?>
</td>
<td>
	<?php echo CHtml::activeTextField($model_detail,"[$index]shiquantity"); ?>
	<?php echo CHtml::error($model_detail,"[$index]shiquantity"); ?>
</td>
<td>
	<?php echo CHtml::activeTextField($model_detail,"[$index]comments"); ?>
	<?php echo CHtml::error($model_detail,"[$index]comments"); ?>
</td>