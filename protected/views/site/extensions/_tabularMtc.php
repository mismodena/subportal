<td style="width: 20px;">
        <?php echo $index + 1; ?>
</td>
<td>
        <?php echo CHtml::activeTextField($model,"[$index]fmtitemno",array('size'=>20, 'readonly'=>true)); ?>
        <?php echo CHtml::activeHiddenField($model,"[$index]itemno"); ?>
        <?php echo CHtml::error($model,"[$index]fmtitemno"); ?>
</td>
<td>
        <?php echo CHtml::activeTextField($model,"[$index]itemdesc",array('size'=>45, 'readonly'=>true)); ?>
        <?php echo CHtml::error($model,"[$index]itemdesc"); ?>
</td>
<td>
        <?php echo CHtml::activeTextField($model,"[$index]unitqty",array('size'=>5, 'readonly'=>true, 'style'=>'text-align:right;')); ?>
        <?php echo CHtml::error($model,"[$index]unitqty"); ?>
</td>
<td>
        <?php echo CHtml::activeTextField($model,"[$index]unit",array('size'=>5, 'readonly'=>true)); ?>
        <?php echo CHtml::error($model,"[$index]unit"); ?>
</td>
<td>
        <?php echo CHtml::activeTextField($model,"[$index]ohnquantity",array('size'=>10, 'readonly'=>true, 'style'=>'text-align:right;')); ?>
        <?php echo CHtml::error($model,"[$index]ohnquantity"); ?>
</td>
<td>
        <?php echo CHtml::activeTextField($model,"[$index]shiquantity",array(
                'size'=>5, 
                'onblur'=>"js:makeAjaxCall([$index]);",
                'onKeyPress'=>"js:return isNumberKey(event);",
                'style'=>'text-align:right;'
            )); ?>
        <?php echo CHtml::error($model,"[$index]shiquantity"); ?>
</td>
<td>
        <?php echo CHtml::activeTextField($model,"[$index]comments",array('size'=>30)); ?>
        <?php echo CHtml::error($model,"[$index]comments"); ?>
</td>
<td>
        <?php 
			$imghtml = CHtml::image(Yii::app()->request->baseUrl.'/css/skins/gridview/view.png','Search Item');
            echo CHtml::link($imghtml, array(
                    'icbomd/viewbom',
                    'location' => $param['location'],
                    'item' => $param['item'],
                    'index' => $index,
                    'asDialog' =>1
                ), 
                array(
                    'onclick'=>'
                        $("#myFrame").attr("src",$(this).attr("href"));
                        $("#myDialog").dialog("open"); 
                        return false;'
                ));
        ?>
</td>